<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolDesempenio extends Model
{
    use HasFactory;
    protected $table = 'roles_desempeniados';
    protected $primaryKey = "rdes_id";
    protected $fillable = ['rdesnombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "rdes_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "rdes_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
