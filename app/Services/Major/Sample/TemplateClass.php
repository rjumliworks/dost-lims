<?php

namespace App\Services\Major\Sample;

use App\Models\SampleDescriptionTemplate;

class TemplateClass
{
    public function list($request){
        $agencyId = \Auth::user()->profile->agency_id;

        $data = SampleDescriptionTemplate::where('agency_id', $agencyId)
        ->when($request->sampletype_id, function ($query, $sampletypeId) {
            $query->where(function ($q) use ($sampletypeId) {
                $q->where('sampletype_id', $sampletypeId)->orWhereNull('sampletype_id');
            });
        })
        ->orderBy('name')
        ->get()
        ->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'sampletype_id' => $item->sampletype_id,
                'customer_description' => $item->customer_description,
                'description' => $item->description,
            ];
        });

        return $data;
    }

    public function save($request){
        return SampleDescriptionTemplate::create([
            'agency_id' => \Auth::user()->profile->agency_id,
            'sampletype_id' => $request->sampletype_id,
            'name' => $request->name,
            'customer_description' => $request->customer_description,
            'description' => $request->description,
            'created_by' => \Auth::user()->id,
        ]);
    }

    public function delete($id){
        SampleDescriptionTemplate::where('agency_id', \Auth::user()->profile->agency_id)
            ->where('id', $id)
            ->delete();
    }
}
