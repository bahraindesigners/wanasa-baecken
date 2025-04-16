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
        Schema::table('wedding_cards', function(Blueprint $table) {
            $table->boolean('has_names')->default(false);

            $table->string('names_font_id')->nullable()->change();
            $table->integer('names_font_size')->nullable()->change();
            $table->string('names_font_weight')->nullable()->change();
            $table->string('names_color')->nullable()->change();
            $table->integer('names_position_x')->nullable()->change();
            $table->integer('names_position_y')->nullable()->change();

            $table->integer('has_time_location')->default(false);

            $table->string('time_location_font_id')->nullable()->change();
            $table->integer('time_location_font_size')->nullable()->change();
            $table->string('time_location_font_weight')->nullable()->change();
            $table->string('time_location_color')->nullable()->change();
            $table->integer('time_position_x')->nullable()->change();
            $table->integer('time_position_y')->nullable()->change();
            $table->integer('location_position_x')->nullable()->change();
            $table->integer('location_position_y')->nullable()->change();
            $table->integer('date_position_x')->nullable()->change();
            $table->integer('date_position_y')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
