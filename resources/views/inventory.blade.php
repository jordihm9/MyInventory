@extends('layouts.master')

@push('scripts')
	<script src="{{ asset('js/categories.js') }}"></script>
@endpush

@section('content')
	<div id="search-filter" class="container">
		<form>
			<h4>Search</h4>
			<div class="input-group">
				<label for="keyword">Keyword</label>
				<input type="text" name="keyword" id="keyword">
			</div>
			<h4>Filter</h4>
			<div class="input-group">
				<label for="category">Category</label>
				<div class="custom-select">
					<select name="category" id="category">
						<option value="all">-- All --</option>
						@foreach ($categories as $category)
						<option value="{{ $category->id }}">{{ $category->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="input-group">
				<label for="subcategory">Subcategory</label>
				<div class="custom-select">
					<select name="subcategory" id="subcategory">
						<option value="all">-- All --</option>
					</select>
				</div>
			</div>
			<div class="input-group">
				<label for="category">Price</label>
				<div class="radio-wrapper">
					<input type="radio" name="price" value="high" id="high-price" hidden>
					<label for="high-price" class="btn radio">High</label>
					
					<input type="radio" name="price" value="low" id="low-price" hidden>
					<label for="low-price" class="btn radio">Low</label>
				</div>
			</div>
			<div class="input-group">
				<label for="state">State</label>
				<div class="radio-wrapper">
					<input type="radio" name="state" value="all" id="state-all" hidden>
					<label for="state-all" class="btn radio">All</label>
					
					<input type="radio" name="state" value="sale" id="state-sale" hidden>
					<label for="state-sale" class="btn radio">Sale</label>
					
					<input type="radio" name="state" value="sold" id="state-sold" hidden>
					<label for="state-sold" class="btn radio">Sold</label>
					
					<input type="radio" name="state" value="reserved" id="state-reserved" hidden>
					<label for="state-reserved" class="btn radio">Reserved</label>
				</div>
			</div>
			<div class="input-group">
				<label for="reset" class="text-right">
					Reset
					<input type="reset" id="reset" hidden>
				</label>
			</div>
		</form>
	</div>
@endsection