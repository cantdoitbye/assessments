<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Assessment;
use App\Models\Option;
use App\Models\Question;
use App\Models\ResultCategory;
use Illuminate\Database\Seeder;
class EmotionalIntelligenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        // Create Emotional Intelligence Assessment
        $assessment = Assessment::create([
            'title' => 'Emotional Intelligence Questionnaire',
            'slug' => 'emotional-intelligence',
            'description' => 'Discover your Emotional Intelligence across four key dimensions: Self-Awareness, Self-Management, Awareness of Others, and Relating to Others. This comprehensive assessment helps you understand how you recognize and manage emotions in yourself and others.',
            'status' => 'active',
            'link_url' => '/assessments/emotional-intelligence',
        ]);

        // Create result categories - Note: We'll handle scoring ranges in the result view
        $categories = [
            [
                'name' => 'Self-Awareness',
                'description' => 'Your ability to sense and understand your inner world — your emotions, triggers, values, motivations, and the impact you have on others.'
            ],
            [
                'name' => 'Self-Management',
                'description' => 'Your capacity to regulate your emotions and impulses, stay calm under stress, recover from setbacks, and act consistently with your values even when things get tough.'
            ],
            [
                'name' => 'Awareness of Others',
                'description' => 'Your ability to read, interpret, and empathize with other people\'s emotional states — to sense what\'s going on beneath their words, and to understand the mood of a group or team.'
            ],
            [
                'name' => 'Relating to Others',
                'description' => 'Your ability to connect skilfully — to build trust, communicate openly, manage conflict, influence ethically, and support others\' growth while maintaining healthy boundaries.'
            ],
        ];

        foreach ($categories as $category) {
            ResultCategory::create(array_merge($category, ['assessment_id' => $assessment->id]));
        }

        // All 40 questions with their dimension mappings and reverse scoring indicators
        // Format based on the scoring table from the document
        $questionsData = [
            // Question 1 - Awareness of Others
            [
                'text' => 'I can usually tell when someone is upset, even if they don\'t say it directly.',
                'dimension' => 'Awareness of Others',
                'reverse' => false
            ],
            // Question 2 - Self-Management
            [
                'text' => 'I manage impulsive reactions effectively.',
                'dimension' => 'Self-Management',
                'reverse' => false
            ],
            // Question 3 - Relating to Others
            [
                'text' => 'I create a safe space for others to express their thoughts and feelings.',
                'dimension' => 'Relating to Others',
                'reverse' => false
            ],
            // Question 4 - Self-Management (Reverse)
            [
                'text' => 'I find it difficult to stay motivated for tasks I don\'t enjoy.',
                'dimension' => 'Self-Management',
                'reverse' => true
            ],
            // Question 5 - Self-Awareness
            [
                'text' => 'I recognize early signs when I\'m becoming stressed or overwhelmed.',
                'dimension' => 'Self-Awareness',
                'reverse' => false
            ],
            // Question 6 - Relating to Others
            [
                'text' => 'I communicate both facts and emotions clearly and respectfully.',
                'dimension' => 'Relating to Others',
                'reverse' => false
            ],
            // Question 7 - Self-Awareness
            [
                'text' => 'I\'m aware of how my personal values influence my choices.',
                'dimension' => 'Self-Awareness',
                'reverse' => false
            ],
            // Question 8 - Relating to Others
            [
                'text' => 'I am patient and open when giving feedback.',
                'dimension' => 'Relating to Others',
                'reverse' => false
            ],
            // Question 9 - Self-Awareness
            [
                'text' => 'I can easily identify what I\'m feeling in the moment.',
                'dimension' => 'Self-Awareness',
                'reverse' => false
            ],
            // Question 10 - Awareness of Others
            [
                'text' => 'I notice when others are uncomfortable or disengaged.',
                'dimension' => 'Awareness of Others',
                'reverse' => false
            ],
            // Question 11 - Self-Management
            [
                'text' => 'I can shift from frustration to problem-solving quickly.',
                'dimension' => 'Self-Management',
                'reverse' => false
            ],
            // Question 12 - Relating to Others (Reverse)
            [
                'text' => 'I tend to withdraw from people when tensions arise.',
                'dimension' => 'Relating to Others',
                'reverse' => true
            ],
            // Question 13 - Self-Awareness
            [
                'text' => 'I\'m aware of what motivates or demotivates me.',
                'dimension' => 'Self-Awareness',
                'reverse' => false
            ],
            // Question 14 - Relating to Others
            [
                'text' => 'I handle conflicts calmly and look for win–win outcomes.',
                'dimension' => 'Relating to Others',
                'reverse' => false
            ],
            // Question 15 - Self-Awareness
            [
                'text' => 'I regularly seek feedback to understand how my behavior impacts others.',
                'dimension' => 'Self-Awareness',
                'reverse' => false
            ],
            // Question 16 - Relating to Others
            [
                'text' => 'I use my influence to inspire rather than to control.',
                'dimension' => 'Relating to Others',
                'reverse' => false
            ],
            // Question 17 - Awareness of Others
            [
                'text' => 'I make an effort to understand what motivates each person I work with.',
                'dimension' => 'Awareness of Others',
                'reverse' => false
            ],
            // Question 18 - Self-Awareness (Reverse)
            [
                'text' => 'I find it hard to describe my emotions clearly.',
                'dimension' => 'Self-Awareness',
                'reverse' => true
            ],
            // Question 19 - Awareness of Others
            [
                'text' => 'I listen actively without jumping to conclusions.',
                'dimension' => 'Awareness of Others',
                'reverse' => false
            ],
            // Question 20 - Self-Awareness
            [
                'text' => 'I notice how my mood affects my decisions.',
                'dimension' => 'Self-Awareness',
                'reverse' => false
            ],
            // Question 21 - Awareness of Others
            [
                'text' => 'I encourage others to develop their potential.',
                'dimension' => 'Awareness of Others',
                'reverse' => false
            ],
            // Question 22 - Self-Management
            [
                'text' => 'When plans change suddenly, I adapt without much resistance.',
                'dimension' => 'Self-Management',
                'reverse' => false
            ],
            // Question 23 - Awareness of Others
            [
                'text' => 'I take into account people\'s emotional needs before making decisions.',
                'dimension' => 'Awareness of Others',
                'reverse' => false
            ],
            // Question 24 - Self-Management (Reverse)
            [
                'text' => 'I give up easily when I encounter obstacles.',
                'dimension' => 'Self-Management',
                'reverse' => true
            ],
            // Question 25 - Awareness of Others
            [
                'text' => 'I can empathize with others even when I disagree with them.',
                'dimension' => 'Awareness of Others',
                'reverse' => false
            ],
            // Question 26 - Self-Management
            [
                'text' => 'I remain calm and composed under pressure.',
                'dimension' => 'Self-Management',
                'reverse' => false
            ],
            // Question 27 - Self-Awareness
            [
                'text' => 'I take time to reflect on what I\'ve learned from emotional experiences.',
                'dimension' => 'Self-Awareness',
                'reverse' => false
            ],
            // Question 28 - Self-Management
            [
                'text' => 'I take responsibility for my mistakes instead of blaming others.',
                'dimension' => 'Self-Management',
                'reverse' => false
            ],
            // Question 29 - Awareness of Others (Reverse)
            [
                'text' => 'I find it difficult to read subtle emotional cues in others.',
                'dimension' => 'Awareness of Others',
                'reverse' => true
            ],
            // Question 30 - Relating to Others (Reverse)
            [
                'text' => 'I find it challenging to collaborate with people who have different opinions.',
                'dimension' => 'Relating to Others',
                'reverse' => true
            ],
            // Question 31 - Self-Awareness
            [
                'text' => 'I can explain why I reacted a certain way after reflecting on it.',
                'dimension' => 'Self-Awareness',
                'reverse' => false
            ],
            // Question 32 - Relating to Others
            [
                'text' => 'I build trust through honesty and follow-through.',
                'dimension' => 'Relating to Others',
                'reverse' => false
            ],
            // Question 33 - Self-Management
            [
                'text' => 'I stay focused on my goals even when things get difficult.',
                'dimension' => 'Self-Management',
                'reverse' => false
            ],
            // Question 34 - Self-Management
            [
                'text' => 'I pay attention to the emotional tone of a group or meeting.',
                'dimension' => 'Self-Management',
                'reverse' => false
            ],
            // Question 35 - Relating to Others (Reverse)
            [
                'text' => 'I sometimes overlook how my behavior affects others\' feelings.',
                'dimension' => 'Relating to Others',
                'reverse' => true
            ],
            // Question 36 - Self-Management (Reverse)
            [
                'text' => 'I\'m often surprised by my own emotional reactions.',
                'dimension' => 'Self-Management',
                'reverse' => true
            ],
            // Question 37 - Self-Awareness
            [
                'text' => 'I act in line with my values even when it\'s inconvenient.',
                'dimension' => 'Self-Awareness',
                'reverse' => false
            ],
            // Question 38 - Awareness of Others
            [
                'text' => 'I can tell when someone\'s words don\'t match their feelings.',
                'dimension' => 'Awareness of Others',
                'reverse' => false
            ],
            // Question 39 - Awareness of Others
            [
                'text' => 'I listen to others to understand their emotions before responding.',
                'dimension' => 'Awareness of Others',
                'reverse' => false
            ],
            // Question 40 - Relating to Others
            [
                'text' => 'I encourage honest feedback from colleagues about my behaviour.',
                'dimension' => 'Relating to Others',
                'reverse' => false
            ],
        ];

        // Create questions and options
        foreach ($questionsData as $index => $questionData) {
            $question = Question::create([
                'assessment_id' => $assessment->id,
                'question_text' => $questionData['text'],
                'order' => $index + 1,
            ]);

            // Create 5-point Likert scale options
            $likertOptions = [
                ['text' => '1 - Disagree Strongly', 'value' => 1],
                ['text' => '2 - Disagree Somewhat', 'value' => 2],
                ['text' => '3 - Neither Agree Or Disagree', 'value' => 3],
                ['text' => '4 - Agree To Some Extent', 'value' => 4],
                ['text' => '5 - Agree Strongly', 'value' => 5],
            ];

            foreach ($likertOptions as $optionData) {
                // Calculate the score based on whether it's a reverse-scored item
                $score = $questionData['reverse'] 
                    ? (6 - $optionData['value'])  // Reverse: 1→5, 2→4, 3→3, 4→2, 5→1
                    : $optionData['value'];        // Normal scoring

                // Create score map for all dimensions (only one gets the score)
                $scoreMap = [
                    'Self-Awareness' => $questionData['dimension'] === 'Self-Awareness' ? $score : 0,
                    'Self-Management' => $questionData['dimension'] === 'Self-Management' ? $score : 0,
                    'Awareness of Others' => $questionData['dimension'] === 'Awareness of Others' ? $score : 0,
                    'Relating to Others' => $questionData['dimension'] === 'Relating to Others' ? $score : 0,
                ];

                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionData['text'],
                    'score_map' => $scoreMap,
                ]);
            }
        }
    }
}
