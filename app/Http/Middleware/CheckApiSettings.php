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
     * @param Closure(Request): (Response) $next
     */
//    public function handle(Request $request, Closure $next): Response
//    {
//        $user = Auth::user();
//
//        try {
//            if (!$user || !UserSettingApi::isTheUserHaveApiSettings($user)){
//                return redirect('/settingsApi');
//            }
//        } catch (\Exception $exception) {
//            return redirect('/settingsApi')->withErrors($exception->getMessage());
//        }
//
//        return $next($request);
//    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/settingsApi');
        }

        try {
            UserSettingApi::userApiSettings();
        } catch (\Exception $exception) {
            return redirect('/settingsApi')->withErrors($exception->getMessage());
        }

        return $next($request);
    }
}
