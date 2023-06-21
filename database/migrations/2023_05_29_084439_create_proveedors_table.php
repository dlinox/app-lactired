<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id('prov_id');
            $table->char('prov_dni', 8)->unique();
            $table->string('prov_paterno', 100);
            $table->string('prov_materno', 80);
            $table->string('prov_nombres', 80);
            $table->enum('prov_sexo', ['M', 'F']);
            $table->decimal('prov_precio_alta', 8, 2);
            $table->decimal('prov_precio_baja', 8, 2);
            $table->decimal('prov_latitud', 10, 8)->nullable();
            $table->decimal('prov_longitud', 10, 8)->nullable();
            $table->boolean('prov_activo')->default(1)->comment('0=No 1=SI');
            $table->unsignedBigInteger('prov_plan_id');
            $table->timestamps();
            $table->foreign('prov_plan_id')->references('plan_id')->on('plantas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
