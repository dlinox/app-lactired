<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCompania extends Model
{
    use HasFactory;
    protected $primaryKey = "tcomp_id";
    protected $fillable = ['tcomp_nombre'];

    public $headers =  [
        ['text' => "ID", 'value' => "tcomp_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "tcomp_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
