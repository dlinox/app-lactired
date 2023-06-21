<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMovilidad extends Model
{
    use HasFactory;

    protected $table = "tipo_movilidades";
    protected $primaryKey = "tmov_id";
    protected $fillable = ['tmov_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "tmov_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "tmov_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
