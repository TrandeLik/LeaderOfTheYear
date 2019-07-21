<?php

namespace App\Http\Controllers;
use Faker\Provider\File;
use Illuminate\Support\Facades\DB;
use App\Achievement;
use App\User;
use App\Setting;
use App\AchievementType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{ 
    public function index(){
        $achievements = Auth::user()->achievements;
        $confirmedScore = Auth::user()->confirmedScore();
        $totalScore = Auth::user()->totalScore();
        $place = Auth::user()->place();
        $falseCategories = Auth::user()->falseCategories();
        $percentage = Auth::user()->percentage();
        $mainCategory = Setting::where('name','Главная категория')->value('value');
        return view('user.index',compact('achievements','confirmedScore','totalScore','place','percentage','falseCategories','mainCategory'));
    }

    public function addView(){
        $achievement_types = AchievementType::all();
        $categories = AchievementType::select('category')->distinct()->get();
        return view('user.addAchievement',compact('categories','achievement_types'));
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
        $achievement_types = AchievementType::all();
        $categories = AchievementType::select('category')->distinct()->get();
        $types = AchievementType::select('type')->where('category',$achievement->category)->distinct()->get();
        $stages = AchievementType::select('stage')->where([['category',$achievement->category],['type',$achievement->type],])->distinct()->get();
        $results = AchievementType::select('result')->where([['category',$achievement->category],['type',$achievement->type],['stage',$achievement->stage],])->distinct()->get();
        return view('user.editAchievement',compact('types','stages','results','achievement','categories','achievement_types'));
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
        $achievement = Achievement::findOrFail($id);
        if ($request -> has('file')) {
            $name = time() . '_' . $request->file->getClientOriginalName();
            $request->file->move(storage_path('confirmations'), $name);
            $achievement->confirmation = $name;
        }

        $achievement->name = $request->name;
        $achievement->category = $request->category;
        $achievement->type = $request->type;
        $achievement->subject = $request->subject;
        $achievement->stage = $request->stage;
        $achievement->score = DB::table('achievement_types')->where([['type', $request->type],['stage', $request->stage], ['result', $request->result],])->value('score');
        $achievement->result = $request->result;
        $achievement->save();
        return redirect('user');
    }
}
