<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('code', 50)->nullable()->unique();
            $table->string('name', 150)->nullable();
			$table->foreignId('promoted_product_id')->nullable()->index();
			$table->foreignId('condition_product_id')->nullable()->index();
			$table->integer('condition_product_quantity')->nullable();
            $table->double('unit_value_net')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
};
