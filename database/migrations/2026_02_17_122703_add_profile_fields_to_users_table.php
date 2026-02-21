<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('bio');
            $table->decimal('hourly_rate', 8, 2)->nullable()->after('profile_photo');
            $table->enum('availability', ['full_time', 'part_time'])->nullable()->after('hourly_rate');
            $table->string('resume')->nullable()->after('availability');
            $table->enum('profile_status', ['draft', 'under_review', 'verified', 'rejected', 'suspended'])
                  ->default('draft')->after('resume');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo',
                'hourly_rate',
                'availability',
                'resume',
                'profile_status',
            ]);
        });
    }
};
