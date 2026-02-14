<?php

namespace App\Services\Common\Testservice;

use Hashids\Hashids;
use App\Models\Testservice;
use App\Models\TestserviceName;
use App\Models\TestserviceMethod;
use App\Models\SampleCategory;
use App\Models\SampleType;
use App\Models\SampleName;
use App\Http\Resources\Common\TestserviceResource;
use App\Http\Resources\Common\Testservice\ListResource;
use App\Http\Resources\Common\Testservice\ListsResource;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\ActivityResource;

class ViewClass
{
    public function counts($statuses){
        foreach($statuses as $status){
            $counts[] = Testservice::where('status_id',$status['value'])->count();
        }
        return $counts;
    }

    public function list($request){
        $data = ListsResource::collection(
            Testservice::query()
            ->when($request->category, function ($query, $category) {
                $query->whereHas('samples', function ($q) use ($category) {
                    $q->where(function ($inner) use ($category) {
                        $inner->whereHasMorph(
                            'sampleable',
                            [SampleType::class],
                            function ($morph) use ($category) {
                                $morph->where('category_id', $category);
                            }
                        )->orWhereHasMorph(
                            'sampleable',
                            [SampleName::class],
                            function ($morph) use ($category) {
                                $morph->whereHas('type', function ($type) use ($category) {
                                    $type->where('category_id', $category);
                                });
                            }
                        );
                    });
                });
            })
            ->when($request->type, function ($query, $type) {
                $query->whereHas('samples', function ($q) use ($type) {
                    $q->where(function ($inner) use ($type) {
                        $inner->whereHasMorph(
                            'sampleable',
                            [SampleType::class],
                            function ($morph) use ($type) {
                                $morph->where('id', $type);
                            }
                        )->orWhereHasMorph(
                            'sampleable',
                            [SampleName::class],
                            function ($morph) use ($type) {
                                $morph->where('type_id', $type);
                            }
                        );
                    });
                });
            })
            ->when($request->name, function ($query, $name) {
                $query->whereHas('samples', function ($q) use ($name) {

                    $q->whereHasMorph(
                        'sampleable',
                        [SampleName::class],
                        function ($morph) use ($name) {
                            $morph->where('id', $name);
                        }
                    );

                });
            })
            ->when($request->laboratory, function ($query, $laboratory) {
                $query->where('laboratory_id',$laboratory);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status_id',$status);
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('testname', function ($query) use ($keyword){
                    $query->where('name', 'LIKE', "%{$keyword}%");
                })->orWhereHas('method', function ($query) use ($keyword){
                    $query->whereHas('method', function ($query) use ($keyword){
                        $query->where('name', 'LIKE', "%{$keyword}%");
                    });
                });
            })
            ->with('status')
            ->with('testname','laboratory')
            ->with('method.method','method.reference')
            ->orderBy(TestserviceName::select('name')->whereColumn('testservices.testname_id', 'testservice_names.id'),'ASC')
            ->orderBy('laboratory_id','ASC')->orderBy('created_at','DESC')->orderBy('id','ASC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function search($request){
        $keyword = $request->keyword;
        $type = $request->type;
        $laboratory = $request->laboratory_id;

        $data = TestserviceName::where('name', 'LIKE', "%{$keyword}%")
        ->where('type_id',$type)
        ->where('laboratory_id',$laboratory)
        ->where('is_active',1)
        ->limit(20)
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
        return $data;
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($id);

        $data = new TestserviceResource(
            Testservice::query()
            ->with('testname','laboratory','status','added.profile.suffix')
            ->with('method.method','method.reference')
            ->with('fees','samples.sampleable')
            ->where('id',$id)->first()
        );
        return $data;
    }

    public function methods($request){
        $laboratory = $request->laboratory_id;
        $keyword = $request->keyword;
      
        $data = TestserviceResource::collection(
            TestserviceMethod::query()
            ->where('is_active',1)
            ->withWhereHas('method', function ($query) use ($keyword){
                $query->select('id','name','short');
                $query->when($keyword, function ($query, $keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%")->orWhere('short', 'LIKE', "%{$keyword}%");
                });
            })
            ->withWhereHas('reference', function ($query) use ($keyword){
                $query->select('id','name');
                $query->when($keyword, function ($query, $keyword) {
                    $query->orWhere('name', 'LIKE', "%{$keyword}%");
                });
            })
            ->where('laboratory_id',$laboratory)
            ->paginate(50)
        );
        return $data;
    }

    public function testservices($request)
    {
        $type = $request->sampletype_id ? 'sampletype' : 'category';
        $id   = $request->sampletype_id ?? $request->category_id;
        
        if ($request->filled('sampletype_id') || $request->filled('category_id')) {
            $testservices = Testservice::with('testname', 'method.method', 'method.reference')
            ->whereHas('samples', function ($q) use ($request) {
                if ($request->filled('sampletype_id')) {
                    $q->whereHasMorph(
                        'sampleable',
                        [SampleType::class],
                        fn ($m) => $m->where('id', $request->sampletype_id)
                    );
                }elseif($request->filled('category_id')) {
                    $q->where(function ($sub) use ($request) {
                        $sub->whereHasMorph(
                            'sampleable',
                            [SampleCategory::class],
                            fn ($m) => $m->where('id', $request->category_id)
                        )->orWhereHasMorph(
                            'sampleable',
                            [SampleType::class],
                            fn ($m) => $m->where('category_id', $request->category_id)
                        );
                    });
                }
            })
            ->where('status_id',32)->where('is_active',1)
            ->distinct()
            ->get();
        }else{
            $testservices = [];
        }
        return ListResource::collection($testservices);
    }

    public function activitylogs($request)
    {
        $test = Testservice::findOrFail(\Auth::user()->id);
        $data = $test->activities()->paginate(15);
        return ActivityResource::collection($data);
    }
}
