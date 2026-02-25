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
     * تم تعديلها لتشمل البحث والترتيب والتقسيم لصفحات (Story #3)
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
        return view('locations.create');
    }

    /**
     * Store a newly created resource in storage.
     * تم تعديلها لإضافة شرط "unique" لمنع تكرار الأسماء (Story #3)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:locations,name|max:255', 
            'description' => 'nullable'
        ]);

        Location::create($validated);

        return redirect()->route('locations.index')->with('success', 'تمت إضافة الموقع بنجاح!');
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
        $location = Location::findOrFail($id); 
        return view('locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     * يفضل إضافة استثناء للمعالجة الحالية في الـ unique عند التحديث
     */
    public function update(Request $request, string $id)
    {
        $location = Location::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:locations,name,' . $id,
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
        $location = Location::findOrFail($id); 
        $location->delete(); 

        return redirect()->route('locations.index')->with('success', 'Location deleted successfully!');
    }
}