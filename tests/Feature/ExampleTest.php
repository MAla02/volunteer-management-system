<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_redirects_to_login(): void
    {
        // بما إنك عاملة ريدايركت في web.php فحصنا إنه فعلاً بيحولنا
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_volunteers_page_is_accessible()
    {
        // تسجيل دخول
        $user = User::factory()->create();

        // دخول لصفحة المتطوعين
        $response = $this->actingAs($user)->get('/volunteers'); 
        
        // لو لسا بيعطيكي 500، رح نخليه يفحص بس إنه المسار موجود
        // بس غالباً مع RefreshDatabase رح يشتغل تمام
        $response->assertStatus(200);
    } 

    public function test_it_can_create_a_volunteer()
    {
        $user = User::factory()->create();

        $volunteerData = [
            'name' => 'Malak Test',
            'email' => 'malak' . rand(1,1000) . '@test.com',
            'phone' => '123456789'
        ];

        // تنفيذ الإضافة
        $response = $this->actingAs($user)->post('/volunteers', $volunteerData);

        // التأكد من التحويل لصفحة الـ index بعد الإضافة بنجاح
        $response->assertRedirect(route('volunteers.index'));

        // التأكد من وجود البيانات
        $this->assertDatabaseHas('volunteers', [
            'name' => 'Malak Test',
            'phone' => '123456789'
        ]);
    }
}
