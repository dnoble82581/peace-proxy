<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum SubjectRequestType: string
{
    case MaterialOrFinancial = 'Material or Financial';
    case EscapeOrSafePassage = 'Escape or Safe Passage';
    case ReleaseOfIndividuals = 'Release of Individuals';
    case PoliticalOrIdeological = 'Political or Ideological';
    case WeaponsOrTacticalEquipment = 'Weapons or Tactical Equipment';
    case NegotiationDriven = 'Negotiation-Driven Requests';
    case PsychologicalOrEmotional = 'Psychological or Emotional Requests';
    case SafetyGuarantees = 'Safety Guarantees';
    case Miscellaneous = 'Miscellaneous';

    /**
     * Get the formatted name for display purposes.
     */
    public function displayName(): string
    {
        return Str::headline($this->name); // Convert to a human-readable format
    }

    /**
     * Get a description of the enum case.
     */
    public function metadata(): array
    {
        return match ($this) {
            self::MaterialOrFinancial => ['description' => 'Requests for money, resources, or vehicles.'],
            self::EscapeOrSafePassage => ['description' => 'Demands for safe exit or travel routes.'],
            self::ReleaseOfIndividuals => ['description' => 'Requests for the release of prisoners or exchanges.'],
            self::PoliticalOrIdeological => ['description' => 'Requests related to political or ideological objectives.'],
            self::WeaponsOrTacticalEquipment => ['description' => 'Requests for weapons, ammunition, or protective gear.'],
            self::NegotiationDriven => ['description' => 'Demands made during negotiation to control the situation.'],
            self::PsychologicalOrEmotional => ['description' => 'Requests related to emotional validation or connection.'],
            self::SafetyGuarantees => ['description' => 'Demands for personal safety or immunity.'],
            self::Miscellaneous => ['description' => 'Other requests such as stalling or medical needs.'],
        };
    }
}
