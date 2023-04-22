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
        Schema::create(config('chatmessenger.threads_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('starred')->default(0);
            $table->string('subject')->nullable();
            $table->string('slug')->nullable()->comment('Unique slug for social media sharing. MD5 hashed string');
            $table->integer('max_participants')->nullable()->comment('Max number of participants allowed');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('avatar')->nullable()->comment('Profile picture for the conversation');
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
        Schema::dropIfExists(config('chatmessenger.threads_table'));
    }
};
