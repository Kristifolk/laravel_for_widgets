<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserSettingApiRequest;
use App\Http\Requests\UpdateUserSettingApiRequest;
use App\Models\UserSettingApi;
use Illuminate\Support\Facades\Auth;

class UserSettingApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = UserSettingApi::where('user_id', Auth::user()->id)->first();
        return view('settingsApi.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settingsApi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserSettingApiRequest $request)
    {
        UserSettingApi::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
            ],
            [
                'url' => $request->get('url'),
                'api_key' => $request->get('api_key'),
            ]
        );

        return redirect()->route('settingsApi.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
//        dd('попали в show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $oldSettings = UserSettingApi::where('user_id', Auth::user()->id)->first();
        return view('settingsApi.edit', compact('oldSettings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id,UpdateUserSettingApiRequest $request)
    {
        UserSettingApi::where('user_id', $id)
        ->update([
            'url' => $request->get('url'),
            'api_key' => $request->get('api_key'),
        ]);
        return redirect()->route('settingsApi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        UserSettingApi::where('user_id', $id)->delete();
        return redirect()->route('settingsApi.index');
    }
}
