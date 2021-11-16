<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    use HasFactory;
    use SoftDeletes;    //軟刪除
    
    protected $dates = ['deleted_at'];


    //ORM方式新增白名單欄位
    protected $fillable = [
        'post_id',
        'title',
        'price',
        'community',
        'photo_list',
        'rent_tag',
        'role_name',
        'contact',
        'area',
        'floor_str',
        'kind_name',
        'room_str',
        'refresh_time',
        'location',
        'section_name',
        'street_name',
        'desc',
        'distance',
        'yesterday_hit',
        'created_at',
        'updated_at',
    ];

    //ORM方式新增黑名單欄位
    // protected $guarded = [

    // ];
    
    //撈資料排除欄位
    // protected $hidden = [
    //     'created_at',
    //     'updated_at',
    // ];

}
