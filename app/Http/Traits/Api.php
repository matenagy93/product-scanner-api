<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Models\ApiUser;

trait Api
{
	#API user collection
	protected $apiUser;
	
	#Appliable errors
	protected $errorList = [
		'API_KEY_EMPTY' => 'The api_key parameter is required, but we didn\'t receive it or the parameter is empty.',
		'API_KEY_AUTH' => 'The given api_key doesn\'t exists.',
		'MISSING_PARAM' => 'One or more required parameters are missing.',
		'SCAN_TOKEN_INVALID' => 'The given scan_token doesn\'t exists.',
		'SCAN_TOKEN_AUTH' => 'The given scan_token doesn\'t belong to the given API user.',
		'SCAN_ENDED' => 'The scanning session is already ended.',
		'PRODUCT_EAN_INVALID' => 'The given product_ean doesn\'t exists.',
		'UNEXPECTED' => 'Something went wrong. Please try again!',
	];
	
	#Check the API user
	protected function checkApiKey(Request $request)
	{
		$apiKey = $request->input('api_key');
		if($apiKey === NULL) { $errorKey = 'API_KEY_EMPTY'; }
		else
		{
			$apiUser = ApiUser::where("api_key", $apiKey)->first();
			if($apiUser === NULL) { $errorKey = 'API_KEY_AUTH'; }
			else
			{
				$this->apiUser = $apiUser;
				$errorKey = NULL;
			}
		}
		
		return $errorKey;
	}
	
	#Response with json format from given array
	public function responseWithSuccess($array = [])
	{
		return response()->json($array);
	}
	
	#Get description of error
	public function getErrorText($key = NULL)
	{
		return ($key !== NULL AND isset($this->errorList[$key])) ? $this->errorList[$key] : NULL;
	}
	
	#Response with json format from error message
	public function responseWithError($errorKey)
	{
		return response()->json([
			'error' => $errorKey,
			'description' => $this->getErrorText($errorKey),
		]);
	}
	
	#Response with json format from error message
	public function responseWithUnexpectedError()
	{
		return $this->responseWithError('UNEXPECTED');
	}
}