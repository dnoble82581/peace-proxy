<?php

namespace Database\Seeders;

use App\Models\ResolutionQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResolutionQuestionSeeder extends Seeder
{
    public function run(): void
    {
        ResolutionQuestion::create([
            'question_text' => 'Resolved By',
            'type' => 'multiple-choice',
            'options' => [
                ['value' => 'negotiated_surrender', 'text' => 'Negotiated Surrender'],
                ['value' => 'tactical_intervention', 'text' => 'Tactical Intervention'],
                ['value' => 'combination', 'text' => 'Combination Negotiation/Tactical Intervention'],
                ['value' => 'suicide', 'text' => 'Suicide'],
                ['value' => 'attempted_suicide', 'text' => 'Attempted Suicide'],
                ['value' => 'escape', 'text' => 'Escape'],
                ['value' => 'law_enforcement_withdrawal', 'text' => 'Law Enforcement Withdrawal'],
                ['value' => 'other', 'text' => 'Other'],
            ],
        ]);

        ResolutionQuestion::create([
            'question_text' => 'Lethal Action Used',
            'type' => 'multiple-choice',
            'options' => [
                ['value' => 'deliberate_assault', 'text' => 'Deliberate Assault'],
                ['value' => 'sniper_shot', 'text' => 'Sniper Shot'],
                ['value' => 'emergency_assault', 'text' => 'Emergency Assault'],
                ['value' => 'suicide_by_cop', 'text' => 'Suicide By Cop'],
                ['value' => 'overtaken_by_hostage', 'text' => 'Overtaken by Hostage/Victim'],
                ['value' => 'other', 'text' => 'Other'],
            ],
        ]);

        ResolutionQuestion::create([
            'question_text' => 'Less than lethal Action Used',
            'type' => 'multiple-choice',
            'options' => [
                ['value' => 'rubber_bullets', 'text' => 'Rubber Bullets'],
                ['value' => 'bean_bag', 'text' => 'Bean Bag'],
                ['value' => 'taser', 'text' => 'Taser'],
                ['value' => 'chemical_agent', 'text' => 'Chemical Agent'],
                ['value' => 'net', 'text' => 'Net'],
                ['value' => 'canine', 'text' => 'Canine'],
                ['value' => 'other', 'text' => 'Other'],
            ],
        ]);

        ResolutionQuestion::create([
            'question_text' => 'Role of Negotiator in Tactical Action',
            'type' => 'multiple-choice',
            'options' => [
                ['value' => 'diversion', 'text' => 'Diversion'],
                ['value' => 'false_concessions', 'text' => 'False Concessions'],
                ['value' => 'bogus_delivery', 'text' => 'Bogus Delivery'],
                ['value' => 'stalling_for_time', 'text' => 'Stalling for Time'],
                ['value' => 'setup_subject', 'text' => 'Set-up Subject for Resolution'],
                ['value' => 'not_used', 'text' => 'Not Used'],
                ['value' => 'other', 'text' => 'Other'],
            ],
        ]);

        ResolutionQuestion::create([
            'question_text' => 'Injuries',
            'type' => 'multiple-choice',
            'options' => [
                ['value' => 'subject', 'text' => 'Subject'],
                ['value' => 'law_enforcement', 'text' => 'Law Enforcement'],
                ['value' => 'hostage_victim', 'text' => 'Hostage/Victim'],
                ['value' => 'bystanders', 'text' => 'Bystanders'],
                ['value' => 'other', 'text' => 'Other'],
            ],
        ]);

        ResolutionQuestion::create([
            'question_text' => 'Death',
            'type' => 'multiple-choice',
            'options' => [
                ['value' => 'subject', 'text' => 'Subject'],
                ['value' => 'law_enforcement', 'text' => 'Law Enforcement'],
                ['value' => 'hostage_victim', 'text' => 'Hostage/Victim'],
                ['value' => 'bystanders', 'text' => 'Bystanders'],
                ['value' => 'other', 'text' => 'Other'],
            ],
        ]);

        ResolutionQuestion::create([
            'question_text' => 'Negotiators on Scene',
            'type' => 'multiple-choice',
            'options' => User::select('id', 'name')->take(10)->get()->map(function ($user) {
                return ['value' => strtolower($user->name), 'text' => $user->name];
            })->toArray(),
        ]);

        ResolutionQuestion::create([
            'question_text' => 'Was an Interpreter Used?',
            'type' => 'single-choice',
            'options' => [
                ['value' => 'yes', 'text' => 'Yes'],
                ['value' => 'no', 'text' => 'No'],
            ],
        ]);

        ResolutionQuestion::create([
            'question_text' => 'Language',
            'type' => 'text',
        ]);

        ResolutionQuestion::create([
            'question_text' => 'Interpreter Name',
            'type' => 'text',
        ]);
    }
}
