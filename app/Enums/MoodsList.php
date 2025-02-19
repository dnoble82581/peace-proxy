<?php

namespace App\Enums;

enum MoodsList: string
{
    case SuicidalDespair = 'Suicidal Despair';
    case SevereDepression = 'Severe Depression';
    case ModerateDepression = 'Moderate Depression';
    case MildDepression = 'Mild Depression';
    case Neutral = 'Neutral';
    case MildlyElevated = 'Mildly Elevated';
    case Hypomania = 'Hypomania';
    case ModerateMania = 'Moderate Mania';
    case Manic = 'Manic';

    /**
     * Get the numeric value for the mood.
     */
    public function numericValue(): int
    {
        return match ($this) {
            self::SuicidalDespair => -4,
            self::SevereDepression => -3,
            self::ModerateDepression => -2,
            self::MildDepression => -1,
            self::Neutral => 0,
            self::MildlyElevated => 1,
            self::Hypomania => 2,
            self::ModerateMania => 3,
            self::Manic => 4,
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::SuicidalDespair => 'Extreme hopelessness, feeling overwhelmed by pain, and seeing no way out. A person may have persistent thoughts of death or self-harm, feel completely disconnected, and believe that nothing will ever improve.',
            self::SevereDepression => 'Persistent sadness, low energy, and a deep sense of worthlessness. The person struggles to find motivation and may withdraw from social interactions, losing interest in once-enjoyable activities.',
            self::ModerateDepression => 'Ongoing feelings of sadness and fatigue but with occasional glimpses of normalcy. Functioning is difficult, but the person can still engage in daily tasks, even if they feel emotionally numb.',
            self::MildDepression => 'A low, dull mood that lingers for a long time. The person can go about their life but feels persistently down, pessimistic, or unmotivated.',
            self::Neutral => 'Neither particularly happy nor sad. The person feels emotionally stable, capable of handling daily life, and responds to circumstances without excessive emotional swings.',
            self::MildlyElevated => 'A subtle sense of optimism and energy. The person feels slightly more motivated and engaged than usual, experiencing a gentle uplift in mood.',
            self::Hypomania => ' Increased energy, confidence, and productivity without a loss of control. The person feels more creative, social, and goal-driven but may be impulsive or take more risks than usual.',
            self::ModerateMania => 'A heightened state of excitement, racing thoughts, and excessive confidence. The person may talk rapidly, engage in impulsive behaviors, and feel invincible, often ignoring consequences.',
            self::Manic => 'Extreme euphoria, delusions of grandeur, and reckless behavior. The person may have little need for sleep, experience hallucinations, or act in ways that are dangerous or self-destructive without realizing it.',
        };
    }

    public function emoji(): string
    {
        return match ($this) {
            self::SuicidalDespair => 'svg-images.mood_emojis.saddest',
            self::SevereDepression => 'svg-images.mood_emojis.sad',
            self::ModerateDepression => 'svg-images.mood_emojis.depressed',
            self::MildDepression => 'svg-images.mood_emojis.anxious',
            self::Neutral => 'svg-images.mood_emojis.base_line',
            self::MildlyElevated => 'svg-images.mood_emojis.happy',
            self::Hypomania => 'svg-images.mood_emojis.annoyed',
            self::ModerateMania => 'svg-images.mood_emojis.upset',
            self::Manic => 'svg-images.mood_emojis.mad',
        };
    }
}
