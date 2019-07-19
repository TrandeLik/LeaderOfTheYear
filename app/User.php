<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'form', 'formLetter'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function achievements(){
        return $this->hasMany('App\Achievement', 'user_id', 'id');
    }

    public function place(){
        $users = User::all() -> where('role', 'student');
        foreach ($users as $user){
            $count = $user -> achievements -> where('status', 'confirmed') -> sum('score');
            $user -> score = $count;
        }
        $leaders = $users -> sortByDesc('score');
        $i = 0;
        foreach ($leaders as $leader){
            $i++;
            if ($leader->score == $this->achievements()->where('status','confirmed')->sum('score')){
                return $i;
            }
        }
    }

    public function percentage(){
        $users = User::all() -> where('role', 'student');
        $min = $users->first()->achievements -> where('status', 'confirmed') -> sum('score');
        $lastUser = $users->first();
        foreach ($users as $user){
            $count = $user -> achievements -> where('status', 'confirmed') -> sum('score');
            if ($count<$min){
                $min = $count;
                $lastUser = $user;
            }
        }
        $percentage = round(($this->place()) / $lastUser->place() *100);
        return $percentage;
    }

    public function confirmedScore(){
        $mainCategory = 'Интеллектуальные соревнования';
        $score = 0;
        $achievements = $this->achievements();
        $mainScore = $this->achievements()->where([['category', $mainCategory],['status','confirmed']])->sum('score');
        $categories = $achievements->select('category')->distinct()->get();
        foreach ($categories as $category){
            $curScore = $this->achievements()->where([['category', $category->category],['status','confirmed']])->sum('score');
            $score += min($curScore,$mainScore);
        }
        return $score;
    }

    public function totalScore(){
        $mainCategory = 'Интеллектуальные соревнования';
        $achievements = $this->achievements();
        $score = 0;
        $mainScore = $this->achievements()->where('category', $mainCategory)->sum('score');
        $categories = $achievements->select('category')->distinct()->get();
        foreach ($categories as $category){
            $curScore = $this->achievements()->where('category', $category->category)->sum('score');
            $score += min($curScore,$mainScore);
        }
        return $score;
    }

    public function falseCategories(){
        $mainCategory = 'Интеллектуальные соревнования';
        $falseCategories = [];
        $achievements = $this->achievements();
        $mainScore = $this->achievements()->where('category', $mainCategory)->sum('score');
        $categories = $achievements->select('category')->distinct()->get();
        foreach ($categories as $category){
            $curScore = $this->achievements()->where('category', $category->category)->sum('score');
            if ($curScore>$mainScore){
                $falseCategories[] = $category->category . ',';
            }
        }
        $falseCategories[count($falseCategories)-1] = substr($falseCategories[count($falseCategories)-1],0,-1);
        return $falseCategories;
    }
}
