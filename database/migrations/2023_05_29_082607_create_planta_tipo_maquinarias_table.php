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
        Schema::create('planta_tipo_maquinarias', function (Blueprint $table) {
            $table->id('ptmaq_id');
            $table->text('ptmaq_observacion');
            $table->unsignedBigInteger('ptmaq_plan_id');
            $table->unsignedBigInteger('ptmaq_tmaq_id');

            $table->timestamps();
            $table->foreign('ptmaq_plan_id')->references('plan_id')->on('plantas');
            $table->foreign('ptmaq_tmaq_id')->references('tmaq_id')->on('tipo_maquinarias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planta_tipo_maquinarias');
    }
};
