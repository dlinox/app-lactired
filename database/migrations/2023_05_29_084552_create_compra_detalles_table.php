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
        Schema::create('compra_detalles', function (Blueprint $table) {
        
            $table->id('cdet_id');
            $table->integer('cdet_cantidad');
            $table->decimal('cdet_precio', 8, 2);
            $table->decimal('cdet_importe', 8, 2);
            $table->unsignedBigInteger('cdet_comp_id');
            $table->unsignedBigInteger('cdet_insu_id');
            $table->timestamps();
            $table->foreign('cdet_comp_id')->references('comp_id')->on('compras');
            $table->foreign('cdet_insu_id')->references('insu_id')->on('insumos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compra_detalles');
    }
};
