<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    use HasFactory;

    protected $primaryKey = "tpro_id";
    protected $fillable = ['tpro_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "tpro_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "tpro_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
