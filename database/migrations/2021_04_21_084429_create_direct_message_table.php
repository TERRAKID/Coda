<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_message', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id_1');
            $table->foreignId('user_id_2');
            $table->text('message');
            $table->boolean('active')->default('1');
            $table->text('attachment_path')->nullable();
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
        Schema::dropIfExists('direct_message');
    }
}
