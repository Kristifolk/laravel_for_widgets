<?php

namespace App\Http\Middleware;

use App\Models\UserSettingApi;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckApiSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user || !UserSettingApi::doesTheUserHaveApiSettings($user)){
            return redirect('/settingsApi');
        }

        return $next($request);
    }
}
