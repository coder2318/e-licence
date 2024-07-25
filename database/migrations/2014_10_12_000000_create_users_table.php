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
            $table->string('username')->nullable();
            $table->string('password');
            $table->string('f_name');
            $table->string('l_name');
            $table->string('s_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('pin', 14);
            $table->string('tin', 9)->nullable();
            $table->string('passport', 9);
            $table->jsonb('data')->nullable();
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
