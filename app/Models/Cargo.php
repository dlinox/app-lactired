<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $primaryKey = "carg_id";
    protected $fillable = ['carg_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "carg_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "carg_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
