<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert([

            [
                'first_name' => 'default', 
                'last_name' => 'admin', 
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456'),
                'phone' => '0123456789',
                'admin' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->truncate();
    }
}
