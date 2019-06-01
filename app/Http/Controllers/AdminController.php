<?php

namespace App\Http\Controllers;

use App\Achievement;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $sentAchievements = Achievement::all() -> where('status', 'sent');
        return view('admin', compact('sentAchievements'));
    }

    public function reject($id){
        $achievement = Achievement::findOrFail($id);
        $achievement -> status = 'rejected';
        $achievement -> save();
        return redirect('/');
    }

    public function confirm($id){
        $achievement = Achievement::findOrFail($id);
        $achievement -> status = 'confirmed';
        $achievement -> save();
        return redirect('/');
    }
}
