<?php

namespace App\Services\Others\Equipments;

use Carbon\Carbon;
use App\Models\Equipment;
use App\Models\EquipmentLog;
use App\Http\Resources\Others\Equipments\IndexResource;

class ViewClass
{
    public function dashboard($request,$statuses){
        return [
            'counts' => $this->counts($request,$statuses),
            'calibrateable' => $this->calibrateable($request),
            'maintenanceable' => $this->maintenanceable($request),
            'calibrations' => $this->calibrations($request),
            'maintenances' => $this->maintenances($request),
        ];
    }

    public function counts($request,$statuses){
        foreach($statuses as $status){
            $count = Equipment::where('status_id',$status['value'])->count();
            $arr[] = [
                'name' => $status['name'],
                'value' => $status['value'],
                'count' => $count
            ];
        }
        return $arr;
    }

    private function calibrateable($request){
        $count = Equipment::where('calibration_program','!=','Not Applicable')->count();

        return $arr = [
            'name' => 'Calibratable Equipments',
            'icon' => 'ri-pencil-ruler-2-fill',
            'color' => 'bg-info-subtle',
            'count' => $count
        ];
    }

    private function maintenanceable($request){
        $count = Equipment::where('maintenance_plan','!=',NULL)->count();

        return $arr = [
            'name' => 'Maintenanceable Equipments',
            'icon' => 'ri-todo-line ',
            'color' => 'bg-info-subtle',
            'count' => $count
        ];
    }

    public function maintenances($request){
         return [
            [
                'name' => 'Maintenance Complete',
                'description' => 'Successfully maintained and ready for use',
                'count' => Equipment::whereDate('maintenance_due','>',now())->count(),
                'icon' => 'ri-checkbox-circle-fill',
                'color' => 'bg-success-subtle text-success'
            ],
            [
                'name' => 'Maintenance Due Soon',
                'description' => '30 days ahead of the maintenance due date',
                'count' => Equipment::whereBetween('maintenance_due', [Carbon::now()->startOfDay(), Carbon::now()->addDays(30)->endOfDay()])->count(),
                'icon' => 'ri-error-warning-line',
                'color' => 'bg-warning-subtle text-warning'
            ],
            [
                'name' => 'Overdue Maintenance',
                'description' => 'Maintenance is past its scheduled due date',
                'count' => Equipment::whereDate('maintenance_due','<',now())->whereNotIn('status_id',[36,37])->count(),
                'icon' => 'ri-error-warning-fill',
                'color' => 'bg-danger-subtle text-danger'
            ],
            [
                'name' => 'Unscheduled Maintenance',
                'description' => 'Ensure follow-up on unclaimed reports.',
                'count' => Equipment::where('maintenance_due',NULL)->whereNotIn('status_id',[36,37])->count(),
                'icon' => 'ri-information-fill',
                'color' => 'bg-dark-subtle text-dark'
            ],
        ];
    }

    public function calibrations($request){
        return [
            [
                'name' => 'Calibration Complete',
                'description' => 'Successfully calibrated and ready for use',
                'count' => Equipment::whereDate('calibration_due','>',now())->count(),
                'icon' => 'ri-checkbox-circle-fill',
                'color' => 'bg-success-subtle text-success'
            ],
            [
                'name' => 'Calibration Due Soon',
                'description' => '30 days ahead of the calibration due date',
                'count' => Equipment::whereBetween('calibration_due', [Carbon::now()->startOfDay(), Carbon::now()->addDays(30)->endOfDay()])->count(),
                'icon' => 'ri-error-warning-line',
                'color' => 'bg-warning-subtle text-warning'
            ],
            [
                'name' => 'Overdue Calibration',
                'description' => 'Calibration is past its scheduled due date',
                'count' => Equipment::whereDate('calibration_due','<',now())->where('calibration_program','!=','Not Applicable')->whereNotIn('status_id',[36,37])->count(),
                'icon' => 'ri-error-warning-fill',
                'color' => 'bg-danger-subtle text-danger'
            ],
            [
                'name' => 'Unscheduled Calibration',
                'description' => 'Ensure follow-up on unclaimed reports.',
                'count' => Equipment::where('calibration_due',NULL)->where('calibration_program','!=','Not Applicable')->whereNotIn('status_id',[36,37])->count(),
                'icon' => 'ri-information-fill',
                'color' => 'bg-dark-subtle text-dark'
            ],
        ];
    }

    public function lists($request){
        $data = IndexResource::collection(
            Equipment::query()
            ->with('logs','info','laboratory','user.profile','agency','status')
            ->addSelect([
                'last_calibration' => EquipmentLog::select('date')->where('is_calibrated',1)->whereColumn('equipment_id', 'equipment.id')->latest()->take(1),
                'last_maintenance' => EquipmentLog::select('date')->where('is_calibrated',0)->whereColumn('equipment_id', 'equipment.id')->latest()->take(1),
            ])
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('code', 'LIKE', "%{$keyword}%")->orWhere('name', 'LIKE', "%{$keyword}%");
            })
            ->when($request->status , function ($query,$status) {
               $query->where('status_id',$status);
            }) 
            ->when($request->laboratory , function ($query, $labtype ) {
                (is_array($labtype)) ?  $query->whereIn('laboratory_id',$labtype ) : $query->where('laboratory_id',$labtype );
            }) 
            ->when($request->reminder, function ($query, $reminder) {
                switch($reminder){
                    case 'Calibration Complete':
                        $query->whereDate('calibration_due','>',now());
                    break;
                    case 'Calibration Due Soon':
                        $query->whereBetween('calibration_due', [Carbon::now()->startOfDay(), Carbon::now()->addDays(30)->endOfDay()]);
                    break;
                    case 'Overdue Calibration':
                        $query->where('calibration_program','!=','Not Applicable')->whereDate('calibration_due','<',now())->whereNotIn('status_id',[36,37]);
                    break;
                    case 'Unscheduled Calibration':
                        $query->where('calibration_program','!=','Not Applicable')->where('calibration_due',NULL)->whereNotIn('status_id',[36,37]);
                    break;
                    case 'Maintenance Complete':
                        $query->whereDate('maintenance_due','>',now());
                    break;
                    case 'Maintenance Due Soon':
                        $query->whereBetween('maintenance_due', [Carbon::now()->startOfDay(), Carbon::now()->addDays(30)->endOfDay()]);
                    break;
                    case 'Overdue Maintenance':
                        $query->whereDate('maintenance_due','<',now())->whereNotIn('status_id',[36,37]);
                    break;
                    case 'Unscheduled Maintenance':
                        $query->where('maintenance_due',NULL)->whereNotIn('status_id',[36,37]);
                    break;
                }
            })
            ->orderBy('code','ASC')
            ->paginate($request->count)
        );
        return $data;
    }
}
