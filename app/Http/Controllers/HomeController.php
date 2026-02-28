<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Volunteer;
use App\Models\Assignment;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // 1. منطق الأدمن: جلب كل التوزيعات ليعرضها في الصفحة الرئيسية (مثل الصورة التي أرفقتيها)
        if ($user->role === 'admin') {
            $allAssignments = Assignment::with(['volunteer', 'location', 'task'])
                                ->latest()
                                ->paginate(10); // لجعل الواجهة غنية بالبيانات

            return view('home', [
                'isAdmin' => true,
                'allAssignments' => $allAssignments
            ]);
        }

        // 2. منطق المتطوع: جلب مهامه الشخصية
        $volunteer = Volunteer::where('email', $user->email)->first();
        $myTasks = collect(); 

        if ($volunteer) {
            $myTasks = Assignment::with(['location', 'task'])
                        ->where('volunteer_id', $volunteer->id)
                        ->where('status', '!=', 'cancelled')
                        ->latest()
                        ->get();
        }

        return view('home', [
            'isAdmin' => false,
            'myTasks' => $myTasks
        ]);
    }

    public function completeTask($id)
    {
        $assignment = Assignment::findOrFail($id);

        $volunteer = Volunteer::where('email', Auth::user()->email)->first();
        if (!$volunteer || $assignment->volunteer_id !== $volunteer->id) {
            abort(403, 'Unauthorized action.');
        }

        // تحديث الحالة
        $assignment->status = 'completed';
        $assignment->save();

        return redirect()->route('home')->with('success', 'Great job! Task marked as completed. 🎉');
    }
}