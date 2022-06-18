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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age')->nullable(true)->change();
            $table->string('gender')->nullable(true)->change();
            $table->text('introduction')->nullable(true)->change();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('age')->nullable(false)->change();
            $table->dropColumn('gender')->nullable(false)->change();
            $table->dropColumn('introduction')->nullable(false)->change();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
