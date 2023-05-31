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
        Schema::create('plantas', function (Blueprint $table) {
            $table->id('plan_id');
            $table->text('plan_razon_social');
            $table->char('plan_ruc', 11)->unique();
            $table->string('plan_marca', 100)->nullable();
            $table->enum('plan_tipo_planta', ['A', 'B', 'C'])->default('A');
            $table->enum('plan_registro_sanitario', ['0', '1'])->comment("0=NO 1=SI")->default('1');
            $table->enum('plan_marca_registrada', ['0', '1'])->comment("0=NO 1=SI")->default('1');
            $table->string('plan_barrio_comunidad', 100)->nullable();
            $table->string('plan_sector', 100)->nullable();
            $table->string('plan_latitud', 100)->nullable();
            $table->string('plan_longitud', 100)->nullable();
            $table->smallInteger('plan_tecnificacion')->nullable();
            $table->enum('plan_parametros_digesa', ['0', '1'])->comment("0=NO 1=SI")->default('1');
            $table->enum('plan_parametros_produccion', ['0', '1'])->comment("0=NO 1=SI")->default('1');
            $table->enum('plan_capacitacion_tdd', ['0', '1'])->comment("0=NO 1=SI")->default('1');

            $table->unsignedBigInteger('plan_tcom_id');
            $table->unsignedBigInteger('plan_ubig_id');
            $table->unsignedBigInteger('plan_ncap_id');
            $table->unsignedBigInteger('plan_cpro_id');
            $table->unsignedBigInteger('plan_inst_id');
            $table->timestamps();

            $table->foreign('plan_tcom_id')->references('tcom_id')->on('tipo_companias');
            $table->foreign('plan_ubig_id')->references('ubig_id')->on('ubigeos');
            $table->foreign('plan_ncap_id')->references('ncap_id')->on('nivel_capacitaciones');
            $table->foreign('plan_cpro_id')->references('cpro_id')->on('calidad_productos');
            $table->foreign('plan_inst_id')->references('inst_id')->on('instituciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantas');
    }
};
