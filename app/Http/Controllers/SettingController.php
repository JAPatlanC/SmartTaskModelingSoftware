<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Setting::all();
        $themesList = Setting::pluck('name', 'id');
        $setting = new Setting;
        $isUpdate = false;
        return view('settings.index',  compact(['projects','themesList','setting','isUpdate']));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Theme  $Theme
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {

        $projects = Setting::all();

        $themesList = Setting::pluck('name', 'id');
        $isUpdate = true;
        return view('settings.index',  compact(['projects','themesList','setting','isUpdate']));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Theme  $Theme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required'
        ]);
        $setting->update($request->all());

        return redirect()->route('settings.index')
            ->with('success', 'Configuración actualizada');
    }

}
