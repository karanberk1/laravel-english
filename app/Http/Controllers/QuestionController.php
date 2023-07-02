<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\question;
use App\Http\Requests\QuestionControlRequest;

class QuestionController extends Controller
{
    public function answerControl(QuestionControlRequest $request)
    {
        $question = question::find($request->questionid);


        if (empty($question)) {
            return response()->json(["status" => false, "message" => "have no question"], 400);
        }

        if ($question->correct_answer != $request->answer) {
            return response()->json(["status" => false, "message" => "answer is not correct !!!"], 400);
        }

        return response()->json(["status" => true, "message" => "answer is correct !!!", "data" => []], 200);
    }
}
