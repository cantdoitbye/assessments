@extends('layouts.public')

@section('title', $assessment->title)

@section('content')
<div class="min-h-screen gradient-bg">
    <!-- Header -->
    <header class="py-6">
        <div class="container mx-auto px-4">
            <nav class="flex justify-between items-center">
                <div class="text-white font-bold text-xl">Assessment System</div>
                @auth
                    <div class="text-white">
                        Welcome, {{ auth()->user()->name }}
                    </div>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 pb-12">
        <div class="max-w-4xl mx-auto">
            <!-- Hero Section -->
            <div class="text-center text-white mb-12 animate-fade-in">
                <h1 class="text-5xl font-bold mb-6 leading-tight">{{ $assessment->title }}</h1>
                <p class="text-xl opacity-90 leading-relaxed max-w-3xl mx-auto">{{ $assessment->description }}</p>
            </div>

            <!-- Assessment Card -->
            <div class="glass-effect rounded-3xl p-8 mb-8 card-hover animate-slide-up">
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $assessment->questions()->count() }} Questions</p>
                                <p class="text-sm text-gray-600">Comprehensive assessment</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ ceil($assessment->questions()->count() * 0.5) }} Minutes</p>
                                <p class="text-sm text-gray-600">Estimated completion time</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $assessment->resultCategories()->count() }} Categories</p>
                                <p class="text-sm text-gray-600">Detailed analysis</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Instant Results</p>
                                <p class="text-sm text-gray-600">Get your analysis immediately</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-blue-50 rounded-2xl p-6 mb-8">
                    <h3 class="text-xl font-semibold text-blue-900 mb-4">How it works</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">1</span>
                                <div>
                                    <p class="font-medium text-blue-900">Answer honestly</p>
                                    <p class="text-sm text-blue-700">Choose the response that best reflects your typical behavior</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">2</span>
                                <div>
                                    <p class="font-medium text-blue-900">Take your time</p>
                                    <p class="text-sm text-blue-700">There are no time limits - reflect on each question</p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">3</span>
                                <div>
                                    <p class="font-medium text-blue-900">No right or wrong</p>
                                    <p class="text-sm text-blue-700">Every answer provides valuable insight into your style</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">4</span>
                                <div>
                                    <p class="font-medium text-blue-900">Get results</p>
                                    <p class="text-sm text-blue-700">Receive detailed analysis and actionable insights</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="text-center">
                    <form method="POST" action="{{ route('assessments.start', $assessment) }}">
                        @csrf
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-12 rounded-2xl text-lg transition duration-300 transform hover:scale-105 shadow-xl">
                            <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            Start Your Assessment
                        </button>
                    </form>
                    <p class="text-gray-600 mt-3 text-sm">Free • No registration required • Instant results</p>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-6 mt-12">
                <div class="text-center text-white animate-slide-up" style="animation-delay: 0.1s">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Scientifically Based</h3>
                    <p class="opacity-90">Based on established psychological assessment principles</p>
                </div>
                
                <div class="text-center text-white animate-slide-up" style="animation-delay: 0.2s">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Quick & Easy</h3>
                    <p class="opacity-90">Complete in minutes with immediate, actionable results</p>
                </div>
                
                <div class="text-center text-white animate-slide-up" style="animation-delay: 0.3s">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Personal Growth</h3>
                    <p class="opacity-90">Gain insights to improve your communication and relationships</p>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
