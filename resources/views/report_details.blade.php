@extends('layouts.master')

@push('scripts')
	@env('production')
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.0/chart.min.js" integrity="sha512-yadYcDSJyQExcKhjKSQOkBKy2BLDoW6WnnGXCAkCoRlpHGpYuVuBqGObf3g/TdB86sSbss1AOP4YlGSb6EKQPg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	@endenv

	@env('local')
		<script src="{{ asset('/js/chart.js') }}"></script>
	@endenv
	
	<script src="{{ asset('/js/report-charts.js') }}" defer></script>
@endpush

@section('content')
	<div class="container report-detail">
		<div class="text-center">
			<h3 class="underline">Products</h3>
		</div>
		<table id="report-products">
			<thead>
				<tr>
					<th>Title</th>
					<th>Unit price</th>
					<th>Quantity</th>
					<th>Total price</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($report->products as $product)
					@php
						$price_format = new \NumberFormatter('es-ES', \NumberFormatter::DECIMAL_ALWAYS_SHOWN);
					@endphp
					<tr>
						<td>{{ $product->title }}</td>
						<td class="price">{{ $price_format->format($product->unit_price) }}</td>
						<td class="center">{{ $product->quantity }}</td>
						<td class="price">{{ $price_format->format($product->total_price) }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div id="charts">
		<div id="category-chart" class="container report-detail">
			<div class="text-center">
				<h3 class="underline">Categories chart</h3>
			</div>
			<canvas class="chart"></canvas>
		</div>
		<div id="condition-chart" class="container report-detail">
			<div class="text-center">
				<h3 class="underline">Conditions chart</h3>
			</div>
			<canvas class="chart"></canvas>
		</div>
		<div id="state-chart" class="container report-detail">
			<div class="text-center">
				<h3 class="underline">States chart</h3>
			</div>
			<canvas class="chart"></canvas>
		</div>
	</div>
@endsection