<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrigenAgua extends Model
{
    use HasFactory;

    protected $primaryKey = "oagu_id";
    protected $fillable = ['oagu_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "oagu_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "oagu_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
