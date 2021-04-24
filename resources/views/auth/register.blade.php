@extends('auth.master')

@push('scripts')
	<script src="{{ asset('js/register.js') }}" defer></script>
@endpush

@section('title', 'Register')

@section('content')
	<form action="{{ route('register.user') }}" method="post" id="register-form">
		@csrf
		<div id="email-step" class="input-group required">
			<label for="email">Email</label>
			<input type="text" name="email" id="email">
			<span id="email-error" class="error__message"></span>
		</div>
		<div id="code-step" class="input-group required">
			<label for="verification_code">Verification code</label>
			<input type="text" name="verification_code" id="verification_code">
			<span id="code-error" class="error__message"></span>
		</div>
		<div id="personal-data-step">
			<div class="input-group required">
				<label for="name">Name</label>
				<input type="text" name="name" id="name">
				<span id="name-error" class="error__message"></span>
			</div>
			<div class="input-group">
				<label for="surnames">Surnames</label>
				<input type="text" name="surnames" id="surnames">
			</div>
			{{-- <div class="input-group">
				<label for="sex">Sex</label>
				<input type="radio" name="sex" id="m" value="m" class="btn radio">
				<input type="radio" name="sex" id="null" value="null" class="btn radio">
				<input type="radio" name="sex" id="f" value="f" class="btn radio">
			</div> --}}
			<div class="input-group required">
				<label for="password">Password</label>
				<input type="password" name="password" id="password">
				<span id="password-error" class="error__message"></span>
			</div>
			<div class="input-group required">
				<label for="password_confirmation">Confirm password</label>
				<input type="password" name="password_confirmation" id="password_confirmation">
				<span id="password-confirmation-error" class="error__message"></span>
			</div>
		</div>
		<div class="submit-container">
			<input type="submit" value="Continue" class="btn primary">
		</div>
	</form>
	<p class="text-center">
		Already have an account? <a href="{{ route('login.view') }}">Log in</a>
	</p>
@endsection