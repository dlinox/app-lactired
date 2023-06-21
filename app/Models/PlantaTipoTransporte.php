<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantaTipoTransporte extends Model
{
    use HasFactory;

    protected $primaryKey = "ttra_id";
    protected $fillable = ['ttra_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "ttra_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "ttra_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
