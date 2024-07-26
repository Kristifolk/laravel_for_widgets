<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetFormRequest;
use App\Models\Pet;
use App\Services\ApiRequest;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class PetController extends Controller
{
    public function index($ownerId)
    {
//
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $ownerId)
    {
//        dd('create');
//        dd(gettype($ownerId));

        return view('pet.create',  compact('ownerId'));
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(StorePetFormRequest $request, $ownerId)
    public function store(StorePetFormRequest $request,$ownerId)
    {
//        dd(gettype($ownerId));
        try {
            $validated = $request->validated();//как узнать прошла ли валидация?
//            dd($request);
            (new ApiRequest())->createInVetmanager('pet', $validated);
//            return redirect(url()->previous());
            dd($validated);
//            return redirect("client/{$validated['ownerId']}']}");
            return redirect("client/$ownerId");
        } catch (\Exception $exception) {
            dd(1111);
            dd($exception->getMessage());
            return back()->withErrors($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $pet = (new ApiRequest())->getPet($id);
        dd($pet);
        return view('pet.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        return view('pet.edit');
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
