<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Volunteer;
use App\Models\Location;
use App\Models\Task;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 

class AssignmentController extends Controller
{
    public function index(Request $request) {
    $search = $request->input('search');

    $assignments = Assignment::with(['volunteer', 'location', 'task'])
        ->when($search, function ($query, $search) {
            return $query->whereHas('volunteer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('task', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        })->latest()->paginate(10);

    return view('assignments.index', compact('assignments'));
}

    public function create() {
        $volunteers = Volunteer::all();
        $locations = Location::all();
        $tasks = Task::all();

        if($volunteers->isEmpty() || $locations->isEmpty() || $tasks->isEmpty()) {
            return redirect()->back()->with('error', 'Please ensure volunteers, locations, and tasks are added first.');
        }

        return view('assignments.create', compact('volunteers', 'locations', 'tasks'));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'volunteer_id' => 'required|exists:volunteers,id',
            'location_id'  => 'required|exists:locations,id',
            'task_id'      => 'required|exists:tasks,id',
            'assigned_date' => 'required|date' 
        ]);

        Assignment::create($validated);
        
        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully!');
    }

    // --- 1. دالة عرض صفحة التعديل (Edit) ---
    public function edit($id)
    {
        $assignment = Assignment::findOrFail($id);
        $volunteers = Volunteer::all();
        $locations = Location::all();
        $tasks = Task::all();
        
        return view('assignments.edit', compact('assignment', 'volunteers', 'locations', 'tasks'));
    }

    // --- 2. دالة حفظ التعديلات (Update) ---
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'volunteer_id' => 'required|exists:volunteers,id',
            'location_id'  => 'required|exists:locations,id',
            'task_id'      => 'required|exists:tasks,id',
            'status'       => 'required|in:pending,completed,cancelled',
        ]);

        $assignment = Assignment::findOrFail($id);
        $assignment->update($validated);

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully!');
    }

    public function updateStatus(Request $request, $id) {
        $assignment = Assignment::findOrFail($id);
        $assignment->update(['status' => 'completed']); 
        return back()->with('success', 'Task status updated successfully!');
    }

    public function cancel($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->status = 'cancelled';
        $assignment->save();

        return back()->with('success', 'Assignment has been marked as Cancelled.');
    }

    public function updateProfile(Request $request) {
        $user = auth()->user();
        
        $request->validate([
            'phone' => 'required|numeric',
            'password' => 'nullable|min:8|confirmed', 
        ]);

        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return back()->with('success', 'Profile updated successfully!');
    }
}