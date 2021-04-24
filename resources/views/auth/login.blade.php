@extends('auth.master')

@section('title', 'Log in')

@section('content')
	<form action="{{ route('login.login') }}" method="post" id="login-form">
		@csrf
		<div class="input-group required">
			<label for="email">Email</label>
			<input type="text" name="email" id="email" value="{{ old('email') }}" class="@error('email') error @enderror" autofocus>
			@error('email')
				<span class="error__message">{{ $message }}</span>
			@enderror
		</div>
		<div class="input-group required">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="@error('password') error @enderror">
			@error('password')
				<span class="error__message">{{ $message }}</span>
			@enderror
			@error('credentials')
				<span class="error__message">{{ $message }}</span>
			@enderror
		</div>
		<p class="text-right">
			<a href="#">Forgot password?</a>
		</p>
		<div class="submit-container">
			<input type="submit" value="Log in" class="btn primary">
		</div>
	</form>
	<p class="text-center">
		Don't have an account? <a href="{{ route('register.view') }}">Register</a>
	</p>
@endsection