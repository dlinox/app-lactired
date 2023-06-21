<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEmpresa extends Model
{
    use HasFactory;
    protected $primaryKey = "temp_id";
    protected $fillable = ['temp_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "temp_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "temp_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
