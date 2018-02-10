<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('groups', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('campus_id')->nullable();
            $table->unsignedInteger('focus_id')->nullable();
            $table->unsignedInteger('life_stage_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('day_of_week')->nullable();
            $table->string('start_time')->nullable();
            $table->string('frequency')->nullable();
            $table->string('contact_first_name')->nullable();
            $table->string('contact_last_name')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->dateTime('first_meeting_at')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('groups');
    }
}