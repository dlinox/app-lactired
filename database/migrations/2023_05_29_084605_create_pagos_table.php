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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('pago_id');
            $table->char('pago_numero', 10)->nullable();
            $table->decimal('pago_monto', 8, 2);
            $table->date('pago_fecha');
            $table->boolean('pago_estado')->comment('0=anulado  1=activo')->default(1);
            $table->string('pago_ticket', 50)->nullable();
            $table->unsignedBigInteger('pago_prov_id');
            $table->unsignedBigInteger('pago_plan_id');
            $table->timestamps();
            $table->foreign('pago_prov_id')->references('prov_id')->on('proveedores');
            $table->foreign('pago_plan_id')->references('plan_id')->on('plantas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
