<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('languages')->insert([

            [
                'code' => 'en', 
                'name' => 'English',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ], [
                'code' => 'ar', 
                'name' => 'العربية',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('languages')->truncate();
    }
}
