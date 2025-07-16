<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScreeningAnswerRequest;
use App\Models\ScreeningAnswer;
use App\Models\ScreeningQuestion;
use App\Models\ScreeningSessions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScreeningController extends Controller
{
    //
    public function questions()
    {
        return ScreeningQuestion::all();
    }

    public function index()
    {
        $sessions = ScreeningSessions::with('answers')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($sessions);
    }

    public function showLatest()
    {
        $session = ScreeningSessions::with('answers')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$session) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($session);
    }


    public function submitAnswers(ScreeningAnswerRequest $request)
    {
        $user = Auth::user();
        $answers = $request->all();
        $score = 0;

        foreach ($answers as $answer) {
            $question = ScreeningQuestion::find($answer['question_id']);
            if ($question && strtolower($answer['answer']) === 'ya') {
                $score += $question->weight;
            }
        }

        $riskData = ScreeningSessions::evaluateRisk($score);

        $session = ScreeningSessions::create([
            'user_id' => $user->id,
            'score' => $score,
            'risk_level' => $riskData['risk_level'],
            'risk_description' => $riskData['risk_description'],
            'next_step' => $riskData['next_step'],
        ]);

        foreach ($answers as $answer) {
            ScreeningAnswer::create([
                'session_id' => $session->id,
                'question_id' => $answer['question_id'],
                'answer' => $answer['answer'],
            ]);
        }

        return response()->json($session->load('answers'), 201);
    }
}
