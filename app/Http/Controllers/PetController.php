<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetFormRequest;
use App\Services\ApiRequest;

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
     * @throws \Exception
     */
    public function store(StorePetFormRequest $request,$ownerId)
    {
        $validated = $request->validated();
        $decodeBodyResponse = (new ApiRequest())->createInVetmanager('pet', $validated);

        if (!isset($decodeBodyResponse)) {
            return back()->withErrors('Ошибка создания питомца');
        }

        return redirect("client/$ownerId")->with('message', 'Питомец успешно создан');
    }

    /**
     * Показать питомца.
     * @throws \Exception
     */
    public function show(int $id)
    {
        $pet = (new ApiRequest())->one('pet', $id);
        return view('pet.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     * @throws \Exception
     */
    public function edit(int $id)
    {
        $oldPetInfo = (new ApiRequest())->one('pet', $id);
        return view('pet.edit', compact('oldPetInfo'));
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(StorePetFormRequest $request, int $id)
    {
        $validated = $request->validated();
        $ownerId = $validated['owner_id'];

        (new ApiRequest())->edit('pet', $validated, $id);

        return redirect("client/$ownerId")->with('message', 'Питомец успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Exception
     */
    public function destroy(int $id)
    {
        (new ApiRequest())->delete('pet', $id);
        return back()->with('message', 'Питомец успешно удален');
    }
}
