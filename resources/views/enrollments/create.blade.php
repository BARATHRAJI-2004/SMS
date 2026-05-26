<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('New Student Enrollment') }}
            </h2>
            <a href="{{ route('enrollments.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Listings
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('enrollments.store') }}" method="POST" class="space-y-6">
                    @csrf

                    @if($errors->any())
                        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-semibold leading-relaxed">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Student Select Dropdown -->
                    <div class="space-y-1">
                        <label for="student_id" class="text-sm font-semibold text-gray-700">Select Active Student <span class="text-red-500">*</span></label>
                        <select name="student_id" id="student_id" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="" disabled {{ !request('student_id') ? 'selected' : '' }}>Select a student...</option>
                            @foreach($students as $st)
                                <option value="{{ $st->id }}" {{ request('student_id') == $st->id || old('student_id') == $st->id ? 'selected' : '' }}>{{ $st->last_name }}, {{ $st->first_name }} ({{ $st->student_id }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course Select Dropdown -->
                    <div class="space-y-1">
                        <label for="course_id" class="text-sm font-semibold text-gray-700">Select Course <span class="text-red-500">*</span></label>
                        <select name="course_id" id="course_id" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="" disabled selected>Select a course...</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->course_code }} - {{ $c->name }} (Instructor: {{ $c->teacher_name }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Enrollment Date -->
                    <div class="space-y-1">
                        <label for="enrollment_date" class="text-sm font-semibold text-gray-700">Enrollment Date <span class="text-red-500">*</span></label>
                        <input type="date" name="enrollment_date" id="enrollment_date" value="{{ old('enrollment_date', date('Y-m-d')) }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('enrollments.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-semibold rounded-lg text-gray-600 bg-white hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-5 py-2 bg-indigo-600 border border-transparent text-sm font-semibold rounded-lg text-white hover:bg-indigo-700 shadow-sm transition">
                            Confirm Enrollment
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
