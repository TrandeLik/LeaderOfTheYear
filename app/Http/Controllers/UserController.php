<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Achievement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $achievements = Auth::user()->achievements;
        return view('user.index',compact('achievements'));
    }

    public function addView(){
        $types = DB::table('achievement_types')->select('type')->distinct()->get();
        return view('user.add_achievement',compact('types'));
    }

    public function addAchievement(Request $request){
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'subject' => 'required',
            'stage' => 'required',
            'result' => 'required',
        ]);
        $achievement = new Achievement();
        $achievement->user_id = Auth::user()->id;
        $achievement->status = 'created';
        $achievement->name = $request->name;
        $achievement->type = $request->type;
        $achievement->subject = $request->subject;
        $achievement->stage = $request->stage;
        $achievement->confirmation = $request->confirmation;
        $achievement->score = DB::table('achievement_types')->where([['type', $request->type],['stage', $request->stage], ['result', $request->result],])->value('score');
        $achievement->result = $request->result;
        $achievement->save();

        return redirect('user');
    }

    public function send($id){
        $achievement = Achievement::findOrFail($id);
        $achievement->status = 'sent';
        $achievement->save();
        return redirect('user');
    }
}
