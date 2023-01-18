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
        Schema::table('food_package', function (Blueprint $table) {
            $table->dropColumn('retrived_at');
            $table->string('retrieved_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('food_package', function (Blueprint $table) {
            $table->dropColumn('retrieved_at');
            $table->string('retrived_at');
        });
    }
};
