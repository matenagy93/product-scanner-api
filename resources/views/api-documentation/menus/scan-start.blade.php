<?php
$rows = [ 
	"api_key" => [
		"required" => "required",
		"type" => "string",
		"description" => "Your unique API key to access the datas.",
	],
];
?>

<div class="overflow-hidden content-section" id="content-{{ $menuKey }}">
	<h2>{{ $menuName }}</h2>
	<p>
		Start a new scanning session.<br>
		If the result is successful the program returns the started session's token. You can use this token to get details of session or do some processes (e.g. scanning a product).
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
			"token" => "5ece4797eaf5e",
			"started_at" => date("Y-m-d H:i:s"),
			"sales_tax" => 0.11,
		], JSON_PRETTY_PRINT); 
		?></span>
	</p>
	
	<h4 style="text-transform: uppercase;">Datas in return</h4>
	<p>The keys belongs to the newly created scanning. The information about the keys are listed in section 'Details Of Items / Scanning'.</p>
</div>