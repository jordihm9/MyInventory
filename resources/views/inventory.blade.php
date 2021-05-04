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
					<input type="radio" name="price" value="high" id="high-price" hidden="hidden">
					<label for="high-price" class="btn radio">High</label>
					
					<input type="radio" name="price" value="low" id="low-price" hidden="hidden">
					<label for="low-price" class="btn radio">Low</label>
				</div>
			</div>
			<div class="input-group">
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
				<label for="condition">Condition</label>
				<div class="radio-wrapper">
					@foreach ($conditions as $condition)
						<input type="radio" name="condition" value="{{ $condition->id }}" id="condition-b{{ $condition->id }}" hidden="hidden">
						<label for="condition-b{{ $condition->id }}" class="btn radio">{{ $condition->name }}</label>
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
@endsection