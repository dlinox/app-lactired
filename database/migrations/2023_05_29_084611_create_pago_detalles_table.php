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
        Schema::create('pago_detalles', function (Blueprint $table) {
            $table->id('pdet_id');
            $table->unsignedBigInteger('pdet_comp_id');
            $table->unsignedBigInteger('pdet_pago_id');
            $table->timestamps();
            $table->foreign('pdet_comp_id')->references('comp_id')->on('compras');
            $table->foreign('pdet_pago_id')->references('pago_id')->on('pagos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_detalles');
    }
};
