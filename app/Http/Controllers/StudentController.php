<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        $students = $query->orderBy('student_id', 'asc')->paginate(10)->withQueryString();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:Male,Female',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:Active,Suspended,Graduated,Inactive',
            'profile_picture_file' => 'nullable|image|max:2048',
        ]);

        // Auto-generate student_id
        $latestStudent = Student::orderBy('id', 'desc')->first();
        $nextNumber = $latestStudent ? ((int) substr($latestStudent->student_id, 9)) + 1 : 1;
        $validated['student_id'] = "STU-2026-" . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        if ($request->hasFile('profile_picture_file')) {
            $path = $request->file('profile_picture_file')->store('profiles', 'public');
            $validated['profile_picture'] = $path;
        }

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student registered successfully!');
    }

    public function show(Student $student)
    {
        $student->load(['enrollments.course']);
        
        // Calculate GPA
        $gradesList = $student->enrollments()->whereNotNull('grade')->where('status', '!=', 'Dropped')->pluck('grade')->toArray();
        $gradePoints = [
            'A+' => 4.0, 'A' => 4.0, 'B+' => 3.5, 'B' => 3.0, 
            'C+' => 2.5, 'C' => 2.0, 'D' => 1.0, 'F' => 0.0
        ];
        
        $totalPoints = 0;
        $gradedCount = 0;
        foreach ($gradesList as $g) {
            if (isset($gradePoints[$g])) {
                $totalPoints += $gradePoints[$g];
                $gradedCount++;
            }
        }
        $gpa = $gradedCount > 0 ? round($totalPoints / $gradedCount, 2) : 'N/A';

        return view('students.show', compact('student', 'gpa'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => "required|email|unique:students,email,{$student->id}",
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:Male,Female',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:Active,Suspended,Graduated,Inactive',
            'profile_picture_file' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_picture_file')) {
            // Delete old picture if exists
            if ($student->profile_picture) {
                Storage::disk('public')->delete($student->profile_picture);
            }
            $path = $request->file('profile_picture_file')->store('profiles', 'public');
            $validated['profile_picture'] = $path;
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student details updated successfully!');
    }

    public function destroy(Student $student)
    {
        if ($student->profile_picture) {
            Storage::disk('public')->delete($student->profile_picture);
        }
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student record deleted successfully.');
    }

    public function exportCsv()
    {
        $students = Student::all();
        $csvFileName = 'students_directory_' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($students) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Student ID', 'First Name', 'Last Name', 'Email', 'Phone', 'Gender', 'DOB', 'Enrollment Date', 'Status']);

            foreach ($students as $student) {
                fputcsv($file, [
                    $student->student_id,
                    $student->first_name,
                    $student->last_name,
                    $student->email,
                    $student->phone,
                    $student->gender,
                    $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '',
                    $student->enrollment_date ? $student->enrollment_date->format('Y-m-d') : '',
                    $student->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
