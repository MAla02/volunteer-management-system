<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;



class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    $volunteers = Volunteer::all();
    return view('volunteers.index', compact('volunteers'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('volunteers.create');    }

    /**
     * Store a newly created resource in storage.
     */
    // This method handles manual volunteer entry (Story #1)
    public function store(Request $request)
    {
        Volunteer::create($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:volunteers',
            'phone' => 'required'
        ]));
        return redirect()->route('volunteers.index');
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
    $volunteer = Volunteer::findOrFail($id);
    return view('volunteers.edit', compact('volunteer'));  
}


    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, string $id)
{
    $volunteer = Volunteer::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        // 'email' => 'required|email|unique:volunteers,email,' . $volunteer->id,
        'phone' => 'required',
    ]);

    $volunteer->update($validatedData);

    return redirect()->route('volunteers.index')->with('success', 'Volunteer updated successfully!');
}



    /**
     * Remove the specified resource from storage.
     */
public function destroy(string $id)
{
    $volunteer = Volunteer::findOrFail($id);  
    $volunteer->delete();                   
    
    return redirect()->route('volunteers.index')->with('success', 'Volunteer deleted successfully!');
}

}
