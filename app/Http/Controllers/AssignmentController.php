<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Volunteer;
use App\Models\Location;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // عرض جدول المهام للآدمن (Story #5)
    public function index() {
        // نكتفي بالعرض البسيط دون paginate معقد إذا لم يطلب
        $assignments = Assignment::with(['volunteer', 'location', 'task'])->latest()->get();
        return view('assignments.index', compact('assignments'));
    }

    // صفحة إضافة تكليف (Story #5)
    public function create() {
        return view('assignments.create', [
            'volunteers' => Volunteer::all(),
            'locations' => Location::all(),
            'tasks' => Task::all()
        ]);
    }

    // حفظ التكليف في قاعدة البيانات (Story #5)
    public function store(Request $request) {
        $validated = $request->validate([
            'volunteer_id' => 'required|exists:volunteers,id',
            'location_id'  => 'required|exists:locations,id',
            'task_id'      => 'required|exists:tasks,id',
            'assigned_date' => 'required|date', 
        ]);

        Assignment::create($validated);
        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully!');
    }

    // عرض المهام الخاصة بالمتطوع (Story #12)
    public function myTasks() {
        $user = Auth::user();
        
        // الربط الأساسي بالسبرنت 3: نبحث عن المتطوع بإيميله 
        $volunteer = Volunteer::where('email', $user->email)->first();

        $myTasks = collect();
        if ($volunteer) {
            $myTasks = Assignment::where('volunteer_id', $volunteer->id)
                ->with(['location', 'task'])
                ->get();
        }
        
        return view('home', compact('myTasks'));
    }
}