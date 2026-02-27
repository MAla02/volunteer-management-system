<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function welcome() {
        $tasks = Task::all(); 
        return view('welcome', compact('tasks'));
    }

    public function showApplyForm($task_id) {
        $task = Task::findOrFail($task_id);
        return view('apply', compact('task'));
    }

    public function store(Request $request) {
        $request->validate([
            'task_id'   => 'required|exists:tasks,id',
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'phone'     => 'required|string',
            'major'     => 'required|string',
            'message'   => 'required|string',
            'cv_path'   => 'required|mimes:pdf|max:2048',
        ]);

        $path = $request->file('cv_path')->store('cvs', 'public');

        Application::create([
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'major'     => $request->major,
            'message'   => $request->message, 
            'task_id'   => $request->task_id,
            'cv_path'   => $path,
            'status'    => 'pending'
        ]);

        return redirect()->back()->with('success', 'Your application has been submitted successfully! We will contact you soon');
    }

    public function index() {
    // جلب الطلبات التي لم يتم التعامل معها فقط (حالتها انتظار)
    $applications = Application::with('task')
        ->where('status', 'pending') 
        ->latest()
        ->get();

    return view('admin.applications.index', compact('applications'));
}

    public function updateStatus(Request $request, $id) {
        $application = Application::findOrFail($id);
        $application->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Application status updated to ' . $request->status);
    }

    public function myApplications() {
        if(Auth::check()){
            $applications = Application::where('user_id', Auth::id())->with('task')->get();
            return view('my_applications', compact('applications'));
        }
        return redirect()->route('login');
    }

    // --- الدوال الجديدة التي كانت تنقصك (أضيفيها الآن) ---

    // 1. عرض صفحة إدخال الإيميل للتتبع
    public function showStatusForm() {
        return view('application_status_check');
    }

    // 2. البحث عن الطلب وعرض حالته
    public function checkStatus(Request $request) {
        $request->validate([
            'email' => 'required|email'
        ]);

        // نبحث عن آخر طلب قدمه هذا الشخص باستخدام الإيميل
        $application = Application::where('email', $request->email)->with('task')->latest()->first();

        if (!$application) {
            return redirect()->back()->with('error', 'No application found for this email address.');
        }

        // نعود لنفس الصفحة ومعنا بيانات الطلب لعرضها
        return view('application_status_check', compact('application'));
    }
}