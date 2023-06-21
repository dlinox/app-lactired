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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('clie_id');
            $table->string('clie_nombres', 200);
            $table->string('clie_paterno', 50)->nullable();
            $table->string('clie_materno', 50)->nullable();
            $table->enum('clie_tipo_documento', ['RUC', 'DNI', 'CE']);
            $table->char('clie_nro_documento', 12)->unique();
            $table->enum('clie_tipo_persona', ['0', '1'])->comment("0=Persona Natural  1=Persona Juridica");
            $table->string('clie_direccion', 100);
            $table->char('clie_telefono', 9)->unique();
            $table->string('clie_correo', 100)->unique();
            $table->string('clie_password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
