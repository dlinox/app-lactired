<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    use HasFactory;
    protected $primaryKey = "umed_id";
    protected $fillable = ['umed_nombre', 'umed_simbolo'];

    public $headers =  [
        ['text' => "ID", 'value' => "umed_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "umed_nombre", 'short' => false, 'order' => 'ASC'],
        ['text' => "Simbolo", 'value' => "umed_simbolo", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
