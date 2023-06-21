<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mercado extends Model
{
    use HasFactory;

    protected $primaryKey = "merc_id";
    protected $fillable = [
        'merc_nombre',
    ];

    public $headers =  [
        ['text' => "ID", 'value' => "merc_id", 'short' => false, 'order' => 'ASC'],
        ['text' => "Nombre", 'value' => "merc_nombre", 'short' => false, 'order' => 'ASC'],
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
