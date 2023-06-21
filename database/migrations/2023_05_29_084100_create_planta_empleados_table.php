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
        Schema::create('planta_empleados', function (Blueprint $table) {
            $table->id('plem_id');
            $table->boolean("plem_activo")->default(1)->comment("0=NO 1=SI");
            $table->date("plem_fecha_alta")->nullable();
            $table->date("plem_fecha_baja")->nullable();
            $table->boolean("plem_responsable", ['0', '1'])->default(0)->comment("0=NO 1=SI");
            $table->unsignedBigInteger('plem_plan_id');
            $table->unsignedBigInteger('plem_empl_id');
            $table->timestamps();
            $table->foreign('plem_plan_id')->references('plan_id')->on('plantas');
            $table->foreign('plem_empl_id')->references('empl_id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planta_empleados');
    }
};
