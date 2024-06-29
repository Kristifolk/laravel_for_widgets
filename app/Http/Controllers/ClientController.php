<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('index');
//        $clients = //по api получить клиентов Ветменеджер
//            return view('home', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'client.create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd('store');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
//        $client =
//        return view(
//            'client.show',
//            compact('client')
//        );
        return view(
            'client.show'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view(
            'client.edit'
        );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd('update');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd('destroy');
//        $client = Client::findOrFail($id);
// удалить со всеми питомцами
//        $client->deleteClient($id);

//        return response()->json(['success' => true]);
        return redirect()->route('home')->with('success', 'Client deleted successfully');

    }

    public function search(Request $request)
    {
        dd('search');
    }
}
