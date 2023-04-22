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
        if (! Schema::hasTable('bundle_courses')) {
            Schema::create('bundle_courses', function (Blueprint $table) {
                $table->integer('bundle_id')->unsigned();
                $table->foreign('bundle_id')->references('id')->on('bundles')->onDelete('cascade');
                $table->integer('course_id')->unsigned();
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bundle_courses');
    }
};
