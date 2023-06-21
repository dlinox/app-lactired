<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $primaryKey = 'clie_id';
    protected $fillable = [
        'clie_nombres',
        'clie_paterno',
        'clie_materno',
        'clie_tipo_documento',
        'clie_nro_documento',
        'clie_tipo_persona',
        'clie_direccion',
        'clie_telefono',
        'clie_correo',
        'clie_password',
    ];

    protected $casts = [
     
        'clie_password' => 'hashed',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'clie_password'
    ];

    protected static function booted()
    {
        static::creating(function ($cliente) {
            if ($cliente->clie_tipo_documento == 'DNI' || $cliente->clie_tipo_documento == 'CE') {
                $cliente->clie_tipo_persona = '0'; // Persona Natural
            } else {
                $cliente->clie_tipo_persona = '1'; // Persona Jurídica
            }
        });
    }


    public $headers =  [
        ['text' => "ID", 'value' => "clie_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "clie_nombres", 'short' => false, 'order' => 'ASC'],
        ['text' => "Paterno", 'value' => "clie_paterno", 'short' => false, 'order' => 'ASC'],
        ['text' => "Materno", 'value' => "clie_materno", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nro Documento", 'value' => "clie_nro_documento", 'short' => false, 'order' => 'ASC'],
        ['text' => "Telefono", 'value' => "clie_telefono", 'short' => false, 'order' => 'ASC'],
        ['text' => "Correo", 'value' => "clie_correo", 'short' => false, 'order' => 'ASC'],
    ];
}
