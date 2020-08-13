<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

class CreateDefaultUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert(
            ['name' => 'Vignesh',
                'email' => 'support@whereami.dev',
                'password' => Hash::make('123456')
            ]
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
        DB::table('users')->truncate();
    }
}
