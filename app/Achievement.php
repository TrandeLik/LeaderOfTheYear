<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'achievements';

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\Comment', 'comment_id', 'id');
    }

    public function allowAdd(){
        $mainCategory = 'Интеллектуальные соревнования';
        if ($this->category == $mainCategory){
            return true;
        } else {
            $mainScore = Achievement::where([['user_id',$this->user_id], ['category',$mainCategory]])->sum('score');
            $currentCategoryScore = Achievement::where([['user_id',$this->user_id], ['category',$this -> category]])->sum('score') + $this -> score;
            if ($mainScore >= $currentCategoryScore){
                return true;
            } else {
                return false;
            }
        } 
    }

    public function allowDelete(){
        $mainCategory = 'Интеллектуальные соревнования';
        if ($this->category!=$mainCategory){
            return true;
        } else {
            $mainScore = Achievement::where([['user_id',$this->user_id], ['category',$mainCategory],['id','!=',$this->id]])->sum('score')-$this->score;
            $categories = Achievement::select('category')->where('user_id',$this->user_id)->distinct()->get();
            foreach ($categories as $category){
                $currentCategoryScore = Achievement::where([['user_id',$this->user_id], ['category',$category]])->sum('score');
                if ($mainScore < $currentCategoryScore){
                    return false;
                }
            }
            return true;
        }   
    }

    /*public function allowEdit($oldVersion){
        $mainCategory = 'Интеллектуальные соревнования';
        if ($this->category==$mainCategory){
            return true;
        } else {
            $mainScore = Achievement::where([['user_id',$this->user_id], ['category',$mainCategory]])->sum('score');
            if ($oldVersion -> category == $mainCategory){
                $mainScore -= $oldVersion -> score;
            }
            $categories = Achievement::select('category')->where('user_id',$this->user_id)->distinct()->get();
            foreach ($categories as $category){
                $currentCategoryScore = Achievement::where([['user_id',$this->user_id], ['category',$category]])->sum('score');
                if ($category == $oldVersion -> category){
                    $currentCategoryScore -= $oldVersion -> score;
                }
                if ($category == $this -> category){
                    $currentCategoryScore += $this -> score;
                }
                if ($mainScore < $currentCategoryScore){
                    return false;
                }
            }
            return true;
        }   
    }*/
}
