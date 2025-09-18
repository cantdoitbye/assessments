{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Assessments</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $total_assessments }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Submissions</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $total_submissions }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Today's Submissions</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ $recent_submissions->where('created_at', '>=', today())->count() }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">This Week</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ $recent_submissions->where('created_at', '>=', now()->startOfWeek())->count() }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Assessment Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Assessment Performance</h3>
                    </div>
                    <div class="p-6">
                        @if($assessment_stats->isEmpty())
                            <p class="text-gray-500 text-center py-4">No assessment data available</p>
                        @else
                            <div class="space-y-4">
                                @foreach($assessment_stats as $assessment)
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($assessment->title, 40) }}
                                            </h4>
                                            <p class="text-sm text-gray-500">{{ $assessment->slug }}</p>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $assessment->user_assessments_count }} submissions
                                            </span>
                                            <a href="{{ route('admin.assessments.show', $assessment) }}" 
                                               class="text-blue-600 hover:text-blue-900 text-sm">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                        <a href="{{ route('admin.assessments.index') }}" 
                           class="text-sm text-blue-600 hover:text-blue-900">
                            View all assessments →
                        </a>
                    </div>
                </div>

                <!-- Recent Submissions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Recent Submissions</h3>
                    </div>
                    <div class="p-6">
                        @if($recent_submissions->isEmpty())
                            <p class="text-gray-500 text-center py-4">No recent submissions</p>
                        @else
                            <div class="space-y-4">
                                @foreach($recent_submissions as $submission)
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900">
                                                {{ $submission->user->name ?? 'Guest User' }}
                                            </h4>
                                            <p class="text-sm text-gray-500">
                                                {{ Str::limit($submission->assessment->title, 30) }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $submission->final_result }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                {{ $submission->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.assessments.create') }}" 
                           class="group relative rounded-lg p-6 bg-blue-50 hover:bg-blue-100 transition-colors">
                            <div>
                                <span class="rounded-lg inline-flex p-3 bg-blue-600 text-white group-hover:bg-blue-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </span>
                            </div>
                            {{-- <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900">Create Assessment</h3>
                                <p class="mt-2 text-sm text-gray-500">Add a new assessment to the system</p>
                            </div> --}}
                        </a>

                        <a href="{{ route('admin.assessments.index') }}" 
                           class="group relative rounded-lg p-6 bg-green-50 hover:bg-green-100 transition-colors">
                            <div>
                                <span class="rounded-lg inline-flex p-3 bg-green-600 text-white group-hover:bg-green-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900">Manage Assessments</h3>
                                <p class="mt-2 text-sm text-gray-500">View and edit existing assessments</p>
                            </div>
                        </a>

                        <a href="/assessments/assertiveness-self-assessment" 
                           class="group relative rounded-lg p-6 bg-purple-50 hover:bg-purple-100 transition-colors">
                            <div>
                                <span class="rounded-lg inline-flex p-3 bg-purple-600 text-white group-hover:bg-purple-700">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900">Preview Assessment</h3>
                                <p class="mt-2 text-sm text-gray-500">Test the user experience</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- resources/views/layouts/navigation.blade.php - Update to include admin menu --}}
{{-- Add this section to your navigation after the existing menu items --}}
@auth
    @if(auth()->user()->is_admin)
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                {{ __('Admin') }}
            </x-nav-link>
        </div>
    @endif
@endauth