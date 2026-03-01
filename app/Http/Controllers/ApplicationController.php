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

        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }

    /**
     * تحديث السبرنت الرابعة: عرض الطلبات مع ميزة البحث المتقدم (شغل ملاك)
     */
    public function index(Request $request) {
    $search = $request->input('search');

    $applications = Application::with('task')
        ->when($search, function($query, $search) {
            // التصحيح هنا: وضعنا كل شروط الـ or داخل مجموعة واحدة لضمان دقة البحث
            return $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('major', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('task', function($taskQuery) use ($search) {
                      $taskQuery->where('name', 'like', "%{$search}%");
                  }); // تم إغلاق قوس الدالة هنا بشكل صحيح
            });
        })
        ->latest()
        ->paginate(10);

    return view('admin.applications.index', compact('applications'));
}

    public function updateStatus(Request $request, $id) {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $application = Application::findOrFail($id);
        $application->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Application status updated to ' . $request->status);
    }

    public function myApplications() {
        if(Auth::check()){
            // جلب طلبات المستخدم المسجل حالياً
            $applications = Application::where('email', Auth::user()->email)
                                     ->with('task')
                                     ->get();
            return view('my_applications', compact('applications'));
        }
        return redirect()->route('login');
    }

    // --- نظام تتبع حالة الطلب (بدون إرسال إيميل خارجي) ---

    public function showStatusForm() {
        return view('application_status_check');
    }

    public function checkStatus(Request $request) {
        $request->validate([
            'email' => 'required|email'
        ]);

        // البحث عن الطلب لعرض حالته مباشرة في الصفحة (تتبع)
        $application = Application::where('email', $request->email)
                                    ->with('task')
                                    ->latest()
                                    ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'No application found for this email address.');
        }

        return view('application_status_check', compact('application'));
    }
}