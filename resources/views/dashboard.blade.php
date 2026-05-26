<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Analytics') }}
            </h2>
            <span class="text-sm text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full font-medium shadow-sm">
                Apex Academy SMS
            </span>
        </div>
    </x-slot>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Students Card -->
                <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100 p-6 flex items-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="p-3 rounded-xl bg-blue-500/10 text-blue-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Students</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalStudents }}</h3>
                    </div>
                </div>

                <!-- Courses Card -->
                <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100 p-6 flex items-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="p-3 rounded-xl bg-purple-500/10 text-purple-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Courses</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalCourses }}</h3>
                    </div>
                </div>

                <!-- Active Enrollments Card -->
                <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100 p-6 flex items-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="p-3 rounded-xl bg-emerald-500/10 text-emerald-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Active Enrollments</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $activeEnrollments }}</h3>
                    </div>
                </div>

                <!-- Average Grade GPA Card -->
                <div class="bg-white overflow-hidden shadow-md rounded-2xl border border-gray-100 p-6 flex items-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="p-3 rounded-xl bg-amber-500/10 text-amber-600 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Average GPA</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($averageGpa, 2) }} / 4.00</h3>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Trend & capacity charts -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 space-y-4">
                    <h4 class="text-lg font-semibold text-gray-800">Enrollment Trends (Last 6 Months)</h4>
                    <div class="h-64">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 space-y-4">
                    <h4 class="text-lg font-semibold text-gray-800">Course Enrollment occupancy vs Capacity</h4>
                    <div class="h-64">
                        <canvas id="courseChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Demographic distribution charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 space-y-4">
                    <h4 class="text-lg font-semibold text-gray-800">Student Status Demographics</h4>
                    <div class="h-64 flex justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 space-y-4">
                    <h4 class="text-lg font-semibold text-gray-800">Student Gender Demographics</h4>
                    <div class="h-64 flex justify-center">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent activity logs -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-6">Recent Enrollments Log</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/55 text-gray-500 uppercase tracking-wider text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-3 text-left">Student ID</th>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Course</th>
                                <th class="px-6 py-3 text-left">Enrollment Date</th>
                                <th class="px-6 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-sm">
                            @forelse($recentEnrollments as $enr)
                                <tr>
                                    <td class="px-6 py-4 font-mono text-xs text-gray-600">{{ $enr->student->student_id }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $enr->student->full_name }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $enr->course->course_code }} - {{ $enr->course->name }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $enr->enrollment_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">
                                        @if($enr->status === 'Enrolled')
                                            <span class="px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-50 rounded-full border border-blue-200">Enrolled</span>
                                        @elseif($enr->status === 'Completed')
                                            <span class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full border border-emerald-200">Completed</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-50 rounded-full border border-red-200 font-medium">Dropped</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">No recent enrollments logged.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts setup scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Trend Line Chart
            new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($trendLabels) !!},
                    datasets: [{
                        label: 'New Enrollments',
                        data: {!! json_encode($trendData) !!},
                        borderColor: 'rgb(79, 70, 229)',
                        backgroundColor: 'rgba(79, 70, 229, 0.05)',
                        tension: 0.35,
                        fill: true,
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, grid: { color: '#f3f4f6' } }, x: { grid: { display: false } } }
                }
            });

            // Course occupancy Bar Chart
            new Chart(document.getElementById('courseChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($courseLabels) !!},
                    datasets: [
                        {
                            label: 'Enrolled',
                            data: {!! json_encode($courseEnrollments) !!},
                            backgroundColor: 'rgba(99, 102, 241, 0.85)',
                            borderRadius: 6
                        },
                        {
                            label: 'Capacity Limit',
                            data: {!! json_encode($courseCapacities) !!},
                            backgroundColor: 'rgba(209, 213, 219, 0.4)',
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, grid: { color: '#f3f4f6' } }, x: { grid: { display: false } } }
                }
            });

            // Student Status Pie/Donut Chart
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($statusLabels) !!},
                    datasets: [{
                        data: {!! json_encode($statusCounts) !!},
                        backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#ef4444'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16 } } }
                }
            });

            // Student Gender Donut Chart
            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($genderLabels) !!},
                    datasets: [{
                        data: {!! json_encode($genderCounts) !!},
                        backgroundColor: ['#60a5fa', '#f472b6'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16 } } }
                }
            });
        });
    </script>
</x-app-layout>
