<?php

namespace Database\Seeders;

use App\Models\Assessment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Option;
use App\Models\Question;
use App\Models\ResultCategory;
use Illuminate\Database\Seeder;

class TemperamentBlocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        // Create Temperament Blocks Assessment
        $assessment = Assessment::create([
            'title' => 'Temperament Blocks to Creativity',
            'slug' => 'temperament-blocks-creativity',
            'description' => 'This feedback instrument identifies temperament-style blocks to creativity across seven scales. Answer honestly — this is developmental, not diagnostic.',
            'status' => 'active',
            'link_url' => '/assessments/temperament-blocks-creativity',
        ]);

        // Create result categories (7 scales)
        $categories = [
            [
                'name' => 'AA',
                'description' => 'Allergy to Ambiguity - Measures comfort with uncertainty and open-ended situations'
            ],
            [
                'name' => 'C',
                'description' => 'Conformity - Measures adherence to rules, norms, and traditions'
            ],
            [
                'name' => 'R/S',
                'description' => 'Rigidity/Stereotyping - Measures flexibility in thinking patterns'
            ],
            [
                'name' => 'FF',
                'description' => 'Fear of Failure - Measures risk-taking and tolerance for mistakes'
            ],
            [
                'name' => 'SS',
                'description' => 'Starved Sensibility - Measures curiosity and openness to diverse experiences'
            ],
            [
                'name' => 'RM',
                'description' => 'Resource Myopia - Measures self-reliance and initiative'
            ],
            [
                'name' => 'T',
                'description' => 'Touchiness (Fear of Humiliation) - Measures sensitivity to criticism'
            ],
        ];

        foreach ($categories as $category) {
            ResultCategory::create(array_merge($category, ['assessment_id' => $assessment->id]));
        }

        // All 40 questions mapped to their categories
        // Format: [question_text, category]
        $questionsData = [
            // AA questions (1, 9, 17, 25, 33)
            ['I dislike unfamiliar situations.', 'AA'],
            ['There is a great danger in giving up your old customs.', 'C'],
            ['I can predict the behaviour of a person if I know his social background.', 'R/S'],
            ['I prefer to give up when I hear that a task is too difficult.', 'FF'],
            ['You can\'t be called matured unless you can really control your emotions.', 'SS'],
            ['I don\'t think I have any distinctive skills outside my area of specialization.', 'RM'],
            ['I like to make friends mostly with those that appreciate me.', 'T'],
            ['I resist expressing tenderness towards others.', 'SS'],
            ['If you don\'t plan your holidays in detail, you just end up wasting time and money.', 'AA'],
            ['Parents know best what occupations their children should pursue.', 'C'],
            ['You can make out what people are like by noticing the way they dress.', 'R/S'],
            ['I don\'t like to compete with strong opponents.', 'FF'],
            ['I rather dislike sad movies.', 'SS'],
            ['At work or in studies I don\'t share problems with colleagues and seek their guidance.', 'RM'],
            ['I really dislike any criticism leveled against me.', 'T'],
            ['I have very little interest in flower arrangements and the like.', 'SS'],
            ['I prefer a boss who tells me precisely what I am supposed to do.', 'AA'],
            ['Women should not dress up like men and vice-versa.', 'C'],
            ['I am more comfortable after I have classified a person.', 'R/S'],
            ['I dislike being compared to others.', 'FF'],
            ['No matter what choice of food I have in a restaurant, I tend to order my favorite.', 'SS'],
            ['I don\'t think India has the resources to compete with the West.', 'RM'],
            ['I dislike juniors trying to be familiar with me.', 'T'],
            ['Giving into the pleasures of the body detracts from high thinking.', 'SS'],
            ['I can\'t stand meetings without a clear prior agenda.', 'AA'],
            ['Premarital sex is wrong because it is considered immoral in society.', 'C'],
            ['Necessities must always have priority over artistic matters.', 'R/S'],
            ['I hate to lose at games.', 'FF'],
            ['I have never bothered myself with modern art.', 'SS'],
            ['I don\'t think I can do well in a job or occupation very different from what I am currently doing.', 'RM'],
            ['I feel tense communicating with persons who have greater authority than I do.', 'T'],
            ['I can\'t be bothered with questions such as "what would happen if birds had hands like humans and humans had wings like birds?"', 'SS'],
            ['I hate confusion.', 'AA'],
            ['One must fulfill one\'s social obligations at any cost.', 'C'],
            ['People in the same professions have the same personalities.', 'R/S'],
            ['In a meeting I don\'t speak up unless I am an expert on a point.', 'FF'],
            ['A pound of imagination is not worth an ounce of facts.', 'SS'],
            ['One can accomplish little without the support of the authorities.', 'RM'],
            ['I don\'t like being contradicted in the presence of others.', 'T'],
            ['I don\'t like to go to serious movies.', 'SS'],
        ];

        // Create questions and options
        foreach ($questionsData as $index => $questionData) {
            $question = Question::create([
                'assessment_id' => $assessment->id,
                'question_text' => $questionData[0],
                'order' => $index + 1,
            ]);

            // Create 4-point Likert scale options
            $options = [
                ['text' => 'Strongly Disagree', 'value' => 1],
                ['text' => 'Disagree', 'value' => 2],
                ['text' => 'Agree', 'value' => 3],
                ['text' => 'Strongly Agree', 'value' => 4],
            ];

            foreach ($options as $optionData) {
                $scoreMap = [$questionData[1] => $optionData['value']];
                
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionData['text'],
                    'score_map' => $scoreMap,
                ]);
            }
        }
    }
}
