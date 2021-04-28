@extends('layouts.master')

@push('scripts')
	<script src="{{ asset('js/hero-typing-effect.js') }}" defer></script>
@endpush

@section('content')
	{{-- LANDING --}}
	<section id="hero">
		<div class="wrapper">
			<h1 class="title">My inventory</h1>
			<span id="hero-text"></span>
		</div>
	</section>
	{{-- STEPS --}}
	<section id="steps" class="container">
		<div class="text-center">	
			<h1 class="underline">Start organising</h1>
		</div>
		<article class="step">
			<div class="step__image">
				<img src="images/undraw_camera.svg" alt="camera">
			</div>
			<div class="step__text">
				<h3>Step 1</h3>
				<p class="text-center">
					<b>Take a photo</b> of all what you have at home or whatever you want to sell.
				</p>
			</div>
		</article>
		<article class="step">
			<div class="step__image">
				<img src="images/undraw_uploading.svg" alt="person using a computer and a loading bar">
			</div>
			<div class="step__text">
				<h3>Step 2</h3>
				<p class="text-center">
					<b>Upload</b> a product with as many as images you want, give a name, description and other information.
				</p>
			</div>
		</article>
		<article class="step">
			<div class="step__image"><img src="images/undraw_list.svg" alt="list"></div>
			<div class="step__text">
				<h3>Step 3</h3>
				<p class="text-center">
					<b>Manage</b>, <b>search</b> and <b>filter</b> products by your preferences in your inventory.
				</p>
			</div>
		</article>
		<article class="step">
			<div class="step__image"><img src="images/undraw_segmentation.svg" alt="graphics"></div>
			<div class="step__text">
				<h3>Step 4</h3>
				<p class="text-center">
					Generate <b>reports</b> and <b>graphics</b> when you need them or program when you want to receive.
				</p>
			</div>
		</article>
	</section>
@endsection