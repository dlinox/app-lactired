<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{
    use HasFactory;
    protected $table = 'profesiones';
    protected $primaryKey = "prof_id";
    protected $fillable = ['prof_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "prof_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "prof_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
