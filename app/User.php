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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->token = str_random(30);
        });
    } 

    public function confirmEmail()
    {
        $this->verified = true;
        $this->token = null;
        $this->save();
    }

    public function achievements(){
        return $this->hasMany('App\Achievement', 'user_id', 'id');
    }

    public function place(){
        $users = User::all() -> where('role', 'student');
        foreach ($users as $user){
            $count = $user -> confirmedScore();
            $user -> score = $count;
        }
        $leaders = $users -> sortByDesc('score');
        $i = 0;
        foreach ($leaders as $leader){
            $i++;
            if ($leader->score == $this->confirmedScore()){
                return $i;
            }
        }
    }

    public function percentage(){
        $users = User::all() -> where('role', 'student');
        $minimalAllowedScore = Setting::where('name', 'Минимальный порог баллов для участия')->first()->value;
        $min = $users->first()->confirmedScore();
        $lastUser = $users->first();
        foreach ($users as $user){
            $count = $user -> confirmedScore();
            if ($count>=$minimalAllowedScore){
                if ($count<$min){
                    $min = $count;
                    $lastUser = $user;
                }
            }
            
        }
        $percentage = round(($this->place()) / $lastUser->place() *100);
        return $percentage;
    }

    public function confirmedScore(){
        $mainCategory = Setting::where('name','Главная категория')->value('value');
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
        $mainCategory = Setting::where('name','Главная категория')->value('value');
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
        $mainCategory = Setting::where('name','Главная категория')->value('value');
        $falseCategories = [];
        $achievements = $this->achievements();
        $mainScore = $this->achievements()->where('category', $mainCategory)->sum('score');
        $categories = $achievements->select('category')->distinct()->get();
        foreach ($categories as $category){
            $curScore = $this->achievements()->where('category', $category->category)->sum('score');
            if ($curScore>$mainScore){
                if ($category!=end($categories)){
                    $falseCategories[] = $category->category . ',';
                } else {
                    $falseCategories[] = $category->category;
                }
            }
        }
        return $falseCategories;
    }
}
