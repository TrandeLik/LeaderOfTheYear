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
        $leaders = [];
        $users = User::all() -> where('role', 'student');
        foreach ($users as $user){
            $count = $user -> achievements -> where('status', 'confirmed') -> sum('score');
            $leaders[$user->id] = $count;
        }
        asort($leaders);
        $i = count($leaders)+1;
        foreach ($leaders as $user => $score){
            $i--;
            if ($score == Auth::user()->achievements()->where('status','confirmed')->sum('score')){
                return $i;
            }
        }
    }
}
