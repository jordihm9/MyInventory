@extends('auth.master')

@section('title', 'Log in')

@section('content')
	<form action="{{ route('login.login') }}" method="post" id="login-form">
		<div class="input-group required">
			<label for="email">Email</label>
			<input type="text" name="email" id="email">
		</div>
		<div class="input-group required">
			<label for="password">Password</label>
			<input type="password" name="password" id="password">
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