<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name', 'company', 'email', 'phone', 'country',
        'pole', 'budget', 'message', 'status',
    ];
}
