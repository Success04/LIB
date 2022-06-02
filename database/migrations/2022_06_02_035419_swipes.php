<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('swipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreignId('to_user_id')
            ->constrained('users','id')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->boolean('is_like');
            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('swipes');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
