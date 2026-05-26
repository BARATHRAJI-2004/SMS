<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Course Enrollments') }}
            </h2>
            <a href="{{ route('enrollments.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent text-sm font-semibold rounded-lg text-white hover:bg-indigo-700 shadow-sm transition">
                New Enrollment
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

            <!-- Quick Filter Bar -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <form action="{{ route('enrollments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <!-- Course Filter -->
                    <div class="space-y-1">
                        <label for="course_id" class="text-xs font-semibold text-gray-500 uppercase">Filter by Course</label>
                        <select name="course_id" id="course_id" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Courses</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->course_code }} - {{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="space-y-1">
                        <label for="status" class="text-xs font-semibold text-gray-500 uppercase">Status</label>
                        <select name="status" id="status" class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Statuses</option>
                            <option value="Enrolled" {{ request('status') === 'Enrolled' ? 'selected' : '' }}>Enrolled</option>
                            <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Dropped" {{ request('status') === 'Dropped' ? 'selected' : '' }}>Dropped</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-indigo-50 border border-indigo-200 text-sm font-semibold rounded-lg text-indigo-700 hover:bg-indigo-100 transition duration-150 cursor-pointer">
                            Filter
                        </button>
                        @if(request()->anyFilled(['course_id', 'status']))
                            <a href="{{ route('enrollments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 text-sm font-semibold rounded-lg text-gray-600 hover:bg-gray-100 transition duration-150">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Enrollments Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50 text-gray-500 uppercase tracking-wider text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-3 text-left">Student</th>
                                <th class="px-6 py-3 text-left">Course Enrolled</th>
                                <th class="px-6 py-3 text-left">Enrollment Date</th>
                                <th class="px-6 py-3 text-center">Grade</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-sm">
                            @forelse($enrollments as $enr)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-950">{{ $enr->student->full_name }}</div>
                                        <div class="text-xs font-mono text-gray-500 font-semibold">{{ $enr->student->student_id }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ $enr->course->course_code }}</div>
                                        <div class="text-xs text-gray-400 font-medium">{{ $enr->course->name }} ({{ $enr->course->credits }} Credits)</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">{{ $enr->enrollment_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-center font-mono font-bold">
                                        @if($enr->grade)
                                            <span class="px-2 py-0.5 rounded bg-indigo-50 border border-indigo-150 text-indigo-800">{{ $enr->grade }}</span>
                                        @else
                                            <span class="text-gray-400 font-normal italic">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($enr->status === 'Enrolled')
                                            <span class="px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-50 rounded-full border border-blue-200">Enrolled</span>
                                        @elseif($enr->status === 'Completed')
                                            <span class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full border border-emerald-200">Completed</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-50 rounded-full border border-red-200 font-medium">Dropped</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <!-- Inline Grade dropdown using AlpineJS -->
                                        <div x-data="{ open: false }" class="relative inline-block text-left">
                                            <div class="flex justify-center gap-3">
                                                <button @click="open = !open" class="text-xs font-semibold text-indigo-600 hover:text-indigo-900 border border-indigo-200 px-2 py-1 rounded bg-indigo-50/50 cursor-pointer">
                                                    Grade / Status
                                                </button>
                                                <form action="{{ route('enrollments.destroy', $enr->id) }}" method="POST" onsubmit="return confirm('Remove enrollment log for {{ $enr->student->full_name }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-900 px-2 py-1 rounded bg-red-50 border border-red-100 cursor-pointer">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>

                                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 p-4 bg-white border border-gray-200 rounded-xl shadow-xl z-25 w-72 text-left space-y-4" style="display: none;">
                                                <h5 class="text-xs font-bold text-gray-800 border-b border-gray-100 pb-1">Update Academic Standing</h5>
                                                
                                                <form action="{{ route('enrollments.update-grade', $enr->id) }}" method="POST" class="space-y-3">
                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="space-y-1">
                                                        <label class="text-xs font-semibold text-gray-500 uppercase">Grade</label>
                                                        <select name="grade" class="w-full text-xs border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                            <option value="">Pending / None</option>
                                                            <option value="A+" {{ $enr->grade === 'A+' ? 'selected' : '' }}>A+</option>
                                                            <option value="A" {{ $enr->grade === 'A' ? 'selected' : '' }}>A</option>
                                                            <option value="B+" {{ $enr->grade === 'B+' ? 'selected' : '' }}>B+</option>
                                                            <option value="B" {{ $enr->grade === 'B' ? 'selected' : '' }}>B</option>
                                                            <option value="C+" {{ $enr->grade === 'C+' ? 'selected' : '' }}>C+</option>
                                                            <option value="C" {{ $enr->grade === 'C' ? 'selected' : '' }}>C</option>
                                                            <option value="D" {{ $enr->grade === 'D' ? 'selected' : '' }}>D</option>
                                                            <option value="F" {{ $enr->grade === 'F' ? 'selected' : '' }}>F</option>
                                                        </select>
                                                    </div>

                                                    <div class="space-y-1">
                                                        <label class="text-xs font-semibold text-gray-500 uppercase">Status</label>
                                                        <select name="status" class="w-full text-xs border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                            <option value="Enrolled" {{ $enr->status === 'Enrolled' ? 'selected' : '' }}>Enrolled</option>
                                                            <option value="Completed" {{ $enr->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                                            <option value="Dropped" {{ $enr->status === 'Dropped' ? 'selected' : '' }}>Dropped</option>
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
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-medium">No enrollments logged matching filter criteria.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($enrollments->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        {{ $enrollments->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
