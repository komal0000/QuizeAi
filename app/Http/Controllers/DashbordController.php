<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashbordController extends Controller
{
    public function index(){
        $user = Auth::user();
        $userQuizScores = DB::table('quizes')->where('user_id',$user->id)->get(['topic','score','created_at']);
        return view('quize.dashbord',compact('userQuizScores'));
    }
}
