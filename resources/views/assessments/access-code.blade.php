@extends('layouts.public')

@section('title', 'Access Code Required - ' . $assessment->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full animate-fade-in">
        <!-- Lock Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-6">
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Access Code Required</h1>
            <p class="text-gray-600">Please enter your access code to continue with this assessment</p>
        </div>

        <!-- Access Code Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('assessments.verify-code', $assessment) }}">
                @csrf
                
                <div class="mb-6">
                    <label for="access_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Access Code
                    </label>
                    <input type="text" 
                           id="access_code" 
                           name="access_code" 
                           value="{{ old('access_code') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-center text-lg font-mono uppercase tracking-widest @error('access_code') border-red-500 @enderror"
                           placeholder="ENTER CODE"
                           style="text-transform: uppercase;"
                           required
                           autocomplete="off">
                    
                    @error('access_code')
                        <div class="mt-2 flex items-center text-red-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-xl transition duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                    </svg>
                    Verify & Continue
                </button>
            </form>

            <!-- Help Text -->
            <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-1">Need Help?</h4>
                        <p class="text-sm text-gray-600">
                            Contact your administrator or the person who shared this assessment link with you to get the access code.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assessment Info -->
        <div class="mt-6 text-center">
            <p class="text-gray-600">
                <strong>{{ $assessment->title }}</strong>
            </p>
            <p class="text-sm text-gray-500 mt-1">
                {{ $assessment->questions()->count() }} questions • 
                ~{{ ceil($assessment->questions()->count() * 0.5) }} minutes
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('access_code').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});

// Auto-focus on load
window.addEventListener('load', function() {
    document.getElementById('access_code').focus();
});
</script>
@endpush
@endsection