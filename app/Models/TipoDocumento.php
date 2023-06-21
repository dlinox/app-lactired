<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

    //protected $table = "tipo_certificaciones";
    protected $primaryKey = "tdoc_id";
    protected $fillable = ['tdoc_nombre','tdoc_abreviatura'];

    public $headers =  [
        ['text' => "ID", 'value' => "tdoc_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "tdoc_nombre", 'short' => false, 'order' => 'ASC'],
        ['text' => "Abreviatura", 'value' => "tdoc_abreviatura", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
