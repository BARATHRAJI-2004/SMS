<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        $subjects = [
            'CS' => ['Introduction to Computer Science', 'Data Structures & Algorithms', 'Database Management Systems', 'Software Engineering', 'Web Development', 'Artificial Intelligence', 'Mobile App Development', 'Cybersecurity Foundations'],
            'MATH' => ['Calculus I', 'Calculus II', 'Linear Algebra', 'Discrete Mathematics', 'Probability & Statistics'],
            'PHY' => ['General Physics I', 'General Physics II', 'Quantum Mechanics', 'Electromagnetism'],
            'ENG' => ['Academic Writing', 'Technical Communication', 'English Literature', 'Public Speaking'],
            'BUS' => ['Introduction to Business', 'Financial Accounting', 'Principles of Marketing', 'Organizational Behavior']
        ];

        $dept = $this->faker->randomElement(array_keys($subjects));
        $name = $this->faker->randomElement($subjects[$dept]);
        $code = $dept . '-' . $this->faker->unique()->numberBetween(101, 499);

        return [
            'course_code' => $code,
            'name' => $name,
            'description' => "This course covers core principles of {$name}, including fundamental concepts, practical assignments, and team projects.",
            'credits' => $this->faker->randomElement([2, 3, 4]),
            'teacher_name' => 'Prof. ' . $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'capacity' => $this->faker->randomElement([25, 30, 40, 50]),
        ];
    }
}
