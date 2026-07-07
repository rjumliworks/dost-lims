<?php

namespace App\Http\Controllers\Finance;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Finance\WalletClass;

class WalletController extends Controller
{
    use HandlesTransaction;

    protected WalletClass $wallet;

    public function __construct(WalletClass $wallet){
        $this->wallet = $wallet;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->wallet->lists($request);
            break;
            default :
            return inertia('Modules/Executive/Wallets/Index');
        }
    }

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'wallet':
                    return $this->wallet->wallet($request);
                break;
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }
}
