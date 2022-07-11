<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    
     // Userテーブルとのリレーション （従テーブル側）
     public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
     // Userテーブルとの多対多リレーション
     public function members() {
        return $this->belongsToMany('App\Models\User')->withPivot('role');
    }
    
}
