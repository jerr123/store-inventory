<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name'        => '烟',
                'description' => '香烟',
            ],
            [
                'name'        => '酒',
                'description' => '酒品',
            ],
            [
                'name'        => '零食',
                'description' => '',
            ],
            [
                'name'        => '生活用品',
                'description' => '',
            ],
            [
                'name'        => '烟花爆竹',
                'description' => '',
            ],
            [
                'name'        => '其他',
                'description' => '其他',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB:table('categories')->truncate();
    }
}
