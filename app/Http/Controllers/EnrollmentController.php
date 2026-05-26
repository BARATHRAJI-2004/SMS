<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['student', 'course']);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->input('course_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $enrollments = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $courses = Course::orderBy('course_code')->get();

        return view('enrollments.index', compact('enrollments', 'courses'));
    }

    public function create()
    {
        // Only load students who are Active
        $students = Student::where('status', 'Active')->orderBy('last_name')->get();
        $courses = Course::orderBy('course_code')->get();

        return view('enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'enrollment_date' => 'required|date',
        ]);

        // 1. Check if already active enrolled
        $alreadyEnrolled = Enrollment::where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->where('status', 'Enrolled')
            ->exists();

        if ($alreadyEnrolled) {
            return redirect()->back()->withErrors(['course_id' => 'This student is already actively enrolled in this course.'])->withInput();
        }

        // 2. Check course capacity
        $course = Course::findOrFail($validated['course_id']);
        $currentEnrollmentCount = Enrollment::where('course_id', $course->id)
            ->where('status', 'Enrolled')
            ->count();

        if ($currentEnrollmentCount >= $course->capacity) {
            return redirect()->back()->withErrors(['course_id' => 'Cannot enroll. The course has reached its maximum capacity of ' . $course->capacity . ' students.'])->withInput();
        }

        Enrollment::create([
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'enrollment_date' => $validated['enrollment_date'],
            'status' => 'Enrolled',
        ]);

        return redirect()->route('enrollments.index')->with('success', 'Student enrolled successfully!');
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'grade' => 'nullable|string|in:A+,A,B+,B,C+,C,D,F',
            'status' => 'required|in:Enrolled,Completed,Dropped',
        ]);

        // If completed, check that grade is provided. Or if dropped, grade might be null.
        if ($validated['status'] === 'Completed' && empty($validated['grade'])) {
            return redirect()->back()->withErrors(['grade' => 'A grade is required to complete a course.']);
        }

        $enrollment->update($validated);

        return redirect()->back()->with('success', 'Enrollment details updated successfully!');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('success', 'Enrollment record removed.');
    }
}
