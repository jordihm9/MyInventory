'use strict';

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
