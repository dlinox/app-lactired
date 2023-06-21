<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorEmpleado extends Model
{
    use HasFactory;


    protected $table = 'proveedor_empleados';
    protected $primaryKey = 'prem_id';
    protected $fillable = [
        
        'prem_prov_id', 
        'prem_empl_id', 
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'prem_prov_id', 'prov_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'prem_empl_id', 'empl_id');
    }
}
