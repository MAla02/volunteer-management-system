<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Task;
use App\Models\Volunteer;
use App\Models\Assignment;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->input('search');
    $locations = Location::when($search, function ($query, $search) {
        return $query->where('name', 'like', "%{$search}%");
    })->latest()->paginate(10);

    return view('locations.index', compact('locations'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('locations.create');    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Location::create($request->validate([
            'name' => 'required|unique:locations,name',
            'description' => 'nullable'
        ]));
        return redirect()->route('locations.index');
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
        
        public function edit(string $id){
            $location = Location::findOrFail($id); // اجلب السجل
            return view('locations.edit', compact('location')); // ثم مرره للعرض

        }
        




    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, string $id)
{
    $location = Location::findOrFail($id); // اجلب السجل أولاً

    $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'nullable'
    ]);

    $location->update($validatedData);

    return redirect()->route('locations.index')->with('success', 'Location updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
public function destroy(string $id)
{
    $location = Location::findOrFail($id); // جلب الموقع باستخدام ID
    $location->delete();                   // حذف الموقع

    return redirect()->route('locations.index')->with('success', 'Location deleted successfully!');
    
}

}
