@extends('mail.master')

@section('content')
	<div class="container" style="width: 500px; margin-top: 10vh">
		<div class="text-center">
			<h2>Reset password</h2>
		</div>
		<div>
			<p>
			</p>
			<p>
				Dear {{ $email->user->name }},
				<br>
				<strong>We have received a request to reset the password</strong>
				<br>
				Click the following button to open a web page that will allow you to directly set a new password for your account.
			</p>
			<div class="text-center" style="margin: 15px;">
				<a href="{{ route('password_reset.change_password.view', ['uuid' => $email->verification_code, 'email' => $email->email]) }}">
					<div class="btn primary">Reset password</div>
				</a>
			</div>
			<p>
				If you did not request to reset your password on My Inventory, delete or ignore this message.
				<br><br>
				Regards,
				<br>
				My Inventory Team
			</p>
		</div>
	</div>
@endsection