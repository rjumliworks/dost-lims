<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SwitchDatabaseConnection
{
    /**
     * Repoints the default DB connection to the 'mysql_test' database for the
     * rest of this request when the local-only Test Mode toggle is on.
     *
     * Must run after StartSession (needs the session flag) so it does not
     * affect how the session/auth guard were bootstrapped for this request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (app()->environment('local') && session('db_test_mode')) {
            config(['database.default' => 'mysql_test']);
        }

        return $next($request);
    }
}
