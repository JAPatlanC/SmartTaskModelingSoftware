<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Content::all();
        $Content = new Content;
        return view('contents.index',  compact(['projects','Content']));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contents.create');
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
            'image' => 'required'
        ]);
        $Content = new Content;
        $file = $request->file('image');
        $Content->filename=$file->getClientOriginalName();
        $Content->filetype=$file->getClientOriginalExtension();
        $Content->size=$file->getSize();

        $imagedata = file_get_contents($file->getRealPath());
        $base64 = base64_encode($imagedata);
        $Content->body=$base64;
        $Content->save();

        return redirect()->route('contents.index')
            ->with('success', 'Archivo creada.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Content  $Content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $Content)
    {
        return redirect()->route('contents.index')
            ->with('success', 'Actividad actualizada');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Content  $Content
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $Content)
    {
        $projects = Content::all();
        return view('contents.index',  compact(['projects','Content']));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Content  $Content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $Content)
    {
        $request->validate([
            'description' => 'required',
            'type' => 'required'
        ]);

        $Content->update($request->all());

        $Content->themes()->sync($request->temas);
        return redirect()->route('contents.index')
            ->with('success', 'Actividad actualizada');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $Content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $Content)
    {
        $Content->delete();

        return redirect()->route('contents.index')
            ->with('success', 'Archivo eliminado');
    }
}
