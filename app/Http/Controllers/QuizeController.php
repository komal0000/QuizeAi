<?php

namespace App\Http\Controllers;

use App\QuizGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizeController extends Controller
{
    public function singlequize($option ,Request $request ){
        if($request->isMethod('GET')){
            $user = DB::table('users')->where('id', Auth::id())->first(['age']);
            $quizeGenerator = new QuizGenerator();
            $quize = $quizeGenerator->generateQuiz($option, $user->age);
            return view('quize.singlequize',['quize' => $quize,'topic'=>$option]);
        }else{

        }

    }
}
