@extends('layouts.public')

@section('title', 'Your Results - ' . $userAssessment->assessment->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-blue-50 to-purple-50">
    <!-- Celebration Header -->
    <header class="text-center py-12">
        <div class="animate-fade-in">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-r from-green-400 to-blue-500 rounded-full shadow-xl mb-6">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-5xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-4">
                Assessment Complete!
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Here are your personalized results for {{ $userAssessment->assessment->title }}
            </p>
        </div>
    </header>

    <!-- Results Content -->
    <main class="max-w-7xl mx-auto px-4 pb-12">
        <div class="grid lg:grid-cols-2 gap-8 mb-12">
            <!-- Primary Result Card -->
            <div class="glass-effect rounded-3xl p-8 card-hover animate-slide-up">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Your Primary Communication Style</h2>
                    <div class="inline-block bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl px-8 py-4 mb-6">
                        <span class="text-3xl font-bold text-white">{{ $userAssessment->final_result }}</span>
                    </div>
                    
                    @if($resultCategory)
                        <p class="text-gray-700 text-lg leading-relaxed">{{ $resultCategory->description }}</p>
                    @endif
                </div>

                <!-- Score Breakdown -->
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-gray-900 border-b pb-2">Detailed Scores</h3>
                    @foreach($userAssessment->result_json as $category => $score)
                        @php
                            $maxScore = max($userAssessment->result_json);
                            $percentage = $maxScore > 0 ? ($score / $maxScore) * 100 : 0;
                            $isHighest = $score == $maxScore;
                        @endphp
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-700">{{ $category }}</span>
                                <span class="font-bold text-gray-900 bg-gray-100 px-3 py-1 rounded-full">{{ $score }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="h-4 rounded-full transition-all duration-1000 {{ $isHighest ? 'bg-gradient-to-r from-blue-500 to-purple-600' : 'bg-gray-400' }}" 
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Visual Chart -->
            <div class="glass-effect rounded-3xl p-8 card-hover animate-slide-up" style="animation-delay: 0.2s">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Visual Breakdown</h2>
                <div class="relative h-80">
                    <canvas id="resultChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Insights and Recommendations -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Understanding Section -->
            <div class="glass-effect rounded-3xl p-8 card-hover animate-slide-up" style="animation-delay: 0.3s">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">What This Means</h3>
                </div>
                <div class="space-y-4 text-gray-700">
                    <p class="leading-relaxed">
                        Your primary communication style is <strong class="text-blue-600">{{ $userAssessment->final_result }}</strong>. 
                        This indicates your most prevalent pattern in interpersonal communications and conflict situations.
                    </p>
                    <p class="leading-relaxed">
                        Remember that everyone uses different communication styles in different situations. 
                        This assessment reflects your general tendencies and provides insight into your default approach to interactions.
                    </p>
                    <div class="bg-blue-50 rounded-xl p-4">
                        <p class="text-blue-800 font-medium">
                            💡 Understanding your style helps you communicate more effectively and build stronger relationships.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Next Steps Section -->
            <div class="glass-effect rounded-3xl p-8 card-hover animate-slide-up" style="animation-delay: 0.4s">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Next Steps</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-gray-700">Reflect on situations where you use different communication styles</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-gray-700">Practice assertive communication techniques in daily interactions</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-gray-700">Seek feedback from trusted colleagues or friends about your communication</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-gray-700">Consider exploring communication skills development resources</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center space-y-4">
            <div class="flex flex-wrap justify-center gap-4">
                <button onclick="window.print()" 
                        class="bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-medium py-3 px-8 rounded-xl transition duration-300 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Results
                </button>
                <a href="{{ route('assessments.show', $userAssessment->assessment) }}" 
                   class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Take Again
                </a>
            </div>
            <p class="text-gray-500 text-sm">Results are automatically saved. You can always retake the assessment for updated insights.</p>
        </div>
    </main>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('resultChart').getContext('2d');
    const data = @json($userAssessment->result_json);
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(data),
            datasets: [{
                data: Object.values(data),
                backgroundColor: [
                    '#3B82F6',
                    '#10B981', 
                    '#F59E0B',
                    '#EF4444'
                ],
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: { size: 14, weight: '600' },
                    bodyFont: { size: 13 },
                    cornerRadius: 8,
                    displayColors: true
                }
            },
            animation: {
                animateRotate: true,
                duration: 1500
            }
        }
    });

    // Add animation delays
    const elements = document.querySelectorAll('.animate-slide-up');
    elements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
    });
</script>
@endpush
@endsection