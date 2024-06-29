<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('index pet');

    }

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
    public function store(Request $request)
    {
        dd('store pet');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
//        $pet =
//        return view(
//            'pet.show',
//            compact('pet')
//        );
        return view(
            'pet.show'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view(
            'pet.edit'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd('update pet');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd('destroy pet');

    }
}
