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
            $table->unsignedInteger('campus_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('demographic_id');
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
            $table->dateTime('started_at')->nullable();
            $table->dateTime('expired_at')->nullable();
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

// tables/Contacts?$Filter=(Contact_ID=1 OR Contact_ID=2)&$Top=5
// tables/Groups?$Filter=(Group_Type_ID=1 )&$Top=5&$Select=Groups.Group_Name, Primary_Contact_Table.First_Name, Primary_Contact_Table.Last_Name

// tables/Groups?$Filter=(Group_Type_ID=1 )&$Top=5&$Select=Groups.Group_Name, Groups.Group_ID, Primary_Contact_Table.First_Name, Primary_Contact_Table.Last_Name, Primary_Contact_Table.User_Account
// tables/Groups?$Filter=(Group_Type_ID=1 )&$Top=20&$Select=Groups.Group_Name, Groups.Group_ID, Primary_Contact_Table.First_Name, Primary_Contact_Table.Last_Name, Primary_Contact_Table.User_Account