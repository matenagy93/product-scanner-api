<?php 
$menus = [
	"products" => "Get product list",
	"scan-start" => "Start a new scanning",
	"scan-product" => "Scan a new product",
	"scan-end" => "End the current scanning",
	"scan-details" => "Get details of scanning",
	"details-of-items" => "Details of items",
];
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<title>Product Scanner API - Documentation</title>
		<meta name="description" content="">
		<meta name="author" content="ticlekiwi">

		<meta http-equiv="cleartype" content="on">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;1,300&family=Source+Code+Pro:wght@300&display=swap" rel="stylesheet"> 
		<style>
			<?php include(public_path("api-documentation/css/style.css")); ?>
			
			.my-pre{
				display: inline-block;
				padding: 15px;
				white-space: pre;
				color: #fff;
				background-color: rgba(255, 255, 255, .05);
			}
			
			@media only screen and (max-width:980px){
				.content table{
					overflow-y: auto;
				}
			}
		</style>		
	</head>
	<body class="one-content-column-version">
		<div class="left-menu">
			<div class="content-logo">
				<div class="logo">
					<img alt="platform by Emily van den Heever from the Noun Project" title="platform by Emily van den Heever from the Noun Project" src="{{ URL::asset('api-documentation/images/logo.png') }}" height="32" />
					<span>Product Scanner API</span>
				</div>
				<button class="burger-menu-icon" id="button-menu-mobile">
					<svg width="34" height="34" viewBox="0 0 100 100"><path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058"></path><path class="line line2" d="M 20,50 H 80"></path><path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942"></path></svg>
				</button>
			</div>
			<div class="mobile-menu-closer"></div>
			<div class="content-menu">
				<div class="content-infos">
					<div class="info"><b>Version:</b> 1.0</div>
					<div class="info"><b>Last Updated:</b> 2nd May, 2022</div>
				</div>
				<ul>
					<li class="scroll-to-link" data-target="content-get-started"><a>GET STARTED</a></li>
					@foreach($menus AS $menuKey => $menuName)
						<li class="scroll-to-link" data-target="content-{{ $menuKey }}"><a>{{ $menuName }}</a></li>
					@endforeach
					<li class="scroll-to-link" data-target="content-errors"><a>Errors</a></li>
				</ul>
			</div>
		</div>
		<div class="content-page">
			<div class="content">
				@include("api-documentation._get-started")
				
				@foreach($menus AS $menuKey => $menuName)
					@include("api-documentation.menus.".$menuKey, ["menuKey" => $menuKey, "menuName" => $menuName])
				@endforeach
							
				@include("api-documentation._errors")				
			</div>
		</div>
		<script><?php include(public_path("api-documentation/js/script.js")); ?></script>
	</body>
</html>