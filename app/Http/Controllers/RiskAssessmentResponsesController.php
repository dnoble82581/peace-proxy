<?php

namespace App\Http\Controllers;

use App\Models\RiskAssessmentResponses;
use Illuminate\Http\Request;

class RiskAssessmentResponsesController extends Controller
{
    public function index()
    {
        return RiskAssessmentResponses::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'risk_assessment_questions_id' => ['required', 'exists:risk_assessment_questions'],
            'user_id' => ['required', 'exists:users'],
            'response' => ['required'],
        ]);

        return RiskAssessmentResponses::create($data);
    }

    public function show(RiskAssessmentResponses $riskAssessmentResponses)
    {
        return $riskAssessmentResponses;
    }

    public function update(Request $request, RiskAssessmentResponses $riskAssessmentResponses)
    {
        $data = $request->validate([
            'risk_assessment_questions_id' => ['required', 'exists:risk_assessment_questions'],
            'user_id' => ['required', 'exists:users'],
            'response' => ['required'],
        ]);

        $riskAssessmentResponses->update($data);

        return $riskAssessmentResponses;
    }

    public function destroy(RiskAssessmentResponses $riskAssessmentResponses)
    {
        $riskAssessmentResponses->delete();

        return response()->json();
    }
}
