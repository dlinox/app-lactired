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
            $table->string('empl_paterno', 100);
            $table->string('empl_materno', 100);
            $table->string('empl_nombres', 100);
            $table->char('empl_dni', 8);
            $table->char('empl_telefono', 9);
            $table->string('empl_email', 100);
            $table->date('empl_fecha_nac');
            $table->enum('empl_sexo', ['M', 'F']);
            $table->date('empl_fecha_inicio_actividad');

            $table->unsignedBigInteger('empl_posi_id');
            $table->unsignedBigInteger('empl_gins_id');
            $table->unsignedBigInteger('empl_prof_id');
            $table->unsignedBigInteger('empl_rdes_id');
            // $table->unsignedBigInteger('status_civil_id');
            // $table->unsignedBigInteger('lives_with_id');
            // $table->unsignedBigInteger('relationship_id');

            $table->timestamps();
            $table->foreign('empl_posi_id')->references('posi_id')->on('posiciones'); //?cargo en la empresa
            $table->foreign('empl_gins_id')->references('gins_id')->on('grado_instrucciones');
            $table->foreign('empl_prof_id')->references('prof_id')->on('profesiones');
            $table->foreign('empl_rdes_id')->references('rdes_id')->on('roles_desempeniados');
            //$table->foreign('status_civil_id')->references('id')->on('status_civils'); //!select simple
            //$table->foreign('lives_with_id')->references('id')->on('lives_withs'); //!tendruia que ser una lista ? 
            // $table->foreign('relationship_id')->references('id')->on('relationships');//!..??

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
