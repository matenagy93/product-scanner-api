<?php
$details = [ 
	"API_KEY_EMPTY" => [
		"meaning" => "The <code class='higlighted'>api_key</code> parameter is required, but we didn't receive it or the parameter is empty.",
	],
	"API_KEY_AUTH" => [
		"meaning" => "The given <code class='higlighted'>api_key</code> doesn't exists.",
	],
	"MISSING_PARAM" => [
		"meaning" => "One or more required parameters are missing.",
	],
	"SCAN_TOKEN_INVALID" => [
		"meaning" => "The given <code class='higlighted'>scan_token</code> doesn't exists.",
	],
	"SCAN_TOKEN_AUTH" => [
		"meaning" => "The given <code class='higlighted'>scan_token</code> doesn't belong to the given API user.",
	],
	"SCAN_ENDED" => [
		"meaning" => "The scanning session is already ended.",
	],
	"PRODUCT_EAN_INVALID" => [
		"meaning" => "The given <code class='higlighted'>product_ean</code> doesn't exists.",
	],
	"UNEXPECTED" => [
		"meaning" => "Something went wrong. Please try again!",
	],
];
?>

<div class="overflow-hidden content-section" id="content-errors">
	<h2>Errors</h2>
	<p>The API uses the error codes listed in the table below. If the programs returns with error, the output is always a json file containing an array which first key is <code class="higlighted">error</code>. Example:</p>
	<p>
		<span class="my-pre"><?php 
		echo json_encode([
			"error" => "API_KEY_EMPTY",
			"description" => "The 'api_key' parameter is required, but we didn't receive it or the parameter is empty.",
		], JSON_PRETTY_PRINT); 
		?></span>
	</p>
	<table>
		<thead>
			<tr>
				<th>Error code</th>
				<th>Meaning</th>
			</tr>
		</thead>
		<tbody>
			@foreach($details AS $dataKey => $data)
				<tr>
					<td>{{ $dataKey }}</td>
					<td>{!! $data["meaning"] !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>