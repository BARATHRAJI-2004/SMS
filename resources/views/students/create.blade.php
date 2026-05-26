<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Register New Student') }}
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
                <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div class="space-y-1">
                            <label for="first_name" class="text-sm font-semibold text-gray-700">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('first_name') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="space-y-1">
                            <label for="last_name" class="text-sm font-semibold text-gray-700">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('last_name') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-1">
                            <label for="email" class="text-sm font-semibold text-gray-700">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('email') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="space-y-1">
                            <label for="phone" class="text-sm font-semibold text-gray-700">Phone Number</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="+91 9876543210" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('phone') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="space-y-1">
                            <label for="date_of_birth" class="text-sm font-semibold text-gray-700">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('date_of_birth') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Gender -->
                        <div class="space-y-1">
                            <label for="gender" class="text-sm font-semibold text-gray-700">Gender <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Enrollment Date -->
                        <div class="space-y-1">
                            <label for="enrollment_date" class="text-sm font-semibold text-gray-700">Enrollment Date <span class="text-red-500">*</span></label>
                            <input type="date" name="enrollment_date" id="enrollment_date" value="{{ old('enrollment_date', date('Y-m-d')) }}" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('enrollment_date') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div class="space-y-1">
                            <label for="status" class="text-sm font-semibold text-gray-700">Initial Academic Status <span class="text-red-500">*</span></label>
                            <select name="status" id="status" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Suspended" {{ old('status') === 'Suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="Graduated" {{ old('status') === 'Graduated' ? 'selected' : '' }}>Graduated</option>
                                <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Profile Picture Upload (Optional) -->
                    <div class="space-y-1.5">
                        <label for="profile_picture_file" class="text-sm font-semibold text-gray-700">Profile Picture (Optional)</label>
                        <input type="file" name="profile_picture_file" id="profile_picture_file" class="w-full text-sm text-gray-500 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-400">Supported formats: JPG, PNG. Max size: 2MB.</p>
                        @error('profile_picture_file') <p class="text-xs text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-semibold rounded-lg text-gray-600 bg-white hover:bg-gray-55 transition">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-5 py-2 bg-indigo-600 border border-transparent text-sm font-semibold rounded-lg text-white hover:bg-indigo-700 shadow-sm transition">
                            Register Student
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
