<?php

namespace App\Http\Controllers;
use Faker\Provider\File;
use Illuminate\Support\Facades\DB;
use App\Achievement;
use App\User;
use App\Comment;
use App\Setting;
use App\AchievementType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{ 
    public function index(){
        $achievements = Auth::user()->achievements;
        $isStatisticsWorking = Setting::where('name', 'Статистика')->first()->value == 'on';
        $confirmedScore = Auth::user()->confirmedScore();
        $totalScore = Auth::user()->totalScore();
        $place = Auth::user()->place();
        $falseCategories = Auth::user()->falseCategories();
        $percentage = Auth::user()->percentage();
        $mainCategory = Setting::where('name','Главная категория')->value('value');

        $confirmedAchievements = [];
        $createdAchievements = [];
        $rejectedAchievements = [];
        $sentAchievements = [];

        foreach ($achievements as $achievement) {
            if ($achievement->status == 'confirmed') {
                $confirmedAchievements[] = $achievement;
            };
            if ($achievement->status == 'created') {
                $createdAchievements[] = $achievement;
            };
            if ($achievement->status == 'rejected') {
                $rejectedAchievements[] = $achievement;
            };
            if ($achievement->status == 'sent') {
                $sentAchievements[] = $achievement;
            }
        }

        return view('user.index', compact('achievements','confirmedScore',
                'totalScore','place', 'percentage','falseCategories','mainCategory',
                'isStatisticsWorking', 'confirmedAchievements', 'createdAchievements',
                'rejectedAchievements', 'sentAchievements'
            ));
    }

    public function addView(){
        $areCommentsWorking = Setting::where('name', 'Возможность комментировать (для учеников)')->first()->value == 'on';
        $achievement_types = AchievementType::all();
        $isUploadingConfirmationsPossible = Setting::where('name', 'Загрузка файлов с подтверждением')->first()->value == 'on';
        $categories = AchievementType::select('category')->distinct()->get();
        return view('user.addAchievement',compact('categories','achievement_types', 'isUploadingConfirmationsPossible', 'areCommentsWorking'));
    }

    public function addAchievement(Request $request){
        $request->validate([
            'category' => 'required',
            'type' => 'required',
            'name' => 'required',
            'subject' => 'required',
            'stage' => 'required',
            'result' => 'required',
        ]);
        $name = '';
        if ($request -> has('file')) {
            $mimeTypes = [
                'application/pdf',
                'image/jpeg',
                'image/pjpeg',
                'image/x-jps',
                'image/png'
            ];
            if (in_array(request()->file->getClientMimeType(), $mimeTypes)) {
                $name = time() . '_' . $request->file->getClientOriginalName();
                $request->file->move(storage_path('confirmations'), $name);
            } else {
                $error = 'Данный тип файлов загрузить нельзя :(';
                return view('general.error', compact('error'));
            }
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
        $areCommentsWorking = Setting::where('name', 'Возможность комментировать (для учеников)')->first()->value == 'on';
        if ($areCommentsWorking) {
            if (isset($request->comment)) {
                $comment = new Comment;
                $comment->achievement_id = Achievement::all()->last()->value('id');
                $comment->text = $request->comment;
                $comment->author = Auth::user()->id;
                $comment->save();
            }
        }
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
        $isUploadingConfirmationsPossible = Setting::where('name', 'Загрузка файлов с подтверждением')->first()->value == 'on';
        $areCommentsWorking = Setting::where('name', 'Возможность комментировать (для учеников)')->first()->value == 'on';
        return view('user.editAchievement',compact('types','stages','results','achievement','categories','achievement_types', 'isUploadingConfirmationsPossible', 'areCommentsWorking'));
    }

    public function edit($id, Request $request){
        $request->validate([
            'category' => 'required',
            'type' => 'required',
            'name' => 'required',
            'subject' => 'required',
            'stage' => 'required',
            'result' => 'required',
        ]);
        $achievement = Achievement::findOrFail($id);
        if ($request -> has('file')) {
            $mimeTypes = [
                'application/pdf',
                'image/jpeg',
                'image/pjpeg',
                'image/x-jps',
                'image/png'
            ];
            if (in_array(request()->file->getClientMimeType(), $mimeTypes)) {
                $name = time() . '_' . $request->file->getClientOriginalName();
                $request->file->move(storage_path('confirmations'), $name);
                $achievement->confirmation = $name;
            } else {
                $error = 'Данный тип файлов загрузить нельзя :(';
                return view('general.error', compact('error'));
            }
        }

        $achievement->name = $request->name;
        $achievement->category = $request->category;
        $achievement->type = $request->type;
        $achievement->subject = $request->subject;
        $achievement->stage = $request->stage;
        $achievement->score = DB::table('achievement_types')->where([['type', $request->type],['stage', $request->stage], ['result', $request->result],])->value('score');
        $achievement->result = $request->result;
        $achievement->save();
        $areCommentsWorking = Setting::where('name', 'Возможность комментировать (для учеников)')->first()->value == 'on';
        if ($areCommentsWorking) {
            if (isset($request->comment)) {
                $comment = new Comment;
                $comment->achievement_id = $id;
                $comment->text = $request->comment;
                $comment->author = Auth::user()->id;
                $comment->save();
            }
        }
        return redirect('user');
    }
}
