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
        Schema::create('bhumidans', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();
            $table->string('donor_name');
            $table->string('donor_name_gujarati')->nullable();
            $table->string('father_or_husband_name')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('village')->nullable();
            $table->string('city')->default('જૂનાગઢ');
            $table->unsignedInteger('sq_yards')->default(1);
            $table->decimal('rate_per_yard', 10, 2)->default(2500.00);
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_method')->default('UPI');
            $table->string('transaction_id')->nullable();
            $table->string('pan_number')->nullable();
            $table->enum('status', ['pending', 'verified', 'completed'])->default('verified');
            $table->boolean('is_featured')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bhumidans');
    }
};
