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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('paterno', 60);
            $table->string('materno', 60);
            $table->char('dni', 8)->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_photo_path', 255)->nullable();

            $table->string('user_plan_nombre', 255)->nullable();
            $table->string('rol_name', 80)->nullable();

            $table->unsignedBigInteger('user_plan_id');
            $table->foreign('user_plan_id')->references('plan_id')->on('plantas');
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
