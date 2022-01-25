<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameMaster extends Model
{
    protected $table = 'GameMaster';  //重新定義資料表名稱
    public function GameSpec()
    {
        return $this->hasOne('App\Models\GameSpec', 'id_GameMaster', 'id'); //<模型名稱>，<目標模型的外鍵名稱>，<模型關聯鍵名稱>
        // return $this->belongsToMany('App\Models\GameSpec', 'id_GameMaster', 'id');
        // return $this->belongsTo('User::class', 'id_GameMaster', 'id');
    }
    
    public function CategoryMaster()
    {
        // return $this->hasMany('App\Models\CategoryMaster', 'id', 'id_GameMaster');
    }

    public function GameCategory()
    {
        return $this->hasMany('App\Models\GameCategory', 'id_GameMaster', 'id');
    }
}
