@extends('layouts.master')

@push('scripts')
	<script src="{{ asset('/js/chart.js') }}"></script>
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
					<tr>
						<td>{{ $product->title }}</td>
						<td class="price">{{ $product->unit_price }}</td>
						<td class="center">{{ $product->quantity }}</td>
						<td class="price">{{ $product->total_price }}</td>
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