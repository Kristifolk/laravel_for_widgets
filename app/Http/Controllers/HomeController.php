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
//    public function index()
//    {
//        $clients = (new ApiRequest())->allClients();
//        $firstFiftyClients = array_slice($clients, 0, 50);
//
//        return view('home', compact('firstFiftyClients'));
//    }

    public function index()
    {
        try {
            $clients = (new ApiRequest())->allClients();
            $firstFiftyClients = array_slice($clients, 0, 50);
        } catch (\Exception $exception) {
            return redirect('/settingsApi')->withErrors($exception->getMessage());
        }

        return view('home', compact('firstFiftyClients'));
    }
}
