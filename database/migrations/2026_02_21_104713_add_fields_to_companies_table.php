<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('city')->nullable()->after('company_address');
            $table->string('country')->nullable()->after('city');
            $table->string('timezone')->nullable()->after('country');
            $table->string('home_currency')->nullable()->after('timezone');
            $table->string('zip_code', 20)->nullable()->after('home_currency');
            $table->string('website_url')->nullable()->after('zip_code');
        });
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'city',
                'country',
                'timezone',
                'home_currency',
                'zip_code',
                'website_url',
            ]);
        });
    }
};
