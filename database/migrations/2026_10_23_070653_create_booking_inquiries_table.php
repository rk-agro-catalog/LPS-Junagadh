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
        Schema::create('booking_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('inquiry_number')->unique();
            $table->string('applicant_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('city_or_village')->nullable();
            $table->string('section_type'); // વિભાગ-૧ / વિભાગ-૨ / અતિથિ ભવન
            $table->string('facility_name'); // પાર્ટી પ્લોટ, બેન્કવેટ હોલ, ભોજનાલય, રૂમ
            $table->string('event_type'); // લગ્ન પ્રસંગ, સગાઈ, મધ્યમ વર્ગ શુભ પ્રસંગ, સામાજિક સભા
            $table->date('event_date');
            $table->date('end_date')->nullable();
            $table->unsignedInteger('approx_guests')->default(100);
            $table->unsignedInteger('required_rooms')->default(0);
            $table->enum('status', ['new', 'in_review', 'confirmed', 'rejected'])->default('new');
            $table->text('user_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_inquiries');
    }
};
