<?php

namespace App\Http\Controllers;

use App\Services\ApiRequest;
use Illuminate\Http\Request;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Запрос 50 чел по Api
        $clients = (new ApiRequest())->getAllClients();

        dd($clients);
//        return view('home', compact('clients'));

//        return view('home');
    }

    public function search()
    {
        return view('client.search');
    }
}
