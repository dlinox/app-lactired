<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    use HasFactory;

    protected $table = 'ubigeos';
    protected $primaryKey = 'ubig_id';

    protected $fillable = [
        'ubig_cod',
        'ubig_departamento',
        'ubig_provincia',
        'ubig_distrito',
    ];

    protected $appends = ['ubig_completo'];

    public function getUbigCompletoAttribute()
    {
        return $this->ubig_departamento . ', ' . $this->ubig_provincia . ', ' . $this->ubig_distrito;
    }
}
