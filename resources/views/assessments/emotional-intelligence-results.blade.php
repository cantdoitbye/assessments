@extends('layouts.public')

@section('title', 'Your Emotional Intelligence Results')

@section('content')
@php
// Calculate averages for each dimension (each has 10 questions)
$scores = $userAssessment->result_json;

$dimensionQuestionCounts = [
    'Self-Awareness' => 10,
    'Self-Management' => 10,
    'Awareness of Others' => 10,
    'Relating to Others' => 10,
];

$dimensionAverages = [];
$interpretations = [];

foreach ($scores as $dimension => $totalScore) {
    $questionCount = $dimensionQuestionCounts[$dimension] ?? 10;
    $average = round($totalScore / $questionCount, 2);
    $dimensionAverages[$dimension] = $average;
    
    // Determine interpretation based on average
    if ($average >= 4.3) {
        $interpretations[$dimension] = 'High';
    } elseif ($average >= 3.0) {
        $interpretations[$dimension] = 'Moderate';
    } else {
        $interpretations[$dimension] = 'Low';
    }
}

// Function to get color for each interpretation
function getInterpretationColor($interpretation) {
    return match($interpretation) {
        'High' => 'green',
        'Moderate' => 'yellow',
        'Low' => 'orange',
        default => 'gray'
    };
}

// Function to get detailed description
function getDimensionDescription($dimension, $level) {
    $descriptions = [
        'Self-Awareness' => [
            'High' => 'You notice your emotions as they arise and can name them precisely. You recognize patterns in your moods, and you understand how your values and needs influence your choices. You actively seek feedback and reflect on both your mistakes and your successes. This clarity helps you make aligned decisions and stay authentic in your interactions. You\'re usually honest with yourself, grounded in reality, and capable of self-correction. You tend to pause before reacting, and you learn deeply from emotional experiences.',
            'Moderate' => 'You understand yourself reasonably well, but there may be blind spots — emotional patterns or triggers you don\'t always catch. You reflect sometimes, but not consistently. You notice strong emotions but may miss the subtler shifts underneath. You\'re aware of how you come across, yet there are times when your reactions surprise you.',
            'Low' => 'You may often feel unclear about your emotional states or act before realizing what you\'re feeling. Emotions can feel confusing or come out as impulsive reactions. You might find yourself surprised by your own responses, or unsure why something affected you so deeply.',
        ],
        'Self-Management' => [
            'High' => 'You stay centred under pressure. You recover quickly from stress and shift from frustration to problem-solving with ease. You don\'t allow temporary emotions to dictate your behaviour; instead, you use them as information to guide effective action. You\'re disciplined, adaptable, and dependable — the kind of person others trust in a crisis.',
            'Moderate' => 'You manage your emotions effectively most of the time, but you may struggle when fatigue, pressure, or personal stress build up. You stay composed in predictable challenges but might slip into frustration, self-criticism, or avoidance when situations stretch you.',
            'Low' => 'Your emotions often take charge. Impulsive reactions, avoidance, or procrastination may get in your way. You might feel driven by moods rather than values. This can show up as emotional outbursts, withdrawal, or difficulty following through on goals.',
        ],
        'Awareness of Others' => [
            'High' => 'You intuitively notice subtle cues — tone, body language, micro-expressions, pauses. You sense how people feel, often before they say it. You adapt your communication to the emotional context and make others feel understood. You listen deeply and respond with genuine empathy.',
            'Moderate' => 'You read emotions accurately in most obvious situations but may miss subtler signals — tension beneath politeness, fatigue behind enthusiasm, or group unease that no one voices. You understand and respond well when people share openly, but your sensitivity may depend on your mood or focus.',
            'Low' => 'You may focus more on facts and tasks than on emotional signals. You might miss cues that others are hurt, stressed, or disengaged until issues become visible. Emotional nuance feels vague or uncomfortable, so you prefer to deal with clear information.',
        ],
        'Relating to Others' => [
            'High' => 'You build relationships grounded in trust and respect. You communicate clearly and directly, balancing honesty with care. You resolve conflict calmly and help others find win–win outcomes. You give feedback thoughtfully and take responsibility for repairing misunderstandings. You naturally uplift others, encourage development, and foster collaboration.',
            'Moderate' => 'You maintain healthy, functional relationships and can navigate many interpersonal situations effectively. You collaborate well and communicate respectfully. Yet, when tensions rise, you may hesitate to give direct feedback or avoid high-stakes conversations. You might prefer harmony over confrontation, even when clarity is needed.',
            'Low' => 'You may find relationships draining, tense, or confusing. You might withdraw under stress, struggle to resolve conflicts, or react defensively when challenged. You could be highly independent but at the cost of connection.',
        ],
    ];
    
    return $descriptions[$dimension][$level] ?? '';
}

// Function to get growth advice
function getGrowthAdvice($dimension, $level) {
    $advice = [
        'Self-Awareness' => [
            'High' => 'Your growth opportunity lies in balancing reflection with action — grounding your insight in embodiment and self-compassion. Practices like brief end-of-day reflection, checking in with your body, and regular feedback conversations can deepen your awareness while keeping it kind and constructive.',
            'Moderate' => 'Your growth point is consistency: make reflection a small daily ritual, ask others how they experience you, and take note of recurring emotional themes. These habits will sharpen your insight and make your awareness more reliable.',
            'Low' => 'Your growth begins with simple awareness-building — naming one feeling a day, doing quick body scans to notice tension, and asking trusted people how they perceive your energy or tone. Over time, you\'ll start to connect dots between emotion, thought, and behavior — and that changes everything.',
        ],
        'Self-Management' => [
            'High' => 'Your growth edge lies in allowing vulnerability and emotional expression without losing composure. Balance control with openness — show more of what you feel, not just what you think. Rest, emotional release practices, and deliberate authenticity will deepen your resilience without hardening it.',
            'Moderate' => 'The growth point for you is consistency and recovery: establish simple regulation habits, schedule decompression time, and reflect after intense situations. With deliberate practice, you\'ll strengthen your emotional muscle memory so you can bounce back faster.',
            'Low' => 'The key growth path for you is learning pause-and-redirect skills. Start with small interventions: take three conscious breaths before responding, use grounding techniques during conflict, and set up accountability for your habits. Over time, this steadiness will give you a stronger sense of power and integrity.',
        ],
        'Awareness of Others' => [
            'High' => 'Your growth opportunity is to balance empathy with healthy detachment — to feel with others without feeling for them. You might practice checking in with yourself after emotionally heavy interactions or visualizing emotional boundaries that keep your energy centred.',
            'Moderate' => 'The growth opportunity is to refine your listening and observation skills: notice what\'s not said, track tone and pace, and confirm your interpretations gently ("You seem a little quieter today — how are you feeling?"). This kind of curiosity sharpens empathy.',
            'Low' => 'Your growth path is to cultivate curiosity — pause to check how others are feeling, look for subtle shifts in energy, and listen for what emotions might be under the words. A small increase in empathy can profoundly deepen your influence.',
        ],
        'Relating to Others' => [
            'High' => 'Your growth opportunity is to maintain boundaries and practice assertive honesty. It\'s not your job to keep everyone comfortable — sometimes growth requires discomfort. Learning to say no gracefully, delegate responsibility, and manage your own emotional energy will keep your relationships authentic and sustainable.',
            'Moderate' => 'Your growth lies in deepening candor and courage — leaning into difficult conversations, expressing needs clearly, and trusting that honesty strengthens connection. Role-playing feedback or conflict conversations can help you build this confidence.',
            'Low' => 'The growth path here is learning small, practical interpersonal habits: acknowledge others\' contributions, ask for input, express appreciation, and practice repair when tension arises. These small acts of relational courage can transform your connection with others and restore trust where it\'s been strained.',
        ],
    ];
    
    return $advice[$dimension][$level] ?? '';
}

// Function to get dimension icon
function getDimensionIcon($dimension) {
    return match($dimension) {
        'Self-Awareness' => '🧠',
        'Self-Management' => '⚖️',
        'Awareness of Others' => '👁️',
        'Relating to Others' => '🤝',
        default => '📊'
    };
}
@endphp

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full mb-6 shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Your Emotional Intelligence Profile</h1>
            <p class="text-xl text-gray-600">{{ $userAssessment->assessment->title }}</p>
        </div>

        <!-- Overall Summary Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Your EI Dimensions Overview</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($dimensionAverages as $dimension => $average)
                    @php
                        $interpretation = $interpretations[$dimension];
                        $color = getInterpretationColor($interpretation);
                    @endphp
                    <div class="border-l-4 border-{{ $color }}-500 bg-{{ $color }}-50 rounded-r-lg p-6">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center">
                                <span class="text-3xl mr-3">{{ getDimensionIcon($dimension) }}</span>
                                <h3 class="text-lg font-bold text-gray-900">{{ $dimension }}</h3>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                                {{ $interpretation }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Average Score</span>
                                <span class="font-semibold">{{ $average }} / 5.0</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full transition-all duration-1000 ease-out bg-{{ $color }}-500"
                                    style="width: {{ ($average / 5) * 100 }}%">
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600">
                            @if($average >= 4.3) 
                                4.3 - 5.0 (High)
                            @elseif($average >= 3.0) 
                                3.0 - 4.2 (Moderate/Developing)
                            @else 
                                1.0 - 2.9 (Needs Development)
                            @endif
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Detailed Results for Each Dimension -->
        @foreach($dimensionAverages as $dimension => $average)
            @php
                $interpretation = $interpretations[$dimension];
                $color = getInterpretationColor($interpretation);
            @endphp
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mr-4 bg-{{ $color }}-100">
                        <span class="text-4xl">{{ getDimensionIcon($dimension) }}</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $dimension }}</h3>
                        <p class="text-gray-600">{{ $interpretation }} Level ({{ $average }} / 5.0)</p>
                    </div>
                </div>

                <!-- What This Means -->
                <div class="bg-gray-50 rounded-xl p-6 mb-4">
                    <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        What This Means
                    </h4>
                    <p class="text-gray-700 leading-relaxed">
                        {!! nl2br(e(getDimensionDescription($dimension, $interpretation))) !!}
                    </p>
                </div>

                <!-- Growth Opportunity -->
                <div class="bg-{{ $color }}-50 rounded-xl p-6 border-l-4 border-{{ $color }}-500">
                    <h4 class="font-bold text-{{ $color }}-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Growth Opportunity
                    </h4>
                    <p class="text-{{ $color }}-800 leading-relaxed">
                        {!! nl2br(e(getGrowthAdvice($dimension, $interpretation))) !!}
                    </p>
                </div>
            </div>
        @endforeach

        <!-- Score Interpretation Guide -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.5s">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Understanding Your Scores</h2>
            <div class="space-y-4">
                <div class="flex items-start space-x-4 p-4 rounded-lg bg-green-50 border-l-4 border-green-500">
                    <div class="flex-shrink-0 w-24 text-center">
                        <span class="font-bold text-green-900 text-lg">4.3 - 5.0</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-green-900 mb-1">High</h3>
                        <p class="text-sm text-gray-700">You demonstrate strong capabilities in this dimension and consistently apply these skills effectively. Your strengths lie in emotional honesty, clarity, and intuitive understanding.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 p-4 rounded-lg bg-yellow-50 border-l-4 border-yellow-500">
                    <div class="flex-shrink-0 w-24 text-center">
                        <span class="font-bold text-yellow-900 text-lg">3.0 - 4.2</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-yellow-900 mb-1">Moderate / Developing</h3>
                        <p class="text-sm text-gray-700">You have developing skills in this area with room for consistent improvement and practice. You're balanced but could benefit from more intentional focus.</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 p-4 rounded-lg bg-orange-50 border-l-4 border-orange-500">
                    <div class="flex-shrink-0 w-24 text-center">
                        <span class="font-bold text-orange-900 text-lg">1.0 - 2.9</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-orange-900 mb-1">Low / Needs Development</h3>
                        <p class="text-sm text-gray-700">This dimension needs focused development and would benefit from targeted practices and support. Small, consistent efforts can create significant growth.</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-blue-50 rounded-xl p-6 border-l-4 border-blue-500">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-blue-900 font-semibold mb-2">Remember:</p>
                        <p class="text-blue-800 text-sm">Emotional Intelligence is not fixed—it can be developed through practice, reflection, and intentional effort. Use this assessment as a starting point for your growth journey. Each dimension can be strengthened with awareness and consistent practice.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8 animate-fade-in">
            <a href="{{ route('assessments.index') }}" 
               class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-lg transform hover:scale-105">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Take Assessment Again
            </a>
            <a href="{{ route('home') }}" 
               class="bg-white hover:bg-gray-50 text-gray-800 font-bold py-3 px-8 rounded-xl border-2 border-gray-300 transition duration-300 transform hover:scale-105">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Back to Home
            </a>
            <button onclick="window.print()" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 px-8 rounded-xl transition duration-300 transform hover:scale-105">
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
        .animate-fade-in, .animate-slide-up {
            animation: none !important;
        }
    }
</style>
@endsection