<?php

namespace App\Traits;

use Illuminate\Database\QueryException;
use Throwable;

trait HandlesTransaction
{
    public static function handleTransaction($callback){
        $data = '';
        $info = null;
        $status = false;

        try {
            $result = \DB::transaction($callback);
            // $status = ($result['status'] === 'error') ? false : true;
            $data = $result['data'];
            $info = $result['info'];
            $message = $result['message'];
            // $status = $status;
            $status = isset($result['status']) ? $result['status'] : true;
        } catch (QueryException $e) {
            $info = 'Transaction failed: ' . $e->getMessage();
            $message = 'Error occured';
        } catch (Throwable $e) {
            $info = 'An unexpected error occurred: ' . $e->getMessage();
            $message = 'Error occured';
        }

        return [
            'data' => ($data) ? $data : 'Nothing found.',
            'message' => $message,
            'info' => $info,
            'status' => $status,
        ];
    }
}
