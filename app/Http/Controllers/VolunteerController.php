<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Models\User; // إضافة موديل المستخدم
use Illuminate\Support\Facades\Hash; // إضافة مكتبة التشفير

class VolunteerController extends Controller
{
    /**
     * عرض قائمة المتطوعين مع ميزة البحث والترقيم (Story #1)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $volunteers = Volunteer::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10); 

        return view('volunteers.index', compact('volunteers'));
    }

    /**
     * عرض نموذج إضافة متطوع جديد
     */
    public function create()
    {
        return view('volunteers.create');
    }

    /**
     * تخزين متطوع جديد وإنشاء حساب مستخدم تلقائياً (Story #2)
     */
    // This method handles manual volunteer entry (Story #1)
    public function store(Request $request)
    {
        // 1. التحقق من البيانات (التأكد من أن الإيميل فريد في الجدولين)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:volunteers|unique:users',
            'phone' => 'required'
        ]);

        // 2. إنشاء سجل المتطوع
        Volunteer::create($validatedData);

        // 3. إنشاء حساب دخول تلقائي للمتطوع (Story #2)
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make('12345678'), // كلمة مرور افتراضية كما هو متفق عليه
            'role'     => 'volunteer', // تحديد الدور
        ]);

        return redirect()->route('volunteers.index')
                         ->with('success', 'Volunteer added and account created successfully!');
    }

    /**
     * عرض نموذج التعديل
     */
    public function edit(string $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        return view('volunteers.edit', compact('volunteer'));
    }

    /**
     * تحديث بيانات المتطوع
     */
    public function update(Request $request, string $id)
    {
        $volunteer = Volunteer::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:volunteers,email,' . $volunteer->id,
            'phone' => 'required',
        ]);

        $volunteer->update($validatedData);

        return redirect()->route('volunteers.index')
                         ->with('success', 'Volunteer updated successfully!');
    }

    /**
     * حذف متطوع
     */
    public function destroy(string $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->delete();

        return redirect()->route('volunteers.index')
                         ->with('success', 'Volunteer deleted successfully!');
    }
}