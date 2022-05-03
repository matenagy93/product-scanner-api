<div class="overflow-hidden content-section" id="content-get-started">
	<h1>Get started</h1>
	<p>The Product Scanner API provides the available products and the total cart value of the scanned products.
	<p>To use this API, you need a unique <strong>API key</strong>. Please contact us at <a href="mailto:nagymat@gmail.com">nagymat@gmail.com</a> to get your own API key.</p>
	<p>The api works over the following URL: <code class="higlighted break-word">{{ env('API_URL') }}<strong style="font-weight: bold;">{query_key}</strong></code></p>	
	<p>
		You always have to provide your <code class="higlighted break-word">api_key</code> as a request parameter. The full query list is in the menubar (left side).<br>
		This documentation provides information about the required and optional query parameters, and an example of the returned datas, too.
	</p>
	<p>
		The returned datas' format is always <strong>JSON</strong>!<br>
		All the prices are in the following currency: <strong>{{ env('PRICES_CURRENCY') }} ({{ env('PRICES_CURRENCY_SIGNAL') }})</strong>.
	</p>	
</div>