<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradoInstruccion extends Model
{
    use HasFactory;
    protected $table = 'grado_instrucciones';
    protected $primaryKey = "gins_id";
    protected $fillable = ['gins_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "gins_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "gins_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
