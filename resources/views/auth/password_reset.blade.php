@extends('auth.master')

@push('scripts')
	<script src="{{ asset('/js/validations-helpers.js') }}"></script>
	<script src="{{ asset('/js/validate-passwords.js') }}"></script>
	<script src="{{ asset('/js/change-password.js') }}" defer></script>
@endpush

@section('title', 'Reset password')

@section('content')
	<form id="change-password-form" action="{{ route('password_reset.change_password') }}" method="POST">
		@csrf
		<input type="hidden" name="email" value="{{ $email }}">
		<input type="hidden" name="uuid" value="{{ $uuid }}">
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
		<div class="submit-container">
			<input type="submit" value="Change password" class="btn primary">
		</div>
	</form>
@endsection