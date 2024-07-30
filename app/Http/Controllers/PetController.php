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

            return redirect("client/$ownerId")->with('message', 'Питомец успешно создан');
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
//        dd($pet);
        return view('pet.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $oldPetInfo = (new ApiRequest())->getPet($id);
        return view('pet.edit', compact('oldPetInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePetFormRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
            $ownerId = $validated['owner_id'];

            (new ApiRequest())->editPet('pet', $validated, $id);

            return redirect("client/$ownerId")->with('message', 'Питомец успешно обновлен');
        } catch (\Exception $exception) {
            return back()->withErrors($exception->getMessage());
            //TOdo если не успешно не выводится сообщение только редирект back
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            (new ApiRequest())->deletePet($id);
            return back()->with('message', 'Питомец успешно удален');

        } catch (\Exception $exception) {
            return back()->with('message',  $exception->getMessage());
        }
    }
}
