<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantaTipoFinanciacion extends Model
{
    use HasFactory;
    //protected $table = "";
    protected $primaryKey = "tfin_id";
    protected $fillable = ['tfin_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "tfin_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "tfin_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
