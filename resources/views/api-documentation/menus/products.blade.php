<?php
$rows = [ 
	"api_key" => [
		"required" => "required",
		"type" => "string",
		"description" => "Your unique API key to access the datas.",
		"values" => NULL,
	],
	"price_min" => [
		"required" => "optional",
		"type" => "double",
		"description" => "Filtering the products by minimum price.",
		"values" => NULL,
	],
	"price_max" => [
		"required" => "optional",
		"type" => "double",
		"description" => "Filtering the products by maximum price.",
		"values" => NULL,
	],
	"order_by" => [
		"required" => "optional",
		"type" => "string",
		"description" => "Sets the ordering type of the list. Default: name ASC",
		"values" => "name ASC | name DESC | price ASC | price DESC",
	],
];
?>

<div class="overflow-hidden content-section" id="content-{{ $menuKey }}">
	<h2>{{ $menuName }}</h2>
	<p>
		Get full list of available products with the basic details.<br>
		You can set filters with the query parameters.
	</p>
	
	<h4>QUERY METHOD & LINK</h4>
	<p><code class="higlighted break-word"><strong style="font-weight: bold;">GET</strong></code>&nbsp;&nbsp;&nbsp; <code class="higlighted break-word">{{ env('API_URL').$menuKey }}</code></p>

	<h4>QUERY PARAMETERS</h4>
	<table>
		<thead>
			<tr>
				<th>Field</th>
				<th>Required?</th>
				<th>Type</th>
				<th>Description</th>
				<th>List of accepted values</th>
			</tr>
		</thead>
		<tbody>
			@foreach($rows AS $rowKey => $data)
				<tr>
					<td>{{ $rowKey }}</td>
					<td>{{ $data["required"] }}</td>
					<td>{{ $data["type"] }}</td>
					<td>{!! $data["description"] !!}</td>
					<td>{!! $data["values"] !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<h4>RETURNED JSON</h4>
	<p style="padding-top: 10px;">
		<span class="my-pre"><?php 
		echo json_encode([
			[
				"ean" => 123456789012,
				"name" => "Product #1",
				"unit_price_net" => 1.15,
			],
			[
				"ean" => 210987654321,
				"name" => "Product #2",
				"unit_price_net" => 2.00,
			],
		], JSON_PRETTY_PRINT); 
		?></span>
	</p>
	
	<h4 style="text-transform: uppercase;">Datas in return</h4>
	<p>If the return is an empty array, it means that the query was successful but there are no matches. The information about the keys are listed in section 'Details Of Items / Product'.</p>
</div>