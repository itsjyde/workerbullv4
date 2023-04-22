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
        if (Schema::hasColumn(config('chatmessenger.threads_table'), 'starred')) {
            Schema::table(config('chatmessenger.threads_table'), function (Blueprint $table) {
                $table->dropColumn('starred');
            });
        }

        if (! Schema::hasColumn(config('chatmessenger.participants_table'), 'starred')) {
            Schema::table(config('chatmessenger.participants_table'), function (Blueprint $table) {
                $table->boolean('starred')->default(false)->after('last_read');
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
        if (! Schema::hasColumn(config('chatmessenger.threads_table'), 'starred')) {
            Schema::table(config('chatmessenger.threads_table'), function (Blueprint $table) {
                $table->boolean('starred')->default(false)->after('id');
            });
        }

        if (Schema::hasColumn(config('chatmessenger.participants_table'), 'starred')) {
            Schema::table(config('chatmessenger.participants_table'), function (Blueprint $table) {
                $table->dropColumn('starred');
            });
        }
    }
};
