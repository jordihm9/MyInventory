@extends('auth.master')

@push('scripts')
	<script src="{{ asset('js/validations-helpers.js') }}"></script>
@endpush

@section('title', 'Recover')

@section('content')
	<form id="password-reset-request" action="{{ route('password_reset.request') }}" method="POST">
		@csrf
		<div class="input-group required">
			<label for="email">Email</label>
			<input type="text" name="email" id="email" value="{{ old('email') }}" class="@error('email') error @enderror" autofocus>
			<span id="email-error" class="error__message">
				@error('email')
					{{ $message }}
				@enderror
			</span>
		</div>
		<div class="submit-container">
			<input type="submit" value="Send password reset email" class="btn primary">
		</div>
	</form>
	@isset($success)
		<script>
			$('#password-reset-request').hide();
		</script>
		<div class="text-center">
			<h4>{{ $success }}</h4>
		</div>
	@endisset
@endsection