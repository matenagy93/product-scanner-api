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
        Schema::create('scan_applied_discounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->softDeletes();
			$table->foreignId('scan_session_id')->nullable()->index();
			$table->foreignId('discount_id')->nullable()->index();
            $table->string('code', 50)->nullable()->index();
			$table->string('name', 150)->nullable();
            $table->double('unit_value_net')->nullable();
            $table->integer('quantity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scan_applied_discounts');
    }
};
