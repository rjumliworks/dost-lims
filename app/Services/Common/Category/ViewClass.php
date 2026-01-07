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

    public function type($request){
        $keyword = $request->keyword;
        $data = SampleType::where('category_id',$request->category_id)
        ->where('name', 'LIKE', "%{$keyword}%")->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }
}
