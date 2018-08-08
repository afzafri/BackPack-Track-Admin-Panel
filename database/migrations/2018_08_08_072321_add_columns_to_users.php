<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function($table) {
          $table->string('username')->after('name');
          $table->string('phone')->after('username');
          $table->string('address')->after('phone');
          $table->integer('country_id')->after('address');
          $table->string('avatar_url')->nullable()->after('password');
          $table->string('role')->after('avatar_url');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function($table) {
            $table->dropColumn('username');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('country_id');
            $table->dropColumn('avatar_url');
            $table->dropColumn('role');
        });
    }
}
