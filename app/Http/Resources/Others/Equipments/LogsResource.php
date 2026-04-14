<?php

namespace App\Http\Resources\Others\Equipments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->user->profile->firstname.' '.$this->user->profile->lastname,
            'date' => date('F d, Y', strtotime($this->date)),
            'note' => $this->note,
            'is_calibrated' => $this->is_calibrated
        ];
    }
}
