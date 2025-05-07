<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStaffPosition
{
    public function handle(Request $request, Closure $next, ...$positions)
    {
        $staff = $request->user();

        if (!$staff || !in_array($staff->position, $positions)) {
            abort(403, 'Unauthorized access for your position');
        }

        return $next($request);
    }
}
