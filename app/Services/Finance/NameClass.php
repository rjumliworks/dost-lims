<?php

namespace App\Services\Finance;

use App\Models\Configuration;
use App\Models\FinanceName;
use App\Http\Resources\DefaultResource;

class NameClass
{
    public function lists($request){
        $data = FinanceName::when($request->keyword, function ($query, $keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        })->orderBy('created_at','DESC')->paginate($request->count);
        return DefaultResource::collection($data);
    }

    public function save($request){
        $data = FinanceName::create($request->all());
        $data = [
            'value' => $data->id,
            'name' => $data->name
        ];
        return [
            'data' => $data,
            'message' => 'Name creation was successful!', 
            'info' => "You've successfully created a name."
        ];
    }

    public function update($request){
        $data = FinanceName::where('id',$request->id)->first();
        $data->update($request->all());

        return [
            'data' => new DefaultResource($data),
            'message' => 'Name update was successful!', 
            'info' => "You've successfully updated the selected name."
        ];
    }

}
