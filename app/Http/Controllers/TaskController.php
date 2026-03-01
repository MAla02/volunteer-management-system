<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;



class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->input('search');
    $tasks = Task::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('description', 'like', "%{$search}%");
    })->latest()->paginate(10);

    return view('tasks.index', compact('tasks'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Task::create($request->validate([
            'name' => 'required|unique:tasks,name|max:255',
            'description' => 'nullable'
        ]));
        return redirect()->route('tasks.index')->with('success', 'Task Added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

public function edit(string $id)
{
    $task = Task::findOrFail($id);
    return view('tasks.edit', compact('task')); 
}
    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, string $id)
{
    $task = Task::findOrFail($id); 

    $validated = $request->validate([
        'name' => 'required|max:255|unique:tasks,name,',
        'description' => 'nullable'
    ]);

    $task->update($validated);

    return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
public function destroy(string $id)
{
    $task = Task::findOrFail($id); 
    $task->delete();              
    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
}

}
