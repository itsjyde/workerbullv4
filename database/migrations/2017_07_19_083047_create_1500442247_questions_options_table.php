<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('questions_options')) {
            Schema::create('questions_options', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('question_id')->unsigned()->nullable();
                $table->foreign('question_id', '54421_596eee8745a1e')->references('id')->on('questions')->onDelete('cascade');
                $table->text('option_text');
                $table->tinyInteger('correct')->nullable()->default(0);

                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);
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
        Schema::dropIfExists('questions_options');
    }
};
