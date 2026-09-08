<?php

namespace App\Services\Common\Category;

use App\Models\SampleName;
use App\Models\SampleType;
use App\Models\SampleCategory;

class SaveClass
{
    public function category($request){
        $data = SampleCategory::create($request->all());
        $data = [
            'value' => $data->id,
            'name' => $data->name,
        ];
        return [
            'data' => $data,
            'message' => 'Sample Category was created!',
            'info'    => "You've successfully added a new sample category."
        ];
    }

    public function type($request){
        $data = SampleType::create($request->all());
        $data = [
            'value' => $data->id,
            'name' => $data->name,
        ];
        return [
            'data' => $data,
            'message' => 'Sample Type was created!',
            'info'    => "You've successfully added a new sample type."
        ];
    }

    public function name($request){
        $data = SampleName::create($request->all());
        return [
            'data' => $data,
            'message' => 'Sample Name was created!',
            'info'    => "You've successfully added a new sample name."
        ];
    }

    public function updateCategory($request){
        $data = SampleCategory::findOrFail($request->id);
        $data->name = $request->name;
        if($request->laboratory_id){
            $data->laboratory_id = $request->laboratory_id;
        }
        $data->save();
        $data = [
            'value' => $data->id,
            'name' => $data->name,
        ];
        return [
            'data' => $data,
            'message' => 'Sample Category was updated!',
            'info'    => "You've successfully updated the sample category."
        ];
    }

    public function updateType($request){
        $data = SampleType::findOrFail($request->id);
        $data->name = $request->name;
        if($request->category_id){
            $data->category_id = $request->category_id;
        }
        $data->save();
        $data = [
            'value' => $data->id,
            'name' => $data->name,
        ];
        return [
            'data' => $data,
            'message' => 'Sample Type was updated!',
            'info'    => "You've successfully updated the sample type."
        ];
    }

    public function updateName($request){
        $data = SampleName::findOrFail($request->id);
        $data->name = $request->name;
        if($request->type_id){
            $data->type_id = $request->type_id;
        }
        $data->save();
        return [
            'data' => $data,
            'message' => 'Sample Name was updated!',
            'info'    => "You've successfully updated the sample name."
        ];
    }
}
