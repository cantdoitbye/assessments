@extends('layouts.public')

@section('title', 'Your Leadership Style Results')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teal-50 via-white to-cyan-50 py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-full shadow-lg mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Your Leadership Style Profile</h1>
            <p class="text-xl text-gray-600">{{ $userAssessment->assessment->title }}</p>
            <p class="text-sm text-gray-500 mt-2">Based on Hersey and Blanchard's Situational Leadership Model</p>
            <p class="text-sm text-gray-500">Completed on {{ $userAssessment->created_at->format('F d, Y') }}</p>
        </div>

        @php
            $scores = $userAssessment->result_json;
            $totalQuestions = 12;
            
            // Define style colors and icons
            $styleInfo = [
                'Directing' => ['color' => 'red', 'icon' => '🎯', 'bgGradient' => 'from-red-500 to-red-600', 'label' => 'Telling'],
                'Coaching' => ['color' => 'blue', 'icon' => '🎓', 'bgGradient' => 'from-blue-500 to-blue-600', 'label' => 'Selling'],
                'Supporting' => ['color' => 'green', 'icon' => '🤝', 'bgGradient' => 'from-green-500 to-green-600', 'label' => 'Facilitating'],
                'Delegating' => ['color' => 'purple', 'icon' => '🚀', 'bgGradient' => 'from-purple-500 to-purple-600', 'label' => 'Observing'],
            ];
            
            // Sort scores to find primary and secondary styles
            arsort($scores);
            $sortedStyles = array_keys($scores);
            $primaryStyle = $sortedStyles[0];
            $primaryScore = $scores[$primaryStyle];
            
            // Check for secondary and hybrid styles
            $secondaryStyle = $sortedStyles[1] ?? null;
            $secondaryScore = $scores[$secondaryStyle] ?? 0;
            
            // Hybrid if difference is 1-2 points
            $isHybrid = ($primaryScore - $secondaryScore) <= 2 && $secondaryScore > 0;
            
            // Determine the final result label
            if ($isHybrid && $secondaryStyle) {
                $resultLabel = $primaryStyle . '-' . $secondaryStyle;
            } else {
                $resultLabel = $primaryStyle;
            }
        @endphp

        <!-- Leadership Style Distribution -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Your Leadership Style Distribution</h2>
            
            <div class="space-y-6">
                @foreach(['Directing', 'Coaching', 'Supporting', 'Delegating'] as $style)
                    @php
                        $score = $scores[$style] ?? 0;
                        $percentage = ($score / $totalQuestions) * 100;
                        $info = $styleInfo[$style];
                        $isPrimary = $style === $primaryStyle;
                        $isSecondary = $style === $secondaryStyle && $isHybrid;
                    @endphp
                    
                    <div class="{{ ($isPrimary || $isSecondary) ? 'ring-4 ring-' . $info['color'] . '-300 rounded-lg p-4' : '' }}">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-3">
                                <span class="text-3xl">{{ $info['icon'] }}</span>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <h3 class="text-lg font-bold text-{{ $info['color'] }}-900">{{ $style }}</h3>
                                        <span class="text-sm text-gray-500">({{ $info['label'] }})</span>
                                        @if($isPrimary)
                                            <span class="px-2 py-1 text-xs font-semibold bg-{{ $info['color'] }}-100 text-{{ $info['color'] }}-800 rounded-full">Primary</span>
                                        @endif
                                        @if($isSecondary)
                                            <span class="px-2 py-1 text-xs font-semibold bg-{{ $info['color'] }}-100 text-{{ $info['color'] }}-800 rounded-full">Secondary</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $score }} out of {{ $totalQuestions }} situations</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-{{ $info['color'] }}-600">{{ round($percentage) }}%</span>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                            <div class="bg-gradient-to-r {{ $info['bgGradient'] }} h-6 rounded-full transition-all duration-1000 ease-out flex items-center justify-end pr-3" 
                                 style="width: {{ $percentage }}%">
                                @if($percentage > 15)
                                    <span class="text-white text-sm font-semibold">{{ $score }}/{{ $totalQuestions }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Primary Style Profile -->
        @php
            $primaryInfo = $styleInfo[$primaryStyle];
        @endphp
        
        <div class="bg-gradient-to-r from-{{ $primaryInfo['color'] }}-50 to-{{ $primaryInfo['color'] }}-100 rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.1s">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-gradient-to-r {{ $primaryInfo['bgGradient'] }} rounded-full flex items-center justify-center text-3xl">
                        {{ $primaryInfo['icon'] }}
                    </div>
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">
                        Your Primary Leadership Style: {{ $primaryStyle }}
                        @if($isHybrid && $secondaryStyle)
                            <span class="text-lg text-gray-700">with {{ $secondaryStyle }} tendencies</span>
                        @endif
                    </h2>
                    <p class="text-gray-700 leading-relaxed text-lg mb-4">
                        {{ getStyleSummary($primaryStyle) }}
                    </p>
                    @if($isHybrid && $secondaryStyle)
                        <div class="mt-4 p-4 bg-white/50 rounded-lg">
                            <p class="text-sm text-gray-700">
                                <strong>Secondary Style ({{ $secondaryStyle }}):</strong> {{ getStyleSummary($secondaryStyle) }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detailed Profile Analysis -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.2s">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-8 h-8 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Detailed Leadership Profile
            </h2>
            <div class="prose prose-lg max-w-none">
                {!! getDetailedLeadershipProfile($resultLabel) !!}
            </div>
        </div>

        <!-- 4-Block Grid Overview -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.3s">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Situational Leadership Styles Overview</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Directing -->
                <div class="border-4 border-red-500 rounded-xl p-6 bg-red-50">
                    <div class="flex items-center mb-4">
                        <span class="text-4xl mr-3">🎯</span>
                        <div>
                            <h3 class="text-2xl font-bold text-red-900">Directing</h3>
                            <p class="text-sm text-red-700">(Telling)</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong class="text-red-900">Best for:</strong> New or inexperienced team members</p>
                        <p><strong class="text-red-900">Focus:</strong> High Task, Low Relationship</p>
                        <p><strong class="text-red-900">Approach:</strong> Clear instructions, close supervision</p>
                    </div>
                </div>

                <!-- Coaching -->
                <div class="border-4 border-blue-500 rounded-xl p-6 bg-blue-50">
                    <div class="flex items-center mb-4">
                        <span class="text-4xl mr-3">🎓</span>
                        <div>
                            <h3 class="text-2xl font-bold text-blue-900">Coaching</h3>
                            <p class="text-sm text-blue-700">(Selling)</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong class="text-blue-900">Best for:</strong> Team members with some experience</p>
                        <p><strong class="text-blue-900">Focus:</strong> High Task, High Relationship</p>
                        <p><strong class="text-blue-900">Approach:</strong> Explain the "why", build buy-in</p>
                    </div>
                </div>

                <!-- Supporting -->
                <div class="border-4 border-green-500 rounded-xl p-6 bg-green-50">
                    <div class="flex items-center mb-4">
                        <span class="text-4xl mr-3">🤝</span>
                        <div>
                            <h3 class="text-2xl font-bold text-green-900">Supporting</h3>
                            <p class="text-sm text-green-700">(Facilitating)</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong class="text-green-900">Best for:</strong> Competent but uncertain team members</p>
                        <p><strong class="text-green-900">Focus:</strong> Low Task, High Relationship</p>
                        <p><strong class="text-green-900">Approach:</strong> Encourage, facilitate, empower</p>
                    </div>
                </div>

                <!-- Delegating -->
                <div class="border-4 border-purple-500 rounded-xl p-6 bg-purple-50">
                    <div class="flex items-center mb-4">
                        <span class="text-4xl mr-3">🚀</span>
                        <div>
                            <h3 class="text-2xl font-bold text-purple-900">Delegating</h3>
                            <p class="text-sm text-purple-700">(Observing)</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-700">
                        <p><strong class="text-purple-900">Best for:</strong> Highly skilled, motivated team members</p>
                        <p><strong class="text-purple-900">Focus:</strong> Low Task, Low Relationship</p>
                        <p><strong class="text-purple-900">Approach:</strong> Trust, autonomy, minimal supervision</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Insight -->
        <div class="bg-gradient-to-r from-teal-100 to-cyan-100 rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.4s">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-8 h-8 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Key Insight
            </h2>
            <p class="text-gray-700 leading-relaxed">
                Effective situational leadership means adapting your style based on your team's development level and the specific situation. Your natural tendency is <strong>{{ $primaryStyle }}</strong>, but the best leaders flexibly move between all four styles depending on what their team needs in the moment.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in">
            <a href="{{ route('assessments.show', $userAssessment->assessment) }}" 
               class="bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-lg">
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
function getStyleSummary($style) {
    $summaries = [
        'Directing' => 'You are a decisive, task-oriented leader who values structure, clarity, and results. You tend to take charge quickly, set clear goals, define roles, and closely monitor progress.',
        'Coaching' => 'You are a high-energy motivator who combines direction with encouragement. You are both goal- and people-focused, explaining the "why" behind tasks and using persuasion to gain buy-in.',
        'Supporting' => 'You are a collaborative, relationship-centered leader who believes in empowerment. You involve your team in decisions, listen deeply, and build trust through participation.',
        'Delegating' => 'You are a trust-based, empowering leader who values autonomy and accountability. You step back and let competent team members take ownership of their work.'
    ];
    
    return $summaries[$style] ?? '';
}

function getDetailedLeadershipProfile($resultLabel) {
    $profiles = [
        'Directing' => '<div class="space-y-4">
            <p>You are a <strong class="text-gray-900">decisive, task-oriented leader</strong> who values structure, clarity, and results. You tend to take charge quickly, set clear goals, define roles, and closely monitor progress. You prefer to give clear instructions and expect compliance, ensuring that tasks are done the right way and on time. Your leadership shines when team members are new, inexperienced, or need direction — you provide the confidence and certainty they require to get started.</p>
            
            <p><strong class="text-gray-900">🔹 Strengths:</strong> Clarity, decisiveness, focus on outcomes, and strong organizational control. You keep people aligned with timelines and expectations.</p>
            
            <p><strong class="text-gray-900">🔹 Challenges:</strong> You may sometimes come across as too rigid or controlling, leaving little room for creativity or input. Your team might depend on you excessively for direction.</p>
            
            <p><strong class="text-gray-900">🔹 Growth Points:</strong> Learn to balance direction with dialogue — encourage feedback, listen actively, and gradually build others\' decision-making confidence. As people grow, shift toward more coaching or supporting behaviors to sustain motivation and ownership.</p>
        </div>',
        
        'Coaching' => '<div class="space-y-4">
            <p>You are a <strong class="text-gray-900">high-energy motivator</strong> who combines direction with encouragement. You tend to be both goal- and people-focused — explaining the "why" behind tasks, involving others in problem-solving, and using persuasion to gain buy-in. You enjoy helping people understand what needs to be done and <em>why</em> it matters. You often use enthusiasm and personal engagement to rally people behind shared objectives.</p>
            
            <p><strong class="text-gray-900">🔹 Strengths:</strong> Strong communicator, inspiring motivator, good at building understanding and confidence. You make people feel seen and valued while maintaining focus on goals.</p>
            
            <p><strong class="text-gray-900">🔹 Challenges:</strong> You may spend too much time explaining or motivating, which can slow down decision-making. Some team members may become dependent on your energy or validation.</p>
            
            <p><strong class="text-gray-900">🔹 Growth Points:</strong> Practice stepping back to let others own outcomes. Learn to trust that your guidance has taken root. Over time, lean more toward "supporting" behaviors — facilitating rather than always convincing.</p>
        </div>',
        
        'Supporting' => '<div class="space-y-4">
            <p>You are a <strong class="text-gray-900">collaborative, relationship-centered leader</strong> who believes in empowerment. You tend to involve your team in decisions, listen deeply, and build trust through participation. You value morale, communication, and shared ownership. Rather than directing what needs to be done, you prefer to ask questions, encourage initiative, and facilitate problem-solving.</p>
            
            <p><strong class="text-gray-900">🔹 Strengths:</strong> High empathy, excellent listener, great at developing team cohesion and trust. People feel safe to contribute ideas and grow under your leadership.</p>
            
            <p><strong class="text-gray-900">🔹 Challenges:</strong> You may avoid giving firm direction when it\'s needed, especially under pressure. Decision-making can become slow or diffuse when consensus is difficult.</p>
            
            <p><strong class="text-gray-900">🔹 Growth Points:</strong> Develop your ability to assert structure when necessary. Remember that support without clarity can lead to confusion. Integrating "directing" elements at key times ensures the team remains aligned and productive.</p>
        </div>',
        
        'Delegating' => '<div class="space-y-4">
            <p>You are a <strong class="text-gray-900">trust-based, empowering leader</strong> who values autonomy and accountability. You tend to step back and let competent team members take ownership of their work. You trust people to make sound decisions and provide input only when needed. You believe in results rather than constant supervision. Your leadership works best when the team is mature, skilled, and self-motivated.</p>
            
            <p><strong class="text-gray-900">🔹 Strengths:</strong> Builds ownership, develops leadership in others, creates a sense of freedom and trust. You model confidence and empower others to shine.</p>
            
            <p><strong class="text-gray-900">🔹 Challenges:</strong> You may sometimes appear disengaged or uninvolved, especially to those who need more support or direction. Problems might go unnoticed until they escalate.</p>
            
            <p><strong class="text-gray-900">🔹 Growth Points:</strong> Stay visible and connected even while delegating. Practice "light-touch" check-ins — offering presence without micromanaging. Reintroduce structure when performance or clarity starts to slip.</p>
        </div>',
        
        // Hybrid Styles
        'Directing-Coaching' => '<div class="space-y-4">
            <p>You combine the structure of a <strong class="text-gray-900">Directing</strong> leader with the warmth and motivation of a <strong class="text-gray-900">Coach</strong>. You set clear goals but also take time to explain, persuade, and involve others. You thrive in high-pressure environments where both results and people matter.</p>
            
            <p><strong class="text-gray-900">🔹 Strengths:</strong> You\'re an energetic driver who gets results through inspiration.</p>
            
            <p><strong class="text-gray-900">🔹 Challenges:</strong> You may overwork yourself trying to do both — directing <em>and</em> motivating constantly.</p>
            
            <p><strong class="text-gray-900">🔹 Growth Point:</strong> Delegate motivation to others sometimes. Teach instead of tell; inspire without always needing to control.</p>
        </div>',
        
        'Coaching-Supporting' => '<div class="space-y-4">
            <p>You balance <strong class="text-gray-900">guidance</strong> and <strong class="text-gray-900">participation</strong>. You encourage, involve, and uplift your team, often blending motivation with collaboration. You tend to enjoy mentoring and creating a positive atmosphere while keeping an eye on goals.</p>
            
            <p><strong class="text-gray-900">🔹 Strengths:</strong> Excellent team morale builder; creates commitment through inclusion.</p>
            
            <p><strong class="text-gray-900">🔹 Challenges:</strong> Risk of losing focus on hard performance metrics or delaying tough feedback.</p>
            
            <p><strong class="text-gray-900">🔹 Growth Point:</strong> Add more structure and accountability when motivation isn\'t enough.</p>
        </div>',
        
        'Supporting-Delegating' => '<div class="space-y-4">
            <p>You lead with trust and collaboration. You rely on strong relationships and encourage independence. Your leadership is most effective with skilled, self-driven teams.</p>
            
            <p><strong class="text-gray-900">🔹 Strengths:</strong> High trust, empowerment, psychological safety.</p>
            
            <p><strong class="text-gray-900">🔹 Challenges:</strong> Can appear too hands-off; risk of disconnect from less mature team members.</p>
            
            <p><strong class="text-gray-900">🔹 Growth Point:</strong> Re-engage actively when morale or direction falters — your team may need more clarity or check-ins than you think.</p>
        </div>',
        
        'Directing-Delegating' => '<div class="space-y-4">
            <p>You are efficient, results-focused, and independent. You expect others to perform without much guidance once expectations are clear. You are most effective with highly competent teams or in time-critical situations.</p>
            
            <p><strong class="text-gray-900">🔹 Strengths:</strong> Fast decisions, accountability, operational efficiency.</p>
            
            <p><strong class="text-gray-900">🔹 Challenges:</strong> May overlook relational nuances; risk of appearing authoritarian or detached.</p>
            
            <p><strong class="text-gray-900">🔹 Growth Point:</strong> Build relational trust to enhance long-term engagement and sustainability.</p>
        </div>',
        
        'Directing-Supporting' => '<div class="space-y-4">
            <p>You blend <strong class="text-gray-900">structure</strong> with <strong class="text-gray-900">empathy</strong>. You provide clear direction while being deeply attuned to people\'s needs and feelings.</p>
            
            <p><strong class="text-gray-900">🔹 Strengths:</strong> Balanced approach that addresses both task and relationship needs effectively.</p>
            
            <p><strong class="text-gray-900">🔹 Challenges:</strong> May struggle when these two approaches conflict in high-pressure situations.</p>
            
            <p><strong class="text-gray-900">🔹 Growth Point:</strong> Learn when to prioritize task over relationship and vice versa based on urgency.</p>
        </div>',
        
        'Coaching-Delegating' => '<div class="space-y-4">
            <p>You are a <strong class="text-gray-900">developer of talent</strong> who invests in people\'s growth and then trusts them to perform independently.</p>
            
            <p><strong class="text-gray-900">🔹 Strengths:</strong> Excellent at building capable, autonomous teams through patient development.</p>
            
            <p><strong class="text-gray-900">🔹 Challenges:</strong> May skip necessary structure with newer team members who need more guidance.</p>
            
            <p><strong class="text-gray-900">🔹 Growth Point:</strong> Ensure you provide enough initial direction before delegating fully.</p>
        </div>',
    ];
    
    return $profiles[$resultLabel] ?? $profiles['Directing'];
}
@endphp
@endsection