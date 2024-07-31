<?php

namespace App\Http\Controllers;

use App\Services\ApiRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *Вывод по 50 клиентов на хоум странице
     */
    public function index()
    {
        $clients = (new ApiRequest())->getAllClients();
        $firstFiftyClients = array_slice($clients, 0, 50);

        return view('home', compact('firstFiftyClients'));
    }
}
