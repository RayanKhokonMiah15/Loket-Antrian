<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('number')->after('display_number')->nullable();
        });

        // Update existing records
        DB::statement('UPDATE tickets SET number = CAST(SUBSTRING(display_number, 2) AS UNSIGNED)');
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
};
