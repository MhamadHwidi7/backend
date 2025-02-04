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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('national_id')->unique();
            $table->string('name');

            $table->string('password');
            $table->integer('phone_number')->unique();
            $table->string('gender');
            $table->integer('mobile')->unique();
            $table->string('address');
            $table->string('address_detail');
            $table->string('notes')->nullable();
            $table->string('added_by');
            $table->text('device_token')->nullable();

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
        Schema::dropIfExists('customers');
    }
};
