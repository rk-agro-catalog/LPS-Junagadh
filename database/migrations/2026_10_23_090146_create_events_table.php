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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('category')->default('સામાજિક'); // સામાજિક, ધાર્મિક, યુવા મહોત્સવ, સ્નેહમિલન, આરોગ્ય
            $table->date('event_date');
            $table->string('event_time')->nullable(); // દા.ત. સવારે ૯:૦૦ કલાકે
            $table->string('venue')->default('શ્રી સમસ્ત લેઉવા પટેલ સમાજ સંકુલ, ખલીલપુર ચોકડી પાસે, જૂનાગઢ');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('organizer')->default('શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ');
            $table->string('contact_person')->default('ટ્રસ્ટ કાર્યાલય: 909 33 909 34');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
