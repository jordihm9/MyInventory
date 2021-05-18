'use strict';

const outer = $('.outer');

const updateInfoBtn = $('#update-info-btn');
const changePasswordBtn = $('#change-password-btn');

const updateInfoContainer = $('#update-info-container');
const changePasswordContainer = $('#change-password-container');

const nameInput = $('#name');
const surnamesInput = $('#surnames');
const oldPasswordInput = $('#old-password');
const passwordInput = $('#password');
const passwordConfirmInput = $('#password_confirmation');

const nameError = $('#name-error');
const oldPasswordError = $('#old-password-error');
const passwordError = $('#password-error');
const passwordConfirmError = $('#password-confirmation-error');

/**
 * When document is ready listen for
 * - edit profile info button click and change password
 * - forms submited
 */
$(document).ready(function () {
	updateInfoBtn.on('click', openUpdateProfileDialog);
	changePasswordBtn.on('click', openChangePasswordDialog);
	
	updateInfoContainer.on('submit', (e)=> {
		if (!validateName()) {
			e.preventDefault();
		}
	});
	
	changePasswordContainer.on('submit', (e)=> {
		e.preventDefault();

		let oldPassOk = validateOldPassword();
		let passwordsOk = validatePasswords();

		if (oldPassOk && passwordsOk) {
			updatePasswords();
		}
	});
});

/**
 * show the update profile info dialog
 */
function openUpdateProfileDialog() {
	removeError(nameError);
	
	outer.addClass('show');

	updateInfoContainer.addClass('show')
		.find('.close-btn')
		.on('click', ()=> {
			updateInfoContainer.removeClass('show');
			outer.removeClass('show');
		});
}

/**
 * Show the change password dialog
 */
function openChangePasswordDialog() {
	removeError(passwordError);
	removeError(passwordConfirmError);
	
	outer.addClass('show');

	changePasswordContainer.addClass('show')
		.find('.close-btn')
		.on('click', ()=> {
			changePasswordContainer.removeClass('show');
			outer.removeClass('show');
		});
}

/**
 * Validate the old password input is not empty
 */
function validateOldPassword() {
	removeError(oldPasswordInput, oldPasswordError);

	let validated = false;
	if (validateRequired(oldPasswordInput)) {
		validated = true;	
	} else {
		setError(oldPasswordInput, oldPasswordError, 'The old password field is required.');
	}

	return validated;
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

function updatePasswords() {
	$.ajax({
		type: "POST",
		url: "/account/change-password",
		data: new FormData(changePasswordContainer[0]),
		processData: false,
		contentType: false,
		success: function (data, textStatus, jqXHR) {
			if (data == 200) {
				changePasswordContainer.removeClass('show');
				$('#success-container').addClass('show')
					.find('.message').text('Password changed successfully');
				
				setTimeout(()=> {
					$('#success-container').removeClass('show');
					outer.removeClass('show');
				}, 2500);
			} else {
				setError(oldPasswordInput, oldPasswordError, data['old-password']);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(jqXHR);
		}
	});
}