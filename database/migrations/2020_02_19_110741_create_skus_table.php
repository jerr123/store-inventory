<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // sku = producte + unit
        // sku
        if (!Schema::hasTable('skus')) {
            Schema::create('skus', function (Blueprint $table) {
                $table->increments('id');
                $table->string('sku_hash')->unique()->index(); // md5(bar_code+unit_id+product_id)
                $table->bigInteger('product_id'); // spu_id
                $table->string('bar_code')->index(); //条形码编号
                $table->bigInteger('unit_id');
                $table->decimal('cost_price', 15, 2)->nullable(); //成本价
                $table->decimal('sell_price', 15, 2); //销售价格
                $table->decimal('market_price', 15, 2)->nullable();   // 市场价
                $table->text('remark');
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
        Schema::dropIfExists('skus');
    }
}
