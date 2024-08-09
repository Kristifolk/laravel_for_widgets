<?php

namespace App\Http\Middleware;

use App\Services\ApiRequest;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

//TOdo Этот HandleApiExceptions надо?
class HandleApiExceptions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
//            dd(777);
            return $next($request);
        }   catch (GuzzleException $exception) {
            dd(1222);
            throw new Exception('Проверьте свои настройки: url клиники и API ключ. Произошла ошибка при выполнении запроса к API: ' . $exception->getMessage());
        } catch (Exception $exception) {
            dd(1333);
            throw new Exception('Проверьте свои настройки: url клиники и API ключ. Произошла ошибка при выполнении запроса к API: ' . $exception->getMessage());
        }

//        return Redirect::to('/settingsApi')->withErrors($exception->getMessage());
    }
}
