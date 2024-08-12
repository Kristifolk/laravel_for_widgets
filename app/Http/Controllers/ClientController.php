<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchClientFormRequest;
use App\Http\Requests\StoreUpdateClientFormRequest;
use App\Services\ApiRequest;

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
     * @throws \Exception
     */
    public function store(StoreUpdateClientFormRequest $request)
    {
        $validated = $request->validated();
        $decodeBodyResponse = (new ApiRequest())->createInVetmanager('client', $validated);

        if (!isset ($decodeBodyResponse) || !isset($decodeBodyResponse['data']['client'][0]['id'])) {
            return back()->withErrors('Ошибка создания клиента');
        }
        $id = $decodeBodyResponse['data']['client'][0]['id'];

        return redirect("client/$id")->with('message', 'Клиент успешно создан');
    }

    /**
     * Клиент и все его питомцы.
     * @throws \Exception
     */
    public function show(string $ownerId)
    {
        $client = (new ApiRequest())->one('client', $ownerId);
        $pets =  (new ApiRequest)->allPetsClient($ownerId);

        return view('client.show', compact('client', 'pets'));
    }

    /**
     * Show the form for editing the specified resource.
     * @throws \Exception
     */
    public function edit(int $id)
    {
        $oldClientInfo = (new ApiRequest())->one('client', $id);
        return view('client.edit', compact('oldClientInfo'));
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(StoreUpdateClientFormRequest $request, int $id)
    {
        $validated = $request->validated();
        (new ApiRequest())->edit('client', $validated, $id);

        return redirect("client/$id")->with('message', 'Клиент успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        (new ApiRequest())->delete('client', $id);
        return redirect()->route('home')->with('message', 'Клиент успешно удален');
    }

    /**
     * Search by client's last name
     * @throws \Exception
     */
    public function search(SearchClientFormRequest $request)
    {
        $lastname = $request->input('last_name');
//        $firstname = $request->input('first_name');//TOdo поиск по полному ФИО,а не только фамилии
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
