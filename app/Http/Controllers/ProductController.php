<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\Api as ApiTrait;

use App\Models\Product;

class ProductController extends Controller
{
    use ApiTrait;
	
	#Last scanned product
	protected $lastCheckedProduct;
	
	#API call: Get the list of available products (optional: where, order by)
	protected function getListOfAvailableProducts(Request $request)
	{
		if(!empty($errorKey = $this->checkApiKey($request))) { return $this->responseWithError($errorKey); }
		else
		{
			#Where parameters
			$where = [['id', '!=', '0']];
			if($request->input('price_min') !== NULL AND $request->input('price_min') > 0) { $where[] = ['unit_price_net', '>=', $request->input('price_min')]; }
			if($request->input('price_max') !== NULL AND $request->input('price_max') > 0) { $where[] = ['unit_price_net', '<=', $request->input('price_max')]; }
			
			#Order of products
			$orderBy = 'name ASC';
			if($request->input('order_by') !== NULL)
			{
				switch($request->input('order_by'))
				{
					case 'name ASC':
					case 'name DESC':
						$orderBy = $request->input('order_by');
					case 'price ASC':
					case 'price DESC':
						$orderBy = str_replace('price', 'unit_price_net', $request->input('order_by'));
						break;
				}
			}
			
			#Get product list
			$products = Product::where($where)->orderByRaw($orderBy)->get(['ean', 'name', 'unit_price_net']);
			
			#Response
			$responseArray = [];
			if(count($products) > 0)
			{
				foreach($products AS $product) { $responseArray[] = $product->toArray(); }
			}
			
			return $this->responseWithSuccess($responseArray);
		}
	}

	#Check product by ean number
	public function checkProductByEan(Request $request)
	{
		$productEan = $request->input('product_ean');
		if($productEan === NULL) { $errorKey = 'MISSING_PARAM'; }
		else
		{
			$product = Product::where("ean", $productEan)->first();
			if($product === NULL) { $errorKey = 'PRODUCT_EAN_INVALID'; }
			else
			{
				$this->setLastCheckedProduct($product);
				$errorKey = NULL;
			}
		}
		
		return $errorKey;
	}

	#Get last checked product row
	public function getLastCheckedProduct()
	{
		return $this->lastCheckedProduct;
	}
	
	#Set the last checked product row
	public function setLastCheckedProduct($product = NULL)
	{
		return $this->lastCheckedProduct = $product;
	}
}
