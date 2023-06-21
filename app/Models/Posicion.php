<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posicion extends Model
{
    use HasFactory;
    protected $table = 'posiciones';
    protected $primaryKey = "posi_id";
    protected $fillable = ['posi_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "posi_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "posi_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
