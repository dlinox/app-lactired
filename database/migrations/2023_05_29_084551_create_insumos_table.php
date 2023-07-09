<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Eliminar Recurso.
     */
    public function up(): void
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->id('insu_id');
            $table->string('insu_nombre');
            $table->integer('insu_stock');
            $table->float('insu_medida');
            $table->boolean('insu_leche')->default(0)->comment('0=No es leche  1=Es leche');
            $table->unsignedBigInteger('insu_umed_id');
            $table->unsignedBigInteger('insu_plan_id');
            $table->string('insu_imagen')->nullable();

            $table->unique(['insu_nombre', 'insu_plan_id']);
            $table->timestamps();
            $table->foreign('insu_umed_id')->references('umed_id')->on('unidad_medidas');
            $table->foreign('insu_plan_id')->references('plan_id')->on('plantas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
