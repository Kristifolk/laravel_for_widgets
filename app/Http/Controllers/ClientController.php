<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientFormRequest;
use App\Http\Requests\StoreUpdateClientFormRequest;
use App\Services\ApiRequest;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateClientFormRequest $request)  //TOdo тест id client id pet создаются с шагом 2, id 50, id 52..
    {
        try {
            $validated = $request->validated();
            $decodeBodyResponse = (new ApiRequest())->createInVetmanager('client', $validated);

            if (!isset ($decodeBodyResponse) || !isset($decodeBodyResponse['data']['client'][0]['id'])) {
                return back()->withErrors('Ошибка создания клиента');
            }
            $id = $decodeBodyResponse['data']['client'][0]['id'];

            return redirect("client/$id")->with('message', 'Клиент успешно создан');
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    /**
     * Клиент и все его питомцы.
     */
    public function show(string $ownerId)
    {
        $client = (new ApiRequest())->getClient($ownerId);
        $pets =  (new ApiRequest)->getAllPetsClient($ownerId);

        return view('client.show', compact('client', 'pets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $oldClientInfo = (new ApiRequest())->getClient($id);
        return view('client.edit', compact('oldClientInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateClientFormRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
            (new ApiRequest())->editClient('client', $validated, $id);

            return redirect("client/$id")->with('message', 'Клиент успешно обновлен');
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            (new ApiRequest())->deleteClient($id);

            return redirect()->route('home')->with('message', 'Клиент успешно удален');
//            return back()->with('message', 'Client deleted successfully');

        } catch (\Exception $exception) {
            return back()->with('message',  $exception->getMessage());
        }
    }

    public function search(Request $request)//TOdo валидация?
    {
        $lastname = $request->input('last_name');
//        $firstname = $request->input('first_name');//TOdo поиск по ФИО,а не только фамилии?
//        $middlename = $request->input('middle_name');
//        $foundClients = (new ApiRequest())->searchClients($lastname, $firstname, $middlename);

        $foundClients = (new ApiRequest())->searchClients($lastname);

        if(!empty($foundClients)){
            $searchInfoMessage = "Результаты поиска по запросу: $lastname";
        } else {
            $searchInfoMessage = "По результатом поиска не найдено совпадений";
        }

        return view('client.search', compact('foundClients', 'searchInfoMessage'));
    }
}
