<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proveedor_empleados', function (Blueprint $table) {
            $table->id('prem_id');
            $table->unsignedBigInteger('prem_prov_id');
            $table->unsignedBigInteger('prem_empl_id');
            $table->foreign('prem_prov_id')->references('prov_id')->on('proveedores');
            $table->foreign('prem_empl_id')->references('empl_id')->on('empleados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor_empleados');
    }
    
};
