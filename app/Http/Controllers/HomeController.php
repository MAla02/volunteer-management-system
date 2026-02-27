<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Volunteer;
use App\Models\Assignment;

class HomeController extends Controller
{
    /**
     * التحقق من تسجيل الدخول (Story #16)
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * عرض المهام الشخصية للمتطوع (Story #12)
     */
    public function index()
    {
        $user = Auth::user();

        // الآدمن في السبرنت 3 قد يرى صفحة بسيطة أو يتم توجيهه للوحات التحكم الأخرى
        if ($user->role === 'admin') {
            return view('home'); 
        }

        // منطق السبرنت 3: جلب مهام المتطوع بناءً على إيميله
        $volunteer = Volunteer::where('email', $user->email)->first();
        $myTasks = collect(); 

        if ($volunteer) {
            $myTasks = Assignment::with(['location', 'task'])
                        ->where('volunteer_id', $volunteer->id)
                        ->get();
        }

        return view('home', compact('myTasks'));
    }
}