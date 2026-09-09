<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DatabaseModeController extends Controller
{
    /**
     * Flip the local-only Test Mode / Live Data switch (see
     * App\Http\Middleware\SwitchDatabaseConnection). Hidden entirely
     * outside the local environment.
     */
    public function toggle(Request $request)
    {
        abort_unless(app()->environment('local'), 404);

        session(['db_test_mode' => ! session('db_test_mode', false)]);

        return back();
    }
}
