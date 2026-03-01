<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// استيراد الموديلات هنا يمنع حدوث أخطاء "Class not found"
use App\Models\Volunteer;
use App\Models\Assignment;
use App\Models\Application; 

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        // الحالة الأولى: إذا كان المستخدم أدمن (إرسال الإحصائيات)
        if ($user->role === 'admin') {
            $stats = [
                'volunteers_count'  => Volunteer::count(),
                'tasks_completed'   => Assignment::where('status', 'completed')->count(),
                'pending_requests'  => Application::where('status', 'pending')->count(),
                'total_assignments' => Assignment::count(),
            ];
            
            // نمرر الـ stats لصفحة home
            return view('home', compact('stats'));
        }

        // الحالة الثانية: إذا كان متطوع (إرسال المهام)
        $volunteer = Volunteer::where('email', $user->email)->first();
        $myTasks = collect(); // مصفوفة فارغة لضمان عدم حدوث خطأ في الـ view

        if ($volunteer) {
            $myTasks = Assignment::with(['location', 'task'])
                        ->where('volunteer_id', $volunteer->id)
                        ->where('status', '!=', 'cancelled')
                        ->get();
        }

        return view('home', compact('myTasks'));
    }

    /**
     * دالة تحديث حالة المهمة إلى مكتملة
     */
    public function completeTask($id)
    {
        $assignment = Assignment::findOrFail($id);

        $assignment->update([
            'status' => 'completed'
        ]);

        return redirect()->route('home')->with('status', 'Task marked as completed! Well done. 🎉');
    }

    /**
     * دالة تحديث بيانات المتطوع الشخصية (رقم الهاتف وكلمة المرور)
     */
    /**
     * دالة تحديث بيانات المتطوع الشخصية (رقم الهاتف وكلمة المرور)
     */
   public function updateProfile(Request $request)
{
    $user = Auth::user();

    // 1. التحقق: جعلنا كل شيء اختياري (Sometimes) عشان لو عدلتي واحد الثاني ما يضرب
    $request->validate([
        'phone'    => 'sometimes|nullable|string|max:20',
        'password' => 'sometimes|nullable|min:8', 
    ]);

    // 2. تحديث الهاتف "فقط" إذا تم إرساله في الفورم وليس فارغاً
    if ($request->filled('phone')) {
        Volunteer::where('email', $user->email)->update([
            'phone' => $request->phone
        ]);
    }

    // 3. تحديث الباسورد "فقط" إذا تم إرساله وليس فارغاً
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
        $user->save();
    }

    return redirect()->route('home')->with('status', 'Profile updated successfully! ✅');
}
}