<?php

namespace App\Http\Controllers;

use App\Models\RiskAssessmentResponse;
use Illuminate\Http\Request;

class RiskAssessmentResponsesController extends Controller
{
    public function index()
    {
        return RiskAssessmentResponse::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'risk_assessment_questions_id' => ['required', 'exists:risk_assessment_questions'],
            'user_id' => ['required', 'exists:users'],
            'response' => ['required'],
        ]);

        return RiskAssessmentResponse::create($data);
    }

    public function show(RiskAssessmentResponse $riskAssessmentResponses)
    {
        return $riskAssessmentResponses;
    }

    public function update(Request $request, RiskAssessmentResponse $riskAssessmentResponses)
    {
        $data = $request->validate([
            'risk_assessment_questions_id' => ['required', 'exists:risk_assessment_questions'],
            'user_id' => ['required', 'exists:users'],
            'response' => ['required'],
        ]);

        $riskAssessmentResponses->update($data);

        return $riskAssessmentResponses;
    }

    public function destroy(RiskAssessmentResponse $riskAssessmentResponses)
    {
        $riskAssessmentResponses->delete();

        return response()->json();
    }
}
