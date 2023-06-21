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
        Schema::create('proveedor_precios', function (Blueprint $table) {
            $table->id('ppre_id');
            $table->decimal('ppre_precio', 8, 2);
            $table->boolean('ppre_estado')->comment('0=anulado  1=activo')->default(1);
            $table->unsignedBigInteger('ppre_prov_id');
            $table->foreign('ppre_prov_id')->references('prov_id')->on('proveedores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor_precios');
    }
};
