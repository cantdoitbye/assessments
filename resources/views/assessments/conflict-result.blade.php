@extends('layouts.public')

@section('title', 'Your Conflict Management Style Results')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full shadow-lg mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Your Results Are Ready!</h1>
            <p class="text-xl text-gray-600">{{ $userAssessment->assessment->title }}</p>
        </div>

        <!-- Score Overview -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Your Conflict Style Profile</h2>
            
            <div class="space-y-4">
                @php
                    $scores = $userAssessment->result_json;
                    arsort($scores);
                    $maxScore = 12;
                    
                    $styleColors = [
                        'Competing' => ['bg' => 'bg-red-500', 'light' => 'bg-red-100', 'text' => 'text-red-700'],
                        'Collaborating' => ['bg' => 'bg-blue-500', 'light' => 'bg-blue-100', 'text' => 'text-blue-700'],
                        'Compromising' => ['bg' => 'bg-purple-500', 'light' => 'bg-purple-100', 'text' => 'text-purple-700'],
                        'Avoiding' => ['bg' => 'bg-gray-500', 'light' => 'bg-gray-100', 'text' => 'text-gray-700'],
                        'Accommodating' => ['bg' => 'bg-green-500', 'light' => 'bg-green-100', 'text' => 'text-green-700'],
                    ];
                @endphp

                @foreach($scores as $style => $score)
                    @php
                        $percentage = ($score / $maxScore) * 100;
                        $colors = $styleColors[$style] ?? ['bg' => 'bg-gray-500', 'light' => 'bg-gray-100', 'text' => 'text-gray-700'];
                        
                        // Determine level
                        if ($score >= 8) {
                            $level = 'High';
                            $levelColor = 'text-green-600';
                        } elseif ($score >= 5) {
                            $level = 'Medium';
                            $levelColor = 'text-yellow-600';
                        } else {
                            $level = 'Low';
                            $levelColor = 'text-red-600';
                        }
                    @endphp
                    
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <h3 class="font-semibold text-gray-900">{{ $style }}</h3>
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $colors['light'] }} {{ $colors['text'] }}">
                                    {{ $score }}/12
                                </span>
                                <span class="px-2 py-1 rounded-full text-xs font-bold {{ $levelColor }}">
                                    {{ $level }}
                                </span>
                            </div>
                            <span class="text-sm font-medium text-gray-600">{{ round($percentage) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="{{ $colors['bg'] }} h-3 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Dominant Style Analysis -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.1s">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">
                        Your Dominant Style: {{ $userAssessment->final_result }}
                    </h2>
                    <p class="text-gray-700 leading-relaxed text-lg">
                        {{ $resultCategory->description }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Detailed Analysis for Each Style -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            @foreach($userAssessment->assessment->resultCategories as $category)
                @php
                    $categoryScore = $scores[$category->name] ?? 0;
                    $colors = $styleColors[$category->name] ?? ['bg' => 'bg-gray-500', 'light' => 'bg-gray-100', 'text' => 'text-gray-700'];
                    
                    // Get appropriate description based on score
                    if ($categoryScore >= 8) {
                        $description = $this->getHighDescription($category->name);
                    } elseif ($categoryScore >= 5) {
                        $description = $this->getMediumDescription($category->name);
                    } else {
                        $description = $this->getLowDescription($category->name);
                    }
                @endphp
                
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow animate-slide-up" 
                     style="animation-delay: {{ ($loop->index * 0.1) }}s">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">{{ $category->name }}</h3>
                        <span class="px-4 py-2 rounded-full font-bold {{ $colors['light'] }} {{ $colors['text'] }}">
                            {{ $categoryScore }}/12
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        {{ $description }}
                    </p>
                </div>
            @endforeach
        </div>

        <!-- Interpretation Guide -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.2s">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Understanding Your Scores</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center p-6 rounded-xl bg-green-50">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-500 rounded-full mb-4">
                        <span class="text-white font-bold text-lg">H</span>
                    </div>
                    <h3 class="font-bold text-green-900 mb-2">High (8-12)</h3>
                    <p class="text-sm text-green-700">Dominantly used style - your go-to approach in most conflicts</p>
                </div>
                <div class="text-center p-6 rounded-xl bg-yellow-50">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-yellow-500 rounded-full mb-4">
                        <span class="text-white font-bold text-lg">M</span>
                    </div>
                    <h3 class="font-bold text-yellow-900 mb-2">Medium (5-7)</h3>
                    <p class="text-sm text-yellow-700">Moderately used style - situationally applied</p>
                </div>
                <div class="text-center p-6 rounded-xl bg-red-50">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-red-500 rounded-full mb-4">
                        <span class="text-white font-bold text-lg">L</span>
                    </div>
                    <h3 class="font-bold text-red-900 mb-2">Low (0-4)</h3>
                    <p class="text-sm text-red-700">Least used style - area for potential development</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('assessments.show', $userAssessment->assessment) }}" 
               class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-lg">
                Take Assessment Again
            </a>
            <a href="{{ route('dashboard') }}" 
               class="bg-white hover:bg-gray-50 text-gray-800 font-bold py-3 px-8 rounded-xl border-2 border-gray-300 transition duration-300">
                Back to Dashboard
            </a>
            <button onclick="window.print()" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 px-8 rounded-xl transition duration-300">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Results
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slide-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
    
    .animate-slide-up {
        animation: slide-up 0.6s ease-out;
    }
    
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

@php
function getHighDescription($style) {
    $descriptions = [
        'Competing' => 'With a high score, you are highly assertive and determined in conflicts. You push strongly for your position and are willing to stand your ground. You thrive in situations that require quick, decisive action.',
        'Collaborating' => 'With a high score, you naturally seek win-win solutions. You value open dialogue, creativity, and hearing all perspectives. You bring issues into the open and work toward solutions that satisfy everyone\'s needs.',
        'Compromising' => 'With a high score, you are skilled at finding middle ground and reaching practical solutions quickly. You value fairness, balance, and the ability to move forward without getting stuck.',
        'Avoiding' => 'With a high score, you often withdraw, delay, or sidestep conflicts to reduce tension or buy time. You prefer not to rush into heated discussions and may wait until emotions cool down.',
        'Accommodating' => 'With a high score, you often put others\' needs first and focus on preserving harmony. You are generous, cooperative, and willing to yield if it helps maintain peace.',
    ];
    return $descriptions[$style] ?? '';
}

function getMediumDescription($style) {
    $descriptions = [
        'Competing' => 'With a medium score, you can stand up for yourself when important, but don\'t always push aggressively. You balance firmness with sensitivity to relationships.',
        'Collaborating' => 'With a medium score, you collaborate when the issue is significant, but recognize that not every situation requires full exploration. You flex between listening deeply and moving toward quicker solutions.',
        'Compromising' => 'With a medium score, you sometimes seek middle ground, but other times hold firm or give in. You flex depending on the importance of the issue.',
        'Avoiding' => 'With a medium score, you selectively avoid conflicts - stepping back when tension is unnecessary, but engaging when issues are important.',
        'Accommodating' => 'With a medium score, you sometimes yield to others to maintain harmony, but other times assert your own needs. You flex depending on the situation.',
    ];
    return $descriptions[$style] ?? '';
}

function getLowDescription($style) {
    $descriptions = [
        'Competing' => 'With a low score, you rarely push strongly for your own way in conflicts. You may avoid direct confrontation, even when your position is important. Your growth lies in practicing assertiveness and building confidence.',
        'Collaborating' => 'With a low score, you rarely seek win-win solutions or explore all perspectives deeply. You may prefer to resolve things quickly, even if not everyone\'s needs are met. Your growth lies in practicing openness and developing skills for deeper dialogue.',
        'Compromising' => 'With a low score, you seldom suggest middle ground solutions. You may lean toward all-or-nothing approaches. Your growth lies in practicing the art of give-and-take.',
        'Avoiding' => 'With a low score, you rarely withdraw from conflicts. You prefer to confront issues directly and quickly. Your growth lies in learning when stepping back can be wise.',
        'Accommodating' => 'With a low score, you rarely give in to others, preferring to prioritize your own needs. Your growth lies in practicing empathy and learning to yield gracefully when relationships matter.',
    ];
    return $descriptions[$style] ?? '';
}
@endphp
@endsection