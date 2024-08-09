<?php

namespace App\Exceptions;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

use function Laravel\Prompts\error;

class InvalidOrderException extends \Exception
{

}
