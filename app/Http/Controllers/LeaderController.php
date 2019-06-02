<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderController extends Controller
{
    public function index()
    {
        $leaders = [];
        $users = User::all();
        foreach ($users as $user){
            $count = DB::table('achievements')->where([['user_id',Auth::user()->id],['status','confirmed'],])->sum('score');
            $leaders[$user->name] = $count;
        }
        asort($leaders);
        return view('leaderboard',compact('leaders'));
    }
}
