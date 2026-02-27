<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // إذا كان المستخدم غير مسجل دخول أو دوره لا يطابق الدور المطلوب
        if (!auth()->check() || auth()->user()->role !== $role) {
            // نرجعه للرئيسية مع رسالة تنبيه
            return redirect('/home')->with('error', 'ليس لديك صلاحية للدخول لهذه الصفحة.');
        }

        return $next($request);
    }
}