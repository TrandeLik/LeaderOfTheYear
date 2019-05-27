<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{


    public function comment(){
        return $this->hasOne('App\Comment', 'comment_id', 'id');
    }
}
