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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_type', 30)->default('public')->index(); // 'public' or 'admin'
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name')->nullable();
            $table->string('user_contact')->nullable();
            $table->string('action', 80)->index(); // 'bhumidan_submitted', 'booking_submitted', 'admin_login', etc.
            $table->text('description');
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('device_type', 30)->default('Desktop')->index(); // 'Mobile', 'Tablet', 'Desktop'
            $table->string('os', 80)->nullable(); // 'Android', 'iOS', 'Windows', 'macOS', 'Linux'
            $table->string('browser', 80)->nullable(); // 'Chrome', 'Safari', 'Firefox', 'Edge'
            $table->string('device_name', 255)->nullable(); // e.g. 'Samsung Galaxy S23 Ultra (SM-S918B)', 'Apple iPhone 15 Pro'
            $table->string('location', 255)->nullable(); // e.g. 'Junagadh, Gujarat, 362001 (Reliance Jio)'
            $table->string('url', 255)->nullable();
            $table->string('method', 10)->default('POST');
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
