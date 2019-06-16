<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\User;
use App\AchievementType;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function addType(Request $request){
      $request -> validate([
          'category' => 'required',
          'type' => 'required',
          'stage' => 'required',
          'result' => 'required',
          'score' => 'required'
      ]);
      $newType = new AchievementType();
      $newType -> category = $request -> category;
      $newType -> type = $request -> type;
      $newType -> stage = $request -> stage;
      $newType -> result = $request -> result;
      $newType -> score = $request -> score;
      $newType -> save();
      return redirect('/');
    }
    
    public function showAddType(){
        $stages = ['школьный','окружной','городской','всероссийский'];
        $results = ['победитель','призер'];
        $categories = ['Интеллектуальные соревнования','Проектная и исследовательская деятельность','Спортивные достижения', 'Участие в лицейской жизни','Общественно полезная деятельность на базе лицея'];
        return view('admin/addAchievementType', compact('stages', 'results','categories'));
    }

    public function index(){
        $allTypes = AchievementType::all()->take(20);
        $sentAchievements = Achievement::all() -> where('status', 'sent')->take(5);
        $students = User::all() -> where('role', 'student') ->take(20);
        return view('admin/admin', compact('sentAchievements', 'students', 'allTypes'));
    }

    public function getAllSentAchievements(){
        $sentAchievements = Achievement::all() -> where('status', 'sent');
        return view('admin/allSentAchievements', compact('sentAchievements'));
    }

    public function getAllUsers(){
        $users = User::all() -> where('role', 'student');
        return view('admin/allUsers', compact('users'));
    }

    public function getAllAchievementTypes(){
        $types = AchievementType::all();
        return view('admin/allAchievementTypes', compact('types'));
    }

    public function showBannedUsers(){
        $bannedUsers = User::all() -> where('role', 'banned');
        return view('admin/bannedUsers', compact('bannedUsers'));
    }

    public function aboutUser($id){
        $user = User::findOrFail($id);
        $place = 1;
        $students = User::all() -> where('role', 'student');
        foreach ($students as $student) {
            if ($user -> achievements -> where('status', 'confirmed') -> sum('score') < $student -> achievements -> where('status', 'confirmed') -> sum('score')){
                $place++;
            }
        }

        $confirmedAchievements = $user -> achievements -> where('status', 'confirmed');

        return view('admin/profile', compact('user', 'place', 'confirmedAchievements'));
    }

    public function ban($id){
        $user = User::findOrFail($id);
        if ($user -> role != 'admin') {
            $user -> role = 'banned';
            $user -> save();
        }
        return redirect('/');
    }

    public function unblock($id){
        $user = User::findOrFail($id);
        if ($user -> role != 'admin') {
            $user -> role = 'student';
            $user -> save();
        }
        return redirect('/banned_users');
    }

    public function reject($id){
        $achievement = Achievement::findOrFail($id);
        $achievement -> status = 'rejected';
        $achievement -> save();
        return redirect(url()->previous());
    }

    public function confirm($id){
        $achievement = Achievement::findOrFail($id);
        $achievement -> status = 'confirmed';
        $achievement -> save();
        return redirect('/');
    }
}
