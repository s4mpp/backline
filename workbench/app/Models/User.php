<?php

namespace Workbench\App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class User extends AuthUser
{
    use HasFactory, Notifiable;

    protected $guard_name = 'web';

    protected $casts = [
        'created_at' => 'datetime',
        'password' => 'hashed',
    ];

}
