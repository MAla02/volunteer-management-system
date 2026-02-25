<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Application;

class ApplicationController extends Controller
{
    /**
     * عرض نموذج التقديم لمهمة معينة
     */
    public function showApplyForm($task_id) {
        $task = Task::findOrFail($task_id);
        return view('apply', compact('task'));
    }

    /**
     * مهمة ملاك الأساسية: تخزين بيانات الطلب ورفع الـ CV
     */
    public function store(Request $request) {
        // التحقق من البيانات (حماية ضد السبام والبيانات الفارغة)
        $request->validate([
            'task_id'   => 'required|exists:tasks,id',
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'required|string|max:20',
            'major'     => 'required|string|max:255',
            'message'   => 'required|string|min:10',
            'cv_path'   => 'required|mimes:pdf|max:2048', // شرط السبرنت: PDF فقط
        ]);

        // رفع الملف وتخزينه في المجلد العام (Storage)
        $path = $request->file('cv_path')->store('cvs', 'public');

        // إنشاء السجل في قاعدة البيانات
        Application::create([
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'major'     => $request->major,
            'message'   => $request->message, 
            'task_id'   => $request->task_id,
            'cv_path'   => $path,
            'status'    => 'pending' // الحالة الافتراضية
        ]);

        // رسالة النجاح المطلوبة في الـ Acceptance Criteria
        return redirect()->back()->with('success', 'Application submitted successfully!');
    }
}