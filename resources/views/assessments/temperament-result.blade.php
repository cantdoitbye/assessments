@extends('layouts.public')

@section('title', 'Your Temperament Profile Results')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full shadow-lg mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Your Temperament Profile</h1>
            <p class="text-xl text-gray-600">{{ $userAssessment->assessment->title }}</p>
            <p class="text-sm text-gray-500 mt-2">Completed on {{ $userAssessment->created_at->format('F d, Y') }}</p>
        </div>

        @php
            $categories = [
                'AA' => ['name' => 'Allergy to Ambiguity', 'icon' => '🎯', 'color' => 'blue'],
                'C' => ['name' => 'Conformity', 'icon' => '📋', 'color' => 'indigo'],
                'R/S' => ['name' => 'Rigidity/Stereotyping', 'icon' => '🔒', 'color' => 'yellow'],
                'FF' => ['name' => 'Fear of Failure', 'icon' => '😰', 'color' => 'red'],
                'SS' => ['name' => 'Starved Sensibility', 'icon' => '🎨', 'color' => 'green'],
                'RM' => ['name' => 'Resource Myopia', 'icon' => '🔍', 'color' => 'gray'],
                'T' => ['name' => 'Touchiness', 'icon' => '💭', 'color' => 'purple']
            ];
            
            $resultData = $userAssessment->result_json;
            $rawScores = $resultData['raw'] ?? [];
            $percentages = $resultData['percentages'] ?? [];
            $interpretations = $resultData['interpretations'] ?? [];
        @endphp

        <!-- Summary Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">Overall Temperament Blocks Summary</h2>
            <p class="text-center text-gray-600 mb-6">This assessment identifies temperament-style blocks to creativity across seven scales. Higher scores indicate stronger blocks in that area.</p>
        </div>

        <!-- Category Scores Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($categories as $code => $info)
                @php
                    $percentage = $percentages[$code] ?? 0;
                    $interpretation = $interpretations[$code] ?? 'Average';
                    $rawScore = $rawScores[$code] ?? 0;
                    $maxScore = $code === 'SS' ? 40 : 20;
                    
                    $barColor = match($interpretation) {
                        'Very High' => 'red',
                        'High' => 'yellow',
                        'Average' => 'blue',
                        'Low' => 'green',
                        'Very Low' => 'emerald',
                        default => 'gray'
                    };
                    
                    $badgeColor = match($interpretation) {
                        'Very High' => 'bg-red-100 text-red-800',
                        'High' => 'bg-yellow-100 text-yellow-800',
                        'Average' => 'bg-blue-100 text-blue-800',
                        'Low' => 'bg-green-100 text-green-800',
                        'Very Low' => 'bg-emerald-100 text-emerald-800',
                        default => 'bg-gray-100 text-gray-800'
                    };
                @endphp
                
                <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-shadow duration-300 animate-slide-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-{{ $info['color'] }}-600 mb-1">{{ $code }}</h3>
                            <p class="text-sm text-gray-600">{{ $info['name'] }}</p>
                        </div>
                        <span class="text-4xl">{{ $info['icon'] }}</span>
                    </div>
                    
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="font-semibold text-gray-700">Score</span>
                            <span class="font-bold text-{{ $info['color'] }}-600">{{ $rawScore }}/{{ $maxScore }}</span>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-3 mb-3">
                            <div class="bg-gradient-to-r from-{{ $barColor }}-400 to-{{ $barColor }}-600 h-3 rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $percentage }}%"></div>
                        </div>
                        
                        <div class="text-center">
                            <div class="text-3xl font-bold text-{{ $info['color'] }}-600 mb-2">{{ $percentage }}%</div>
                            <span class="inline-block px-4 py-1 rounded-full text-sm font-semibold {{ $badgeColor }}">
                                {{ $interpretation }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Detailed Descriptions -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.7s">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-8 h-8 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Detailed Analysis
            </h2>
            
            @php
                $descriptions = [
                    'AA' => [
                        'Very High' => 'You tend to feel very uncomfortable when things are uncertain, vague, or open-ended. You like clarity, step-by-step plans, and predictable outcomes. This helps you create order and stability for yourself and others, and you are dependable when structure is critical. At the same time, you may resist innovation, avoid open-ended challenges, and become inflexible. You are especially useful in areas where precision, compliance, and rules are essential. <strong>To grow:</strong> practice exposing yourself to uncertainty in small, safe ways, try tasks with no fixed answers, and build tolerance for not knowing before you decide.',
                        'High' => 'You usually prefer clarity and structure, though you can handle some ambiguity. You provide reliability and steadiness, which others appreciate. Yet you may hesitate when faced with vague or uncertain tasks and shy away from experimentation. You thrive in structured roles that still require some flexibility. <strong>To grow:</strong> allow yourself time for exploration before moving into detailed planning.',
                        'Average' => 'You are balanced in your approach. You can work with clear plans and procedures, but you can also adapt when things are uncertain. This makes you versatile and able to bridge both worlds. At times, you may feel torn about whether to seek structure or embrace exploration. <strong>To grow:</strong> notice which way you lean under stress and practice using the opposite style intentionally.',
                        'Low' => 'You are comfortable with ambiguity and incomplete information. You can adapt easily to uncertain situations and thrive in exploration and brainstorming. This makes you good at seeing possibilities and staying flexible. Yet sometimes you may overlook the need for structure, and others may find you too unstructured. <strong>To grow:</strong> build small routines and checkpoints to balance your adaptability.',
                        'Very Low' => 'You thrive in uncertainty and prefer environments without rigid rules. You are comfortable exploring, experimenting, and improvising, and you bring ideas others may miss. At the same time, you may frustrate people who need order and may struggle with consistency or follow-through. <strong>To grow:</strong> work on turning your ideas into structured plans and practice discipline in execution.'
                    ],
                    'C' => [
                        'Very High' => 'You strongly prefer to follow rules, norms, and traditions. You feel secure doing things the way they have always been done. This makes you reliable and predictable, and you help maintain standards and stability. Yet this can limit your creativity, suppress new ideas, and make you resistant to change. You are valuable in roles where consistency and compliance are crucial. <strong>To grow:</strong> practice questioning assumptions, experiment with small changes, and expose yourself to alternative viewpoints.',
                        'High' => 'You usually value rules and traditions, though you can allow for some flexibility. You provide steadiness and reliability, which is appreciated in structured environments. However, you may hesitate to break from tradition even when a new approach could help. You thrive in organizations with clear expectations. <strong>To grow:</strong> take small risks to test new ideas and gradually build comfort with constructive nonconformity.',
                        'Average' => 'You balance tradition with openness to change. You can follow rules when needed but are also willing to consider alternatives. This gives you adaptability. At times, you may hesitate when required to take a strong stand for or against tradition. <strong>To grow:</strong> pay attention to when you play it safe and when you innovate, and practice leaning into whichever feels less natural.',
                        'Low' => 'You are willing to step away from rules and traditions when necessary. You bring fresh thinking and often challenge assumptions. This is valuable in change-driven or innovative roles. However, you may sometimes clash with authority or disrupt systems unnecessarily. <strong>To grow:</strong> channel your nonconformity toward constructive change and balance it with respect for what does work.',
                        'Very Low' => 'You strongly reject conformity and thrive on independence. You enjoy questioning authority and challenging norms. You are bold and innovative, and you often spark transformation. At the same time, you may appear rebellious or resistant to collaboration. <strong>To grow:</strong> learn when to align with existing systems in order to make your innovations sustainable and impactful.'
                    ],
                    'R/S' => [
                        'Very High' => 'You tend to think in very fixed patterns and routines. You prefer familiar approaches and may stereotype people or ideas. This makes you dependable and consistent, but it can also make you inflexible and resistant to change. You are reliable in stable environments where routine matters. <strong>To grow:</strong> practice perspective-taking, expose yourself to diverse viewpoints, and ask, "What would change my mind?" before making decisions.',
                        'High' => 'You show noticeable rigidity in how you think and work. You provide stability and consistency, and you help enforce standards. However, you may be slow to adapt or dismiss ideas that don\'t fit your categories. You do well where tested methods are best. <strong>To grow:</strong> deliberately try new approaches and allow yourself to consider unfamiliar perspectives.',
                        'Average' => 'You are reasonably flexible while still valuing structure. You can provide stability but also adapt when needed. This makes you balanced. At times, though, you may default to old habits under pressure. <strong>To grow:</strong> practice using flexible thinking even in stressful situations.',
                        'Low' => 'You are open-minded and adaptable. You enjoy experimenting with new routines and perspectives. This makes you agile in change-driven contexts. Yet sometimes you may lack consistency or dismiss proven methods too quickly. <strong>To grow:</strong> balance your openness with steady routines that anchor your ideas.',
                        'Very Low' => 'You are highly fluid in your thinking and resist fixed categories. You are excellent at innovation and diversity of thought. At the same time, you may struggle to stick with stable structures or routines, which can frustrate others. <strong>To grow:</strong> practice committing to tested methods when they serve your goals.'
                    ],
                    'FF' => [
                        'Very High' => 'You are highly cautious and avoid risks where failure is possible. You prepare thoroughly and avoid mistakes, which makes you dependable in safety-critical situations. At the same time, you may procrastinate, avoid challenges & competitions, or miss opportunities because you fear getting it wrong. <strong>To grow:</strong> experiment with small, safe risks, reframe failures as learning, and remind yourself that progress requires mistakes.',
                        'High' => 'You are careful and deliberate, and you prefer to avoid failure. This helps you prepare well and protect yourself from errors. Yet sometimes you may hesitate too long or play too safe. You are valuable where caution and planning are needed. <strong>To grow:</strong> take on small challenges that stretch you outside your comfort zone and build confidence from minor setbacks.',
                        'Average' => 'You are balanced. You are cautious but also willing to take some risks when the reward is worth it. This gives you flexibility. At times, you may hesitate in high-stakes situations. <strong>To grow:</strong> reflect on how you respond under stress and practice leaning toward action when doubt arises.',
                        'Low' => 'You are not overly concerned about failure. You are bold and resilient, and you learn from mistakes. This helps you in innovation and problem-solving. At times, though, you may underestimate risks or skip preparation. <strong>To grow:</strong> balance your courage with more planning and risk assessment.',
                        'Very Low' => 'You have almost no fear of failure. You are highly experimental and thrive on trying new things. You are resilient when things go wrong. However, you may act recklessly, repeat mistakes, or ignore consequences. <strong>To grow:</strong> slow down occasionally, assess risks, and capture lessons from failures.'
                    ],
                    'SS' => [
                        'Very High' => 'You are very narrow in focus and may show low curiosity about things outside your expertise. This helps you concentrate deeply and master details, but it can limit imagination and cross-disciplinary creativity. You are useful in technical or highly specialized roles. <strong>To grow:</strong> diversify your inputs, explore unfamiliar fields, and engage in activities that stimulate your imagination.',
                        'High' => 'You prefer focus and specialization. You are reliable with details and technical tasks. Yet you may be less responsive to novelty or aesthetic experiences. You do well where precision matters. <strong>To grow:</strong> broaden your exposure to art, culture, or unrelated fields to spark new ideas.',
                        'Average' => 'You are balanced — you can focus deeply but also explore new interests. You bring steadiness with some openness. At times, you may need prompting to refresh your imagination. <strong>To grow:</strong> schedule regular exposure to new ideas or fields.',
                        'Low' => 'You are curious and enjoy variety. You bring fresh perspectives and cross-pollinate ideas from different areas. At times, though, you may lack depth in one domain. <strong>To grow:</strong> commit to mastering one area while still feeding your curiosity.',
                        'Very Low' => 'You are extremely curious and imaginative, with wide-ranging interests. You generate many new connections and ideas. Yet you may scatter your energy and struggle to finish projects. <strong>To grow:</strong> focus your curiosity into a sustained project and balance exploration with discipline.'
                    ],
                    'RM' => [
                        'Very High' => 'You tend to depend heavily on external support or authority for resources and solutions. You are cooperative and patient in structured systems, but you may become passive and avoid initiative. You are useful in hierarchical settings where following direction is valued. <strong>To grow:</strong> practice identifying and mobilizing your own resources and take small steps to act independently.',
                        'High' => 'You often look outward for help and guidance. You work well in teams and within authority structures, but you may hesitate to take ownership. You do well where clear direction is given. <strong>To grow:</strong> set small goals that require self-initiative and actively seek out resources on your own.',
                        'Average' => 'You are balanced between self-reliance and dependency. You can collaborate when needed but can also take initiative. At times, though, you may wait for permission rather than acting. <strong>To grow:</strong> practice taking small independent steps even when no one has directed you.',
                        'Low' => 'You are resourceful and proactive. You take initiative and mobilize what you need. This makes you effective in entrepreneurial or leadership roles. At times, though, you may underutilize group support and appear overly independent. <strong>To grow:</strong> practice asking for help and collaboration when appropriate.',
                        'Very Low' => 'You are highly independent and self-directed. You create opportunities and show strong agency. This is valuable in innovation and leadership. However, you may resist authority and struggle with cooperation. <strong>To grow:</strong> balance independence with teamwork and respect for group structures.'
                    ],
                    'T' => [
                        'Very High' => 'You are highly sensitive to criticism and humiliation. You protect yourself from situations where you might be judged. This makes you socially cautious and considerate of others\' feelings. At the same time, it can prevent you from taking feedback, limit your growth, and isolate you. You are useful in roles requiring tact and sensitivity. <strong>To grow:</strong> practice seeking small pieces of feedback, reframe criticism as learning, and build self-compassion.',
                        'High' => 'You show noticeable sensitivity to criticism. You are careful not to offend others and are considerate in relationships. Yet you may hesitate to share ideas or become defensive in collaboration. You are valued in people-focused environments. <strong>To grow:</strong> increase your tolerance for feedback by starting with trusted colleagues.',
                        'Average' => 'You are balanced. You can take feedback while still protecting your self-esteem. This makes you open to growth yet careful with yourself. At times, though, you may hesitate in highly evaluative settings. <strong>To grow:</strong> remind yourself that critique is information, not identity.',
                        'Low' => 'You are fairly resilient to criticism. You can hear feedback openly and use it to improve. This makes you adaptable and growth-oriented. At times, though, you may overlook how criticism affects others. <strong>To grow:</strong> be mindful of empathy when giving feedback to others.',
                        'Very Low' => 'You have little fear of humiliation. You are bold, expressive, and resilient. You take risks socially and are not easily discouraged. Yet you may sometimes appear insensitive, blunt, or reckless in group settings. <strong>To grow:</strong> balance your boldness with tact and awareness of others\' feelings.'
                    ]
                ];
            @endphp

            <div class="space-y-6">
                @foreach($categories as $code => $info)
                    <div class="border-l-4 border-{{ $info['color'] }}-500 pl-6 py-4 bg-{{ $info['color'] }}-50 rounded-r-lg">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center">
                                <span class="text-3xl mr-3">{{ $info['icon'] }}</span>
                                <div>
                                    <h3 class="text-xl font-bold text-{{ $info['color'] }}-900">{{ $code }} - {{ $info['name'] }}</h3>
                                    <span class="inline-block px-3 py-1 mt-1 rounded-full text-sm font-semibold {{ $badgeColor ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $interpretations[$code] ?? 'Average' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700 leading-relaxed">
                            {!! $descriptions[$code][$interpretations[$code] ?? 'Average'] ?? 'No description available.' !!}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Score Interpretation Guide -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.8s">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-8 h-8 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Score Interpretation Guide
            </h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="flex items-center space-x-4 p-4 rounded-lg bg-red-50">
                    <span class="px-4 py-2 rounded-lg bg-red-100 text-red-800 font-bold text-sm whitespace-nowrap">Very High</span>
                    <span class="text-gray-700">60% and above</span>
                </div>
                <div class="flex items-center space-x-4 p-4 rounded-lg bg-yellow-50">
                    <span class="px-4 py-2 rounded-lg bg-yellow-100 text-yellow-800 font-bold text-sm whitespace-nowrap">High</span>
                    <span class="text-gray-700">40% - 59%</span>
                </div>
                <div class="flex items-center space-x-4 p-4 rounded-lg bg-blue-50">
                    <span class="px-4 py-2 rounded-lg bg-blue-100 text-blue-800 font-bold text-sm whitespace-nowrap">Average</span>
                    <span class="text-gray-700">25% - 39%</span>
                </div>
                <div class="flex items-center space-x-4 p-4 rounded-lg bg-green-50">
                    <span class="px-4 py-2 rounded-lg bg-green-100 text-green-800 font-bold text-sm whitespace-nowrap">Low</span>
                    <span class="text-gray-700">15% - 24%</span>
                </div>
                <div class="flex items-center space-x-4 p-4 rounded-lg bg-emerald-50 md:col-span-2">
                    <span class="px-4 py-2 rounded-lg bg-emerald-100 text-emerald-800 font-bold text-sm whitespace-nowrap">Very Low</span>
                    <span class="text-gray-700">Below 15%</span>
                </div>
            </div>
            <div class="mt-6 p-4 bg-indigo-50 rounded-lg">
                <p class="text-sm text-gray-700">
                    <strong class="text-indigo-900">Note:</strong> Higher scores indicate stronger blocks to creativity in that area. Lower scores suggest greater openness and flexibility. This is a developmental tool, not a diagnostic instrument.
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in">
            <a href="{{ route('assessments.show', $userAssessment->assessment) }}" 
               class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-lg">
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
@endsection