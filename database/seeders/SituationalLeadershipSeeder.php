<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Assessment;
use App\Models\Option;
use App\Models\Question;
use App\Models\ResultCategory;
use Illuminate\Database\Seeder;
class SituationalLeadershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        // Create Situational Leadership Assessment
        $assessment = Assessment::create([
            'title' => 'Situational Leadership Style Assessment',
            'slug' => 'situational-leadership-style',
            'description' => 'Discover your natural leadership tendencies based on the Hersey and Blanchard Situational Leadership model. This assessment identifies how you adapt your leadership style across four dimensions: Directing, Coaching, Supporting, and Delegating.',
            'status' => 'active',
            'link_url' => '/assessments/situational-leadership-style',
        ]);

        // Create result categories
        $categories = [
            [
                'name' => 'Directing',
                'description' => 'You are a decisive, task-oriented leader who values structure, clarity, and results. You tend to take charge quickly, set clear goals, define roles, and closely monitor progress.'
            ],
            [
                'name' => 'Coaching',
                'description' => 'You are a high-energy motivator who combines direction with encouragement. You are both goal- and people-focused, explaining the "why" behind tasks and using persuasion to gain buy-in.'
            ],
            [
                'name' => 'Supporting',
                'description' => 'You are a collaborative, relationship-centered leader who believes in empowerment. You involve your team in decisions, listen deeply, and build trust through participation.'
            ],
            [
                'name' => 'Delegating',
                'description' => 'You are a trust-based, empowering leader who values autonomy and accountability. You step back and let competent team members take ownership of their work.'
            ],
        ];

        foreach ($categories as $category) {
            ResultCategory::create(array_merge($category, ['assessment_id' => $assessment->id]));
        }

        // All 12 situations with their alternative actions
        // Based on the scoring matrix from the document
        $questionsData = [
            [
                'text' => 'Your group is not responding lately to your friendly conversation and obvious concern for their welfare. Their performance is declining rapidly.',
                'options' => [
                    ['text' => 'Emphasize the use of uniform procedures and the necessity for task accomplishment.', 'style' => 'Directing'],
                    ['text' => 'Talk with them and then set goals.', 'style' => 'Coaching'],
                    ['text' => 'Make yourself available for discussion but do not push your involvement.', 'style' => 'Supporting'],
                    ['text' => 'Intentionally do not intervene.', 'style' => 'Delegating'],
                ]
            ],
            [
                'text' => 'The observable performance of your group is increasing. You have been making sure that all members were aware of their responsibilities and expected standards of performance.',
                'options' => [
                    ['text' => 'Emphasize the importance of deadlines and tasks.', 'style' => 'Directing'],
                    ['text' => 'Engage in friendly interaction, but continue to make sure that all members are aware of their responsibilities and expected standards of performance.', 'style' => 'Coaching'],
                    ['text' => 'Do what you can to make the group feel important and involved.', 'style' => 'Supporting'],
                    ['text' => 'Take no definite action.', 'style' => 'Delegating'],
                ]
            ],
            [
                'text' => 'Members of your group are unable to solve a problem themselves. You have normally left them alone. Group performance and interpersonal relations have been good.',
                'options' => [
                    ['text' => 'Act quickly and firmly to correct and redirect.', 'style' => 'Directing'],
                    ['text' => 'Work with the group and together engage in problem solving.', 'style' => 'Coaching'],
                    ['text' => 'Encourage the group to work on the problem and be supportive of their efforts.', 'style' => 'Supporting'],
                    ['text' => 'Let the group work it out.', 'style' => 'Delegating'],
                ]
            ],
            [
                'text' => 'You are considering a change. Your group has a fine record of accomplishment. They respect the need for change.',
                'options' => [
                    ['text' => 'Announce changes and then implement with close supervision.', 'style' => 'Directing'],
                    ['text' => 'Incorporate group recommendations, but you direct the change.', 'style' => 'Coaching'],
                    ['text' => 'Allow group involvement in developing the change, but do not be too directive.', 'style' => 'Supporting'],
                    ['text' => 'Allow the group to formulate its own directive.', 'style' => 'Delegating'],
                ]
            ],
            [
                'text' => 'The performance of your group has been dropping during the last few months. Members have been unconcerned with meeting objectives. Redefining roles and responsibilities has helped in the past. They have continually needed reminding to have their tasks done on time.',
                'options' => [
                    ['text' => 'Redefine roles and responsibilities and supervise carefully.', 'style' => 'Directing'],
                    ['text' => 'Incorporate group recommendations, but see that objectives are met.', 'style' => 'Coaching'],
                    ['text' => 'Allow group involvement in determining roles and responsibilities but do not be too directive.', 'style' => 'Supporting'],
                    ['text' => 'Allow the group to formulate its own direction.', 'style' => 'Delegating'],
                ]
            ],
            [
                'text' => 'You stepped into an efficiently run group. The previous leader tightly controlled the situation. You want to maintain a productive situation, but would like to begin having more time building interpersonal relationships among members.',
                'options' => [
                    ['text' => 'Emphasize the importance of deadlines and tasks.', 'style' => 'Directing'],
                    ['text' => 'Get the group involved in decision-making, but see that objectives are met.', 'style' => 'Coaching'],
                    ['text' => 'Do what you can to make the group feel important and involved.', 'style' => 'Supporting'],
                    ['text' => 'Intentionally do not intervene.', 'style' => 'Delegating'],
                ]
            ],
            [
                'text' => 'You are considering changing to a structure that will be new to your group. Members of the group have made suggestions about needed change. The group has been productive and demonstrated flexibility.',
                'options' => [
                    ['text' => 'Define the change and supervise carefully.', 'style' => 'Directing'],
                    ['text' => 'Be willing to make changes as recommended, but maintain control of the implementation.', 'style' => 'Coaching'],
                    ['text' => 'Participate with the group in developing the change but allow members to organize the implementation.', 'style' => 'Supporting'],
                    ['text' => 'Be supportive in discussing the situation with the group but not too directive.', 'style' => 'Delegating'],
                ]
            ],
            [
                'text' => 'Group performance and interpersonal relations are good. You feel somewhat unsure about your lack of direction in the group.',
                'options' => [
                    ['text' => 'Redefine goals and supervise carefully.', 'style' => 'Directing'],
                    ['text' => 'Discuss the situation with the group and then you initiate necessary changes.', 'style' => 'Coaching'],
                    ['text' => 'Allow group involvement in setting goals, but don\'t push.', 'style' => 'Supporting'],
                    ['text' => 'Leave the group alone.', 'style' => 'Delegating'],
                ]
            ],
            [
                'text' => 'You have been appointed to give leadership to a study group that is far overdue in making requested recommendations for change. The group is not clear on its goals. Attendance at sessions has been poor. Their meetings have turned into social gatherings. Potentially they have the talent necessary to help.',
                'options' => [
                    ['text' => 'Redefine goals and supervise carefully.', 'style' => 'Directing'],
                    ['text' => 'Incorporate group recommendations, but see that objectives are met.', 'style' => 'Coaching'],
                    ['text' => 'Allow group involvement in setting goals, but do not push.', 'style' => 'Supporting'],
                    ['text' => 'Let the group work out its problems.', 'style' => 'Delegating'],
                ]
            ],
            [
                'text' => 'Your group, usually able to take responsibility, is not responding to your recent redefining of job responsibilities as a result of one member leaving the city.',
                'options' => [
                    ['text' => 'Redefine standards and supervise carefully.', 'style' => 'Directing'],
                    ['text' => 'Incorporate group recommendations, but see that new job responsibilities are met.', 'style' => 'Coaching'],
                    ['text' => 'Allow group involvement in redefining standards but don\'t take control.', 'style' => 'Supporting'],
                    ['text' => 'Avoid confrontation by not applying pressure, leave situation alone.', 'style' => 'Delegating'],
                ]
            ],
            [
                'text' => 'You have been promoted to a leadership position. The previous leader was involved in the affairs of the group. The group has adequately handled its tasks and direction. Interpersonal relationships in the group are good.',
                'options' => [
                    ['text' => 'Take steps to direct the group towards working in a well-defined manner.', 'style' => 'Directing'],
                    ['text' => 'Discuss past performance with the group and then you examine the need for new practice.', 'style' => 'Coaching'],
                    ['text' => 'Involve the group in decision-making and reinforce good contributions.', 'style' => 'Supporting'],
                    ['text' => 'Continue to leave the group alone.', 'style' => 'Delegating'],
                ]
            ],
            [
                'text' => 'Recent information indicates some internal difficulties among group members. The group has a remarkable record of accomplishment. Members have effectively maintained long-range goals. They have worked in harmony for the past year. All are well qualified for the tasks.',
                'options' => [
                    ['text' => 'Act quickly and firmly to correct and redirect.', 'style' => 'Directing'],
                    ['text' => 'Try out your solution with the group and examine the need for new procedures.', 'style' => 'Coaching'],
                    ['text' => 'Participate in problem discussion while providing support for group members.', 'style' => 'Supporting'],
                    ['text' => 'Allow group members to work it out themselves.', 'style' => 'Delegating'],
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
                    'Directing' => $optionData['style'] === 'Directing' ? 1 : 0,
                    'Coaching' => $optionData['style'] === 'Coaching' ? 1 : 0,
                    'Supporting' => $optionData['style'] === 'Supporting' ? 1 : 0,
                    'Delegating' => $optionData['style'] === 'Delegating' ? 1 : 0,
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
