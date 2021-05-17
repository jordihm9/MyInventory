'use stricts';

/**
 * Check if both passwords inputs are not empty, follow a the minimum password strength and are the same
 * @returns {boolean}
 */
 function validatePasswords() {
	removeError(passwordInput, passwordError);
	removeError(passwordConfirmInput, passwordConfirmError);

	let validated = false;
	if (validateRequired(passwordInput)) {
		let passwordStrength = /^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})/;
		if (passwordInput.val().match(passwordStrength)) {
			if (passwordInput.val() === passwordConfirmInput.val())	{
				validated = true;
			} else {
				setError(passwordConfirmInput, passwordConfirmError, 'Passwords don\'t match.');
			}
		} else {
			setError(passwordInput, passwordError, 'The password must contain at least 1 lowercase character, 1 uppercase character, 1 numeric character and be 6 characters long.');
		}
	} else {
		setError(passwordInput, passwordError, 'The password field is required.');
		setError(passwordConfirmInput, passwordConfirmError, '');
	}
	return validated;
}