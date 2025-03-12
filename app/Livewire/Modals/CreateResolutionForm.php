<?php

namespace App\Livewire\Modals;

use App\Events\DocumentCreatedEvent;
use App\Models\Negotiation;
use App\Models\Resolution;
use App\Models\ResolutionQuestion;
use App\Models\Subject;
use App\Services\DocumentProcessor;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Collection;
use WireElements\Pro\Components\Modal\Modal;

class CreateResolutionForm extends Modal
{
    public Collection $questions;

    public Negotiation $negotiation;

    public Subject $subject;

    public array $responses = [];

    public static function behavior(): array
    {
        return [
            // Close the modal if the escape key is pressed
            'close-on-escape' => true,
            // Close the modal if someone clicks outside the modal
            'close-on-backdrop-click' => true,
            // Trap the users focus inside the modal (e.g. input autofocus and going back and forth between input fields)
            'trap-focus' => true,
            // Remove all unsaved changes once someone closes the modal
            'remove-state-on-close' => false,
        ];
    }

    public static function attributes(): array
    {
        return [
            // Set the modal size to 2xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl, fullscreen
            'size' => '4xl',
        ];
    }

    public function mount($negotiationId, $subjectId): void
    {
        $this->questions = ResolutionQuestion::all();
        $this->negotiation = $this->getNegotiation($negotiationId);
        $this->subject = $this->getSubject($subjectId);

        // Initialize responses array
        foreach ($this->questions as $question) {
            if ($question->type === 'multiple-choice') {
                $this->responses[$question->id] = []; // Multiple-choice answers as array
            } else {
                $this->responses[$question->id] = null; // Single-choice or text answers as null
            }
        }
    }

    private function getNegotiation($negotiationId): Negotiation
    {
        return Negotiation::findorFail($negotiationId);
    }

    private function getSubject($subjectId): Subject
    {
        return Subject::findorFail($subjectId);
    }

    /**
     * @throws Exception
     */
    public function saveResolutionPlan(): void
    {
        $resolution = $this->createResolution();

        foreach ($this->responses as $questionId => $response) {
            $question = $this->questions->firstWhere('id', $questionId);
            if ($question->type === 'multiple-choice') {
                // Store multiple-choice responses
                foreach ($response as $option) {
                    if (! empty($option)) {
                        $resolution->responses()->create([
                            'resolution_question_id' => $questionId,
                            'response' => $option,
                            'tenant_id' => $this->subject->tenant_id,
                            'subject_id' => $this->subject->id,
                        ]);
                    }
                }
            } elseif ($question->type === 'date-time') {
                // Store date-time response
                if (! empty($response)) {
                    $resolution->responses()->create([
                        'resolution_question_id' => $questionId,
                        'response' => $response, // The date-time string will be stored as-is
                        'tenant_id' => $this->subject->tenant_id,
                        'subject_id' => $this->subject->id,
                    ]);
                }
            } else {
                // Store single-choice or text response
                if (! empty($response)) {
                    $resolution->responses()->create([
                        'resolution_question_id' => $questionId,
                        'tenant_id' => $this->subject->tenant_id,
                        'response' => $response,
                        'subject_id' => $this->subject->id,
                    ]);
                }
            }
        }

        $pdfData = [
            'questions' => $this->questions,
            'responses' => collect($this->responses),
            'subject' => $this->subject,
        ];

        $pdf = Pdf::loadView('pdfs.resolution', $pdfData);

        // Save PDF to storage (optional)
        $documentProcessor = new DocumentProcessor;
        $documentProcessor->processDocuments($pdf, $this->negotiation, auth()->user()->id, 'Resolution');

        $this->reset('responses'); // Clear all responses

        // Notify the user and close the modal
        session()->flash('success', 'Resolution Plan saved successfully!');
        event(new DocumentCreatedEvent($this->subject->room_id));
        $this->close();
    }

    private function createResolution()
    {
        return Resolution::create([
            'negotiation_id' => $this->negotiation->id,
            'tenant_id' => $this->negotiation->tenant_id,
            'subject_id' => $this->subject->id,
        ]);
    }

    public function cancel(): void
    {
        $this->close();
    }

    public function render()
    {
        return view('livewire.modals.create-resolution-form');
    }
}
