<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('inversiones');
        Schema::create('inversiones', function (Blueprint $table) {
            $table->id('inver_id');
            $table->unsignedBigInteger('inver_plan_id');
            $table->string('inver_rubro');
            $table->decimal('inver_valor_unitario', 10, 2);
            $table->integer('inver_cantidad');
            $table->decimal('inver_total', 12, 2)->storedAs('inver_valor_unitario * inver_cantidad');
            $table->enum('inver_tipo', ['Activo Fijo', 'Capital de Trabajo']);
            $table->char('inver_periodo', 7)->nullable()->comment('Formato: YYYY-MM');
            $table->timestamps();
            $table->foreign('inver_plan_id')->references('plan_id')->on('plantas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inversiones');
    }
};
