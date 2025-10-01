<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Option;
use App\Models\Question;
use App\Models\ResultCategory;
use Illuminate\Database\Seeder;

class BrainDominanceSeeder extends Seeder
{
    public function run(): void
    {
        // Create Brain Dominance Assessment
        $assessment = Assessment::create([
            'title' => 'Brain Dominance Test',
            'slug' => 'brain-dominance-test',
            'description' => 'Discover whether your thinking style is more left-brain dominant (analytical, logical, structured) or right-brain dominant (intuitive, creative, holistic). This assessment helps you understand your cognitive preferences and learning style.',
            'status' => 'active',
            'link_url' => '/assessments/brain-dominance-test',
        ]);

        // Create result categories
        $categories = [
            [
                'name' => 'Strong Left-Brain',
                'description' => 'You prefer order, structure, and routines. You rely on logic and facts more than feelings. You would excel in data-driven roles such as finance, engineering, law, IT, or research.'
            ],
            [
                'name' => 'Moderate Left-Brain',
                'description' => 'You generally prefer structure but allow some flexibility. You are comfortable with rules but can improvise if needed. You perform well in management, operations, teaching, analysis, or healthcare.'
            ],
            [
                'name' => 'Balanced/Whole-Brain',
                'description' => 'You are a flexible thinker who adapts to different situations easily. You can switch between logic and intuition depending on the context. You are effective in roles that combine innovation with execution.'
            ],
            [
                'name' => 'Moderate Right-Brain',
                'description' => 'You enjoy variety, change, and experimentation. You are comfortable with ambiguity and think in metaphors and visuals. You excel in roles requiring creativity, design, communication, or marketing.'
            ],
            [
                'name' => 'Strong Right-Brain',
                'description' => 'You are strongly intuitive, imaginative, and spontaneous. You follow feelings and instincts more than logic. You thrive in careers such as art, writing, design, entrepreneurship, or therapy.'
            ]
        ];

        foreach ($categories as $category) {
            ResultCategory::create(array_merge($category, ['assessment_id' => $assessment->id]));
        }

        // All 30 questions
        $questionsData = [
            [
                'text' => 'If you had to give someone directions to your house, which method would you most likely use?',
                'options' => [
                    ['text' => 'Write a paragraph that explains where and when to turn', 'scores' => ['Left' => 1]],
                    ['text' => 'Draw a road map', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which do you remember more easily?',
                'options' => [
                    ['text' => 'Names', 'scores' => ['Left' => 1]],
                    ['text' => 'Faces', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Imagine that you\'re vacationing at a resort. Which would you most likely do?',
                'options' => [
                    ['text' => 'Obtain a brochure of local attractions and plan what you\'d like to do for the day', 'scores' => ['Left' => 1]],
                    ['text' => 'Drive around without a plan and decide what you\'d like to do as you drive along', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Imagine enrolling in a music course. You and a partner must write a song. Which would you prefer to do?',
                'options' => [
                    ['text' => 'Write the lyrics', 'scores' => ['Left' => 1]],
                    ['text' => 'Compose the melody', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'In which English class would you most likely enroll?',
                'options' => [
                    ['text' => 'Journalism', 'scores' => ['Left' => 1]],
                    ['text' => 'Creative writing', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which do you prefer?',
                'options' => [
                    ['text' => 'Planning activities in advance', 'scores' => ['Left' => 1]],
                    ['text' => 'Doing things spontaneously', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'When listening to a speaker, which do you pay more attention to?',
                'options' => [
                    ['text' => 'What the speaker is saying', 'scores' => ['Left' => 1]],
                    ['text' => 'The speaker\'s body language', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Are you usually aware of what time it is and how much time has passed?',
                'options' => [
                    ['text' => 'Yes', 'scores' => ['Left' => 1]],
                    ['text' => 'No', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'After reading a new chapter in a textbook, which would you rather do?',
                'options' => [
                    ['text' => 'Summarize the chapter', 'scores' => ['Left' => 1]],
                    ['text' => 'Outline the chapter', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which way do you typically write papers?',
                'options' => [
                    ['text' => 'Plan the sequence of ideas in advance', 'scores' => ['Left' => 1]],
                    ['text' => 'Let your ideas flow freely', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which classroom situation do you prefer?',
                'options' => [
                    ['text' => 'A teacher announces assignments weekly with specific due dates', 'scores' => ['Left' => 1]],
                    ['text' => 'A teacher announces all assignments at the beginning and lets you complete them anytime before the course ends', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which are you more likely to remember after listening to music?',
                'options' => [
                    ['text' => 'Words', 'scores' => ['Left' => 1]],
                    ['text' => 'Tunes', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Do you frequently move furniture around in your home?',
                'options' => [
                    ['text' => 'No', 'scores' => ['Left' => 1]],
                    ['text' => 'Yes', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Are you a good memorizer?',
                'options' => [
                    ['text' => 'Yes', 'scores' => ['Left' => 1]],
                    ['text' => 'No', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which subject do you prefer?',
                'options' => [
                    ['text' => 'Algebra', 'scores' => ['Left' => 1]],
                    ['text' => 'Geometry', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which are you better at solving?',
                'options' => [
                    ['text' => 'Crossword puzzle', 'scores' => ['Left' => 1]],
                    ['text' => 'Jigsaw puzzle', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'How do you plan your day?',
                'options' => [
                    ['text' => 'List the important activities in order to better see that they are carried out', 'scores' => ['Left' => 1]],
                    ['text' => 'Just let things happen', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Was it usually easy or difficult to learn grammar in school?',
                'options' => [
                    ['text' => 'Easy', 'scores' => ['Left' => 1]],
                    ['text' => 'Difficult', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which way do you use a tube of toothpaste?',
                'options' => [
                    ['text' => 'Carefully roll it up from the bottom', 'scores' => ['Left' => 1]],
                    ['text' => 'Squeeze it in the middle', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'When you read a new chapter in a textbook, what are you most likely to do?',
                'options' => [
                    ['text' => 'Read the chapter from beginning to end without much skimming', 'scores' => ['Left' => 1]],
                    ['text' => 'Skim through the entire chapter first to get a general idea', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'When you sit down to study for two hours, how do you work?',
                'options' => [
                    ['text' => 'I work on one topic for a long period until it is completed', 'scores' => ['Left' => 1]],
                    ['text' => 'I work on several topics and projects, going back and forth between them', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which do you prefer?',
                'options' => [
                    ['text' => 'The details and specifics of how things work', 'scores' => ['Left' => 1]],
                    ['text' => 'The big picture, larger concepts and theories', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Imagine you volunteered to work for the company newspaper. Which would you rather do?',
                'options' => [
                    ['text' => 'Write one or two of the stories', 'scores' => ['Left' => 1]],
                    ['text' => 'Cut, paste and lay out the stories and decide which should appear where', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'If you had an important project due, would you prefer to work:',
                'options' => [
                    ['text' => 'Alone', 'scores' => ['Left' => 1]],
                    ['text' => 'In a group', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which questions are you more likely to ask?',
                'options' => [
                    ['text' => '"How should I do this?" and "What facts do I need to know?"', 'scores' => ['Left' => 1]],
                    ['text' => '"How much of this is necessary?" and "What is this really all about?"', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which statement best applies to you?',
                'options' => [
                    ['text' => 'I\'m not good at guessing a person\'s mood by their body language', 'scores' => ['Left' => 1]],
                    ['text' => 'I\'m good at guessing a person\'s mood by their body language', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'Which do you prefer?',
                'options' => [
                    ['text' => 'An established routine', 'scores' => ['Left' => 1]],
                    ['text' => 'Going with the flow, doing things differently each time', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'When in a new city, which do you find most helpful?',
                'options' => [
                    ['text' => 'Clearly worded directions', 'scores' => ['Left' => 1]],
                    ['text' => 'A map', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'How do you find yourself preparing for an exam?',
                'options' => [
                    ['text' => 'With a clear and organized plan of action', 'scores' => ['Left' => 1]],
                    ['text' => 'With a less organized approach, studying different topics at different times', 'scores' => ['Right' => 1]],
                ]
            ],
            [
                'text' => 'With which statement do you most agree?',
                'options' => [
                    ['text' => 'We should continue exploring outer space only if we can be sure of certain benefits', 'scores' => ['Left' => 1]],
                    ['text' => 'We should continue exploring outer space since one day this may benefit us', 'scores' => ['Right' => 1]],
                ]
            ],
        ];

        foreach ($questionsData as $index => $questionData) {
            $question = Question::create([
                'assessment_id' => $assessment->id,
                'question_text' => $questionData['text'],
                'order' => $index + 1,
            ]);

            foreach ($questionData['options'] as $optionData) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionData['text'],
                    'score_map' => $optionData['scores'],
                ]);
            }
        }
    }
}