<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tsr;
use App\Models\Customer;
use App\Http\Resources\Public\Customer\TsrResource;
use App\Http\Resources\Common\Customer\ViewResource;

class CustomerController extends Controller
{
    public function view(){
        return inertia('Public/Customer/Index');
    }

    public function tsrs(Request $request){
        $data = Tsr::with('payment.status','status')->whereIn('status_id',[2,3,4])->where('customer_id',$request->id)->paginate(10);
        return TsrResource::collection($data);
    }

    public function profile(Request $request){
        $data = new ViewResource(
            Customer::query()
            ->with('conformes','payors')
            ->with('customer_name:id,name','classification:id,name','industry:id,name','type:id,name','sex:id,name','led:id,name')
            ->with('address.region:code,name,region','address.province:code,name','address.municipality:code,name','address.barangay:code,name')
            ->where('id',$request->id)->first()
        );
        return $data;
    }

    public function login(){
        return inertia('Public/Customer/Login');
    }

    public function logout(Request $request): RedirectResponse
    {
        \Auth::guard('customer')->logout(); // logout the participant guard
        $request->session()->invalidate();     // invalidate session
        $request->session()->regenerateToken(); // regenerate CSRF token

        return redirect('/customer/login'); // or any route you prefer
    }
}
