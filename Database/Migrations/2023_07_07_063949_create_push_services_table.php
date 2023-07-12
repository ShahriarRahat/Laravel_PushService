<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_services', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 50);
            $table->string('description', 191)->nullable();
            $table->string('image', 191)->nullable();
            $table->enum('type', ['announcement', 'reminder', 'notice'])->default('announcement');
            $table->morphs('pushable');
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
        Schema::dropIfExists('push_services');
    }
};
