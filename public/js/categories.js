'use strict';

$(document).ready(function () {
	// listen for category change
	$('#category').on('change', ()=> {
		const category = $('#category').val();
		if (category !== 'all') {
			getSubcategories(category);
		}
	});
});

/**
 * Send a request to the server asking for the subcategories from a category
 * @param {number} category id of the category
 */
function getSubcategories(category) {
	$.ajax({
		type: "POST",
		url: `/category/${category}/subcategories/`,
		success: function (data, textStatus, jqXHR) {
			appendSubcategories(data.subcategories);
		}
	});
}

/**
 * Remove all the options from the subcategories select and append the new subcategories options
 * @param {object} subcategories list of subcategories objects
 */
function appendSubcategories(subcategories) {
	// get the select html element
	const subcategorySelect = $('#subcategory');

	// remove all the options
	subcategorySelect.html('');

	// append the 'all' default option
	subcategorySelect.append($('<option>').val('all').text('-- All --'));

	// check if there are subcategories
	if (subcategories.length >= 1) {
		// loop over each subcategory and append it as an option
		for (const subcategory of subcategories) {
			subcategorySelect.append($('<option>').val(subcategory.id).text(subcategory.name));
		}
	}
}