'use strict';

// select inputs
const passwordInput = $('#password');
const passwordConfirmInput = $('#password_confirmation');

const passwordError = $('#password-error');
const passwordConfirmError = $('#password-confirmation-error');

removeError(passwordError);
removeError(passwordConfirmError);

$('#change-password-form').on('submit', (e)=> {
	if (!validatePasswords()) {
		e.preventDefault();
	}
})