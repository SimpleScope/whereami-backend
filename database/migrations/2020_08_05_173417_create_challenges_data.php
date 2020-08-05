<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('challenges')->insert(
            ['name' => '100DaysOfCode', 'description' => 'https://www.100daysofcode.com/']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // todo: Fix rollback error with foreign key constraints
        DB::table('challenges')->truncate();
    }
}
