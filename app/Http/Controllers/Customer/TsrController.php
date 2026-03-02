<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tsr;
use App\Http\Resources\Public\Customer\TsrResource;

class TsrController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'list':
                return $this->list($request);
            break;
            default:
                return inertia('Customer/Tsrs/Index');
        }
    }

    private function list(Request $request){
        $data = Tsr::with('payment.status','status')->whereIn('status_id',[2,3,4])->where('customer_id',\Auth::guard('customer')->id())->paginate(10);
        return TsrResource::collection($data);
    }
}
