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
        Schema::create('ubigeos', function (Blueprint $table) {
            $table->id('ubig_id');
            $table->char('ubig_cod', 6)->unique();
            $table->string('ubig_departamento', 100);
            $table->string('ubig_provincia', 100);
            $table->string('ubig_distrito', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubigeos');
    }
};
