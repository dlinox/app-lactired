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
        Schema::create('proyecciones', function (Blueprint $table) {
            $table->id('proy_id');
            $table->unsignedBigInteger('proy_plan_id');
            $table->char('proy_anio', 4);
            $table->timestamps();
            $table->foreign('proy_plan_id')
                ->references('plan_id')
                ->on('plantas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unique(['proy_plan_id', 'proy_anio'], 'unique_plan_anio');
            $table->index('proy_plan_id', 'idx_plan_proyecciones');
            $table->index('proy_anio', 'idx_anio_proyecciones');
        });

        Schema::create('proyeccion_detalles', function (Blueprint $table) {
            $table->id('proyd_id');
            $table->unsignedBigInteger('proyd_proy_id');
            $table->unsignedBigInteger('proyd_prod_id');
            $table->text('proyd_cantidad_mensual')->nullable();
            $table->timestamps();
            $table->foreign('proyd_proy_id')
                ->references('proy_id')
                ->on('proyecciones');
            $table->foreign('proyd_prod_id')
                ->references('prod_id')
                ->on('productos');
            $table->index(['proyd_proy_id', 'proyd_prod_id'], 'idx_proyeccion_producto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecciones');
        Schema::dropIfExists('proyeccion_detalles');
    }
};
