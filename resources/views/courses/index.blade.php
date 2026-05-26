<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Course Catalog') }}
            </h2>
            <a href="{{ route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent text-sm font-semibold rounded-lg text-white hover:bg-indigo-700 shadow-sm transition">
                Create Course
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Courses Responsive Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($courses as $course)
                    @php
                        $enrolledPercent = $course->capacity > 0 ? min(100, round(($course->enrollments_count / $course->capacity) * 100)) : 0;
                    @endphp
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-150 p-6 flex flex-col justify-between hover:shadow-md transition duration-200">
                        <div class="space-y-4">
                            <!-- Course Code & Credits -->
                            <div class="flex justify-between items-start">
                                <span class="font-mono text-xs font-bold px-2.5 py-1 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded">
                                    {{ $course->course_code }}
                                </span>
                                <span class="text-xs font-semibold px-2 py-0.5 bg-gray-100 border border-gray-250 text-gray-700 rounded-full">
                                    {{ $course->credits }} Credits
                                </span>
                            </div>

                            <!-- Course Title & description -->
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 leading-snug">{{ $course->name }}</h3>
                                <p class="text-xs text-gray-400 font-medium mt-0.5">Instructor: {{ $course->teacher_name ?? 'TBA' }}</p>
                                <p class="text-sm text-gray-600 mt-2 line-clamp-3 leading-relaxed">{{ $course->description ?? 'No description provided.' }}</p>
                            </div>
                        </div>

                        <!-- Capacity Occupancy rates -->
                        <div class="mt-6 pt-4 border-t border-gray-100 space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-semibold text-gray-500 uppercase tracking-wider">Occupancy Rate</span>
                                <span class="font-mono font-bold text-gray-800">{{ $course->enrollments_count }} / {{ $course->capacity }} Enrolled ({{ $enrolledPercent }}%)</span>
                            </div>
                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden shadow-inner border border-gray-200/50">
                                <div class="h-2 rounded-full transition-all duration-300 {{ $enrolledPercent >= 90 ? 'bg-rose-500' : ($enrolledPercent >= 75 ? 'bg-amber-500' : 'bg-emerald-500') }}" style="width: {{ $enrolledPercent }}%"></div>
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-end gap-3 pt-3">
                                <a href="{{ route('courses.edit', $course->id) }}" class="text-xs font-semibold text-amber-600 hover:text-amber-900 px-2 py-1 rounded bg-amber-50 border border-amber-100">
                                    Edit Course
                                </a>
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course? This will remove all associated enrollment logs.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-900 px-2 py-1 rounded bg-red-50 border border-red-100 cursor-pointer">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-2xl border border-gray-150 p-12 text-center text-gray-400 font-medium">
                        No courses created in the catalog yet.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
