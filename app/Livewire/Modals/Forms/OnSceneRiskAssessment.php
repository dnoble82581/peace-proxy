<?php

namespace App\Livewire\Modals\Forms;

use App\Events\DocumentCreatedEvent;
use App\Models\RiskAssessmentQuestion;
use App\Models\Subject;
use App\Services\DocumentProcessor;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class OnSceneRiskAssessment extends Modal
{
    public Collection $questions;

    public Subject $subject;

    public array $responses = [];

    //    public int $yesCount = 0;

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
            'size' => '6xl',
        ];
    }

    public function mount($subjectId)
    {
        // Load all the questions when the form is mounted
        $this->questions = RiskAssessmentQuestion::all();
        $this->subject = Subject::find($subjectId);

        // Initialize the `responses` array
        foreach ($this->questions as $question) {
            $this->responses[$question->id] = $question->type === 'multiple-choice' ? [] : 'No';
        }
    }

    public function getYesCountProperty(): int
    {
        return collect($this->responses)->filter(fn ($response) => $response === 'Yes')->count();
    }

    /**
     * @throws Exception
     */
    public function submit(): void
    {
        $this->validate(['responses.*' => 'required']);
        $riskAssessment = $this->subject->riskAssessments()->create([
            'result' => 0, 'tenant_id' => $this->subject->tenant_id,
        ]);

        foreach ($this->responses as $questionId => $response) {
            $riskAssessment->responses()->create([
                'risk_assessment_question_id' => $questionId,
                'response' => is_array($response) ? json_encode($response) : $response,
                'tenant_id' => $this->subject->tenant_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $riskAssessment->update(['result' => $this->yesCount]);
        }

        $pdfData = [
            'questions' => $this->questions,
            'responses' => $this->responses,
            'subject' => $this->subject,
        ];

        $pdf = Pdf::loadView('pdfs.on-scene-risk-assessment', $pdfData);

        // Save PDF to storage (optional)
        $documentProcessor = new DocumentProcessor;
        $documentProcessor->processDocuments($pdf, $this->subject, auth()->user()->id, 'Risk Assessment');

        session()->flash('success', 'Survey submitted and saved as PDF!');
        $this->reset('responses'); // Clear all responses

        $this->subject->update(['risk_assessment' => true]);

        event(new DocumentCreatedEvent($this->subject->room_id));

        $this->close();

        // Allow the user to download the PDF directly
        //        return response()->streamDownload(fn () => print ($pdf->output()), $filename);
    }

    public function render(): View
    {
        return view('livewire.modals.forms.on-scene-risk-assessment');
    }
}
