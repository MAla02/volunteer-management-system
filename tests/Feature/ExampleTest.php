<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase; // ضفت هاد السطر
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase; // وضفت هاد السطر كمان عشان ينظف الداتابيز تلقائياً

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
        // بيتأكد إن صفحة المتطوعين بتفتح
        $response = $this->get('/volunteers'); 
        $response->assertStatus(200);
    } 

    public function test_it_can_create_a_volunteer()
    {
        // بيانات تجريبية (تأكدي إن الحقول مطابقة لجدولك)
        $volunteerData = [
            'name' => 'Malak Test',
            'email' => 'malak' . rand(1,100) . '@test.com', // استعملت rand عشان ما يتكرر الايميل
            'phone' => '123456789'
        ];

        $this->post('/volunteers', $volunteerData);

        // بنتأكد إن البيانات موجودة في الداتابيز
        $this->assertDatabaseHas('volunteers', [
            'name' => 'Malak Test'
        ]);
    }
}
