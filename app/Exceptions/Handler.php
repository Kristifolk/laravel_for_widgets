<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (InvalidOrderException $e) {
            $exception = "Проверьте свои настройки: url клиники и API ключ. Произошла ошибка при выполнении запроса к API: " . $e->getMessage();
//            dd( $exception);
            return response()->view('errors.invalidApi', compact('exception'));
//            var_dump('gg'); die();
        });
    }
}
