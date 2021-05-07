'use strict';

let unitPrice = 0;
let quantity = 1;
let totalPrice = 0;

// select inputs
const titleInput = $('#title');
const unitPriceInput = $('#unit-price');
const quantityInput = $('#quantity');
const totalPriceInput = $('#total-price');

// select places to show errors
const titleError = $('#title-error');
const unitPriceError = $('#price-error');
const quantityError = $('#quantity-error');

$(document).ready(function () {
	// remove all errors when page loads
	// removeError(titleInput, titleError);
	// removeError(unitPriceInput, unitPriceError);
	// removeError(quantityInput, quantityError);
	
	writeUnitPrice();
	writeQuantity();
	if (totalPriceInput.val() !== '') {
		// cast to float after replacing ',' to '.'
		totalPrice = parseFloat(totalPriceInput.val().replace(/\,/, '.'));
	}
	writeTotalPrice();
});

// detect when form is submited
$('#product-form').submit((e)=> {
	let titleOk = validateTitle();
	let unitPriceOk = validateUnitPrice();
	let quantityOk = validateQuantity();
	
	// validate all inputs necessary, if at least 1 fails, prevent sending the form
	if (!titleOk || !unitPriceOk || !quantityOk) {
		e.preventDefault();
	} else {
		// remove disabled property from total price to add it automatically in request
		totalPriceInput.prop('disabled', false);
	}
});

// validate inputs when lose focus or change
titleInput.on('focusout change', validateTitle);
unitPriceInput.on('focusout change', calculateTotalPrice);
quantityInput.on('focusout change', calculateTotalPrice);

/**
 * Write the unit price into the input
 */
function writeUnitPrice() {
	if (unitPriceInput.val() !== '') {
		// cast to float after replacing ',' to '.'
		unitPrice = parseFloat(unitPriceInput.val().replace(/\,/, '.'));
	}
	// write the unit price to the input formatting
	unitPriceInput.val(formatPrice(unitPrice));
}

/**
 * Write the quantity into the input
 */
function writeQuantity() {
	if (quantityInput.val() !== '') {
		quantity = quantityInput.val();
	}
	// write the quantity to the input
	quantityInput.val(quantity);
}

/**
 * Write the total price into the input
 */
function writeTotalPrice() {
	// write the total to the input formatting
	totalPriceInput.val(formatPrice(totalPrice));
}

/**
 * Check title input is not empty
 * @return {boolean} true if passes all validations related
 */
function validateTitle() {
	removeError(titleInput, titleError);

	let validated = validateRequired(titleInput);
	if (!validated) {
		setError(titleInput, titleError, 'The title field is required.');
	}
	return validated;
}

/**
 * Check unit price input is not empty, is a number and format with 2 decimals
 * @return {boolean} true if passes all validations related
 */
function validateUnitPrice() {
	removeError(unitPriceInput, unitPriceError);

	let validated = validateRequired(unitPriceInput);
	if (!validated) {
		setError(unitPriceInput, unitPriceError, 'The unit price field is required.');
	} else {
		validated = checkNumber(unitPriceInput, unitPriceError, 'unit price');
		if (validated) {
			writeUnitPrice();
		}
	}
	return validated;
}

/**
 * Check quantity input is not empty and its a number
 * @return {boolean} true if passes all validations related
 */
 function validateQuantity() {
	removeError(quantityInput, quantityError);

	let validated = validateRequired(quantityInput);
	if (!validated) {
		setError(quantityInput, quantityError, 'The quantity field is required.');
	} else {
		validated = checkNumber(quantityInput, quantityError, 'quantity');
		if (validated) {
			writeQuantity();
		}
	}
	return validated;
}

/**
 * Validate if the value from the input is a number
 * @param {object} input 
 * @param {object} error 
 * @param {string} fieldName 
 * @returns {boolean} true if is a valid number
 */
function checkNumber(input, error, fieldName) {
	// get the value from the input
	let value = input.val();
	// replace comma to dots
	value = value.replace(/\,/, '.');
	// try to cast the value from the input to float
	value = parseFloat(value);
	// check if the new value is a valid number
	let valid = !isNaN(value);
	
	// if is not a number, set an error
	if (!valid) {
		setError(input, error, `The ${fieldName} field must be a number.`);
	}
	return valid;
}

/**
 * Format a number to have 2 decimal separated by comma
 * @param {number} value 
 * @returns formated number
 */
function formatPrice(value) {
	return value.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

/**
 * Recalculate the total price multiplying the quantity by the unit price
 */
function calculateTotalPrice() {
	let quantityOk = validateQuantity();
	let unitPriceOk = validateUnitPrice();

	if (quantityOk && unitPriceOk) {
		// calculate the total
		totalPrice = parseInt(quantity) * parseFloat(unitPrice);
	} else {
		totalPrice = 0;
	}
	writeTotalPrice();
}