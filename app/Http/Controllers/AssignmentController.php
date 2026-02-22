<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Volunteer;
use App\Models\Location;
use App\Models\Task;



class AssignmentController extends Controller
{
    public function index() {
        $assignments = Assignment::with(['volunteer', 'location', 'task'])->get();
        return view('assignments.index', compact('assignments'));
    }

    public function create() {
        return view('assignments.create', [
            'volunteers' => Volunteer::all(),
            'locations' => Location::all(),
            'tasks' => Task::all()
        ]);
    }

    public function store(Request $request) {
        Assignment::create($request->validate([
            'volunteer_id' => 'required|exists:volunteers,id',
            'location_id' => 'required|exists:locations,id',
            'task_id' => 'required|exists:tasks,id'
        ]));
        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
    }
}
