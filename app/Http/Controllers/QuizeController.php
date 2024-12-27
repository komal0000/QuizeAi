<?php

namespace App\Http\Controllers;

use App\Models\Quize;
use App\QuizGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\QizGeneratorOpenAI;

class QuizeController extends Controller
{
    public function singlequize($option, Request $request)
    {
        $user = Auth::user();
        $quizeGenerator = new QizGeneratorOpenAI();
        $quize = DB::table('quizes')->where('topic', $option)->first();
        if ($quize) {
            $quize->user_id = $user->id;
            $quize->topic = $option;
            $quize->question = json_encode($quizeGenerator->generateQuiz($option, $user->age, 10));
            $quize->save();
            return response(route('play', ['quize' => $quize->id]));
        } else {
            $quize = new Quize();
            $quize->user_id = $user->id;
            $quize->topic = $option;
            $quize->question = json_encode($quizeGenerator->generateQuiz($option, $user->age, 10));
            $quize->save();
            return response(route('play', ['quize' => $quize->id]));
        }
    }

    public function play($quize, Request $request)
    {
        $quizeData = Quize::where('id', $quize)->first();
        if ($request->isMethod('GET')) {
            return view('quize.play', compact('quizeData', 'quize'));
        } else {
            $quizeData->answer = $request->answers;
            $quizeData->score = $request->score;
            $quizeData->save();
            return response()->json($quizeData);
        }
    }
}
