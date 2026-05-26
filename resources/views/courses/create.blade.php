<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Course') }}
            </h2>
            <a href="{{ route('courses.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 flex items-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Catalog
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <form action="{{ route('courses.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course Code -->
                        <div class="space-y-1">
                            <label for="course_code" class="text-sm font-semibold text-gray-700">Course Code <span class="text-red-500">*</span></label>
                            <input type="text" name="course_code" id="course_code" value="{{ old('course_code') }}" required placeholder="e.g. CS-101" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('course_code') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Course Title -->
                        <div class="space-y-1">
                            <label for="name" class="text-sm font-semibold text-gray-700">Course Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g. Database Management Systems" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('name') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Instructor Name -->
                        <div class="space-y-1">
                            <label for="teacher_name" class="text-sm font-semibold text-gray-700">Instructor Name <span class="text-red-500">*</span></label>
                            <input type="text" name="teacher_name" id="teacher_name" value="{{ old('teacher_name') }}" required placeholder="Prof. Jane Doe" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('teacher_name') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Credit Hours -->
                            <div class="space-y-1">
                                <label for="credits" class="text-sm font-semibold text-gray-700">Credits <span class="text-red-500">*</span></label>
                                <input type="number" name="credits" id="credits" value="{{ old('credits', 3) }}" required min="1" max="6" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('credits') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                            </div>

                            <!-- Capacity Limit -->
                            <div class="space-y-1">
                                <label for="capacity" class="text-sm font-semibold text-gray-700">Capacity <span class="text-red-500">*</span></label>
                                <input type="number" name="capacity" id="capacity" value="{{ old('capacity', 30) }}" required min="5" max="100" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('capacity') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Course Description -->
                    <div class="space-y-1">
                        <label for="description" class="text-sm font-semibold text-gray-700">Course Description</label>
                        <textarea name="description" id="description" rows="4" placeholder="Brief details about the curriculum, prerequisites..." class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                        @error('description') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-semibold rounded-lg text-gray-600 bg-white hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-5 py-2 bg-indigo-600 border border-transparent text-sm font-semibold rounded-lg text-white hover:bg-indigo-700 shadow-sm transition">
                            Create Course
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
