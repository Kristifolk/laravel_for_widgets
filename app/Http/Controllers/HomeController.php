<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
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
     *Вывод по 50 клиентов на хоум странице $totalPage = количество клиентов / 50 клиентов на странице,
     * если на следующей странице будет менее 50 клиентов, то выведет сколько есть.
     * Чтобы изменить количество выводимых клиентов на одной странице, требуется заменить цифру 50 в ApiRequest fiftyClients() $paginate и HomeController в index() $totalPage
     */
//    public function index()
//    {
//        $clients = (new ApiRequest())->allClients();
//        $firstFiftyClients = array_slice($clients, 0, 50);
//
//        return view('home', compact('firstFiftyClients'));
//    }

    public function index(Request $request)
    {
//        try {
            $currentPage = $request->get('page', 1);

            if (!is_numeric($currentPage) || $currentPage < 1) {
                $currentPage = 1;
            }

            $data = (new ApiRequest())->fiftyClients($currentPage);
            if($data == null) {//TOdo Этот if надо?
                throw new Exception('Проверьте свои настройки: url клиники и API ключ. Произошла ошибка при выполнении запроса к API');
            }
            $firstFiftyClients = $data['client'];
            $totalPage = ceil($data['totalCount']/50);

        return view('home', compact('firstFiftyClients', 'currentPage', 'totalPage'));
    }
}
