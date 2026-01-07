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
}
