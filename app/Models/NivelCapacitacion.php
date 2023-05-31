<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelCapacitacion extends Model
{
    use HasFactory;

    protected $table = "nivel_capacitaciones";
    protected $primaryKey = "ncap_id";
    protected $fillable = ['ncap_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "ncap_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "ncap_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
