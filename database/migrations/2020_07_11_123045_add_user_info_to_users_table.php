<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserInfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('status')->nullable();
            $table->text('biography')->nullable();
            $table->text('location')->nullable();
            $table->text('facebook')->nullable();
            $table->text('twitter')->nullable();
            $table->text('github')->nullable();
            $table->text('gitlab')->nullable();
            $table->text('instagram')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('biography');
            $table->dropColumn('location');
            $table->dropColumn('facebook');
            $table->dropColumn('twitter');
            $table->dropColumn('github');
            $table->dropColumn('gitlab');
            $table->dropColumn('instagram');
        });
    }
}
