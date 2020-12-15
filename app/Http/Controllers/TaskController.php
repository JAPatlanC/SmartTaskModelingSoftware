<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Content;
use Illuminate\Http\Request;

use App\Models\Task;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Task::with('themes','contents')->get();
        $task = new Task;
        $isUpdate = false;
        $themesList = Theme::pluck('name', 'id');
        $contentList = Content::pluck('filename', 'id');
        return view('tasks.index',  compact(['projects','task','isUpdate','themesList','contentList']));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
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
            'description' => 'required',
            'type' => 'required'
        ]);

        $task = Task::create($request->all());
        if($task->type=='Checkbox'){
            $suma=0;
            try{
                foreach(explode(',',$task->answer) as $ans){
                    $suma += $ans;
                }
            }catch(\Exception $e){
                return Redirect::back()->withErrors(['Valide los valores de la respuesta separa por comas (debe sumar 100)'])->withInput($request->all());
            }
            if($suma!=100)
                return Redirect::back()->withErrors(['Valide los valores de la respuesta separa por comas (debe sumar 100)'])->withInput($request->all());
        }
        #dd($request->temas);
        $task->themes()->sync($request->temas);
        $task->contents()->sync($request->archivos);

        return redirect()->route('tasks.index')
            ->with('success', 'Actividad creada.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $Task)
    {
        return redirect()->route('tasks.index')
            ->with('success', 'Actividad actualizada');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $projects = Task::with('themes','contents')->get();
        $isUpdate = true;
        $themesList = Theme::pluck('name', 'id');
        $contentList = Content::pluck('filename', 'id');
        return view('tasks.index',  compact(['projects','task','isUpdate','themesList','contentList']));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $Task)
    {
        $request->validate([
            'description' => 'required',
            'type' => 'required'
        ]);

        $Task->update($request->all());

        $Task->themes()->sync($request->temas);
        $Task->contents()->sync($request->archivos);
        return redirect()->route('tasks.index')
            ->with('success', 'Actividad actualizada');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $Task)
    {
        $Task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Actividad eliminada');
    }
}
