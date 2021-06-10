<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesToMovieRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movie_ratings', function (Blueprint $table) {
            $table->longText('notes')->after('review')->nullable();
            $table->string('view_date')->after('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movie_ratings', function (Blueprint $table) {
            $table->dropColumn('notes');
            $table->dropColumn('view_date');
        });
    }
}
