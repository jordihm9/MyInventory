@extends('mail.master')

@section('content')
	<div class="container" style="width: 475px; margin-top: 10vh">
		<div class="text-center">
			<h2 class="underline">My Inventory</h2>
		</div>
		<div>
			<p style="font-size: 1.35em">
				<strong>Confirm your registration</strong>
			</p>
			<p>
				Here is your verification code:
			</p>
			<div class="text-center">
				<span style="color: #FD7A33; font-size: 1.40em">{{ $verification_code }}</span>
			</div>
		</div>
	</div>
@endsection