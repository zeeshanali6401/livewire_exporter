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
        Schema::create('imports', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('division')->nullable();
            $table->string('email')->nullable();
            $table->string('assigned_table')->nullable();
            $table->string('lucky_draw_blacklist')->nullable();
            $table->string('dietary_prefrences')->nullable();
            $table->string('lucky_draw_number')->nullable();
            $table->string('auth_key')->unique()->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imports');
    }
};
