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
        Schema::create('compras', function (Blueprint $table) {
            $table->id('comp_id');
            $table->char('comp_serie', 4)->nullable();
            $table->char('comp_numero', 10)->nullable();
            $table->char('comp_correlativo', 15)->nullable();
            $table->date('comp_fecha');

            $table->decimal('comp_subtotal', 8, 2);
            $table->decimal('comp_total', 8, 2);
            $table->decimal('comp_importe', 8, 2)->nullable();
            $table->decimal('comp_igv', 8, 2)->nullable();

            $table->boolean('comp_estado')->default(1)->comment('0=anulado  1=activo');
            
            $table->boolean('comp_tipo_pago')->default(1)->comment('0=al contado  1=al credito');

            $table->boolean('comp_tipo')->default(1)->comment('0=recoleccion  1=Normal');
            $table->boolean('comp_estado_deuda')->default(0)->comment('0=en deuda  1=pagado');
            $table->string("comp_imagen", 100)->nullable();

            $table->unsignedBigInteger('comp_plan_id');
            $table->unsignedBigInteger('comp_prov_id');

            $table->enum('comp_tipo_comprobante',  ['FACTURA', 'BOLETA', 'NOTA DE CREDITO', 'NOTA DE DEBITO', 'RECIBO POR HONORARIOS', 'GUIA DE REMISION']);
            $table->unique(['comp_serie', 'comp_numero', 'comp_plan_id']);

            $table->timestamps();
            $table->foreign('comp_prov_id')->references('prov_id')->on('proveedores');
            $table->foreign('comp_plan_id')->references('plan_id')->on('plantas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
