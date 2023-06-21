<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'name',
        'paterno',
        'materno',
        'dni',
        'email',
        'password',
        'profile_photo_path',
        'user_plan_id',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "name", 'short' => false, 'order' => 'ASC'],
        ['text' => "Paterno", 'value' => "paterno", 'short' => false, 'order' => 'ASC'],
        ['text' => "Materno", 'value' => "materno", 'short' => false, 'order' => 'ASC'],
        ['text' => "Coreo", 'value' => "email", 'short' => false, 'order' => 'ASC'],
        ['text' => "DNI", 'value' => "dni", 'short' => false, 'order' => 'ASC'],
    ];
}
