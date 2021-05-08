'use strict';

let inputsCounter = 0;

$(document).ready(function () {
	addInput();
});

/**
 * Append a div with a label and a file input
 */
function addInput() {
	let input = $('<div>')
		.addClass('image-preview')
		.append(
			$('<label>')
				.prop('for', `image${inputsCounter}`)
		)
		.append(
			$('<input>')
				.prop('type', 'file')
				.prop('name', `image${inputsCounter}`)
				.prop('id', `image${inputsCounter}`)
				.prop('hidden', true)
				.on('change', (e)=> {
					makePreview(e);
				})
		);
	
	$('#images-input .images-wrapper')[0].append(input[0]);

	// increment counter
	inputsCounter++;
}

function removeInput(e) {
	if (confirm('Are you sure you want to remove the image?')) {
		$(e.target).parent().remove();
	}
}

/**
 * Get the file input that was uploaded a file and append an image tag to preview it
 * @param {object} e event from event listener
 */
function makePreview(e) {
	// get the input that changed
	const input = e.target;
	
	// get the file set to the input
	const image = input.files[0];
	
	if (image) {
		const fileReader = new FileReader();
		fileReader.readAsDataURL(image);
	
		fileReader.addEventListener('load', (e)=> {
			// get the preview element for the input
			let preview = $(input).parent().get(0);
			// append the image tag
			$(preview)
				.append(
					$('<img>')
						.prop('src', fileReader.result)
				)
				.append(
					$('<div>')
						.addClass('delete-btn')
						.on('click', (e)=> {
							removeInput(e);
						})
			);
		})

		// add another input when it ends
		addInput();
	}
}