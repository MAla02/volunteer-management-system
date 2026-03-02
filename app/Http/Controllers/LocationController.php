<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * عرض قائمة المواقع مع البحث والتقسيم لصفحات
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
     * عرض نموذج إنشاء موقع جديد
     */
    public function create()
    {
        return view('locations.create');
    }

    /**
     * تخزين الموقع الجديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:locations,name|max:255', 
            'description' => 'nullable'
        ]);

        Location::create($validated);

        return redirect()->route('locations.index')->with('success', 'Location added successfully!');
    }

    /**
     * عرض بيانات موقع محدد (اختياري)
     */
    public function show(string $id)
    {
        //
    }

    /**
     * عرض نموذج تعديل الموقع
     */
    public function edit(string $id)
    {
        $location = Location::findOrFail($id); 
        return view('locations.edit', compact('location'));
    }

    /**
     * تحديث بيانات الموقع في قاعدة البيانات
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
     * حذف الموقع من قاعدة البيانات
     */
    public function destroy(string $id)
    {
        $location = Location::findOrFail($id); 
        $location->delete(); 

        return redirect()->route('locations.index')->with('success', 'Location deleted successfully!');
    }
}