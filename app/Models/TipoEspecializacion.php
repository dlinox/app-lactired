<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEspecializacion extends Model
{
    use HasFactory;

    protected $table = "tipo_especializaciones";
    protected $primaryKey = "tesp_id";
    protected $fillable = ['tesp_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "tesp_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "tesp_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
