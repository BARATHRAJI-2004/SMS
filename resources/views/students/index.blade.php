<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Student Directory') }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('students.export.csv') }}" class="inline-flex items-center px-4 py-2 bg-emerald-550 border border-emerald-300 text-sm font-semibold rounded-lg text-emerald-800 bg-emerald-50 hover:bg-emerald-100 transition duration-150 ease-in-out cursor-pointer shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export CSV
                </a>
                <a href="{{ route('students.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent text-sm font-semibold rounded-lg text-white hover:bg-indigo-700 transition duration-150 ease-in-out shadow-sm">
                    Register Student
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search and Filter Bar -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <form action="{{ route('students.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <!-- Search Input -->
                    <div class="space-y-1">
                        <label for="search" class="text-xs font-semibold text-gray-500 uppercase">Search Directory</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="ID, Name, or Email..." class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Status Filter -->
                    <div class="space-y-1">
                        <label for="status" class="text-xs font-semibold text-gray-500 uppercase">Status</label>
                        <select name="status" id="status" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Statuses</option>
                            <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Suspended" {{ request('status') === 'Suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="Graduated" {{ request('status') === 'Graduated' ? 'selected' : '' }}>Graduated</option>
                            <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Gender Filter -->
                    <div class="space-y-1">
                        <label for="gender" class="text-xs font-semibold text-gray-500 uppercase">Gender</label>
                        <select name="gender" id="gender" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Genders</option>
                            <option value="Male" {{ request('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ request('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-indigo-50 border border-indigo-200 text-sm font-semibold rounded-lg text-indigo-700 hover:bg-indigo-100 transition duration-150 cursor-pointer">
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'status', 'gender']))
                            <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 text-sm font-semibold rounded-lg text-gray-600 hover:bg-gray-100 transition duration-150">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Students List Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50 text-gray-500 uppercase tracking-wider text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-3 text-left">Student ID</th>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Email</th>
                                <th class="px-6 py-3 text-left">Phone</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-sm">
                            @forelse($students as $st)
                                <tr class="hover:bg-gray-50/30 transition duration-150">
                                    <td class="px-6 py-4 font-mono text-xs text-gray-600 font-semibold">{{ $st->student_id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $st->full_name }}</div>
                                        <span class="text-xs text-gray-400 font-medium">{{ $st->gender }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">{{ $st->email }}</td>
                                    <td class="px-6 py-4 text-gray-500 font-mono text-xs">{{ $st->phone ?? '—' }}</td>
                                    <td class="px-6 py-4">
                                        @if($st->status === 'Active')
                                            <span class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full border border-emerald-200">Active</span>
                                        @elseif($st->status === 'Suspended')
                                            <span class="px-2.5 py-1 text-xs font-semibold text-amber-700 bg-amber-50 rounded-full border border-amber-200">Suspended</span>
                                        @elseif($st->status === 'Graduated')
                                            <span class="px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-50 rounded-full border border-blue-200">Graduated</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold text-gray-600 bg-gray-50 rounded-full border border-gray-200">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('students.show', $st->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">Profile</a>
                                            <a href="{{ route('students.edit', $st->id) }}" class="text-amber-600 hover:text-amber-900 font-medium text-sm">Edit</a>
                                            <form action="{{ route('students.destroy', $st->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-medium">No students registered yet. Click "Register Student" to add a new record.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($students->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
