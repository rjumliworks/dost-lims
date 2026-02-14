<?php

namespace App\Services\Common\Category;

use App\Models\SampleName;
use App\Models\SampleType;
use App\Models\SampleCategory;
use App\Http\Resources\Common\CategoryResource;

class ViewClass
{
    public function list($request){
        $data = SampleName::with('type:id,name,category_id','type.category:id,name,laboratory_id','type.category.laboratory')
        ->when($request->laboratory, function ($query, $laboratory) {
            $query->whereHas('type', function ($query) use ($laboratory){
                $query->whereHas('category', function ($query) use ($laboratory){
                    $query->where('laboratory_id',$laboratory);
                });
            });
        })
        ->latest()
        ->paginate($request->count ?? 20);

        return  CategoryResource::collection($data);
    }

    public function category($request){
        $keyword = $request->keyword;
        $data = SampleCategory::where('laboratory_id',$request->laboratory_id)
        ->where('name', 'LIKE', "%{$keyword}%")->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function type($request)
    {
        $keyword = $request->keyword;
        $withNames = filter_var($request->with, FILTER_VALIDATE_BOOLEAN);

        $query = SampleType::where('category_id', $request->category_id)
            // ->where('name', 'LIKE', "%{$keyword}%")
            ->where('is_active', 1);

        if ($withNames) {
            $query->with('names:id,name,type_id');
        }

        $data = $query->get()->map(function ($item) use ($withNames) {
            $response = [
                'value' => $item->id,
                'name'  => $item->name,
            ];
            if ($withNames) {
                $response['names'] = $item->names->map(function ($name) {
                    return [
                        'value' => $name->id,  
                        'name'  => $name->name,
                    ];
                });
            }
            return $response;
        });
        return $data;
    }

    public function name($request)
    {
        $query = SampleName::where('type_id', $request->sampletype_id)->where('is_active', 1);

        $data = $query->get()->map(function ($item) {
            $response = [
                'value' => $item->id,
                'name'  => $item->name,
            ];
            return $response;
        });
        return $data;
    }
}
