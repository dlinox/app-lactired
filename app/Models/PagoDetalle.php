<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoDetalle extends Model
{
    use HasFactory;

    protected $primaryKey = 'pdet_id';
    public $timestamps = true;

    protected $fillable = [
        'pdet_comp_id',
        'pdet_pago_id',
    ];
}
