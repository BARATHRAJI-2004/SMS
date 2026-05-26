<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Student Details') }}
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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="mb-6 pb-6 border-b border-gray-100 flex items-center gap-4">
                    @if($student->profile_picture)
                        <img class="w-14 h-14 rounded-full object-cover shadow-inner" src="{{ asset('storage/' . $student->profile_picture) }}" alt="{{ $student->full_name }}">
                    @else
                        <div class="w-14 h-14 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-600 font-bold flex justify-center items-center uppercase shadow-inner text-lg">
                            {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="font-bold text-gray-800">{{ $student->full_name }}</h4>
                        <p class="text-xs font-mono text-gray-500 font-semibold">{{ $student->student_id }}</p>
                    </div>
                </div>

                <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div class="space-y-1">
                            <label for="first_name" class="text-sm font-semibold text-gray-700">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name) }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('first_name') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="space-y-1">
                            <label for="last_name" class="text-sm font-semibold text-gray-700">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name) }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('last_name') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-1">
                            <label for="email" class="text-sm font-semibold text-gray-700">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('email') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="space-y-1">
                            <label for="phone" class="text-sm font-semibold text-gray-700">Phone Number</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone) }}" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('phone') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="space-y-1">
                            <label for="date_of_birth" class="text-sm font-semibold text-gray-700">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('date_of_birth') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Gender -->
                        <div class="space-y-1">
                            <label for="gender" class="text-sm font-semibold text-gray-700">Gender <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Male" {{ old('gender', $student->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $student->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Enrollment Date -->
                        <div class="space-y-1">
                            <label for="enrollment_date" class="text-sm font-semibold text-gray-700">Enrollment Date <span class="text-red-500">*</span></label>
                            <input type="date" name="enrollment_date" id="enrollment_date" value="{{ old('enrollment_date', $student->enrollment_date ? $student->enrollment_date->format('Y-m-d') : '') }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('enrollment_date') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-1">
                            <label for="status" class="text-sm font-semibold text-gray-700">Academic Status <span class="text-red-500">*</span></label>
                            <select name="status" id="status" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Active" {{ old('status', $student->status) === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Suspended" {{ old('status', $student->status) === 'Suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="Graduated" {{ old('status', $student->status) === 'Graduated' ? 'selected' : '' }}>Graduated</option>
                                <option value="Inactive" {{ old('status', $student->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Profile Picture Upload (Optional) -->
                    <div class="space-y-1.5">
                        <label for="profile_picture_file" class="text-sm font-semibold text-gray-700">Update Profile Picture (Optional)</label>
                        <input type="file" name="profile_picture_file" id="profile_picture_file" class="w-full text-sm text-gray-500 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-400">Supported formats: JPG, PNG. Leave empty to keep existing picture.</p>
                        @error('profile_picture_file') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-semibold rounded-lg text-gray-600 bg-white hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-5 py-2 bg-indigo-600 border border-transparent text-sm font-semibold rounded-lg text-white hover:bg-indigo-700 shadow-sm transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
