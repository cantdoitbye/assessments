<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Option;
use App\Models\Question;
use App\Models\ResultCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        // Create Assertive Communication Assessment
        $assessment = Assessment::create([
            'title' => 'Assertiveness Self-Assessment Questionnaire',
            'slug' => 'assertiveness-self-assessment',
            'description' => 'This questionnaire evaluates your communication style across four key dimensions: Assertive, Passive, Aggressive, and Passive-Aggressive behaviors. Answer each question honestly based on how you typically think or act.',
            'status' => 'active',
            'link_url' => '/assessments/assertiveness-self-assessment',
        ]);

        // Create result categories
        $categories = [
            [
                'name' => 'Passive (Flight)',
                'description' => 'You tend to avoid conflict and suppress your own needs. You may struggle to say "no" or voice your preferences, which can lead to internal tension and resentment. Developing assertiveness skills will help you express yourself effectively while maintaining harmony.'
            ],
            [
                'name' => 'Aggressive (Attack)',
                'description' => 'You tend to dominate or intimidate others and may disregard their perspectives. While your confidence and decisiveness are strengths, balancing them with empathy and constructive communication will help maintain respect and trust.'
            ],
            [
                'name' => 'Passive-Aggressive (Manipulation)',
                'description' => 'You tend to express dissatisfaction indirectly through subtle behaviors like sarcasm or procrastination. Learning to communicate frustrations directly and respectfully will improve clarity and strengthen relationships.'
            ],
            [
                'name' => 'Assertive (Harmony)',
                'description' => 'You consistently balance your own needs with those of others. You communicate clearly, maintain respect, and foster harmony in interactions. You are seen as confident, fair, trustworthy, and approachable.'
            ]
        ];

        foreach ($categories as $category) {
            ResultCategory::create(array_merge($category, ['assessment_id' => $assessment->id]));
        }

        // All 60 questions with proper scoring based on the correction table
        $questionsData = [
            // Passive questions
            [
                'text' => 'I often say "yes", when I really want to say "no"',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I don\'t dare refusing tasks that clearly don\'t fit my powers and skills',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I prefer not to ask the help of my colleagues, as they might think that I\'m not competent enough',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m shy and I feel stuck whenever facing an unusual situation',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m said to fly off the handle easily; I get angry and others laugh',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I tend to procrastinate what I do',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I often walk away from a job without finishing it',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m always concerned not to annoy others',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'It\'s hard for me to take a side or choose',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I don\'t like to be the only one with a different opinion in a group: In this case I prefer to keep quiet',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I am friendly and easygoing, but sometimes I get a little exploited',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I would rather observe than participate',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I prefer to be behind the scene than to be at the forefront',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I think that problems cannot be effectively addressed without seeking the roots of what caused these problems',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I don\'t like others to think ill of me',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 1, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],

            // Aggressive questions
            [
                'text' => 'I\'m rather authoritarian and decisive',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m not afraid to criticize and tell people what I think',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m sometimes accused of contradicting myself',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'It is hard for me to listen to others',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m talkative and I tend to interrupt others without noticing it in time',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m ambitious and I\'m willing to do whatever it takes to get to where I want',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'It takes a lot to intimidate me',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'Intimidating others is often a good way to take the power',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'When I get cheated on, I know how to take my revenge',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'Life is a constant struggle with changing balance of powers',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m not afraid to take on dangerous and risky challenges',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'It can be difficult for me to keep my speaking time under control',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I know how to make ironic remarks',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I often shock people with my propositions and thoughts',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I would rather be a wolf than a lamb',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 1, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],

            // Passive-Aggressive questions
            [
                'text' => 'I prefer to hide my thoughts and feelings if I don\'t know the person well enough',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'It is usually easier and smarter to act through a middleman than to act directly',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'When there is a debate, I prefer to stand back to see what will happen',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I know how to get close to influential people; this has been of much use to me in the past',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m considered smart and clever when it comes to relations',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I often pretend; how else can you manage to get what you want?',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'In general, I know who I need to see and when; this is important if you want to succeed',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'To criticize someone, it is effective to blame him/her for not following his/her own principles. He/she has to agree',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I know how to secure personal advantages thanks to my resourcefulness',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'Entertaining conflicts can sometimes be more effective than soothing tensions',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'Playing cards on the table is a good way to build confidence',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I know how to bring people to my ideas and make them acceptable',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'Using a bit of flattery is still a good way to get what you want',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'One should not be too quick in revealing one\'s intentions, this is clumsy',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'Manipulating other is often the only practical way to get what you want',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 1, 'Assertive (Harmony)' => 0],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],

            // Assertive questions
            [
                'text' => 'I defend my rights without infringing those of others',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m not afraid to give my opinion, even when facing hostile interlocutors',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I communicate with others based on trust rather than domination or calculation',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m comfortable with face-to-face interactions',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'In case of disagreement, I look for realistic compromises on the basis of mutual interests',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'In an argument, I prefer to put my cards on the table',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'In general, I present myself as I am, without hiding my emotions',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m able to be myself, while being socially accepted at the same time',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'When I don\'t agree, I try to make my opinion clearly heard',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'Public speaking does not intimidate me',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m a good listener and I don\'t interrupt people when speaking',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I always go to the end of what I have decided to do',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I\'m not afraid to express what I\'m feeling',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I don\'t think that manipulation is an effective solution',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ],
            [
                'text' => 'I know how to protest effectively in general, without excessive aggression',
                'scores' => [
                    'Rather true' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 1],
                    'Rather false' => ['Passive (Flight)' => 0, 'Aggressive (Attack)' => 0, 'Passive-Aggressive (Manipulation)' => 0, 'Assertive (Harmony)' => 0]
                ]
            ]
        ];

        // Create questions and options
        foreach ($questionsData as $index => $questionData) {
            $question = Question::create([
                'assessment_id' => $assessment->id,
                'question_text' => $questionData['text'],
                'order' => $index + 1,
            ]);

            foreach ($questionData['scores'] as $optionText => $scores) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionText,
                    'score_map' => $scores,
                ]);
            }
        }
    }
}
