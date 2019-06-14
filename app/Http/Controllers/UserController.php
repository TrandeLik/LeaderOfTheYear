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
        $stages = ['школьный','окружной','городской','всероссийский'];
        $results = ['победитель','призер'];
        return view('user.add_achievement',compact('types','stages','results'));
    }

    public function addAchievement(Request $request){
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'subject' => 'required',
            'stage' => 'required',
            'result' => 'required',
        ]);
        $name = '';
        if ($request -> has('file')) {
            $name = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(storage_path('confirmations'), $name);
        }
        $achievement = new Achievement();
        $achievement->user_id = Auth::user()->id;
        $achievement->status = 'created';
        $achievement->name = $request->name;
        $achievement->type = $request->type;
        $achievement->subject = $request->subject;
        $achievement->stage = $request->stage;
        $achievement->confirmation = $name;
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

    public function return($id){
        $achievement = Achievement::findOrFail($id);
        $achievement->status = 'created';
        $achievement->save();
        return redirect('user');
    }

    public function delete($id){
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();
        return redirect('user');
    }

    public function editView($id){
        $achievement = Achievement::findOrFail($id);
        $types = DB::table('achievement_types')->select('type')->distinct()->get();
        $stages = ['школьный','окружной','городской','всероссийский'];
        $results = ['победитель','призер'];
        return view('user.edit_achievement',compact('types','stages','results','achievement'));
    }

    public function edit($id, Request $request){
        $achievement = Achievement::findOrFail($id);
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
}
