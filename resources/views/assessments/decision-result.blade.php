@extends('layouts.public')

@section('title', 'Your Decision-Making Style Results')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-amber-50 py-12">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-500 to-amber-600 rounded-full shadow-lg mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Your Decision-Making Style</h1>
            <p class="text-xl text-gray-600">{{ $userAssessment->assessment->title }}</p>
            <p class="text-sm text-gray-500 mt-2">Completed on {{ $userAssessment->created_at->format('F d, Y') }}</p>
        </div>

        @php
            $scores = $userAssessment->result_json;
            $totalQuestions = 15;
            
            // Define style colors and icons
            $styleInfo = [
                'Analytical' => ['color' => 'blue', 'icon' => '📊', 'bgGradient' => 'from-blue-500 to-blue-600'],
                'Intuitive' => ['color' => 'purple', 'icon' => '💡', 'bgGradient' => 'from-purple-500 to-purple-600'],
                'Collaborative' => ['color' => 'green', 'icon' => '🤝', 'bgGradient' => 'from-green-500 to-green-600'],
                'Avoidant' => ['color' => 'gray', 'icon' => '⏸️', 'bgGradient' => 'from-gray-500 to-gray-600'],
            ];
            
            // Sort scores to find dominant and secondary styles
            arsort($scores);
            $sortedStyles = array_keys($scores);
            $dominantStyle = $sortedStyles[0];
            $dominantScore = $scores[$dominantStyle];
            
            // Check for hybrid styles (if top two scores are close)
            $secondaryStyle = $sortedStyles[1] ?? null;
            $secondaryScore = $scores[$secondaryStyle] ?? 0;
            $isHybrid = ($secondaryScore >= $dominantScore - 2) && $secondaryScore > 0;
            
            // Determine the final result label
            if ($isHybrid && $secondaryStyle) {
                $resultLabel = $dominantStyle . ' - ' . $secondaryStyle;
            } else {
                $resultLabel = $dominantStyle;
            }
        @endphp

        <!-- Style Distribution Chart -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Your Decision-Making Profile</h2>
            
            <div class="space-y-6">
                @foreach(['Analytical', 'Intuitive', 'Collaborative', 'Avoidant'] as $style)
                    @php
                        $score = $scores[$style] ?? 0;
                        $percentage = ($score / $totalQuestions) * 100;
                        $info = $styleInfo[$style];
                    @endphp
                    
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-3">
                                <span class="text-3xl">{{ $info['icon'] }}</span>
                                <div>
                                    <h3 class="text-lg font-bold text-{{ $info['color'] }}-900">{{ $style }}</h3>
                                    <p class="text-sm text-gray-600">{{ $score }} out of {{ $totalQuestions }} responses</p>
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
            $primaryInfo = $styleInfo[$dominantStyle];
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
                        Your Primary Style: {{ $dominantStyle }}
                        @if($isHybrid)
                            <span class="text-lg text-gray-700">with {{ $secondaryStyle }} tendencies</span>
                        @endif
                    </h2>
                    <p class="text-gray-700 leading-relaxed text-lg">
                        {!! getPrimaryDescription($dominantStyle) !!}
                    </p>
                </div>
            </div>
        </div>

        <!-- Detailed Profile Analysis -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.2s">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-8 h-8 mr-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Detailed Profile & Growth Suggestions
            </h2>
            <div class="prose prose-lg max-w-none">
                {!! getDetailedProfile($resultLabel) !!}
            </div>
        </div>

        <!-- 4-Block Grid -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-slide-up" style="animation-delay: 0.3s">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Decision-Making Styles Overview</h2>
            
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Analytical -->
                <div class="border-4 border-blue-500 rounded-xl p-6 bg-blue-50">
                    <div class="flex items-center mb-4">
                        <span class="text-4xl mr-3">📊</span>
                        <h3 class="text-2xl font-bold text-blue-900">Analytical</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="font-bold text-blue-900 mb-1">Characteristics:</p>
                            <p class="text-gray-700">Data-driven, logical, and methodical. Takes time to gather and evaluate all relevant information. Focuses on facts, evidence, and long-term outcomes.</p>
                        </div>
                        <div>
                            <p class="font-bold text-blue-900 mb-1">Strengths:</p>
                            <p class="text-gray-700">Minimizes risks by considering all options. Ensures well-informed, accurate decisions. Good for complex, high-stakes decisions.</p>
                        </div>
                        <div>
                            <p class="font-bold text-blue-900 mb-1">Challenges:</p>
                            <p class="text-gray-700">Can be slow in urgent situations. Risks "paralysis by analysis" and overcomplication.</p>
                        </div>
                    </div>
                </div>

                <!-- Intuitive -->
                <div class="border-4 border-purple-500 rounded-xl p-6 bg-purple-50">
                    <div class="flex items-center mb-4">
                        <span class="text-4xl mr-3">💡</span>
                        <h3 class="text-2xl font-bold text-purple-900">Intuitive</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="font-bold text-purple-900 mb-1">Characteristics:</p>
                            <p class="text-gray-700">Relies on instincts and gut feelings. Quick decision-making without overanalyzing. Draws on experience and intuition to guide choices.</p>
                        </div>
                        <div>
                            <p class="font-bold text-purple-900 mb-1">Strengths:</p>
                            <p class="text-gray-700">Fast and efficient decision-making. Ideal in time-sensitive situations. Confident in uncertain or ambiguous environments.</p>
                        </div>
                        <div>
                            <p class="font-bold text-purple-900 mb-1">Challenges:</p>
                            <p class="text-gray-700">May overlook important details. Risk of making errors due to a lack of data. Decisions may seem arbitrary to others.</p>
                        </div>
                    </div>
                </div>

                <!-- Collaborative -->
                <div class="border-4 border-green-500 rounded-xl p-6 bg-green-50">
                    <div class="flex items-center mb-4">
                        <span class="text-4xl mr-3">🤝</span>
                        <h3 class="text-2xl font-bold text-green-900">Collaborative</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="font-bold text-green-900 mb-1">Characteristics:</p>
                            <p class="text-gray-700">Values team input and consensus. Involves others in decision-making. Focuses on maintaining harmony and collective responsibility.</p>
                        </div>
                        <div>
                            <p class="font-bold text-green-900 mb-1">Strengths:</p>
                            <p class="text-gray-700">Builds team alignment and trust. Encourages diverse perspectives. Decisions are generally well-received by the group.</p>
                        </div>
                        <div>
                            <p class="font-bold text-green-900 mb-1">Challenges:</p>
                            <p class="text-gray-700">Can be slow or indecisive when consensus isn't reached. Risks losing authority by overly relying on others.</p>
                        </div>
                    </div>
                </div>

                <!-- Avoidant -->
                <div class="border-4 border-gray-500 rounded-xl p-6 bg-gray-50">
                    <div class="flex items-center mb-4">
                        <span class="text-4xl mr-3">⏸️</span>
                        <h3 class="text-2xl font-bold text-gray-900">Avoidant</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="font-bold text-gray-900 mb-1">Characteristics:</p>
                            <p class="text-gray-700">Tends to avoid decisions, especially under pressure. Delays or defers responsibility to others. Feels anxious about making the wrong choice.</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 mb-1">Strengths:</p>
                            <p class="text-gray-700">May avoid making hasty decisions. Prefers to wait for more clarity before deciding. Good at deferring decisions to those with more expertise.</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 mb-1">Challenges:</p>
                            <p class="text-gray-700">May miss opportunities by delaying decisions. Risk of indecision causing inefficiency. Avoids responsibility, leading to ineffective leadership.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in">
            <a href="{{ route('assessments.show', $userAssessment->assessment) }}" 
               class="bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-lg">
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
function getPrimaryDescription($style) {
    $descriptions = [
        'Analytical' => 'You prefer a structured, data-driven approach to decision-making. You like to gather as much information as possible and carefully evaluate all available options before making a choice. You are methodical, evidence-first, and prefer predictable processes.',
        'Intuitive' => 'You tend to rely on your instincts and experiences when making decisions. You prefer a fast, gut-feeling approach rather than overanalyzing situations. You are instinct-driven and pattern-oriented, using tacit knowledge and emotional sensing as primary inputs.',
        'Collaborative' => 'You thrive in team environments and like to involve others in the decision-making process. You value input from colleagues and prefer reaching consensus over making decisions independently. You view decisions as social processes that create buy-in and shared ownership.',
        'Avoidant' => 'You tend to shy away from making decisions, especially if they are high-stakes or complex. You often prefer to delay decisions or leave them to others when possible. You are cautious, risk-aware, and often conflict-averse, preferring to wait for additional clarity.'
    ];
    
    return $descriptions[$style] ?? '';
}

function getDetailedProfile($resultLabel) {
    $profiles = [
        'Analytical' => '<div class="space-y-4">
            <p><strong class="text-gray-900">You are</strong> a methodical, evidence-first decision-maker who prefers structure, logic and predictable processes. You tend to slow the pace intentionally so you can collect data, model alternatives, and quantify risk before committing.</p>
            
            <p><strong class="text-gray-900">How you make decisions:</strong> You map out the problem, break it into components, list assumptions, gather measurable inputs, run comparisons (pros/cons, cost/benefit), test scenarios and use frameworks (decision trees, matrices, spreadsheets). You often create checklists or step-by-step plans and insist on documented rationale.</p>
            
            <p><strong class="text-gray-900">Pros:</strong> Your choices are transparent, defensible and repeatable. You reduce the chance of costly surprises by surfacing hidden risks and dependencies. You\'re excellent for complex, long-term, compliance-heavy or capital-intensive decisions where precision matters.</p>
            
            <p><strong class="text-gray-900">Cons / Blind spots:</strong> You can get trapped in "paralysis by analysis," delaying action when speed matters. In situations with sparse or ambiguous data you may feel uncomfortable and stall. You sometimes underweight human factors because they\'re not easily quantifiable.</p>
            
            <p><strong class="text-gray-900">When you excel:</strong> Strategic planning, budgeting, technical vendor selection, regulatory choices, product specs or high-stakes projects requiring accuracy.</p>
            
            <p><strong class="text-gray-900">Quick development moves:</strong> Impose a decision deadline; adopt a "good-enough" threshold; run a fast pre-mortem instead of endless analysis; pair with an intuitive partner for early-stage choices; practice summarizing decisions in one sentence to force clarity.</p>
        </div>',
        
        'Intuitive' => '<div class="space-y-4">
            <p><strong class="text-gray-900">You are</strong> an instinct-driven, pattern-oriented decision-maker who uses tacit knowledge, experience and emotional sensing as primary inputs. You tend to make reasonably fast calls based on impressions, early signals, and an internal "feel" for what will work.</p>
            
            <p><strong class="text-gray-900">How you make decisions:</strong> You scan for patterns from prior experience and let subconscious associations surface into a gut judgment. You privilege coherence and fit over exhaustive data. You may process many subtle cues at once — tone, body language, market "vibes" — and synthesize them into a single intuitive read.</p>
            
            <p><strong class="text-gray-900">Pros:</strong> Speed, creativity and strong judgement in ambiguous settings. You can spot opportunities missed by slower, analysis-first colleagues. You keep teams moving in uncertainty and are good at sensing cultural fit or unspoken client needs.</p>
            
            <p><strong class="text-gray-900">Cons / Blind spots:</strong> You may be vulnerable to cognitive biases (availability, anchoring, confirmation). You can under-communicate rationale, making your decisions harder to justify to stakeholders who require evidence. In complex technical or regulated domains you may miss critical details.</p>
            
            <p><strong class="text-gray-900">When you excel:</strong> Early stage innovation, crisis triage where speed matters, people-readings (hires, partnerships), ambiguous market moves.</p>
            
            <p><strong class="text-gray-900">Quick development moves:</strong> Keep a decision journal to test intuition accuracy; document top 2–3 reasons for your gut; use short analytical checklists for high-impact choices; invite a data partner to validate critical assumptions.</p>
        </div>',
        
        'Collaborative' => '<div class="space-y-4">
            <p><strong class="text-gray-900">You are</strong> an inclusion-first, consensus-oriented decision-maker who views decisions as social processes that create buy-in and shared ownership. You tend to centre diverse perspectives, surface concerns, and invest time in discussion so that the group aligns around the outcome.</p>
            
            <p><strong class="text-gray-900">How you make decisions:</strong> You structure conversations, invite broad input, facilitate workshops or alignment meetings, and prioritize solutions that are acceptable to the majority. You place high value on relational health and often use decision methods that maximize participation.</p>
            
            <p><strong class="text-gray-900">Pros:</strong> High team commitment, fewer implementation surprises, and decisions that are practical and socially sustainable. You reduce resistance and build stronger cross-functional alignment.</p>
            
            <p><strong class="text-gray-900">Cons / Blind spots:</strong> Meetings and alignment can drag out the timeline. Consensus can produce watered-down compromises rather than bold moves. Groupthink and the tendency to avoid dissent are real risks. You may abdicate responsibility to preserve harmony.</p>
            
            <p><strong class="text-gray-900">When you excel:</strong> Organizational change, cultural or people-focused decisions, major cross-functional initiatives where adoption is critical.</p>
            
            <p><strong class="text-gray-900">Quick development moves:</strong> Set timeboxes for consultation, clarify decision rights (RACI), use structured group methods (nominal group technique, Delphi), appoint a decision owner, capture minority opinions in writing.</p>
        </div>',
        
        'Avoidant' => '<div class="space-y-4">
            <p><strong class="text-gray-900">You are</strong> cautious, risk-aware and often conflict-averse, preferring to delay or delegate decisions when you feel stakes are high or when you fear blame. You tend to wait for additional clarity or hand the choice to others to avoid the stress of committing.</p>
            
            <p><strong class="text-gray-900">How you make decisions:</strong> Frequently you stall until more information arrives, seek direction from higher-ups, or reframe problems to reduce accountability. When forced to decide, you may pick the safest or most reversible option, or consult extensively to diffuse responsibility.</p>
            
            <p><strong class="text-gray-900">Pros:</strong> You can prevent rash choices and act as a brake against impulsive moves. In highly risky scenarios your caution can protect resources and reputation. You can be the person who demands that the team fully consider consequences.</p>
            
            <p><strong class="text-gray-900">Cons / Blind spots:</strong> Chronic avoidance frequently creates missed opportunities, bottlenecks and eroded leadership credibility. Teams may bypass you, and your career momentum can slow. Persistent avoidance raises stress for you and frustration for others.</p>
            
            <p><strong class="text-gray-900">When you excel:</strong> When a cautious, thoroughly vetted approach is required (e.g., high legal/regulatory risk), or when deferring to a specialist is the correct governance route.</p>
            
            <p><strong class="text-gray-900">Quick development moves:</strong> Practice making small, low-risk decisions daily; set a maximum info threshold (e.g., 48 hours); create default options and "fallback" plans; use accountability partners; quantify the cost of delay and weigh it against the risk of being wrong.</p>
        </div>',
        
        // Hybrid Styles
        'Analytical - Intuitive' => '<div class="space-y-4">
            <p><strong class="text-gray-900">You are</strong> a rare blend of logic and instinct — someone who validates your gut feelings through data, and interprets data through an intuitive lens. You tend to start with a hunch or sense of direction, then seek facts to confirm or refine it. You can pivot fluidly between intuition and reasoning.</p>
            
            <p><strong class="text-gray-900">Pros:</strong> You balance facts with foresight, logic with creativity. You\'re strong in innovation, strategic planning, and entrepreneurial roles where both analytical rigor and intuitive judgment are crucial.</p>
            
            <p><strong class="text-gray-900">Cons:</strong> You may experience inner conflict when the two systems disagree — your gut says one thing, the data another. This can cause oscillation, overthinking, or self-doubt.</p>
            
            <p><strong class="text-gray-900">Growth focus:</strong> Learn to trust the interplay — sometimes intuition precedes evidence, sometimes evidence sharpens intuition. Practice identifying when to lead with one or the other. Keep decision journals noting outcomes to refine both muscles.</p>
        </div>',
        
        'Analytical - Collaborative' => '<div class="space-y-4">
            <p><strong class="text-gray-900">You are</strong> both methodical and people-conscious — a thinker who values precision but also believes in shared ownership. You tend to gather data, run analyses, and then invite discussion to ensure alignment and commitment before finalizing a decision.</p>
            
            <p><strong class="text-gray-900">Pros:</strong> You build trust because people know your logic is sound and your process fair. Your decisions tend to be balanced — intellectually robust and socially supported. You shine in organizational planning, policy formation, and strategic facilitation.</p>
            
            <p><strong class="text-gray-900">Cons:</strong> You can overextend timelines by gathering too much input or data. You may over-rationalize to persuade others, or grow frustrated with teammates who rely on feelings over evidence.</p>
            
            <p><strong class="text-gray-900">Growth focus:</strong> Learn when it\'s safe to decide without full consensus. Use facilitation methods that limit endless discussion. Remember that not every great decision needs universal agreement — only clarity and communication.</p>
        </div>',
        
        'Analytical - Avoidant' => '<div class="space-y-4">
            <p><strong class="text-gray-900">You are</strong> highly cautious, perfectionistic, and deeply risk-aware. You tend to crave certainty and evidence before acting, which can make you hesitant to decide until all variables are known. Your avoidant streak magnifies your analytical one.</p>
            
            <p><strong class="text-gray-900">Pros:</strong> You\'re exceptionally thorough, responsible, and protective of quality. Your decisions, once made, are rarely reckless. You serve as a necessary counterbalance in overly fast-moving teams.</p>
            
            <p><strong class="text-gray-900">Cons:</strong> You can stall progress, frustrate stakeholders, and experience decision fatigue. Fear of being wrong may mask as "wanting more data."</p>
            
            <p><strong class="text-gray-900">Growth focus:</strong> Practice setting decision deadlines and "satisficing" (accepting "good enough" data). Remind yourself that no decision is also a decision — often with higher costs. Build tolerance for imperfection by making smaller, faster calls regularly.</p>
        </div>',
        
        'Intuitive - Collaborative' => '<div class="space-y-4">
            <p><strong class="text-gray-900">You are</strong> an emotionally attuned, relational decision-maker who blends personal insight with collective wisdom. You tend to read the energy of the group, sense what feels right for people, and guide decisions that honour both logic and feeling.</p>
            
            <p><strong class="text-gray-900">Pros:</strong> You excel at change leadership, conflict resolution, coaching, and innovation within teams. Your empathy builds trust and morale, while your intuition helps spot invisible risks or opportunities.</p>
            
            <p><strong class="text-gray-900">Cons:</strong> You can over-personalize decisions, internalize group tension, or delay action until everyone "feels okay." You may avoid tough trade-offs that upset others.</p>
            
            <p><strong class="text-gray-900">Growth focus:</strong> Balance empathy with firmness. Learn that temporary discomfort in others doesn\'t mean a wrong decision. Anchor intuition with a few factual checks before acting. Document rationale to strengthen credibility with logic-driven peers.</p>
        </div>',
        
        'Collaborative - Avoidant' => '<div class="space-y-4">
            <p><strong class="text-gray-900">You are</strong> harmony-seeking and non-confrontational, valuing group unity over speed or authority. You tend to prioritize consensus to such an extent that you may defer to others, hoping agreement will emerge naturally.</p>
            
            <p><strong class="text-gray-900">Pros:</strong> You protect relationships and prevent unilateral mistakes. You bring gentleness and psychological safety to groups. People trust you as a considerate, non-imposing collaborator.</p>
            
            <p><strong class="text-gray-900">Cons:</strong> You can lose credibility as a decision authority, cause delays, or produce diluted outcomes that satisfy no one fully. Fear of conflict can quietly erode accountability.</p>
            
            <p><strong class="text-gray-900">Growth focus:</strong> Learn to separate agreement from alignment. Practice closing discussions with clear ownership statements ("Given input from all, I decide we\'ll..."). Develop assertiveness and comfort with imperfect consensus.</p>
        </div>',
        
        'Intuitive - Avoidant' => '<div class="space-y-4">
            <p><strong class="text-gray-900">You are</strong> instinctive but hesitant — someone who often feels what\'s right yet fears acting on it. You tend to sense solutions early but second-guess them, worrying they\'re too subjective or risky. Your internal knowing clashes with self-doubt.</p>
            
            <p><strong class="text-gray-900">Pros:</strong> You possess a deep intuitive sensitivity that, once trusted, can guide extraordinary judgment. You\'re empathic and aware of subtle cues that others miss.</p>
            
            <p><strong class="text-gray-900">Cons:</strong> Fear and avoidance often silence your intuitive strength. This can result in missed chances, frustration, or regret ("I knew it but didn\'t act").</p>
            
            <p><strong class="text-gray-900">Growth focus:</strong> Build self-trust through small, low-risk intuitive actions. Record intuitive hits to validate accuracy. Reframe mistakes as learning data. Cultivate supportive environments where acting on inner guidance feels safe.</p>
        </div>',
    ];
    
    return $profiles[$resultLabel] ?? $profiles['Analytical'];
}
@endphp
@endsection