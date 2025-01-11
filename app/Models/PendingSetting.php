<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingSetting extends Model
{
    protected $fillable = ['key', 'value'];
}
