@extends('auth.master')

@section('title', 'Log in')

@section('content')
	<form action="{{ route('login.login') }}" method="post" id="login-form">
		@csrf
		<div class="input-group required">
			<label for="email">Email</label>
			<input type="text" name="email" id="email" value="{{ old('email') }}" class="@error('credentials') error @enderror" autofocus>
			@error('email')
				<span class="error__message">{{ $message }}</span>
			@enderror
		</div>
		<div class="input-group required">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="@error('credentials') error @enderror">
			@error('password')
				<span class="error__message">{{ $message }}</span>
			@enderror
			@error('credentials')
				<span class="error__message">{{ $message }}</span>
			@enderror
		</div>
		<p class="text-right">
			<a href="{{ route('password_reset.request.view') }}">Forgot password?</a>
		</p>
		<div class="submit-container">
			<input type="submit" value="Log in" class="btn primary">
		</div>
	</form>
	<p class="text-center">
		Don't have an account? <a href="{{ route('register.view') }}">Register</a>
	</p>
	@auth
		<div class="outer show">
			<div class="container text-center centered show">
				<div class="warning-sign"></div>
				<h3>
					You are logged in!
				</h3>
				<div class="submit-container">
					<a href="{{ route('home') }}">
						<div class="btn primary" onclick="$('.outer').removeClass('show');">Go home</div>
					</a>
				</div>
			</div>
		</div>
	@endauth
@endsection