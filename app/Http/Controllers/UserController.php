<?php

namespace App\Http\Controllers;
use Faker\Provider\File;
use Illuminate\Support\Facades\DB;
use App\Achievement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{ 
    public function index(){
        $achievements = Auth::user()->achievements;
        return view('user.index',compact('achievements'));
    }

    public function addView(){
        $achievement_types = DB::table('achievement_types')->get();
        $categories = DB::table('achievement_types')->select('category')->distinct()->get();
        //$categories = ['Интеллектуальные соревнования','Проектная и исследовательская деятельность','Спортивные достижения', 'Участие в лицейской жизни','Общественно полезная деятельность на базе лицея'];
        return view('user.add_achievement',compact('categories','achievement_types'));
    }

    public function addAchievement(Request $request){
        $request->validate([
            'category' => 'required',
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
        $achievement->category = $request->category;
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
        $categories = ['Интеллектуальные соревнования','Проектная и исследовательская деятельность','Спортивные достижения', 'Участие в лицейской жизни','Общественно полезная деятельность на базе лицея'];
        return view('user.edit_achievement',compact('types','stages','results','achievement','categories'));
    }

    public function edit($id, Request $request){
        $request->validate([
            'category' => 'required',
            'name' => 'required',
            'type' => 'required',
            'subject' => 'required',
            'stage' => 'required',
            'result' => 'required',
        ]);
        $name = '';
//        if ($request -> has('file')) {
//            $name = time() . '_' . $request->file->getClientOriginalName();
//            $request->file->move(storage_path('confirmations'), $name);
//        }
        $achievement = Achievement::findOrFail($id);
        $achievement->name = $request->name;
        $achievement->category = $request->category;
        $achievement->type = $request->type;
        $achievement->subject = $request->subject;
        $achievement->stage = $request->stage;
        $achievement->confirmation = $name;
        $achievement->score = DB::table('achievement_types')->where([['type', $request->type],['stage', $request->stage], ['result', $request->result],])->value('score');
        $achievement->result = $request->result;
        $achievement->save();
        return redirect('user');
    }
}
