@extends('layouts.master')

@push('scripts')
	<script src="{{ asset('/js/validations-helpers.js') }}"></script>
	<script src="{{ asset('/js/validate-passwords.js') }}"></script>
	<script src="{{ asset('/js/manage-account.js') }}" defer></script>
@endpush

@section('content')
	<div class="container fit">
		<div class="text-center">
			<h2 class="underline">Account details</h2>
		</div>
		<div class="user-info">
			<div class="profile-pic">
				<img src="/images/undraw_profile_pic.svg" alt="Profile picture">
			</div>
			<div class="text-center">
				<p class="user-name">
					{{ Auth::user()->name }} {{ Auth::user()->surnames }}
				</p>
				<p class="user-email">
					{{ Auth::user()->email->email }}
				</p>
			</div>
			<div class="btn-wrapper">
				<div id="update-info-btn" class="btn primary">Update info</div>
				<div id="change-password-btn" class="btn dark">Change password</div>
			</div>
		</div>
	</div>
	<div class="outer">
		{{-- UPDATE USER INFO --}}
		<form id="update-info-container" action="{{ route('account.update') }}" method="POST" class="centered container">
			<div class="close-btn"></div>
			@csrf
			<div class="text-center" style="margin: 1em 0;">
				<h3 class="underline">Update info</h3>
			</div>
			<div class="input-group required">
				<label for="name">Name</label>
				<input type="text" name="name" id="name" value="{{ Auth::user()->name }}">
				<span id="name-error" class="error__message"></span>
			</div>
			<div class="input-group">
				<label for="surnames">Surnames</label>
				<input type="text" name="surnames" id="surnames" value="{{ Auth::user()->surnames }}">
			</div>
			{{-- <div class="input-group">
				<label for="sex">Sex</label>
				<input type="radio" name="sex" id="m" value="m" class="btn radio">
				<input type="radio" name="sex" id="null" value="null" class="btn radio">
				<input type="radio" name="sex" id="f" value="f" class="btn radio">
			</div> --}}
			<div class="submit-container">
				<input type="submit" value="Update" class="btn primary">
			</div>
		</form>
		{{-- CHANGE PASSWORD CONTAINER --}}
		<form id="change-password-container" action="{{ route('account.change_password') }}" method="POST" class="centered container">
			<div class="close-btn"></div>
			@csrf
			<div class="text-center" style="margin: 1em 0;">
				<h3 class="underline">Change Password</h3>
			</div>
			<div class="input-group required">
				<label for="old-password">Old password</label>
				<input type="password" name="old-password" id="old-password">
				<span id="old-password-error" class="error__message"></span>
			</div>
			<div class="input-group required">
				<label for="password">New password</label>
				<input type="password" name="password" id="password">
				<span id="password-error" class="error__message"></span>
			</div>
			<div class="input-group required">
				<label for="password_confirmation">Confirm new password</label>
				<input type="password" name="password_confirmation" id="password_confirmation">
				<span id="password-confirmation-error" class="error__message"></span>
			</div>
			<div class="submit-container">
				<input type="submit" value="Change" class="btn primary">
			</div>
		</form>
		{{-- SUCCESS MESSAGE CONTAINER --}}
		<div id="success-container" class="centered container">
			<div class="text-center">
				<h4 class="message"></h4>
			</div>
			{{-- <div class="submit-container">
				<div class="btn primary">Close</div>
			</div> --}}
		</div>
	</div>
@endsection