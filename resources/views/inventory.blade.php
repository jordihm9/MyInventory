@extends('layouts.master')

@push('scripts')
	<script src="{{ asset('js/inventory-product-info.js') }}" defer></script>
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
				<div class="close-btn toggle-search-filter"></div>
				<form id="search-filter-form">
					{{-- SEARCH --}}
					<h4>Search</h4>
					{{-- keyword --}}
					<div class="input-group">
						<label for="keyword">Keyword</label>
						<input type="text" name="keyword" id="keyword">
					</div>
					{{-- FILTER OPTIONS --}}
					<h4>Filter</h4>
					{{-- CATEGORY --}}
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
					{{-- SUBCATEGORY --}}
					<div class="input-group">
						<label for="subcategory">Subcategory</label>
						<div class="custom-select">
							<select name="subcategory" id="subcategory">
								<option value="all">-- All --</option>
							</select>
						</div>
					</div>
					{{-- PRICE --}}
					{{-- <div class="input-group">
						<label for="price">Price</label>
						<div class="radio-wrapper">
							<input type="radio" name="price" value="high" id="high-price" hidden="hidden">
							<label for="high-price" class="btn radio">High</label>
							
							<input type="radio" name="price" value="low" id="low-price" hidden="hidden">
							<label for="low-price" class="btn radio">Low</label>
						</div>
					</div> --}}
					{{-- STATE --}}
					<div class="input-group">
						<label for="state">State</label>
						<div class="radio-wrapper">
							@foreach ($states as $state)
								<input type="radio" name="state" value="{{ $state->id }}" id="state-{{ $state->id }}" hidden="hidden">
								<label for="state-{{ $state->id }}" class="btn radio">{{ $state->name }}</label>
							@endforeach
						</div>
					</div>
					{{-- CONDITION --}}
					<div class="input-group">
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
					<div class="product" onclick="requestProduct({{ $product->id }})">
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
		<div class="text-center no-content-msg">
			<h1>You don't have any products yet</h1>
			<a href="{{ route('product.create.view') }}">
				<div class="btn primary">Add product</div>
			</a>
		</div>
	@endif

	<div class="outer">
		<div id="product-container" class="centered container show">
			<div class="close-btn"></div>
			<div class="product__images"></div>
			<div class="product__details">
				<div>
					<h4 class="title"></h4>
				</div>
				<div>
					<p class="description"></p>
				</div>
				<div class="info-wrapper">
					<div>
						<b>Unit price: </b>
						<span class="unit-price"></span>
						&euro;
					</div>
					<div>
						<b>Quantity: </b>
						<span class="quantity"></span>
					</div>
					<div>
						<b>Total price: </b>
						<span class="total-price"></span>
						&euro;
					</div>
				</div>
				<div class="info-wrapper">
					<div>
						<b>Category: </b>
						<span class="category"></span>
					</div>
					<div>
						<b>Subcategory: </b>
						<span class="subcategory"></span>
					</div>
				</div>
				<div class="info-wrapper">
					<div>
						<b>Condition: </b>
						<span class="condition"></span>
					</div>
					<div>
						<b>State: </b>
						<span class="state"></span>
					</div>
				</div>
				<div class="btn-wrapper text-right">
					<form id="delete-product-form" method="POST" style="position: absolute">
						@csrf
						<input type="hidden" name="product">
						<input type="submit" value="Delete" class="btn secondary">
					</form>
					<a class="edit-btn-link">
						<div class="btn primary">
							Edit
						</div>
					</a>
				</div>
			</div>
		</div>
		{{-- SUCCESS MESSAGE CONTAINER --}}
		<div id="success-container" class="centered container">
			<div class="text-center">
				<h4 class="message"></h4>
			</div>
			{{-- <div class="submit-container">
				<div class="btn primary">Close</div>
			</div> --}}
		</div>
	</div>
@endsection