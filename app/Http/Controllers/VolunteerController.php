<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;



class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('volunteers.create');    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. التحقق من البيانات (تأكدي من صحة الإيميل وأنه غير مكرر في الجدولين)
    $validatedData = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:volunteers|unique:users',
        'phone' => 'required'
    ]);

    // 2. إنشاء المتطوع في جدول volunteers
    Volunteer::create($validatedData);

    // 3. إنشاء حساب دخول (User) في جدول users بنفس البيانات
    \App\Models\User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make('12345678'), // كلمة المرور الافتراضية
        'role'     => 'volunteer', // تحديد الدور تلقائياً كمتطوع
    ]);

    // 4. التوجه لصفحة القائمة مع رسالة نجاح
    return redirect()->route('volunteers.index')->with('success', 'Volunteer created and login account generated!');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit(string $id)
{
    $volunteer = Volunteer::findOrFail($id);
    return view('volunteers.edit', compact('volunteer'));  
}


    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, string $id)
{
    $volunteer = Volunteer::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        // 'email' => 'required|email|unique:volunteers,email,' . $volunteer->id,
        'phone' => 'required',
    ]);

    $volunteer->update($validatedData);

    return redirect()->route('volunteers.index')->with('success', 'Volunteer updated successfully!');
}



    /**
     * Remove the specified resource from storage.
     */
public function destroy(string $id)
{
    $volunteer = Volunteer::findOrFail($id);  
    $volunteer->delete();                   
    
    return redirect()->route('volunteers.index')->with('success', 'Volunteer deleted successfully!');
}

}
