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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_code')->unique();
            $table->string('full_name');
            $table->string('father_or_husband_name')->nullable();
            $table->string('surname')->default('પટેલ');
            $table->string('gender')->default('male');
            $table->date('birth_date')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('native_village')->nullable();
            $table->text('current_address')->nullable();
            $table->string('city')->default('જૂનાગઢ');
            $table->string('pincode')->nullable();
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('occupation')->nullable();
            $table->unsignedInteger('family_members_count')->default(1);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
