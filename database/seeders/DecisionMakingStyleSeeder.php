<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Assessment;
use App\Models\Option;
use App\Models\Question;
use App\Models\ResultCategory;
use Illuminate\Database\Seeder;
class DecisionMakingStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        // Create Decision Making Style Assessment
        $assessment = Assessment::create([
            'title' => 'What is My Decision-Making Style?',
            'slug' => 'decision-making-style',
            'description' => 'Discover your preferred decision-making style in work-related situations. This assessment identifies how you typically behave when making decisions across four dimensions: Analytical, Intuitive, Collaborative, and Avoidant.',
            'status' => 'active',
            'link_url' => '/assessments/decision-making-style',
        ]);

        // Create result categories
        $categories = [
            [
                'name' => 'Analytical',
                'description' => 'You prefer a structured, data-driven approach to decision-making. You like to gather as much information as possible and carefully evaluate all available options before making a choice.'
            ],
            [
                'name' => 'Intuitive',
                'description' => 'You tend to rely on your instincts and experiences when making decisions. You prefer a fast, gut-feeling approach rather than overanalyzing situations.'
            ],
            [
                'name' => 'Collaborative',
                'description' => 'You thrive in team environments and like to involve others in the decision-making process. You value input from colleagues and prefer reaching consensus over making decisions independently.'
            ],
            [
                'name' => 'Avoidant',
                'description' => 'You tend to shy away from making decisions, especially if they are high-stakes or complex. You often prefer to delay decisions or leave them to others when possible.'
            ],
        ];

        foreach ($categories as $category) {
            ResultCategory::create(array_merge($category, ['assessment_id' => $assessment->id]));
        }

        // All 15 questions with their options
        $questionsData = [
            [
                'text' => 'When faced with an important decision, you usually:',
                'options' => [
                    ['text' => 'Collect as much information as possible before deciding.', 'style' => 'Analytical'],
                    ['text' => 'Go with your gut feeling.', 'style' => 'Intuitive'],
                    ['text' => 'Seek input from others and make a decision together.', 'style' => 'Collaborative'],
                    ['text' => 'Avoid making a decision until you absolutely have to.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'You are given a complex task with multiple options. What do you do?',
                'options' => [
                    ['text' => 'Analyze each option carefully, comparing the pros and cons.', 'style' => 'Analytical'],
                    ['text' => 'Choose the option that feels right, without overthinking.', 'style' => 'Intuitive'],
                    ['text' => 'Ask your team for input and come to a consensus.', 'style' => 'Collaborative'],
                    ['text' => 'Postpone the decision in hopes that things will become clearer.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'In a situation where there is a lot of uncertainty, you:',
                'options' => [
                    ['text' => 'Break down the problem into smaller, manageable parts and evaluate each.', 'style' => 'Analytical'],
                    ['text' => 'Trust your instincts to guide you through the uncertainty.', 'style' => 'Intuitive'],
                    ['text' => 'Discuss with colleagues to understand different viewpoints.', 'style' => 'Collaborative'],
                    ['text' => 'Feel uncomfortable and try to delay making any decision.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'When making a decision, you prefer:',
                'options' => [
                    ['text' => 'A step-by-step approach with all available data.', 'style' => 'Analytical'],
                    ['text' => 'A decision that just feels like the right choice.', 'style' => 'Intuitive'],
                    ['text' => 'A decision that everyone on the team supports.', 'style' => 'Collaborative'],
                    ['text' => 'To leave the decision to someone else if possible.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'How do you react when your decision turns out to be wrong?',
                'options' => [
                    ['text' => 'You review what went wrong to avoid future mistakes.', 'style' => 'Analytical'],
                    ['text' => 'You accept it and move on, knowing you followed your instincts.', 'style' => 'Intuitive'],
                    ['text' => 'You talk with others about how to correct it together.', 'style' => 'Collaborative'],
                    ['text' => 'You feel stressed and try to avoid making another decision in the future.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'When making decisions under time pressure, you:',
                'options' => [
                    ['text' => 'Take a few minutes to quickly analyze the available data.', 'style' => 'Analytical'],
                    ['text' => 'Rely on your experience and make a fast choice.', 'style' => 'Intuitive'],
                    ['text' => 'Check with colleagues before finalizing any decision.', 'style' => 'Collaborative'],
                    ['text' => 'Feel anxious and tend to procrastinate until the last moment.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'If there are conflicting opinions about a decision, you:',
                'options' => [
                    ['text' => 'Evaluate all the information to decide what is best, regardless of opinions.', 'style' => 'Analytical'],
                    ['text' => 'Trust your own intuition to make the call.', 'style' => 'Intuitive'],
                    ['text' => 'Facilitate a group discussion to find a compromise.', 'style' => 'Collaborative'],
                    ['text' => 'Prefer to avoid the conflict and let others decide.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'When a decision could have long-term consequences, you:',
                'options' => [
                    ['text' => 'Conduct a thorough analysis of all possible outcomes.', 'style' => 'Analytical'],
                    ['text' => 'Make the decision quickly based on what feels right.', 'style' => 'Intuitive'],
                    ['text' => 'Hold a meeting with the team to discuss the implications.', 'style' => 'Collaborative'],
                    ['text' => 'Put off the decision as long as possible to avoid pressure.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'If you have incomplete information but need to make a decision, you:',
                'options' => [
                    ['text' => 'Try to gather more data before proceeding.', 'style' => 'Analytical'],
                    ['text' => 'Trust your experience and make the decision with what you have.', 'style' => 'Intuitive'],
                    ['text' => 'Consult others to get a wider perspective.', 'style' => 'Collaborative'],
                    ['text' => 'Delay the decision until more information becomes available.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'When working with a team on a project, you:',
                'options' => [
                    ['text' => 'Take charge by outlining a detailed plan based on analysis.', 'style' => 'Analytical'],
                    ['text' => 'Encourage the team to follow your instincts and move quickly.', 'style' => 'Intuitive'],
                    ['text' => 'Facilitate a group decision to ensure everyone is aligned.', 'style' => 'Collaborative'],
                    ['text' => 'Let others lead the way and contribute minimally to the decision-making process.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'When presented with multiple equally good options, you:',
                'options' => [
                    ['text' => 'Carefully weigh the pros and cons of each to determine the best choice.', 'style' => 'Analytical'],
                    ['text' => 'Make a decision based on your initial reaction.', 'style' => 'Intuitive'],
                    ['text' => 'Ask the team for their input to reach a collective decision.', 'style' => 'Collaborative'],
                    ['text' => 'Feel overwhelmed and prefer to let someone else decide.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'If you realize a decision you\'ve made is leading to problems, you:',
                'options' => [
                    ['text' => 'Reassess the situation and adjust your approach based on data.', 'style' => 'Analytical'],
                    ['text' => 'Trust that things will work out if you stick with your initial decision.', 'style' => 'Intuitive'],
                    ['text' => 'Gather the team to brainstorm possible solutions together.', 'style' => 'Collaborative'],
                    ['text' => 'Avoid taking responsibility and hope the issue resolves on its own.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'When faced with a decision that could disrupt your usual routine, you:',
                'options' => [
                    ['text' => 'Carefully evaluate the potential benefits and risks before proceeding.', 'style' => 'Analytical'],
                    ['text' => 'Follow your instinct and make a quick call.', 'style' => 'Intuitive'],
                    ['text' => 'Discuss with your team to assess the impact on everyone involved.', 'style' => 'Collaborative'],
                    ['text' => 'Delay making the decision until you feel more comfortable.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'How do you respond to feedback that questions your decision?',
                'options' => [
                    ['text' => 'You reassess the decision by looking at the data and consider making changes.', 'style' => 'Analytical'],
                    ['text' => 'You stand by your decision, confident that your intuition was correct.', 'style' => 'Intuitive'],
                    ['text' => 'You invite further discussion to get everyone\'s input before adjusting your approach.', 'style' => 'Collaborative'],
                    ['text' => 'You feel unsure and may second-guess the decision, avoiding further involvement.', 'style' => 'Avoidant'],
                ]
            ],
            [
                'text' => 'When you have multiple projects to manage and need to prioritize, you:',
                'options' => [
                    ['text' => 'Systematically analyze each project\'s importance and allocate resources accordingly.', 'style' => 'Analytical'],
                    ['text' => 'Go with your instinct about which projects need the most attention.', 'style' => 'Intuitive'],
                    ['text' => 'Hold a team discussion to get consensus on priorities.', 'style' => 'Collaborative'],
                    ['text' => 'Avoid making a decision and hope that the priorities will naturally become clear.', 'style' => 'Avoidant'],
                ]
            ],
        ];

        // Create questions and options
        foreach ($questionsData as $index => $questionData) {
            $question = Question::create([
                'assessment_id' => $assessment->id,
                'question_text' => $questionData['text'],
                'order' => $index + 1,
            ]);

            foreach ($questionData['options'] as $optionData) {
                // Each option gives 1 point to its respective style
                $scoreMap = [
                    'Analytical' => $optionData['style'] === 'Analytical' ? 1 : 0,
                    'Intuitive' => $optionData['style'] === 'Intuitive' ? 1 : 0,
                    'Collaborative' => $optionData['style'] === 'Collaborative' ? 1 : 0,
                    'Avoidant' => $optionData['style'] === 'Avoidant' ? 1 : 0,
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
