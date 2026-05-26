<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        static $sequenceNum = 1;
        $gender = $this->faker->randomElement(['Male', 'Female']);
        $firstName = $gender === 'Male' ? $this->faker->firstNameMale() : $this->faker->firstNameFemale();
        $lastName = $this->faker->lastName();
        $status = $this->faker->randomElement(['Active', 'Active', 'Active', 'Suspended', 'Graduated', 'Inactive']);
        
        $paddedNum = str_pad($sequenceNum++, 4, '0', STR_PAD_LEFT);
        $studentId = "STU-2026-" . $paddedNum;

        return [
            'student_id' => $studentId,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => strtolower($firstName . '.' . $lastName . $paddedNum . '@academy.com'),
            'phone' => $this->faker->numerify('+91 ##########'),
            'date_of_birth' => $this->faker->dateTimeBetween('-24 years', '-18 years')->format('Y-m-d'),
            'gender' => $gender,
            'enrollment_date' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'status' => $status,
            'profile_picture' => null,
        ];
    }
}
