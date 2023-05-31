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
        Schema::create('planta_tipo_movilidades', function (Blueprint $table) {
            $table->id('ptmob_id');

            $table->smallinteger('ptmov_cantidad');
            $table->enum('ptmov_condicion',['1','2','3'])->comment("1=propia 2=prestado 3=alquilado");
            $table->unsignedBigInteger('ptmov_plan_id');
            $table->unsignedBigInteger('ptmov_tmov_id');

            $table->timestamps();
            $table->foreign('ptmov_plan_id')->references('plan_id')->on('plantas');
            $table->foreign('ptmov_tmov_id')->references('tmov_id')->on('tipo_movilidades');
   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planta_tipo_movilidades');
    }
};
