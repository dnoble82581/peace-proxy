<?php

namespace App\Http\Controllers;

use App\Models\RiskAssessmentQuestion;
use Illuminate\Http\Request;

class RiskAssessmentQuestionsController extends Controller
{
    public function index()
    {
        return RiskAssessmentQuestion::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question_text' => ['required'],
            'type' => ['nullable'],
            'options' => ['nullable'],
        ]);

        return RiskAssessmentQuestion::create($data);
    }

    public function show(RiskAssessmentQuestion $riskAssessmentQuestions)
    {
        return $riskAssessmentQuestions;
    }

    public function update(Request $request, RiskAssessmentQuestion $riskAssessmentQuestions)
    {
        $data = $request->validate([
            'question_text' => ['required'],
            'type' => ['nullable'],
            'options' => ['nullable'],
        ]);

        $riskAssessmentQuestions->update($data);

        return $riskAssessmentQuestions;
    }

    public function destroy(RiskAssessmentQuestion $riskAssessmentQuestions)
    {
        $riskAssessmentQuestions->delete();

        return response()->json();
    }
}
