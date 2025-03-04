<?php

namespace Database\Seeders;

use App\Models\RiskAssessmentQuestion;
use Illuminate\Database\Seeder;

class RiskAssessmentQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RiskAssessmentQuestion::create([
            'question_text' => 'Has stated an intention to commit suicide.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has expressed feelings of depression, hopelessness, and/or helplessness.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has a history of impulsivity (assaults, high risk behaviors, many parking/traffic violations, etc.).',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has a family history of suicide.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has fired a weapon during this incident.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Did not reasonably expect to be interrupted (isolated as to time or place).',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has used drugs and/or alcohol during this incident.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has a suicide plan that includes details.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has a suicide plan that includes high lethality.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has a suicide plan that includes means that are readily available.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has a suicide plan that includes a short deadline.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has been experiencing extreme insomnia.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Is causing our experienced team to have a bad gut feeling.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has a history of increasingly dangerous suicidal gestures.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has a history of mental health issues.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has indicated a sudden, unexplained improvement in the negotiation process.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Refuses to talk to the negotiator.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Is extremely upset or agitated.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Expresses feelings of intense self-hatred or self-loathing.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Sees no alternatives to his/her situation.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Views death as a way out of extreme psychological pain.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Has fantasies of death as an escape from his/her situation.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Feels no pleasure or interst in life.',
            'type' => 'single-choice',
        ]);
        RiskAssessmentQuestion::create([
            'question_text' => 'Views him/herself as a source of shame to their family or others.',
            'type' => 'single-choice',
        ]);
    }
}
