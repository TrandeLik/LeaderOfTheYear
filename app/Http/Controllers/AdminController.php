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
          'type' => 'required',
          'stage' => 'required',
          'result' => 'required',
          'score' => 'required'
      ]);
      $newType = new AchievementType();
      $newType -> type = $request -> type;
      $newType -> stage = $request -> stage;
      $newType -> result = $request -> result;
      $newType -> score = $request -> score;
      $newType -> save();
      return redirect('/');
    }
    
    public function showAddType(){
      return view('admin/addAchievementType');
    }

    public function index(Request $request){
        $allTypes = AchievementType::all();
        $sentAchievements = Achievement::all() -> where('status', 'sent');
        $students = User::all() -> where('role', 'student');
        return view('admin/admin', compact('sentAchievements', 'students', 'allTypes'));
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
