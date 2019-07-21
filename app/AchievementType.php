<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AchievementType extends Model
{
    protected $table = 'achievement_types';
    protected $fillable = ['category','type', 'stage','result','score'];
}
