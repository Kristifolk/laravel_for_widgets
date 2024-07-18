<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Services\ApiRequest;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
//    public function index($id_client)
//    {
//        dd('index pet');
////        $pets = ApiRequest::getAllPetsClient($id_client);
////
////        return view('client.show', compact('$pets'));
//
//    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'pet.create'
        );    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$ClientId)
    {
        dd('store pet');
//        $client = ApiRequest::getClient($ClientId);
//        $pets = [];
//
//        if ($request->has('pets')) {
//            foreach ($request->pets as $pet) {
//                $pet = Pet::create(
//                    [
//                        'client_id' => $client->id,
//                        'name' => $pet['name'],
//                        'type' => $pet['type'],
//                        'breed' => $pet['breed'] ?? null,
//                        'color' => $pet['color'] ?? null,
//                        'age' => $pet['age'] ?? null,
//                    ]
//                );
//                $pets[] = $client->pets;
//                $pets[] = $pet;
//            }
//        }
//        $pets[] = $client->pets;
//        return response()->json([
//            'success' => true,
//            'pets' => $pets,
//        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $ClientId, int $id)
    {
//        $client = ApiRequest::getClient($ClientId);
//        $pets = [];
////или         $pet = ApiRequest::getPet($id);
//        if ($client->pets) {
//            foreach ($client->pets as $pet) {
//                $pets[] = $pet;
//            }
//
//        return view('pet.show', compact('client','pets'));

        return view(
            'pet.show'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        return view(
            'pet.edit'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
//        dd('update pet');

        $pet = Pet::update(
            [
                'client_id' => $request->client->id,
                'name' => $request->pet['name'],
                'type' => $request->pet['type'],
                'breed' => $request->pet['breed'] ?? null,
                'color' => $request->pet['color'] ?? null,
                'age' => $request->pet['age'] ?? null,
            ]
        );
        return response()->json([
            'success' => true,
            '$pet' => $pet,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        dd('destroy pet');
//        $pet = ApiRequest::deletePet($id);
//
//        return response()->json(['success' => true]);
    }
}
