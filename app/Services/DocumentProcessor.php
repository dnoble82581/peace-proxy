<?php

namespace App\Services;

use Barryvdh\DomPDF\PDF;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentProcessor
{
    private string $disk;

    public function __construct(string $disk = 's3')
    {
        $this->disk = $disk;
    }

    /**
     * Process and store the uploaded documents, associated with a polymorphic model.
     *
     * @param  iterable  $documents  Array or Collection of documents to process
     * @param  Model  $model  Polymorphic model instance (e.g., Subject, User)
     * @param  int  $userId  ID of the authenticated user
     * @return array Details of the processed documents
     *
     * @throws Exception
     */
    public function processDocuments($documents, Model $model, int $userId): array
    {
        $processedDocuments = [];

        if (! is_iterable($documents)) {
            $documents = [$documents];
        }

        foreach ($documents as $document) {
            $filename = $this->generateFilename($document);
            $this->storeDocument($document, $model, $filename);

            $documentData = [
                'type' => $document instanceof UploadedFile ? 'Document' : 'Risk Assessment',
                'user_id' => $userId,
                'filename' => $filename,
                'extension' => $document instanceof UploadedFile
                    ? $document->getClientOriginalExtension()
                    : 'pdf',
                'size' => $document instanceof UploadedFile
                    ? $document->getSize()
                    : (method_exists($document, 'output') ? strlen($document->output()) : 0),
            ];

            // Attach document to the model (polymorphic relationship)
            $model->documents()->create($documentData);

            $processedDocuments[] = $documentData;
        }

        return $processedDocuments;
    }

    /**
     * Generate a unique filename for the document.
     */
    private function generateFilename($document): string
    {
        if ($document instanceof UploadedFile) {
            return pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME)
                .'_'.now()->timestamp.'.'.$document->getClientOriginalExtension();
        }

        if ($document instanceof PDF) {
            return 'document_'.now()->timestamp.'.pdf';
        }

        return 'document_'.now()->timestamp.'.tmp';
    }

    /**
     * Store the document in the designated location.
     */
    private function storeDocument($document, $model, string $filename): void
    {
        $savePath = '/documents/'.strtolower(class_basename($model)).'/'.$model->id.'/';

        // If document is an uploaded file
        if ($document instanceof UploadedFile) {
            Storage::disk($this->disk)->putFileAs($savePath, $document, $filename);

            return;
        }

        // If document is dynamically generated (e.g., PDF)
        if ($document instanceof PDF) {
            $pdfContent = $document->output(); // Get the raw PDF content
            Storage::disk($this->disk)->put($savePath.$filename, $pdfContent);

            return;
        }

        throw new Exception('Invalid document type provided for storage.');
    }
}
