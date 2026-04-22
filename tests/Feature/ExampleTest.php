<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_volunteers_page_is_accessible()
{
    // هاد التست بيتأكد إن صفحة عرض المتطوعين شغالة ومش معطلة
    $response = $this->get('/volunteers'); 

    $response->assertStatus(200);
} 

public function test_it_can_create_a_volunteer()
{
    // بنجرب نبعث بيانات متطوع جديد
    $volunteerData = [
        'name' => 'Malak Test',
        'email' => 'malak@test.com',
        'phone' => '123456789'
    ];

    $this->post('/volunteers', $volunteerData);

    // بنتأكد إن البيانات انحفظت في الداتابيز فعلاً
    $this->assertDatabaseHas('volunteers', [
        'email' => 'malak@test.com'
    ]);
}
}
 
