<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationAttempt extends Model
{
    protected $fillable = ['user_id', 'code', 'method', 'expires_at', 'pending_setting_id'];
    public $timestamps = false;
}
