@extends('layouts.master')

@push('scripts')
	<script src="{{ asset('js/search-filter-container.js') }}" defer></script>
	<script src="{{ asset('js/categories.js') }}"></script>
@endpush

@section('content')
	@if (sizeof($products) >= 1)
		<div id="inventory">
			<div id="search-filter-btn" class="btn primary toggle-search-filter">
				Search & Filter
				<img src="images/icons/filter.svg" alt="filter">
			</div>
			<div id="search-filter" class="container">
				<div class="toggle-search-filter"></div>
				<form>
					{{-- SEARCH --}}
					<h4>Search</h4>
					{{-- keyword --}}
					<div class="input-group">
						<label for="keyword">Keyword</label>
						<input type="text" name="keyword" id="keyword">
					</div>
					{{-- FILTER OPTIONS --}}
					<h4>Filter</h4>
					<div class="input-group">
						{{-- CATEGORY --}}
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
						{{-- SUBCATEGORY --}}
						<label for="subcategory">Subcategory</label>
						<div class="custom-select">
							<select name="subcategory" id="subcategory">
								<option value="all">-- All --</option>
							</select>
						</div>
					</div>
					<div class="input-group">
						{{-- PRICE --}}
						<label for="price">Price</label>
						<div class="radio-wrapper">
							<input type="radio" name="price" value="high" id="high-price" hidden="hidden">
							<label for="high-price" class="btn radio">High</label>
							
							<input type="radio" name="price" value="low" id="low-price" hidden="hidden">
							<label for="low-price" class="btn radio">Low</label>
						</div>
					</div>
					<div class="input-group">
						{{-- STATE --}}
						<label for="state">State</label>
						<div class="radio-wrapper">
							<input type="radio" name="state" id="state-all" value="all" hidden="hidden">
							<label for="state-all" class="btn radio">All</label>
							@foreach ($states as $state)
								<input type="radio" name="state" value="{{ $state->id }}" id="state-{{ $state->id }}" hidden="hidden">
								<label for="state-{{ $state->id }}" class="btn radio">{{ $state->name }}</label>
							@endforeach
						</div>
					</div>
					<div class="input-group">
						{{-- CONDITION --}}
						<label for="condition">Condition</label>
						<div class="radio-wrapper">
							@foreach ($conditions as $condition)
								<input type="radio" name="condition" value="{{ $condition->id }}" id="condition-{{ $condition->id }}" hidden="hidden">
								<label for="condition-{{ $condition->id }}" class="btn radio">{{ $condition->name }}</label>
							@endforeach
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
			{{-- LIST OF PRODUCTS --}}
			<div id="products">
				@foreach ($products as $product)
					<div class="product">
						<div class="product__text">
							@php
								// get just the first 30 characters
								$title = substr($product->title, 0, 30);
								// append 3 dots if original title has more than 30 characters
								if (strlen($product->title) > 30) {
									$title .= '...';
								}
							@endphp
							{{ $title }}
						</div>
						<div class="product__image-container"
							@if (sizeof($product->images) >= 1)
							style="background-image: url({{ asset('storage/'. $product->images[0]->url) }})"
							@endif
						>
						</div>
						<a href="{{ route('product.edit.view', ['id'=> $product->id]) }}">
							<div class="edit-btn">
								<img src="images/icons/edit.svg" alt="edit">
							</div>
						</a>
					</div>
				@endforeach
			</div>
		</div>
	@else
		{{-- NO PRODUCTS --}}
		<div id="no-products-msg" class="text-center">
			<h1>You don't have any products yet</h1>
			<a href="{{ route('product.create.view') }}">
				<div class="btn primary">Add product</div>
			</a>
		</div>
	@endif
@endsection