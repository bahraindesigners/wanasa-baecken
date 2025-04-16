<?php

use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('time');
            $table->string('location')->nullable();
            $table->string('groom_family')->nullable();
            $table->string('groom_name')->nullable();
            $table->string('bride_family')->nullable();
            $table->string('bride_name')->nullable();
            $table->string('status')->default(EventStatus::NOT_STARTED);
            $table->foreignId('wedding_card_id')->constrained()->restrictOnDelete()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete()->restrictOnDelete();
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
