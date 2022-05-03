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
        Schema::create('scan_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->softDeletes();
			
			$table->foreignId('api_user_id')->nullable()->index();
			$table->string('token', 13)->nullable()->unique();
			$table->dateTime('started_at')->nullable();
			$table->dateTime('ended_at')->nullable();
			$table->boolean('is_ended')->nullable()->default(0)->index();
			$table->double('sum_products_net')->nullable();
			$table->double('sum_discounts_net')->nullable();
			$table->double('sales_tax')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scan_sessions');
    }
};
