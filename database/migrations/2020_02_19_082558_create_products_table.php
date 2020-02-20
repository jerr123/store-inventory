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
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->index();
                $table->string('img')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('products', function (Blueprint $table) {
            $table->string('description')->nullable()->after('img');
            $table->integer('category_id')->unsigned()->index()->after('name');
            $table->string('hash')->index()->after('name');
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
