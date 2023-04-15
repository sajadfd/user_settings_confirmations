<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_setting_id',
        'code',
        'expiry_time',
        'confirmation_method',
        'is_success',
    ];

    public function userSetting()
    {
        return $this->belongsTo(UserSetting::class);
    }
}
