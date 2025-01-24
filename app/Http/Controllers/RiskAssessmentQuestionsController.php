<?php

namespace App\Http\Controllers;

use App\Models\RiskAssessmentQuestions;
use Illuminate\Http\Request;

class RiskAssessmentQuestionsController extends Controller
{
    public function index()
    {
        return RiskAssessmentQuestions::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question_text' => ['required'],
            'type' => ['nullable'],
            'options' => ['nullable'],
        ]);

        return RiskAssessmentQuestions::create($data);
    }

    public function show(RiskAssessmentQuestions $riskAssessmentQuestions)
    {
        return $riskAssessmentQuestions;
    }

    public function update(Request $request, RiskAssessmentQuestions $riskAssessmentQuestions)
    {
        $data = $request->validate([
            'question_text' => ['required'],
            'type' => ['nullable'],
            'options' => ['nullable'],
        ]);

        $riskAssessmentQuestions->update($data);

        return $riskAssessmentQuestions;
    }

    public function destroy(RiskAssessmentQuestions $riskAssessmentQuestions)
    {
        $riskAssessmentQuestions->delete();

        return response()->json();
    }
}
