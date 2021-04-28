'use strict';

// select steps containers
const emailStep = $('#email-step');
const codeStep = $('#code-step');
const personalDataStep = $('#personal-data-step');

// select inputs
const emailInput = $('#email');
const codeInput = $('#verification_code');
const nameInput = $('#name');
const surnamesInput = $('#surnames');
const passwordInput = $('#password');
const passwordConfirmInput = $('#password_confirmation');

// select place to show errors
const emailError = $('#email-error');
const codeError = $('#code-error');
const nameError = $('#name-error');
const passwordError = $('#password-error');
const passwordConfirmError = $('#password-confirmation-error');

// hide all errors
removeError(emailError);
removeError(codeError);
removeError(nameError);
removeError(passwordError);

let activeStep; // define active step
changeStep(emailStep); // set the email step as the active

// when form is submited
$('#register-form').submit((e)=> {
	e.preventDefault(); // prevent sending the form

	switch (activeStep) {
		case emailStep:
			validateEmail();
			break;

		case codeStep:
			validateCode();
			break;
			
		case personalDataStep:
			let okname = validateName();
			let okpass = validatePasswords();

			if (okname && okpass) {
				registerUser();
			}
			break;
	}
});

/**
 * Check if email is not empty and has the correct format
 */
function validateEmail() {
	removeError(emailInput, emailError);

	if (validateRequired(emailInput)) {
		let emailformat = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
		if (emailInput.val().match(emailformat)) {
			registerEmail();
		} else {
			setError(emailInput, emailError, 'The email must be a valid email address.');
		}
	} else {
		setError(emailInput, emailError, 'The email field is required.');
	}
}

/**
 * Send the form to the server to register the email
 */
function registerEmail() {
	$.ajax({
		type: "POST",
		url: "/register/email",
		data: new FormData($('#register-form').get(0)),
		processData: false,
		contentType: false,
		success: function (data, textStatus, jqXHR) {
			if (jqXHR.responseText === 'registered') {
				changeStep(codeStep);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			let errors = jqXHR.responseJSON.errors;
			setError(emailInput, emailError, errors.email[0])
		}
	});
}

/**
 * Verify the code sending a request to the server to verify the email
 */
function validateCode() {
	removeError(codeInput, codeError);

	if (validateRequired(codeInput)) {
		$.ajax({
			type: "POST",
			url: "/register/validate",
			data: new FormData($('#register-form').get(0)),
			processData: false,
			contentType: false,
			success: function (data, textStatus, jqXHR) {
				if (jqXHR.responseText === 'verified') {
					changeStep(personalDataStep);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				if (jqXHR.responseText === 'not_verified') {
					setError(codeInput, codeError, 'The verification code is not correct.');
				}
			}
		});
	} else {
		setError(codeInput, codeError, 'The verification code field is required.');
	}
}

/**
 * Send the form to the server 
 */
function registerUser() {
	$.ajax({
		type: "POST",
		url: "/register/user",
		data: new FormData($('#register-form').get(0)),
		processData: false,
		contentType: false,
		success: function (data, textStatus, jqXHR) {
			window.location.replace('/login');
		},
		error: function(jqXHR, textStatus, thrownError) {
			let errors = jqXHR.responseJSON.errors;
			if (errors) {
				if (errors.email) {
					alert('An error occured with email:\n'+ errors.email[0]);
				} else {
					if (errors.name) {
						setError(nameInput, nameError, errors.name[0]);
					}
					if (errors.password) {
						setError(passwordInput, passwordError, errors.password[0]);
					}
				}
			}
		}
	});
}

/**
 * Check name input is not empty
 * @returns {boolean} true if is NOT empty
 */
function validateName() {
	removeError(nameInput, nameError);

	let notEmpty = validateRequired(nameInput);
	if (!notEmpty) {
		setError(nameInput, nameError, 'The name field is required.');
	}
	return notEmpty;
}

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

/**
 * Check if the input is empty of not
 * @param {object} input input element
 * @returns {boolean} true if input is NOT empty
 */
function validateRequired(input) {
	return input.val() !== '';
}

/**
 * Add the error class after 250ms and set and show the error element
 * @param {object} input 
 * @param {object} error 
 * @param {string} message 
 */
function setError(input, error, message) {
	setTimeout(() => {
		input.addClass('error');
		$(error).text(message).show();
	}, 250);
}

/**
 * Clear the text and hide the error element & remove the error class from the input
 * @param {object} element 
 * @param {object} error
 */
function removeError(input, error) {
	input.removeClass('error');
	$(error).text('').hide();
}

/**
 * Change step and hide or show
 * @param {object} step step to change to
 */
function changeStep(step) {
	activeStep = step;

	switch(activeStep) {
		case emailStep:
			emailStep.show();
			codeStep.hide();
			personalDataStep.hide();
			emailInput.focus();
			break;
		case codeStep:
			emailStep.hide();
			codeStep.show();
			personalDataStep.hide();
			codeInput.focus();
			break;
		case personalDataStep:
			emailStep.hide();
			codeStep.hide();
			personalDataStep.show();
			nameInput.focus();
			break;
	}
}