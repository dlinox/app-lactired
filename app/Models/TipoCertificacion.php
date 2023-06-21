<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCertificacion extends Model
{
    use HasFactory;

    protected $table = "tipo_certificaciones";
    protected $primaryKey = "tcer_id";
    protected $fillable = ['tcer_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "tcer_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "tcer_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
