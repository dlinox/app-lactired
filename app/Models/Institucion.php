<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;

    protected $table = "instituciones";
    protected $primaryKey = "inst_id";
    protected $fillable = [
        'inst_nombre',
        'inst_naturaleza',
        'inst_nivel',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "inst_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "inst_nombre", 'short' => false, 'order' => 'ASC'],
        ['text' => "Naturaleza", 'value' => "inst_naturaleza", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nivel", 'value' => "inst_nivel", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
