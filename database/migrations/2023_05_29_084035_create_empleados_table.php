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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id('empl_id');
            $table->string('empl_nombres', 100);
            $table->string('empl_materno', 100)->nullable();
            $table->string('empl_paterno', 100)->nullable();
            $table->char('empl_dni', 8)->unique();
            $table->char('empl_telefono', 9)->unique();
            $table->string('empl_email', 100)->unique();
            $table->date('empl_fecha_nac')->nullable();
            $table->enum('empl_sexo', ['M', 'F'])->nullable();
            $table->date('empl_fecha_inicio_actividad')->nullable();

            $table->unsignedBigInteger('empl_gins_id')->nullable();
            $table->unsignedBigInteger('empl_prof_id')->nullable();
            $table->unsignedBigInteger('empl_carg_id')->nullable();

            $table->timestamps();

            $table->foreign('empl_carg_id')->references('carg_id')->on('cargos');
            $table->foreign('empl_gins_id')->references('gins_id')->on('grado_instrucciones');
            $table->foreign('empl_prof_id')->references('prof_id')->on('profesiones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
