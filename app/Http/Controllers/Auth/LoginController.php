<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * هذه الدالة يتم استدعاؤها تلقائياً فور نجاح عملية تسجيل الدخول
     */
    protected function authenticated(Request $request, $user)
    {
        // التعديل الجراحي هنا:
        // إذا كان المستخدم أدمن، نرسله لصفحة الداشبورد (home) وليس لصفحة المهام (tasks)
        if ($user->role === 'admin') {
            return redirect()->route('home'); 
        }

        // إذا كان مستخدماً عادياً (متطوع)، نرسله لصفحة الهوم الخاصة به
        return redirect('/home');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}