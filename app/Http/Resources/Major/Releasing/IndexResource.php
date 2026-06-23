<?php

namespace App\Http\Resources\Major\Releasing;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->tsr->id);
        $name = ($this->tsr->customer->name == 'Main') ? '' : ' - '.$this->tsr->customer->name;
        return [
            'id' => $this->id,
            'qr' => $code,
            'code' => $this->tsr->code,
            'due_at' => $this->tsr->due_at,
            'status' => $this->status,
            'released_at' => ($this->released_at) ? $this->released_at : '-',
            'user' => ($this->user) ? $this->user->profile->firstname.' '.$this->user->profile->lastname : '-',
            'customer' => $this->tsr->customer->customer_name->name.$name,
            'contact_no' => $this->tsr->customer->contact->contact_no,
            'email' => $this->tsr->customer->contact->email,
            'conforme' => $this->tsr->conforme,
            'mode' => $this->tsr->mode,
            'created_at' => $this->tsr->created_at
        ];
    }
}
