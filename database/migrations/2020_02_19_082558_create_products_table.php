<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // spu
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('img')->nullable();
            $table->timestamps();
        });

        if (!Schema::hasTable('units')) {
            Schema::create('units', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // 单位换算
        if (!Schema::hasTable('product_has_unit_relation')) {
            Schema::create('unit_relation', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('product_id');
                $table->bigInteger('main_unit_id');
                $table->bigInteger('assist_unit_id');
                $table->bigInteger('value');
                $table->timestamps();
            });
        }

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

        DB::table('categories')->insert($units);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
