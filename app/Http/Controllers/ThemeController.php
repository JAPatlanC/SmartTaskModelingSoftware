<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Theme::with('parent')->get();
        $themesList = Theme::pluck('name', 'id');
        $theme = new Theme;
        $isUpdate = false;
        return view('themes.index',  compact(['projects','themesList','theme','isUpdate']));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Themes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required'
        ]);

        Theme::create($request->all());

        return redirect()->route('themes.index')
            ->with('success', 'Tema creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Theme  $Theme
     * @return \Illuminate\Http\Response
     */
    public function show(Theme $Theme)
    {
        return redirect()->route('themes.index')
            ->with('success', 'Tema actualizado');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Theme  $Theme
     * @return \Illuminate\Http\Response
     */
    public function edit(Theme $theme)
    {
        $projects = Theme::with('parent')->get();
        $themesList = Theme::pluck('name', 'id');
        $isUpdate = true;
        return view('themes.index',  compact(['projects','themesList','theme','isUpdate']));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Theme  $Theme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Theme $Theme)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required'
        ]);
        $Theme->update($request->all());

        return redirect()->route('themes.index')
            ->with('success', 'Tema actualizado');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Theme  $Theme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theme $Theme)
    {
        $Theme->delete();

        return redirect()->route('themes.index')
            ->with('success', 'Tema eliminado');
    }

}
