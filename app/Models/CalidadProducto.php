<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalidadProducto extends Model
{
    use HasFactory;
    //protected $table = "";
    protected $primaryKey = "cpro_id";
    protected $fillable = ['cpro_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "cpro_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "cpro_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
