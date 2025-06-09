<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('producto_insumos');
        Schema::create('producto_insumos', function (Blueprint $table) {
            $table->id('pinsu_id');
            $table->unsignedBigInteger('pinsu_prod_id');
            $table->unsignedBigInteger('pinsu_insu_id');
            $table->unsignedBigInteger('pinsu_umed_id');
            $table->integer('pinsu_cantidad')->default(0);
            $table->decimal('pinsu_precio', 8, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('pinsu_prod_id')->references('prod_id')->on('productos')->onDelete('cascade');
            $table->foreign('pinsu_insu_id')->references('insu_id')->on('insumos')->onDelete('restrict');
            $table->foreign('pinsu_umed_id')->references('umed_id')->on('unidad_medidas')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto_insumos');
    }
};
