@extends('layouts.master')

@push('scripts')
	<script src="{{ asset('/js/categories.js') }}"></script>
	<script src="{{ asset('/js/validations-helpers.js') }}"></script>
	<script src="{{ asset('/js/product-form.js') }}" defer></script>
	<script src="{{ asset('/js/form-image-preview.js') }}"></script>
@endpush

@section('content')
	<div id="product-form-container" class="container">
		<div class="text-center">
			<h1 class="underline">
				@if (isset($product))
					Edit product
				@else
					Add product
				@endif
			</h1>
		</div>
		<form id="product-form" action="{{ route('product.save') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="id" value="@isset ($product){{ $product->id }}@endisset">
			{{-- TITLE --}}
			<div class="input-group required">
				<label for="title">Title</label>
				<input type="text" name="title" id="title" value="@isset($product){{ $product->title }}@endisset" class="@error('title') error @enderror()" autofocus>
				<span id="title-error" class="error__message">
					@error('title')
						{{ $message }}
					@enderror
				</span>
			</div>
			<div class="grid col-lg-1-1-1">
				{{-- UNIT PRICE --}}
				<div class="input-group required">
					<label for="unit-price">Unit price</label>
					{{-- <div class="price-input"> --}}
						<input type="text" name="unit-price" id="unit-price" value="@isset($product){{ $product->unit_price }}@endisset" class="text-right @error('unit-price') error @enderror()">
						<span></span>
					{{-- </div> --}}
					<span id="price-error" class="error__message">
						@error('unit-price')
							{{ $message }}
						@enderror
					</span>
				</div>
				{{-- QUANTITY --}}
				<div class="input-group required">
					<label for="quantity">Quantity</label>
					<input type="text" name="quantity" id="quantity" value="@isset($product){{ $product->quantity }}@endisset" class="text-center @error('quantity') error @enderror()">
					<span id="quantity-error" class="error__message">
						@error('quantity')
							{{ $message }}
						@enderror
					</span>
				</div>
				{{-- TOTAL PRICE --}}
				<div class="input-group">
					<label for="total-price">Total price</label>
					{{-- <div class="price-input"> --}}
						<input type="text" name="total-price" id="total-price" value="@isset($product){{ $product->total_price }}@endisset" disabled="disabled" class="text-right">
						<span></span>
					{{-- </div> --}}
				</div>
			</div>
			<div class="grid col-lg-2-1">
				{{-- DESCRIPTION --}}
				<div class="input-group">
					<label for="description">Description</label>
					<textarea name="description" id="description" rows="10" style="resize: none">@isset($product){{ $product->description }}@endisset</textarea>
					<span id="description-error" class="error__message"></span>
				</div>
				<div class="selects">
					{{-- CATEGORY --}}
					<div class="input-group">
						<label for="category">Category</label>
						<div class="custom-select">
							<select name="category" id="category">
								<option value="all">-- All --</option>
								@foreach ($categories as $category)
									<option value="{{ $category->id }}"
										@isset($product->category)
											@if ($product->category->id === $category->id)
											selected="selected"
											@endif
										@endisset>
										{{ $category->name }}
									</option>
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
								@isset($subcategories)
									@foreach ($subcategories as $subcategory)
										<option value="{{ $subcategory->id }}"
											@isset($product->subcategory)
												@if ($product->subcategory->id === $subcategory->id)
												selected="selected"
												@endif
											@endisset>
											{{ $subcategory->name }}
										</option>
									@endforeach
								@endisset
							</select>
						</div>
					</div>
					{{-- CONDITION --}}
					<div class="input-group">
						<label for="condition">Condition</label>
						<div class="custom-select">
							<select name="condition" id="condition">
								<option disabled="disabled">-- Select --</option>
								@foreach ($conditions as $condition)
									<option value="{{ $condition->id }}"
										@isset($product->condition)
											@if ($product->condition->id === $condition->id)
											selected="selected"
											@endif
										@endisset>
										{{ $condition->name }}
									</option>
								@endforeach
							</select>
						</div>
					</div>
					{{-- STATE --}}
					<div class="input-group">
						<label for="state">State</label>
						<div class="custom-select">
							<select name="state" id="state">
								<option disabled="disabled">-- Select --</option>
								@foreach ($states as $state)
									<option value="{{ $state->id }}"
										@isset($product->state)
											@if ($product->state->id === $state->id)
												selected="selected"
											@endif
										@endisset>
										{{ $state->name }}
									</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
			{{-- IMAGES --}}
			<div id="images-input" class="input-group">
				<label>Images</label>
				<div class="images-wrapper">
					{{-- here goes file inputs --}}
					@isset($product->images)
						@if(sizeof($product->images) >= 1)
							<input type="hidden" name="images-to-remove" id="images-to-remove">
							@foreach ($product->images as $image)
								<div class="image-preview"
								style="background-image: url({{ asset('storage/'. $image->url) }})"
								>
									<input type="hidden" value="{{ $image->id }}">
									{{-- <img src="{{ asset('storage/'. $image->url) }}"> --}}
									<div class="delete-btn"></div>
								</div>
							@endforeach
						@endif
					@endisset
				</div>
			</div>
			{{-- FORM BUTTONS --}}
			<div class="text-right">
				<a href="{{ route('inventory') }}"><div class="btn dark">Cancel</div></a>
				<input type="submit" value="Save" class="btn primary">
			</div>
		</form>
	</div>
@endsection