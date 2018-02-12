<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeocodeFieldsToGroups extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('groups', function (Blueprint $table) {
            $table->dateTime('last_geocode_attempt_at')->after('longitude')->nullable();
            $table->unsignedInteger('geocode_attempts')->after('longitude')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('groups', function (Blueprint $table) {
            //
        });
    }
}
