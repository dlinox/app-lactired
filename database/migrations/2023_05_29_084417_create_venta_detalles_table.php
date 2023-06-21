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
        Schema::create('venta_detalles', function (Blueprint $table) {
            $table->id('vdet_id');
            $table->integer('vdet_cantidad');
            $table->decimal('vdet_precio', 8, 2);
            $table->decimal('vdet_importe', 8, 2);
            $table->unsignedBigInteger('vdet_vent_id');
            $table->unsignedBigInteger('vdet_prod_id');
            $table->timestamps();
            $table->foreign('vdet_vent_id')->references('vent_id')->on('ventas');
            $table->foreign('vdet_prod_id')->references('prod_id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_detalles');
    }
};
