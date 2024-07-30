<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetFormRequest;
use App\Models\Pet;
use App\Services\ApiRequest;
use Illuminate\Http\Request;

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
    public function store(StorePetFormRequest $request,$ownerId)
    {
        try {
            $validated = $request->validated();
            (new ApiRequest())->createInVetmanager('pet', $validated);

            return redirect("client/$ownerId");
        } catch (\Exception $exception) {
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
        try {
            (new ApiRequest())->deletePet($id);
            return back()->with('message', 'Pet deleted successfully');

        } catch (\Exception $exception) {
            return back()->with('message',  $exception->getMessage());
        }
    }
}
