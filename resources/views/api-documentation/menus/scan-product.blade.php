<?php
$rows = [ 
	"api_key" => [
		"required" => "required",
		"type" => "string",
		"description" => "Your unique API key to access the datas.",
	],
	"scan_token" => [
		"required" => "required",
		"type" => "string",
		"description" => "The token of the scanning session.",
	],
	"product_ean" => [
		"required" => "required",
		"type" => "integer",
		"description" => "The EAN code of the scanned product.",
	],
	"product_quantity" => [
		"required" => "optional",
		"type" => "integer",
		"description" => "Quantity of the scanned product. Default value: 1. Min. value: 1.",
	],
];
?>

<div class="overflow-hidden content-section" id="content-{{ $menuKey }}">
	<h2>{{ $menuName }}</h2>
	<p>
		Scanning a product into an existing scanning session.<br>
		If the result is successful the program returns an array with the details of the product.
	</p>
	
	<h4>QUERY METHOD & LINK</h4>
	<p><code class="higlighted break-word"><strong style="font-weight: bold;">POST</strong></code>&nbsp;&nbsp;&nbsp; <code class="higlighted break-word">{{ env('API_URL').$menuKey }}</code></p>

	<h4>QUERY PARAMETERS</h4>
	<table>
		<thead>
			<tr>
				<th>Field</th>
				<th>Required?</th>
				<th>Type</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
			@foreach($rows AS $rowKey => $data)
				<tr>
					<td>{{ $rowKey }}</td>
					<td>{{ $data["required"] }}</td>
					<td>{{ $data["type"] }}</td>
					<td>{!! $data["description"] !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<h4>RETURNED JSON</h4>
	<p style="padding-top: 10px;">
		<span class="my-pre"><?php 
		echo json_encode([
			"ean" => "123456789012",
			"name" => "Product #1",
			"unit_price_net" => 2.00,
			"quantity" => 3,
			"sum_net" => 6.00,
		], JSON_PRETTY_PRINT); 
		?></span>
	</p>
	
	<h4 style="text-transform: uppercase;">Datas in return</h4>
	<p>
		The values in return (quantity, sum_net) includes the previous scanning of this product, therefore the values are representing the current status and NOT the changes made by this query!<br>
		The information about the keys are listed in section 'Details Of Items / Scanned product'.
	</p>
</div>