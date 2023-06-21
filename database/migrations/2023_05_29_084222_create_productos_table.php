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

        Schema::create('productos', function (Blueprint $table) {
            $table->id('prod_id');
            $table->string('prod_nombre');
            $table->integer('prod_stock');
            $table->float('prod_medida');
            $table->unsignedBigInteger('prod_umed_id');
            $table->unsignedBigInteger('prod_tpro_id');
            $table->unsignedBigInteger('prod_plan_id');
            $table->unique(['prod_nombre','prod_plan_id']);
            $table->timestamps();
            $table->foreign('prod_umed_id')->references('umed_id')->on('unidad_medidas');
            $table->foreign('prod_tpro_id')->references('tpro_id')->on('tipo_productos');
            $table->foreign('prod_plan_id')->references('plan_id')->on('plantas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
