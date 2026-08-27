<?php

namespace App\Services\Dashboard;

use App\Models\ListLaboratory;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class TechnicalManagerClass
{
    protected LabHeadClass $labhead;

    public function __construct(LabHeadClass $labhead)
    {
        $this->labhead = $labhead;
    }

    public function laboratories(){
        $ids = $this->assignedLaboratoryIds();

        return ListLaboratory::whereIn('id', $ids)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
    }

    public function dashboard($request){
        $ids = $this->assignedLaboratoryIds();

        $laboratory = ($request->laboratory && $ids->contains((int) $request->laboratory))
            ? $request->laboratory
            : $ids->first();

        $request->merge(['laboratory' => $laboratory]);

        return $this->labhead->dashboard($request);
    }

    private function assignedLaboratoryIds(){
        return UserRole::where('user_id', Auth::id())
            ->where('role_id', 3)
            ->where('is_active', 1)
            ->pluck('laboratory_id')
            ->filter()
            ->unique();
    }
}
