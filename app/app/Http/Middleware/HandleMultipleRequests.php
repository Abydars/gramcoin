<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class HandleMultipleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->input('_token');

        if($token) {
            $token = session($token);

            session($token, Carbon::now());

            if($token) {
                $last_visited = Carbon::parse($token);

                $diff = Carbon::now()->diffInSeconds($last_visited);
                if ($diff < 10) {
                    return redirect()->route('deal.index');
                }
            }
        }
        return $next($request);
    }
}
