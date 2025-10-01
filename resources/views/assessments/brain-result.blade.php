@extends('layouts.public')

@section('title', 'Your Brain Dominance Results')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-pink-50 py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full shadow-lg mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Your Brain Dominance Profile</h1>
            <p class="text-xl text-gray-600">{{ $userAssessment->assessment->title }}</p>
        </div>

        @php
            $scores = $userAssessment->result_json;
            $leftScore = $scores['Left'] ?? 0;
            $rightScore = $scores['Right'] ?? 0;
            $totalQuestions = 30;
            
            // Determine the brain dominance category
            if ($leftScore >= 24) {
                $category = 'Strong Left-Brain';
                $categoryColor = 'blue';
            } elseif ($leftScore >= 18) {
                $category = 'Moderate Left-Brain';
                $categoryColor = 'indigo';
            } elseif ($leftScore >= 14 && $rightScore >= 14) {
                $category = 'Balanced/Whole-Brain';
                $categoryColor = 'purple';
            } elseif ($rightScore >= 18) {
                $category = 'Moderate Right-Brain';
                $categoryColor = 'pink';
            } else {
                $category = 'Strong Right-Brain';
                $categoryColor = 'rose';
            }
            
            $resultCategory = $userAssessment->assessment->resultCategories()
                ->where('name', $category)
                ->first();
        @endphp

        <!-- Brain Visualization -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Your Thinking Style Distribution</h2>
            
            <div class="flex items-center justify-center mb-8">
                <div class="relative w-full max-w-2xl">
                    <!-- Left Brain Section -->
                    <div class="flex items-center mb-4">
                        <div class="w-32 text-right pr-4">
                            <span class="text-lg font-bold text-blue-600">Left Brain</span>
                            <p class="text-sm text-gray-600">Logical</p>
                        </div>
                        <div class="flex-1 bg-gray-200 rounded-l-full h-16 relative overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-400 h-full rounded-l-full transition-all duration-1000 ease-out flex items-center justify-end pr-4" 
                                 style="width: {{ ($leftScore / $totalQuestions) * 100 }}%">
                                <span class="text-white font-bold text-xl">{{ $leftScore }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Brain Section -->
                    <div class="flex items-center">
                        <div class="w-32 text-right pr-4">
                            <span class="text-lg font-bold text-pink-600">Right Brain</span>
                            <p class="text-sm text-gray-600">Creative</p>
                        </div>
                        <div class="flex-1 bg-gray-200 rounded-l-full h-16 relative overflow-hidden">
                            <div class="bg-gradient-to-r from-pink-500 to-rose-400 h-full rounded-l-full transition-all duration-1000 ease-out flex items-center justify-end pr-4" 
                                 style="width: {{ ($rightScore / $totalQuestions) * 100 }}%">
                                <span class="text-white font-bold text-xl">{{ $rightScore }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Score Summary -->
            <div class="grid md:grid-cols-2 gap-6 mt-8">
                <div class="text-center p-6 rounded-xl bg-blue-50">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ $leftScore }}/30</div>
                    <p class="text-lg font-semibold text-blue-900">Left-Brain Responses</p>
                    <p class="text-sm text-blue-700 mt-2">{{ round(($leftScore / $totalQuestions) * 100) }}% Analytical</p>
                </div>
                <div class="text-center p-6 rounded-xl bg-pink-50">
                    <div class="text-4xl font-bold text-pink-600 mb-2">{{ $rightScore }}/30</div>
                    <p class="text-lg font-semibold text-pink-900">Right-Brain Responses</p>
                    <p class="text-sm text-pink-700 mt-2">{{ round(($rightScore / $totalQuestions) * 100) }}% Creative</p>
                </div>
            </div>
        </div>

        <!-- Your Profile -->
        <div class="bg-gradient-to-r from-{{ $categoryColor }}-50 to-{{ $categoryColor }}-100 rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.1s">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-gradient-to-r from-{{ $categoryColor }}-500 to-{{ $categoryColor }}-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">
                        Your Profile: {{ $category }}
                    </h2>
                    <p class="text-gray-700 leading-relaxed text-lg">
                        {{ $resultCategory->description }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Detailed Analysis -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.2s">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Detailed Profile & Growth Suggestions</h2>
            <div class="prose prose-lg max-w-none">
                {!! getDetailedDescription($category) !!}
            </div>
        </div>

        <!-- Understanding Your Results -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.3s">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Understanding Your Dominance</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Left Brain -->
                <div class="border-l-4 border-blue-500 pl-6">
                    <h3 class="text-xl font-bold text-blue-900 mb-4">Left-Brain Traits</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Analytical and logical thinking
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Sequential processing
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Detail-oriented
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Verbal and mathematical
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Prefers structure and planning
                        </li>
                    </ul>
                </div>

                <!-- Right Brain -->
                <div class="border-l-4 border-pink-500 pl-6">
                    <h3 class="text-xl font-bold text-pink-900 mb-4">Right-Brain Traits</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-pink-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Big-picture oriented
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-pink-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Visual and spatial
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-pink-500 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Prefers spontaneity and flexibility
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Score Ranges Guide -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.4s">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Score Interpretation Guide</h2>
            <div class="space-y-4">
                <div class="flex items-start space-x-4 p-4 rounded-lg bg-blue-50">
                    <div class="flex-shrink-0 w-24 text-center">
                        <span class="font-bold text-blue-900">24-30 A's</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-blue-900 mb-1">Strong Left-Brain</h3>
                        <p class="text-sm text-gray-700">Highly analytical, structured, and logical. Excels in data-driven fields.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 p-4 rounded-lg bg-indigo-50">
                    <div class="flex-shrink-0 w-24 text-center">
                        <span class="font-bold text-indigo-900">18-23 A's</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-indigo-900 mb-1">Moderate Left-Brain</h3>
                        <p class="text-sm text-gray-700">Prefers structure but allows flexibility. Good at practical decision-making.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 p-4 rounded-lg bg-purple-50">
                    <div class="flex-shrink-0 w-24 text-center">
                        <span class="font-bold text-purple-900">14-17 Each</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-purple-900 mb-1">Balanced/Whole-Brain</h3>
                        <p class="text-sm text-gray-700">Flexible thinker who adapts easily. Can switch between logic and creativity.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 p-4 rounded-lg bg-pink-50">
                    <div class="flex-shrink-0 w-24 text-center">
                        <span class="font-bold text-pink-900">18-23 B's</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-pink-900 mb-1">Moderate Right-Brain</h3>
                        <p class="text-sm text-gray-700">Enjoys variety and experimentation. Strong at creative problem-solving.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 p-4 rounded-lg bg-rose-50">
                    <div class="flex-shrink-0 w-24 text-center">
                        <span class="font-bold text-rose-900">24-30 B's</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-rose-900 mb-1">Strong Right-Brain</h3>
                        <p class="text-sm text-gray-700">Highly intuitive and creative. Thrives in artistic and innovative fields.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('assessments.show', $userAssessment->assessment) }}" 
               class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-lg">
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
        button {
            display: none !important;
        }
    }
</style>

@php
function getDetailedDescription($category) {
    $descriptions = [
        'Strong Left-Brain' => '<p class="mb-4">You prefer order, structure, and routines. You rely on logic and facts more than feelings. You like rules, lists, and schedules, and you feel comfortable when life is predictable and well-planned. You make decisions cautiously after analyzing details.</p>
        <p class="mb-4"><strong class="text-gray-900">Career Strengths:</strong> You would excel in roles that are data-driven such as finance, engineering, law, IT, or research. You are strong in project management, step-by-step execution, and quality control. You produce reliable, consistent results and are excellent at identifying risks, flaws, and gaps.</p>
        <p class="mb-4"><strong class="text-gray-900">Potential Challenges:</strong> You may resist change or spontaneity and can sometimes come across as rigid or overly cautious. You may also undervalue intuition, creativity, and emotions in yourself and others.</p>
        <p><strong class="text-gray-900">Growth Suggestions:</strong> Allow space for creativity and play—try art, journaling, or brainstorming without structure. Practice saying "yes" to spontaneous activities. In decision-making, experiment with listening to your gut feelings, not just facts. Collaborate with highly creative colleagues to balance your perspective.</p>',
        
        'Moderate Left-Brain' => '<p class="mb-4">You generally prefer structure but allow some flexibility. You are comfortable with rules but can improvise if needed. You like understanding how things work and often take a fact-based approach to conversations, though you can listen to emotions too. You make practical decisions and balance logic with some openness.</p>
        <p class="mb-4"><strong class="text-gray-900">Career Strengths:</strong> Professionally, you are good at analysis and structured action. You adapt while still providing stability and structure in work environments. You perform well in management, operations, teaching, analysis, or healthcare. You are skilled at turning ideas into practical, workable plans.</p>
        <p class="mb-4"><strong class="text-gray-900">Potential Challenges:</strong> At times, you may overthink before acting and struggle with ambiguity or "big-picture" vision. You may also undervalue imagination if it feels "impractical."</p>
        <p><strong class="text-gray-900">Growth Suggestions:</strong> Push yourself to engage in visionary, "big picture" discussions before diving into details. Try mind-mapping or drawing ideas instead of only writing lists. Set small challenges to act before you feel fully ready. Join brainstorming sessions without judgment of feasibility.</p>',
        
        'Balanced/Whole-Brain' => '<p class="mb-4">You are a flexible thinker who adapts to different situations easily. You can switch between logic and intuition depending on the context. You balance planning with spontaneity and feel equally comfortable with detail and the big picture. You often connect with both analytical and creative people.</p>
        <p class="mb-4"><strong class="text-gray-900">Career Strengths:</strong> In your work, you are well-rounded and good at both teamwork and leadership. You can move between strategic thinking and detailed execution. You are effective in roles that combine innovation with execution such as entrepreneurship, consultancy, or leadership. You often act as a bridge between data-driven and creative teams.</p>
        <p class="mb-4"><strong class="text-gray-900">Potential Challenges:</strong> At times, you may feel "pulled" between two styles, which can lead to indecision. You may not specialize deeply in one area and risk becoming a "jack of all trades, master of none" if you don\'t focus.</p>
        <p><strong class="text-gray-900">Growth Suggestions:</strong> Choose a few areas to specialize in so you can develop mastery. Strengthen decision-making by setting deadlines and committing to a choice. Notice which side (logic vs creativity) you rely on under stress and practice balancing it. Take roles where you intentionally switch between detail and vision to sharpen both.</p>',
        
        'Moderate Right-Brain' => '<p class="mb-4">You enjoy variety, change, and experimentation. You are comfortable with ambiguity and uncertainty. You think in metaphors, visuals, and "what ifs." You prefer big-picture conversations over small details and you are expressive, empathetic, and people-focused.</p>
        <p class="mb-4"><strong class="text-gray-900">Career Strengths:</strong> In your career, you excel in roles requiring creativity, design, communication, marketing, teaching, or counseling. You are strong at brainstorming, innovation, and inspiring others. You are comfortable with non-linear, multi-tasking work styles and you bring fresh perspectives to problem-solving.</p>
        <p class="mb-4"><strong class="text-gray-900">Potential Challenges:</strong> You may struggle with time management and deadlines. You can overlook important details or practical limitations and may start many things but find it difficult to finish them.</p>
        <p><strong class="text-gray-900">Growth Suggestions:</strong> Use planners or digital tools to keep yourself accountable. Break large creative projects into small, trackable milestones. Intentionally practice detail work (e.g., editing, budgeting) to complement your vision. Partner with structured, left-brain thinkers who help you follow through.</p>',
        
        'Strong Right-Brain' => '<p class="mb-4">You are strongly intuitive, imaginative, and spontaneous. You follow feelings and instincts more than logic. You love storytelling, music, art, and emotional experiences. You see patterns and connections others may miss, and you dislike rigid rules and routines.</p>
        <p class="mb-4"><strong class="text-gray-900">Career Strengths:</strong> You thrive in careers such as art, writing, design, entrepreneurship, coaching, innovation, or therapy. You bring visionary ideas and inspire others. You have strong emotional intelligence and easily connect with people. You are comfortable in dynamic, rapidly changing environments.</p>
        <p class="mb-4"><strong class="text-gray-900">Potential Challenges:</strong> You can appear scattered or disorganized. You may resist planning, rules, or authority. You may have great ideas but struggle with follow-through, and you might avoid "hard data" and accountability when it feels restrictive.</p>
        <p><strong class="text-gray-900">Growth Suggestions:</strong> Develop simple routines to bring focus without limiting creativity. Practice completing one project before starting another. Learn basic financial or analytical skills to ground your vision. Partner with structured teammates who can help with execution while you provide inspiration.</p>',
    ];
    
    return $descriptions[$category] ?? '';
}
@endphp
@endsection