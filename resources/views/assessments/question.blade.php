@extends('layouts.public')

@section('title', 'Question ' . $questionNumber . ' - ' . $assessment->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <!-- Progress Header -->
    <div class="sticky top-0 z-10 bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-gray-700">Question {{ $questionNumber }} of {{ $totalQuestions }}</span>
                <span class="text-sm font-medium text-gray-700">{{ round(($questionNumber / $totalQuestions) * 100) }}% Complete</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full progress-bar" 
                     style="width: {{ ($questionNumber / $totalQuestions) * 100 }}%"></div>
            </div>
        </div>
    </div>

    <!-- Question Content -->
    <main class="max-w-4xl mx-auto px-4 py-12">
        <div class="animate-fade-in">
            <!-- Question Number Badge -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full shadow-lg mb-6 animate-pulse-slow">
                    <span class="text-2xl font-bold text-white">{{ $questionNumber }}</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 leading-relaxed max-w-3xl mx-auto">
                    {{ $question->question_text }}
                </h1>
            </div>

            <!-- Options Form -->
            <form method="POST" action="{{ route('assessments.answer', [$assessment, $questionNumber]) }}" 
                  class="space-y-4 animate-slide-up">
                @csrf
                
                @foreach($question->options as $index => $option)
                    <label class="block group cursor-pointer">
                        <input type="radio" name="option_id" value="{{ $option->id }}" 
                               class="sr-only peer" required>
                        <div class="option-card border-2 border-gray-200 rounded-2xl p-8 bg-white shadow-sm
                                   hover:border-blue-300 hover:shadow-md peer-checked:border-blue-500 
                                   peer-checked:bg-blue-50 peer-checked:ring-4 peer-checked:ring-blue-100
                                   group-hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full peer-checked:border-blue-500 
                                                peer-checked:bg-blue-500 flex items-center justify-center
                                                group-hover:border-blue-400 transition-all">
                                        <div class="w-3 h-3 bg-white rounded-full opacity-0 peer-checked:opacity-100 scale-0 peer-checked:scale-100 transition-all"></div>
                                    </div>
                                    <span class="text-xl font-medium text-gray-900 group-hover:text-blue-700 peer-checked:text-blue-700">
                                        {{ $option->option_text }}
                                    </span>
                                </div>
                                <div class="opacity-0 peer-checked:opacity-100 transition-opacity">
                                    <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </label>
                @endforeach

                @error('option_id')
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    </div>
                @enderror

                <!-- Navigation -->
                <div class="flex justify-between items-center pt-8">
                    @if($questionNumber > 1)
                        <a href="{{ route('assessments.question', [$assessment, $questionNumber - 1]) }}" 
                           class="flex items-center px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </a>
                    @else
                        <div></div>
                    @endif

                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 
                                   text-white font-bold py-4 px-8 rounded-xl transition duration-300 
                                   transform hover:scale-105 shadow-lg flex items-center">
                        @if($questionNumber < $totalQuestions)
                            Next Question
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        @else
                            Complete Assessment
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

@push('scripts')
<script>
    // Auto-submit on option selection (optional)
    document.querySelectorAll('input[name="option_id"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Optional: Add small delay and auto-submit
            // setTimeout(() => this.form.submit(), 500);
        });
    });
</script>
@endpush
@endsection