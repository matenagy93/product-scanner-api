<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
		
		DB::table('products')->insert([
			[
				'ean' => 111,
				'name' => 'Product A',
				'unit_price_net' => 2.00,
			],
			[
				'ean' => 222,
				'name' => 'Product B',
				'unit_price_net' => 10.00,
			],
			[
				'ean' => 333,
				'name' => 'Product C',
				'unit_price_net' => 1.25,
			],
			[
				'ean' => 444,
				'name' => 'Product D',
				'unit_price_net' => 0.15,
			],
			[
				'ean' => 555,
				'name' => 'Product E',
				'unit_price_net' => 2.00,
			],
		]);
		
		DB::table('discounts')->insert([
			[
				'code' => '5PCS_PROD_A_1FREE',
				'name' => 'Product A: 5 for $8.00',
				'promoted_product_id' => 1,
				'condition_product_id' => 1,
				'condition_product_quantity' => 5,
				'unit_value_net' => 2.00,
			],
			[
				'code' => 'SIXPACK_PROD_C',
				'name' => 'Product C: $6.00 for a six pack',
				'promoted_product_id' => 3,
				'condition_product_id' => 3,
				'condition_product_quantity' => 6,
				'unit_value_net' => 1.50,
			],
			[
				'code' => 'FREE_PROD_E_TO_PROD_B',
				'name' => 'Product E: buy one product B and get one for free',
				'promoted_product_id' => 5,
				'condition_product_id' => 2,
				'condition_product_quantity' => 1,
				'unit_value_net' => 2.00,
			],
		]);
		
		DB::table('api_users')->insert([
			[
				'api_key' => sha1('TA Cash Register - May, 2022 - SN: BKJLB8XXL2'),
				'name' => 'TA Cash Register',
			],
		]);
    }
}
