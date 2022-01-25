<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSpec extends Model
{
    protected $table = 'GameSpec';  //重新定義資料表名稱
    public function GameMaster()
    {
        return $this->hasOne('App\Models\GameMaster', 'id', 'id_GameMaster');
        // return $this->belongsToMany('App\Models\GameMaster', 'id', 'id_GameMaster');
    }

}
