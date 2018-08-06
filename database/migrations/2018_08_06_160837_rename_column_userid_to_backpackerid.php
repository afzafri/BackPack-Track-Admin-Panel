<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnUseridToBackpackerid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('itineraries', function ($table) {
            $table->renameColumn('user_id', 'backpacker_id');
        });

        Schema::table('comments', function ($table) {
            $table->renameColumn('user_id', 'backpacker_id');
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
        Schema::table('itineraries', function ($table) {
            $table->renameColumn('backpacker_id', 'user_id');
        });

        Schema::table('comments', function ($table) {
            $table->renameColumn('backpacker_id', 'user_id');
        });
    }
}
