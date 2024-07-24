<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientFormRequest;
use App\Http\Requests\UpdateClientFormRequest;
use App\Models\Pet;
use App\Models\Client;
use App\Services\ApiRequest;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
//        dd('index');
//        return view('home');
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
    public function store(StoreClientFormRequest $request)
    {
//        dd('store');
        $client = Client::create(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_name' => $request->middle_name,
                'email' => $request->email,
                'city' => $request->city,
                'phone' => $request->phone,
            ]
        );
        $pets = [];

        if ($request->has('pets')) {
            foreach ($request->pets as $pet) {
                $pet = Pet::create(
                    [
                        'client_id' => $client->id,//откуда взять
                        'name' => $pet['name'],
                        'type' => $pet['type'],
                        'breed' => $pet['breed'] ?? null,
                        'color' => $pet['color'] ?? null,
                        'age' => $pet['age'] ?? null,
                    ]
                );
                $pets[] = $pet;
            }
        }

        return response()->json([
            'success' => true,
            'client' => $client,
            'pets' => $pets,
        ]);
    }

    /**
     * Клиент и все его питомцы.
     */
    public function show(int $owner_id)
    {
//        $client = (new ApiRequest)->getClient($owner_id);
        $pets =  (new ApiRequest)->getAllPetsClient($owner_id);
        $client = $pets[0]['owner'];

        return view('client.show', compact('client', 'pets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
//        $client = ApiRequest::getClient($id);
//        return view('client.edit', compact('client'));
        return view('client.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientFormRequest $request, int $id)
    {
//        dd('update');
//id?
        $client = Client::update(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_name' => $request->middle_name,
                'email' => $request->email,
                'city' => $request->city,
                'phone' => $request->phone,
            ]
        );
        return response()->json([
            'success' => true,
            'client' => $client,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
//        dd('destroy');
//        $client = ApiRequest::deleteClient($id);
//
//        return response()->json(['success' => true]);
        return redirect()->route('/')->with('success', 'Client deleted successfully');

    }

    public function search(Request $request)//валидация?
    {
        $lastname = $request->input('last_name');
//        $firstname = $request->input('first_name');
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
