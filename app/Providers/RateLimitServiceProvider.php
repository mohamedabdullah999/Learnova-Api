<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        $limits = config('ratelimits.limits');

        foreach($limits as $key => $limit) {

            RateLimiter::for($key, function (Request $request) use ($key,$limit) {

                $limit =  Limit::perMinute($limit)->by($request->ip());

                return $limit->response(function() use ($key) {
                    return response()->json([
                        'status' => false,
                        'message' => "Too many requests for {$key}. Please try again later."
                    ], 429);
                });

            });
        }
    }
}
