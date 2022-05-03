<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\Api as ApiTrait;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\DiscountController;

use App\Models\ScanSession;
use App\Models\ScanScannedProduct;
use App\Models\ScanAppliedDiscount;

class ScanController extends Controller
{
	use ApiTrait;
	
	#Scanning session collection
	public $scanSession;
	
	#API call: start a new scanning session
	protected function sessionStart(Request $request)
	{
		if(!empty($errorKey = $this->checkApiKey($request))) { return $this->responseWithError($errorKey); }
		else
		{
			#Creating the new scanning session item
			$scanSession = new ScanSession;
			$scanSession->api_user_id = $this->apiUser->id;
			$scanSession->token = uniqid();
			$scanSession->started_at = date('Y-m-d H:i:s');
			$scanSession->sum_products_net = 0;
			$scanSession->sum_discounts_net = 0;
			$scanSession->sales_tax = env('CURRENT_SALES_TAX');
			$scanSession->save();
			
			#If something went wrong
			if(!isset($scanSession->id) OR empty($scanSession->id)) { return $this->responseWithUnexpectedError(); }
			#Everything is okay: response
			else
			{
				$responseArray = [
					'token' => $scanSession->token,
					'started_at' => $scanSession->started_at,
					'sales_tax' => $scanSession->sales_tax,
				];
				
				return $this->responseWithSuccess($responseArray);
			}
		}
	}
	
	#API call: add product to scanning session
	protected function scanProduct(Request $request)
	{
		if(!empty($errorKey = $this->checkApiKey($request))) { return $this->responseWithError($errorKey); }
		elseif(!empty($errorKey = $this->checkScanToken($request))) { return $this->responseWithError($errorKey); }
		elseif($this->scanSession->is_ended) { return $this->responseWithError('SCAN_ENDED'); }
		else
		{
			#Check if product exists (by EAN number)
			$productController = new ProductController;
			if(!empty($errorKey = $productController->checkProductByEan($request))) { return $this->responseWithError($errorKey); }
			else
			{
				#Get product row
				$product = $productController->getLastCheckedProduct();
				if(!$product) { return $this->responseWithUnexpectedError(); }
				else
				{
					#Quantity
					$quantity = ($request->input('product_quantity') !== NULL AND $request->input('product_quantity') > 1) ? $request->input('product_quantity') : 1;
					
					#Check if this product has been scanned before
					$where = [
						['scan_session_id', $this->scanSession->id],
						['product_id', $product->id],
					];
					$scannedProduct = ScanScannedProduct::where($where)->first();
					
					#If first scan of the product: create basic row
					if($scannedProduct === NULL)
					{
						$scannedProduct = new ScanScannedProduct;
						$scannedProduct->scan_session_id = $this->scanSession->id;
						$scannedProduct->product_id = $product->id;
						$scannedProduct->quantity = 0;
					}
					
					#Scan the product (insert new row or update existing one)
					$scannedProduct->ean = $product->ean;
					$scannedProduct->name = $product->name;
					$scannedProduct->unit_price_net = $product->unit_price_net;
					$scannedProduct->quantity += $quantity;
					$scannedProduct->save();
					
					#Refresh scan session's prices and discounts
					$this->refreshSessionPricesAndDiscounts();
					
					#Response
					$responseArray = [
						'ean' => $scannedProduct->ean,
						'name' => $scannedProduct->name,
						'unit_price_net' => $scannedProduct->unit_price_net,
						'quantity' => $scannedProduct->quantity,
						'sum_net' => $scannedProduct->sum_net,
					];
					
					return $this->responseWithSuccess($responseArray);
				}
			}	
		}
	}
	
	#API call: end an existing scanning session
	protected function sessionEnd(Request $request)
	{
		if(!empty($errorKey = $this->checkApiKey($request))) { return $this->responseWithError($errorKey); }
		elseif(!empty($errorKey = $this->checkScanToken($request))) { return $this->responseWithError($errorKey); }
		elseif($this->scanSession->is_ended) { return $this->responseWithError('SCAN_ENDED'); }
		else
		{
			if(!$this->scanSession->is_ended)
			{
				#Refresh prices and discounts
				$this->refreshSessionPricesAndDiscounts();
				
				#End scanning session
				$this->scanSession->is_ended = 1;
				$this->scanSession->ended_at = date('Y-m-d H:i:s');
				$this->scanSession->save();
			}
			
			#Response
			$responseArray = [
				'is_ended' => $this->scanSession->is_ended,
				'ended_at' => $this->scanSession->ended_at,
			];
			
			return $this->responseWithSuccess($responseArray);
		}
	}
	
	#API call: get details of scanning session
	protected function sessionDetails(Request $request)
	{
		if(!empty($errorKey = $this->checkApiKey($request))) { return $this->responseWithError($errorKey); }
		elseif(!empty($errorKey = $this->checkScanToken($request))) { return $this->responseWithError($errorKey); }
		else
		{
			if(!$this->scanSession->is_ended) { $this->refreshSessionPricesAndDiscounts(); }
			
			#Response
			$responseArray = [
				'token' => $this->scanSession->token,
				'started_at' => $this->scanSession->started_at,
				'ended_at' => $this->scanSession->ended_at,
				'is_ended' => $this->scanSession->is_ended,
				'sum_products_net' => $this->scanSession->sum_products_net,
				'sum_discounts_net' => $this->scanSession->sum_discounts_net,
				'total_net' => $this->scanSession->total_net,
				'sales_tax' => $this->scanSession->sales_tax,
				'total_gross' => $this->scanSession->total_gross,
			];
			
			#Add products to response
			if($request->input('products'))
			{
				$responseArray['products'] = [];
				if(count($this->scanSession->products) > 0)
				{
					foreach($this->scanSession->products AS $product)
					{
						$responseArray['products'][] = [
							'ean' => $product->ean,
							'name' => $product->name,
							'unit_price_net' => $product->unit_price_net,
							'quantity' => $product->quantity,
							'sum_net' => $product->sum_net,
						];
					}
				}
			}
			
			#Add discounts to response
			if($request->input('discounts'))
			{
				$responseArray['discounts'] = [];
				if(count($this->scanSession->discounts) > 0)
				{
					foreach($this->scanSession->discounts AS $discount)
					{
						$responseArray['discounts'][] = [
							'code' => $discount->code,
							'name' => $discount->name,
							'unit_value_net' => $discount->unit_value_net,
							'quantity' => $discount->quantity,
							'sum_net' => $discount->sum_net,
						];
					}
				}
			}
			
			return $this->responseWithSuccess($responseArray);
		}
	}
	
	#Check the scan token
	protected function checkScanToken(Request $request)
	{
		$scanToken = $request->input('scan_token');
		if($scanToken === NULL) { $errorKey = 'MISSING_PARAM'; }
		else
		{
			$scanSession = ScanSession::where("token", $scanToken)->first();
			if($scanSession === NULL) { $errorKey = 'SCAN_TOKEN_INVALID'; }
			elseif($scanSession->api_user_id != $this->apiUser->id) { $errorKey = 'SCAN_TOKEN_AUTH'; }
			else
			{
				$this->scanSession = $scanSession;
				$errorKey = NULL;
			}
		}
		
		return $errorKey;
	}
	
	#Apply discounts on scan session
	protected function applyDiscountsOnSession()
	{
		#Get list of product IDs added into session
		$productIdList = $this->getProductIdListBySession();
		if(count($productIdList) > 0)
		{
			#Get discount list
			$discountController = new DiscountController;
			$discounts = $discountController->getDiscountListByPromotedProductIds($productIdList);
			if(count($discounts) > 0)
			{
				#Get quantities by product ids
				$productIdsAndQuantities = $this->getProductQuantityByProductIdAndSession();
				
				#Loop discounts and check if they are applicable
				foreach($discounts AS $discount)
				{
					$applicableQuantity = $discountController->checkIfDiscountIsApplicable($discount, $productIdsAndQuantities);
					
					#If applicable: insert new row or update existing one
					if($applicableQuantity > 0)
					{
						#Check if this discount has applied before
						$where = [
							['scan_session_id', $this->scanSession->id],
							['discount_id', $discount->id],
						];
						$scanDiscount = ScanAppliedDiscount::where($where)->first();
						
						#If first apply of the discount: create basic row
						if($scanDiscount === NULL)
						{
							$scanDiscount = new ScanAppliedDiscount;
							$scanDiscount->scan_session_id = $this->scanSession->id;
							$scanDiscount->discount_id = $discount->id;
						}
						
						#Update details
						$scanDiscount->code = $discount->code;
						$scanDiscount->name = $discount->name;
						$scanDiscount->unit_value_net = $discount->unit_value_net;
						$scanDiscount->quantity = $applicableQuantity;
						$scanDiscount->save();
					}
					#If NOT applicable: delete existing row if exists
					else
					{
						$where = [
							['scan_session_id', $this->scanSession->id],
							['discount_id', $discount->id],
						];
						ScanAppliedDiscount::where($where)->delete();
					}
				}
			}
		}
	}
	
	#Update scan session's sum fields
	protected function calculateSumFieldsOnSession()
	{
		#Calculate field: sum_products_net
		$productSum = 0;
		if(count($this->scanSession->products) > 0)
		{
			foreach($this->scanSession->products AS $product) { $productSum += $product->sum_net; }
		}
		
		#Calculate field: sum_discounts_net
		$discountSum = 0;
		if(count($this->scanSession->discounts) > 0)
		{
			foreach($this->scanSession->discounts AS $discount) { $discountSum += $discount->sum_net; }
		}
		
		#Update sums
		$this->scanSession->sum_products_net = $productSum;
		$this->scanSession->sum_discounts_net = $discountSum;
		$this->scanSession->save();
	}
	
	#Refresh scan session's prices and discounts
	protected function refreshSessionPricesAndDiscounts()
	{
		$this->applyDiscountsOnSession();
		$this->calculateSumFieldsOnSession();
	}
	
	#Get product id list by session
	protected function getProductIdListBySession()
	{
		$products = [];
		if(count($this->scanSession->products) > 0)
		{
			foreach($this->scanSession->products AS $product)
			{
				if(!in_array($product->id, $products)) { $products[] = $product->product_id; }
			}
		}
		
		return $products;
	}
	
	protected function getProductQuantityByProductIdAndSession()
	{
		$products = [];
		if(count($this->scanSession->products) > 0)
		{
			foreach($this->scanSession->products AS $product)
			{
				if(!in_array($product->id, $products)) { $products[$product->product_id] = $product->quantity; }
			}
		}
		
		return $products;
	}
}
