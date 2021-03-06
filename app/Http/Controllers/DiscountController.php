<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    #Get the list of discounts that may will be applied on products
	public function getDiscountListByPromotedProductIds($idList = [])
	{
		$discounts = (count($idList) == 0) ? [] : Discount::whereIn('promoted_product_id', $idList)->get();
		return $discounts;
	}
	
	#Check if discount is applicable
	public function checkIfDiscountIsApplicable(Discount $discount, $productIdsAndQuantities = [])
	{	
		if(count($productIdsAndQuantities) == 0) { $applicableQuantity = 0; }
		else
		{
			#Store quantities into variables
			$promotedProductQuantity = (isset($productIdsAndQuantities[$discount->promoted_product_id])) ? $productIdsAndQuantities[$discount->promoted_product_id] : 0;
			$conditionProductQuantity = (isset($productIdsAndQuantities[$discount->condition_product_id])) ? $productIdsAndQuantities[$discount->condition_product_id] : 0;
			
			#How many times could we apply the discount at most?
			$maxApplies = min($promotedProductQuantity, $conditionProductQuantity);
			
			#Calculate
			$applies = floor($conditionProductQuantity / $discount->condition_product_quantity);
			$applicableQuantity = min($maxApplies, $applies);		
		}

		#Return the calculated value
		return $applicableQuantity;
	}
}
