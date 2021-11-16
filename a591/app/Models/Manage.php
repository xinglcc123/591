<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manage extends Model
{
    use HasFactory;
    use SoftDeletes;    //軟刪除

    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     * 可批量分配的屬性。
     * @var string[]
     */
    protected $fillable = [
        'account',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * 應該為序列化隱藏的屬性。
     * @var array
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    //     'two_factor_recovery_codes',
    //     'two_factor_secret',
    // ];

    /**
     * The attributes that should be cast.
     * 應該轉換的屬性。
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    /**
     * The accessors to append to the model's array form.
     * 附加到模型數組形式的訪問器。
     * @var array
     */
    // protected $appends = [
    //     'profile_photo_url',
    // ];
}
