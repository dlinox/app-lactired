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
        Schema::create('mercado_plantas', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('merc_id');

            $table->timestamps();
            $table->foreign('plan_id')->references('plan_id')->on('plantas');
            $table->foreign('merc_id')->references('merc_id')->on('mercados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mercado_plantas');
    }
};
