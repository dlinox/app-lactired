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

            $table->string('plan_barrio_comunidad', 100)->nullable();
            $table->string('plan_sector', 100)->nullable();
            $table->char('plan_latitud', 30)->nullable();
            $table->char('plan_longitud', 30)->nullable();

            $table->boolean('plan_registro_sanitario')->comment("0=NO 1=SI")->default(1);
            $table->boolean('plan_marca_registrada')->comment("0=NO 1=SI")->default(1);
            $table->boolean('plan_tecnificacion')->default(0);
            $table->boolean('plan_parametros_digesa')->comment("0=NO 1=SI")->default(1);
            $table->boolean('plan_parametros_produccion')->comment("0=NO 1=SI")->default(1);
            $table->boolean('plan_capacitacion_tdd')->comment("0=NO 1=SI")->default(1);

            $table->unsignedBigInteger('plan_tcomp_id');
            $table->unsignedBigInteger('plan_ubig_id');
            $table->unsignedBigInteger('plan_ncap_id');
            $table->unsignedBigInteger('plan_cpro_id');
            $table->unsignedBigInteger('plan_inst_id');
            $table->timestamps();

            $table->foreign('plan_tcomp_id')->references('tcomp_id')->on('tipo_companias');
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
