<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedUnitsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $units = [
            [
                'name'        => '个',
            ],
            [
                'name'        => '件',
            ],
            [
                'name'        => '盒',
            ],
            [
                'name'        => '箱',
            ],
            [
                'name'        => '提',
            ],
            [
                'name'        => '包',
            ],
            [
                'name'        => '条',
            ],
            [
                'name'        => '瓶',
            ],
            [
                'name'        => '板',
            ],
            [
                'name'        => '斤',
            ],
            [
                'name'        => '公斤',
            ],
        ];

        DB::table('units')->insert($units);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('units')->truncate();
    }
}
