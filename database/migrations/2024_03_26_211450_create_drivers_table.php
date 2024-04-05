<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
           //  $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
             //$table->string('password');
            $table->integer('phone_number')->unique();
            $table->string('mother_name');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('address');
            $table->integer('national_number')->unique();
            $table->integer('vacations');
            $table->integer('salary');
            $table->integer('rewards');
            $table->date('employment_date');
            $table->date('resignation_date');
            $table->string('manager_name');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};
