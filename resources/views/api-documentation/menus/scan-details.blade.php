<?php
$rows = [ 
	"api_key" => [
		"required" => "required",
		"type" => "string",
		"description" => "Your unique API key to access the datas.",
		"values" => NULL,
	],
	"scan_token" => [
		"required" => "required",
		"type" => "string",
		"description" => "The token of the scanning session.",
		"values" => NULL,
	],
	"products" => [
		"required" => "optional",
		"type" => "boolean",
		"description" => "Return the products in an array? Default: 1.",
		"values" => "0 or 1",
	],
	"discounts" => [
		"required" => "optional",
		"type" => "boolean",
		"description" => "Return the discounts in an array? Default: 1.",
		"values" => "0 or 1",
	],
];
?>

<div class="overflow-hidden content-section" id="content-{{ $menuKey }}">
	<h2>{{ $menuName }}</h2>
	<p>Get details of a scanning session.</p>
	
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
			"token" => "5ece4797eaf5e",
			"started_at" => date("Y-m-d H:i:s", strtotime("-15 Minutes")),
			"ended_at" => date("Y-m-d H:i:s"),
			"is_ended" => 1,
			"sum_products_net" => 17.4,
			"sum_discounts_net" => 2,
			"total_net" => 15.4,
			"sales_tax" => 0.11,
			"total_gross" => 17.094,
			"products" => "**Array**",
			"discounts" => "**Array**",
		], JSON_PRETTY_PRINT); 
		?></span>
	</p>
	
	<h4 style="text-transform: uppercase;">Datas in return</h4>
	<p>The information about the keys are listed in section 'Details Of Items / Scanning'.</p>
</div>