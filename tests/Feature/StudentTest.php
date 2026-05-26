<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin user for testing
        $this->user = User::factory()->create();
    }

    public function test_unauthenticated_user_cannot_access_students(): void
    {
        $response = $this->get(route('students.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_view_students_list(): void
    {
        Student::factory(3)->create();

        $response = $this->actingAs($this->user)->get(route('students.index'));

        $response->assertStatus(200);
        $response->assertViewHas('students');
    }

    public function test_authenticated_admin_can_register_student(): void
    {
        $studentData = [
            'first_name' => 'Kavin',
            'last_name' => 'Prasad',
            'email' => 'kavin.prasad@academy.com',
            'phone' => '+91 9876543210',
            'date_of_birth' => '2004-05-12',
            'gender' => 'Male',
            'enrollment_date' => '2026-05-26',
            'status' => 'Active',
        ];

        $response = $this->actingAs($this->user)->post(route('students.store'), $studentData);

        $response->assertRedirect(route('students.index'));
        $this->assertDatabaseHas('students', [
            'first_name' => 'Kavin',
            'last_name' => 'Prasad',
            'email' => 'kavin.prasad@academy.com',
        ]);
    }

    public function test_authenticated_admin_can_export_students_csv(): void
    {
        Student::factory(2)->create();

        $response = $this->actingAs($this->user)->get(route('students.export.csv'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }
}
