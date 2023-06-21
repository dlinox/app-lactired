<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    use HasFactory;

    //protected $table = "tipo_certificaciones";
    protected $primaryKey = "tcom_id";
    protected $fillable = ['tcom_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "tcom_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "tcom_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
