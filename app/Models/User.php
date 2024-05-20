<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $primaryKey = 'email';
    protected $keyType = 'string';
    protected $fillable = [
        'username',
        'email',
        'password',
        'noTelp',
        'tanggal',
        'image',
        'active',
    ];
    public $timestamps = false;
}
