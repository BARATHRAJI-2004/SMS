<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Student Profile') }}
            </h2>
            <a href="{{ route('students.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Directory
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Profile Summary Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 md:p-10 flex flex-col md:flex-row gap-8 items-center md:items-start">
                    <!-- Profile Picture -->
                    @if($student->profile_picture)
                        <img class="w-28 h-28 md:w-36 md:h-36 rounded-full object-cover border-4 border-indigo-50 shadow-md" src="{{ asset('storage/' . $student->profile_picture) }}" alt="{{ $student->full_name }}">
                    @else
                        <div class="w-28 h-28 md:w-36 md:h-36 rounded-full bg-indigo-50 border-4 border-indigo-100 text-indigo-600 font-bold flex justify-center items-center uppercase shadow-md text-4xl">
                            {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                        </div>
                    @endif

                    <!-- Student Info Details -->
                    <div class="flex-1 space-y-4 text-center md:text-left">
                        <div>
                            <div class="flex flex-col md:flex-row items-center gap-3">
                                <h3 class="text-2xl font-extrabold text-gray-900">{{ $student->full_name }}</h3>
                                @if($student->status === 'Active')
                                    <span class="px-2.5 py-0.5 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full border border-emerald-200">Active</span>
                                @elseif($student->status === 'Suspended')
                                    <span class="px-2.5 py-0.5 text-xs font-semibold text-amber-700 bg-amber-50 rounded-full border border-amber-200">Suspended</span>
                                @elseif($student->status === 'Graduated')
                                    <span class="px-2.5 py-0.5 text-xs font-semibold text-blue-700 bg-blue-50 rounded-full border border-blue-200">Graduated</span>
                                @else
                                    <span class="px-2.5 py-0.5 text-xs font-semibold text-gray-600 bg-gray-50 rounded-full border border-gray-200 font-medium">Inactive</span>
                                @endif
                            </div>
                            <p class="text-sm font-mono text-gray-500 font-semibold mt-1">{{ $student->student_id }}</p>
                        </div>

                        <!-- Stats / Fields -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-4 border-t border-gray-100 text-sm">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Email Address</span>
                                <p class="text-gray-900 font-medium mt-1 truncate">{{ $student->email }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Phone Number</span>
                                <p class="text-gray-900 font-medium mt-1">{{ $student->phone ?? '—' }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Gender</span>
                                <p class="text-gray-900 font-medium mt-1">{{ $student->gender }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Date of Birth</span>
                                <p class="text-gray-900 font-medium mt-1">{{ $student->date_of_birth ? $student->date_of_birth->format('M d, Y') : '—' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-4 text-sm">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Enrollment Date</span>
                                <p class="text-gray-900 font-medium mt-1">{{ $student->enrollment_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Cumulative GPA</span>
                                <p class="text-indigo-600 font-extrabold mt-1 text-base">{{ $gpa }}</p>
                            </div>
                            <div class="col-span-2 flex justify-end items-end gap-2 text-right">
                                <a href="{{ route('students.edit', $student->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition">
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrolled Courses list -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-lg font-bold text-gray-800">Enrolled Courses & Grading</h4>
                    <a href="{{ route('enrollments.create', ['student_id' => $student->id]) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 border border-indigo-200 text-xs font-semibold rounded-lg text-indigo-700 hover:bg-indigo-100 shadow-sm transition">
                        Enroll in Course
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50 text-gray-500 uppercase tracking-wider text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-3 text-left">Course Code</th>
                                <th class="px-6 py-3 text-left">Course Name</th>
                                <th class="px-6 py-3 text-left">Prof. / Instructor</th>
                                <th class="px-6 py-3 text-left">Credits</th>
                                <th class="px-6 py-3 text-center">Grade</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-sm">
                            @forelse($student->courses as $course)
                                <tr>
                                    <td class="px-6 py-4 font-mono text-xs text-gray-600 font-semibold">{{ $course->course_code }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $course->name }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $course->teacher_name }}</td>
                                    <td class="px-6 py-4 text-gray-500 font-semibold">{{ $course->credits }}</td>
                                    <td class="px-6 py-4 text-center font-mono font-bold text-gray-800">
                                        @if($course->pivot->grade)
                                            <span class="px-2 py-0.5 rounded bg-indigo-50 border border-indigo-150 text-indigo-800">{{ $course->pivot->grade }}</span>
                                        @else
                                            <span class="text-gray-400 font-normal italic">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($course->pivot->status === 'Enrolled')
                                            <span class="px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-50 rounded-full border border-blue-200">Enrolled</span>
                                        @elseif($course->pivot->status === 'Completed')
                                            <span class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full border border-emerald-200">Completed</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-50 rounded-full border border-red-200">Dropped</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <!-- Inline update grade form trigger/details -->
                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open" class="text-xs font-semibold text-indigo-600 hover:text-indigo-900 border border-indigo-200 px-2.5 py-1 rounded bg-indigo-50/50 hover:bg-indigo-50 transition cursor-pointer">
                                                Update Grade/Status
                                            </button>

                                            <!-- Dropdown form sheet -->
                                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 p-4 bg-white border border-gray-150 rounded-xl shadow-lg z-10 w-72 text-left space-y-4" style="display: none;">
                                                <h5 class="text-xs font-bold text-gray-800 border-b border-gray-100 pb-1">Update Academic Standing</h5>
                                                
                                                <form action="{{ route('enrollments.update-grade', $course->pivot->id) }}" method="POST" class="space-y-3">
                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="space-y-1">
                                                        <label class="text-xs font-semibold text-gray-500 uppercase">Grade</label>
                                                        <select name="grade" class="w-full text-xs border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                            <option value="">Pending / None</option>
                                                            <option value="A+" {{ $course->pivot->grade === 'A+' ? 'selected' : '' }}>A+</option>
                                                            <option value="A" {{ $course->pivot->grade === 'A' ? 'selected' : '' }}>A</option>
                                                            <option value="B+" {{ $course->pivot->grade === 'B+' ? 'selected' : '' }}>B+</option>
                                                            <option value="B" {{ $course->pivot->grade === 'B' ? 'selected' : '' }}>B</option>
                                                            <option value="C+" {{ $course->pivot->grade === 'C+' ? 'selected' : '' }}>C+</option>
                                                            <option value="C" {{ $course->pivot->grade === 'C' ? 'selected' : '' }}>C</option>
                                                            <option value="D" {{ $course->pivot->grade === 'D' ? 'selected' : '' }}>D</option>
                                                            <option value="F" {{ $course->pivot->grade === 'F' ? 'selected' : '' }}>F</option>
                                                        </select>
                                                    </div>

                                                    <div class="space-y-1">
                                                        <label class="text-xs font-semibold text-gray-500 uppercase">Status</label>
                                                        <select name="status" class="w-full text-xs border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                            <option value="Enrolled" {{ $course->pivot->status === 'Enrolled' ? 'selected' : '' }}>Enrolled</option>
                                                            <option value="Completed" {{ $course->pivot->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                                            <option value="Dropped" {{ $course->pivot->status === 'Dropped' ? 'selected' : '' }}>Dropped</option>
                                                        </select>
                                                    </div>

                                                    <div class="flex justify-end gap-2 pt-2 border-t border-gray-100">
                                                        <button type="button" @click="open = false" class="px-2.5 py-1 text-xs border border-gray-200 rounded text-gray-500 hover:bg-gray-50">Cancel</button>
                                                        <button type="submit" class="px-3 py-1 text-xs bg-indigo-600 hover:bg-indigo-700 text-white rounded font-medium shadow-sm">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-400 font-medium">This student is not enrolled in any courses yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
