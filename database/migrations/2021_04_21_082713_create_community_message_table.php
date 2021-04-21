<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_message', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id');
            $table->foreignId('user_id');
            $table->text('message');
            $table->boolean('pinned')->default('0');
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
        Schema::dropIfExists('community_message');
    }
}
