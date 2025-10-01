<?php

namespace Database\Seeders;

use App\Models\Assessment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Option;
use App\Models\Question;
use App\Models\ResultCategory;
use Illuminate\Database\Seeder;

class ConflictManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        // Create Conflict Management Assessment
        $assessment = Assessment::create([
            'title' => 'TK Conflict Management Style Questionnaire',
            'slug' => 'conflict-management-style',
            'description' => 'Discover your preferred conflict management style. This assessment identifies how you typically respond to conflicts across five dimensions: Competing, Collaborating, Compromising, Avoiding, and Accommodating.',
            'status' => 'active',
            'link_url' => '/assessments/conflict-management-style',
        ]);

        // Create result categories with score ranges
        $categories = [
            [
                'name' => 'Competing',
                'description' => 'You are highly assertive and determined in conflicts. You push strongly for your position and are willing to stand your ground, even when others resist. You thrive in situations that require quick, decisive action.'
            ],
            [
                'name' => 'Collaborating',
                'description' => 'You naturally seek to create win-win solutions. You value open dialogue, creativity, and hearing all perspectives. You bring issues into the open and work toward solutions that satisfy everyone\'s needs.'
            ],
            [
                'name' => 'Compromising',
                'description' => 'You are skilled at finding middle ground and reaching practical solutions quickly. You value fairness, balance, and the ability to move forward without getting stuck.'
            ],
            [
                'name' => 'Avoiding',
                'description' => 'You often withdraw, delay, or sidestep conflicts to reduce tension or buy time. You prefer not to rush into heated discussions and may wait until emotions cool down.'
            ],
            [
                'name' => 'Accommodating',
                'description' => 'You often put others\' needs first and focus on preserving harmony. You are generous, cooperative, and willing to yield if it helps maintain peace.'
            ]
        ];

        foreach ($categories as $category) {
            ResultCategory::create(array_merge($category, ['assessment_id' => $assessment->id]));
        }

        // All 30 questions based on TK Instrument scoring table
        $questionsData = [
            // Question 1
            [
                'text' => 'When faced with conflict, I typically:',
                'options' => [
                    ['text' => 'There are times when I let others take responsibility for solving the problem.', 'scores' => ['Avoiding' => 1]],
                    ['text' => 'Rather than negotiate the issues on which we disagree, I try to stress those things upon which we both agree.', 'scores' => ['Accommodating' => 1]],
                ]
            ],
            // Question 2
            [
                'text' => 'In a disagreement, I typically:',
                'options' => [
                    ['text' => 'Try to find a compromise solution', 'scores' => ['Compromising' => 1]],
                    ['text' => 'Attempt to deal with all concerns', 'scores' => ['Collaborating' => 1]],
                ]
            ],
            // Question 3
            [
                'text' => 'When conflicts arise, I:',
                'options' => [
                    ['text' => 'Am usually firm in pursuing my goals', 'scores' => ['Competing' => 1]],
                    ['text' => 'Try to soothe the other\'s feelings', 'scores' => ['Accommodating' => 1]],
                ]
            ],
            // Question 4
            [
                'text' => 'During conflicts, I:',
                'options' => [
                    ['text' => 'Try to find a compromise solution', 'scores' => ['Compromising' => 1]],
                    ['text' => 'Sometimes sacrifice my own wishes', 'scores' => ['Accommodating' => 1]],
                ]
            ],
            // Question 5
            [
                'text' => 'When handling conflicts, I:',
                'options' => [
                    ['text' => 'Consistently seek the other\'s help', 'scores' => ['Collaborating' => 1]],
                    ['text' => 'Try to avoid useless tension', 'scores' => ['Avoiding' => 1]],
                ]
            ],
            // Question 6
            [
                'text' => 'In conflict situations, I:',
                'options' => [
                    ['text' => 'Try to avoid creating unpleasantness', 'scores' => ['Avoiding' => 1]],
                    ['text' => 'Try to win my position', 'scores' => ['Competing' => 1]],
                ]
            ],
            // Question 7
            [
                'text' => 'When disagreements occur, I:',
                'options' => [
                    ['text' => 'Try to postpone the issue', 'scores' => ['Avoiding' => 1]],
                    ['text' => 'Give up some points in exchange', 'scores' => ['Compromising' => 1]],
                ]
            ],
            // Question 8
            [
                'text' => 'In conflicts, I typically:',
                'options' => [
                    ['text' => 'Am usually firm in pursuing my goals', 'scores' => ['Competing' => 1]],
                    ['text' => 'Get all concerns out in the open', 'scores' => ['Collaborating' => 1]],
                ]
            ],
            // Question 9
            [
                'text' => 'When facing conflicts, I:',
                'options' => [
                    ['text' => 'Feel differences aren\'t always worth worrying about', 'scores' => ['Avoiding' => 1]],
                    ['text' => 'Make some effort to get my way', 'scores' => ['Competing' => 1]],
                ]
            ],
            // Question 10
            [
                'text' => 'In disagreements, I:',
                'options' => [
                    ['text' => 'Am firm in pursuing my goals', 'scores' => ['Competing' => 1]],
                    ['text' => 'Try to find a compromise', 'scores' => ['Compromising' => 1]],
                ]
            ],
            // Question 11
            [
                'text' => 'When conflicts arise, I:',
                'options' => [
                    ['text' => 'Get all concerns out in the open', 'scores' => ['Collaborating' => 1]],
                    ['text' => 'Try to soothe feelings and preserve relationships', 'scores' => ['Accommodating' => 1]],
                ]
            ],
            // Question 12
            [
                'text' => 'During conflicts, I:',
                'options' => [
                    ['text' => 'Avoid taking positions that create controversy', 'scores' => ['Avoiding' => 1]],
                    ['text' => 'Let them have some if they let me have some', 'scores' => ['Compromising' => 1]],
                ]
            ],
            // Question 13
            [
                'text' => 'In conflict situations, I:',
                'options' => [
                    ['text' => 'Propose a middle ground', 'scores' => ['Compromising' => 1]],
                    ['text' => 'Press to get my point made', 'scores' => ['Competing' => 1]],
                ]
            ],
            // Question 14
            [
                'text' => 'When handling conflicts, I:',
                'options' => [
                    ['text' => 'Tell my ideas and ask for theirs', 'scores' => ['Collaborating' => 1]],
                    ['text' => 'Show the logic and benefits of my position', 'scores' => ['Competing' => 1]],
                ]
            ],
            // Question 15
            [
                'text' => 'During disagreements, I:',
                'options' => [
                    ['text' => 'Try to soothe feelings and preserve relationships', 'scores' => ['Accommodating' => 1]],
                    ['text' => 'Try to do what\'s necessary to avoid tension', 'scores' => ['Avoiding' => 1]],
                ]
            ],
            // Question 16
            [
                'text' => 'In conflicts, I:',
                'options' => [
                    ['text' => 'Try not to hurt the other\'s feelings', 'scores' => ['Accommodating' => 1]],
                    ['text' => 'Try to convince them of the merits of my position', 'scores' => ['Competing' => 1]],
                ]
            ],
            // Question 17
            [
                'text' => 'When conflicts occur, I:',
                'options' => [
                    ['text' => 'Am usually firm in pursuing my goals', 'scores' => ['Competing' => 1]],
                    ['text' => 'Try to avoid useless tension', 'scores' => ['Avoiding' => 1]],
                ]
            ],
            // Question 18
            [
                'text' => 'During conflicts, I:',
                'options' => [
                    ['text' => 'Let them maintain their views if it makes them happy', 'scores' => ['Accommodating' => 1]],
                    ['text' => 'Let them have some if they let me have some', 'scores' => ['Compromising' => 1]],
                ]
            ],
            // Question 19
            [
                'text' => 'In conflict situations, I:',
                'options' => [
                    ['text' => 'Get all concerns and issues out in the open', 'scores' => ['Collaborating' => 1]],
                    ['text' => 'Try to postpone the issue until I have time to think', 'scores' => ['Avoiding' => 1]],
                ]
            ],
            // Question 20
            [
                'text' => 'When handling conflicts, I:',
                'options' => [
                    ['text' => 'Attempt to immediately work through differences', 'scores' => ['Collaborating' => 1]],
                    ['text' => 'Try to find a fair combination of gains and losses', 'scores' => ['Compromising' => 1]],
                ]
            ],
            // Question 21
            [
                'text' => 'During disagreements, I:',
                'options' => [
                    ['text' => 'Try to be considerate of the other\'s wishes', 'scores' => ['Accommodating' => 1]],
                    ['text' => 'Always lean toward direct discussion', 'scores' => ['Collaborating' => 1]],
                ]
            ],
            // Question 22
            [
                'text' => 'In conflicts, I:',
                'options' => [
                    ['text' => 'Try to find an intermediate position', 'scores' => ['Compromising' => 1]],
                    ['text' => 'Assert my wishes', 'scores' => ['Competing' => 1]],
                ]
            ],
            // Question 23
            [
                'text' => 'When conflicts arise, I:',
                'options' => [
                    ['text' => 'Am very often concerned with satisfying all wishes', 'scores' => ['Collaborating' => 1]],
                    ['text' => 'Let others take responsibility for solving the problem', 'scores' => ['Avoiding' => 1]],
                ]
            ],
            // Question 24
            [
                'text' => 'During conflicts, I:',
                'options' => [
                    ['text' => 'Try to meet their wishes if important to them', 'scores' => ['Accommodating' => 1]],
                    ['text' => 'Try to get them to settle for a compromise', 'scores' => ['Compromising' => 1]],
                ]
            ],
            // Question 25
            [
                'text' => 'In conflict situations, I:',
                'options' => [
                    ['text' => 'Show the logic and benefits of my position', 'scores' => ['Competing' => 1]],
                    ['text' => 'Try to be considerate of the other\'s wishes', 'scores' => ['Accommodating' => 1]],
                ]
            ],
            // Question 26
            [
                'text' => 'When handling conflicts, I:',
                'options' => [
                    ['text' => 'Propose a middle ground', 'scores' => ['Compromising' => 1]],
                    ['text' => 'Am nearly always concerned with satisfying all needs', 'scores' => ['Collaborating' => 1]],
                ]
            ],
            // Question 27
            [
                'text' => 'During disagreements, I:',
                'options' => [
                    ['text' => 'Sometimes avoid positions that create controversy', 'scores' => ['Avoiding' => 1]],
                    ['text' => 'Let them maintain their views if it makes them happy', 'scores' => ['Accommodating' => 1]],
                ]
            ],
            // Question 28
            [
                'text' => 'In conflicts, I:',
                'options' => [
                    ['text' => 'Am usually firm in pursuing my goals', 'scores' => ['Competing' => 1]],
                    ['text' => 'Usually seek the other\'s help in working out a solution', 'scores' => ['Collaborating' => 1]],
                ]
            ],
            // Question 29
            [
                'text' => 'When conflicts occur, I:',
                'options' => [
                    ['text' => 'Propose a middle ground', 'scores' => ['Compromising' => 1]],
                    ['text' => 'Feel differences aren\'t always worth worrying about', 'scores' => ['Avoiding' => 1]],
                ]
            ],
            // Question 30
            [
                'text' => 'During conflicts, I:',
                'options' => [
                    ['text' => 'Try not to hurt the other\'s feelings', 'scores' => ['Accommodating' => 1]],
                    ['text' => 'Always share the problem so we can work it out', 'scores' => ['Collaborating' => 1]],
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
