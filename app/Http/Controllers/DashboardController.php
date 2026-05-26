<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Core Metrics
        $totalStudents = Student::count();
        $totalCourses = Course::count();
        $activeEnrollments = Enrollment::where('status', 'Enrolled')->count();
        
        // Calculate average grade (gpa simulation from letters)
        $gradesList = Enrollment::whereNotNull('grade')->where('status', '!=', 'Dropped')->pluck('grade')->toArray();
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
        $averageGpa = $gradedCount > 0 ? round($totalPoints / $gradedCount, 2) : 0.0;

        // 2. Recent enrollments activity
        $recentEnrollments = Enrollment::with(['student', 'course'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // 3. Chart Data: Monthly Enrollments (Last 6 Months)
        $monthlyEnrollments = Enrollment::select(
                DB::raw("DATE_FORMAT(enrollment_date, '%b %Y') as month"),
                DB::raw("count(*) as count")
            )
            ->groupBy('month')
            ->orderBy('enrollment_date', 'asc')
            ->limit(6)
            ->get();

        $trendLabels = $monthlyEnrollments->pluck('month')->toArray();
        $trendData = $monthlyEnrollments->pluck('count')->toArray();

        // 4. Chart Data: Gender distribution
        $genderData = Student::select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->pluck('count', 'gender')
            ->toArray();
        
        $genderLabels = array_keys($genderData);
        $genderCounts = array_values($genderData);

        // 5. Chart Data: Student Status distribution
        $statusData = Student::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        $statusLabels = array_keys($statusData);
        $statusCounts = array_values($statusData);

        // 6. Chart Data: Courses Capacity vs Enrollment
        $coursesData = Course::withCount(['enrollments' => function($q) {
                $q->where('status', 'Enrolled');
            }])
            ->limit(5)
            ->get();

        $courseLabels = $coursesData->pluck('course_code')->toArray();
        $courseEnrollments = $coursesData->pluck('enrollments_count')->toArray();
        $courseCapacities = $coursesData->pluck('capacity')->toArray();

        return view('dashboard', compact(
            'totalStudents',
            'totalCourses',
            'activeEnrollments',
            'averageGpa',
            'recentEnrollments',
            'trendLabels',
            'trendData',
            'genderLabels',
            'genderCounts',
            'statusLabels',
            'statusCounts',
            'courseLabels',
            'courseEnrollments',
            'courseCapacities'
        ));
    }
}
