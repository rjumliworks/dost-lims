<?php

namespace App\Services\Others\Equipments;

use App\Models\Equipment;
use App\Models\EquipmentLog;
use App\Models\EquipmentInfo;
use App\Http\Resources\Others\Equipments\IndexResource;
class SaveClass
{
    public function save($request){
        $service = Equipment::create(array_merge($request->all(),[
            'status_id' => 35
        ]));
        if($service){
            $service->info()->create(array_merge($request->all(),[
                'user_id' => \Auth::user()->id
            ]));
        }
        return [
            'data' => $service,
            'message' => 'Equipment added successful!', 
            'info' => "You've successfully added the new equipment."
        ];
    }

    public function perform($request){
        $service = EquipmentLog::create(array_merge($request->all(),[
            'user_id' => \Auth::user()->id
        ]));
        if($service){
            if($request->is_calibrated){
                Equipment::where('id',$request->equipment_id)->update(['calibration_due' => $request->next_date]);
            }else{
                Equipment::where('id',$request->equipment_id)->update(['maintenance_due' => $request->next_date]);
            }
        }

        $data = Equipment::with('logs','user.profile','laboratory','agency')
        ->addSelect([
            'last_calibration' => EquipmentLog::select('date')->where('is_calibrated',1)->whereColumn('equipment_id', 'equipment.id')->latest()->take(1),
            'last_maintenance' => EquipmentLog::select('date')->where('is_calibrated',0)->whereColumn('equipment_id', 'equipment.id')->latest()->take(1),
        ])
        ->where('id',$request->equipment_id)->first();

        return [
            'data' => new IndexResource($data),
            'message' => 'Equipment successfully calibrated or maintained.', 
            'info' => "Your submission has been recorded. The next due date is automatically set based on the duration field."
        ];
    }

    public function update($request){
        $data = Equipment::where('id',$request->id)->first();
        $data->code = $request->code;
        $data->name = $request->name;
        $data->calibration_program = $request->calibration_program;
        $data->maintenance_plan = $request->maintenance_plan;
        $data->calibration_testpoints = $request->calibration_testpoints;
        $data->laboratory_id = $request->laboratory_id;
        if($data->save()){
            $data1 = EquipmentInfo::where('equipment_id',$request->id)->first();
            $data1->manufacturer = $request->manufacturer;
            $data1->model = $request->model;
            $data1->price = $request->price;
            $data1->serial_no = $request->serial_no;
            $data1->supplier_id = $request->supplier_id;
            $data1->acquired_at = $request->acquired_at;
            $data1->others = $request->others;
            $data1->save();
            $data = Equipment::where('id',$request->id)->first();
            return [
                'data' => $data,
                'message' => 'Equipment updated successfully!', 
                'info' => "You've successfully updated the equipment."
            ];
        }
    }   

    public function status($request){
        $data = Equipment::where('id',$request->id)->first();
        $data->status_id = $request->status_id;
        $data->save();
            $data = Equipment::with('status')->where('id',$request->id)->first();
        return [
            'data' => $data->status,
            'message' => 'Equipment status updated successfully!', 
            'info' => "You've successfully updated the equipment status."
        ];
    } 
    
    public function delete($id){
        $data = EquipmentLog::where('id',$id)->first();
        $equipment_id = $data->equipment_id;
        $is_calibrated = $data->is_calibrated;
       
        if($data->delete()){
            $latest = EquipmentLog::where('equipment_id', $equipment_id)
            ->latest() 
            ->first();
            if($latest){
                $latest_due = $latest->next_date;
            }else{
                $latest_due = null;
            }
            
            $equipment = Equipment::where('id',$equipment_id)->first();
            if($is_calibrated){
                $equipment->calibration_due = $latest_due;
            }else{
                $equipment->maintenance_due = $latest_due;
            }
            $equipment->save();
        }
        return [
            'data' => $data,
            'message' => 'Equipment status updated successfully!', 
            'info' => "You've successfully updated the equipment status."
        ];
    } 
}
