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
        if (Schema::hasTable('bhumidans') && ! Schema::hasColumn('bhumidans', 'payment_screenshot')) {
            Schema::table('bhumidans', function (Blueprint $table) {
                $table->string('payment_screenshot')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('bhumidans') && Schema::hasColumn('bhumidans', 'payment_screenshot')) {
            Schema::table('bhumidans', function (Blueprint $table) {
                $table->dropColumn('payment_screenshot');
            });
        }
    }
};
