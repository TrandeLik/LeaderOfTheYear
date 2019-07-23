<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table='comments';

    public function achievement(){
        return $this->hasOne('App\Achievement', 'id', 'achievement_id');
    }
}
