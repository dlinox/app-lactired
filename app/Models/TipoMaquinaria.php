<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMaquinaria extends Model
{
    use HasFactory;
    protected $primaryKey = "tmaq_id";
    protected $fillable = ['tmaq_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "tmaq_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "tmaq_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
