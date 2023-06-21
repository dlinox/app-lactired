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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('vent_id');
            $table->char('vent_serie', 4);
            $table->char('vent_numero', 10);
            $table->char('vent_correlativo', 15)->nullable();
            $table->date('vent_fecha');
            $table->decimal('vent_subtotal', 8, 2);
            $table->decimal('vent_total', 8, 2);
            $table->decimal('vent_importe', 8, 2)->nullable();
            $table->boolean('vent_estado')->default(1)->comment('0=anulado  1=activo');
            $table->boolean('vent_tipo_pago')->default('0')->comment('0=al contado  1=al credito');
            
            $table->unsignedBigInteger('vent_clie_id');
            $table->unsignedBigInteger('vent_plan_id');
            $table->enum('vent_tipo_comprobante', ['FACTURA', 'BOLETA', 'NOTA DE CREDITO', 'NOTA DE DEBITO', 'RECIBO POR HONORARIOS', 'GUIA DE REMISION']);
            $table->unique(['vent_serie', 'vent_numero', 'vent_plan_id']);
            $table->timestamps();
            $table->foreign('vent_clie_id')->references('clie_id')->on('clientes');
            $table->foreign('vent_plan_id')->references('plan_id')->on('plantas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
