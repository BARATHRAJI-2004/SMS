<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed an admin/test user for Breeze dashboard access
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@academy.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Seed 30 students
        $students = Student::factory(30)->create();

        // 3. Seed 10 courses
        $courses = Course::factory(10)->create();

        // 4. Seed random enrollments for students
        $grades = ['A+', 'A', 'B+', 'B', 'C+', 'C', 'D', 'F', null];
        
        foreach ($students as $student) {
            // Enroll each student in 2 to 4 courses randomly
            $numCourses = rand(2, 4);
            $randomCourses = $courses->random($numCourses);

            foreach ($randomCourses as $course) {
                // Ensure capacity limits are kept safe
                if ($course->enrollments()->count() < $course->capacity) {
                    $status = rand(1, 10) > 8 ? 'Dropped' : (rand(1, 10) > 5 ? 'Completed' : 'Enrolled');
                    
                    $grade = null;
                    if ($status === 'Completed') {
                        $grade = $grades[array_rand(array_filter($grades, fn($g) => !is_null($g)))];
                    } elseif ($status === 'Enrolled' && rand(1, 10) > 4) {
                        $grade = $grades[array_rand(array_filter($grades, fn($g) => !is_null($g)))];
                    }

                    Enrollment::create([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'enrollment_date' => $student->enrollment_date->addDays(rand(1, 15)),
                        'grade' => $grade,
                        'status' => $status,
                    ]);
                }
            }
        }
    }
}

