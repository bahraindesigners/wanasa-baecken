<?php

use Illuminate\Support\Facades\Schema;
use App\Enums\InviteeNotificationStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invitees', function (Blueprint $table) {
            $table->string('reminder_status')->default(InviteeNotificationStatus::PENDING);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitees', function (Blueprint $table) {
            $table->dropColumn('reminder_status');
        });
    }
};
