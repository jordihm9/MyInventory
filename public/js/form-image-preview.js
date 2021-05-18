'use strict';

let inputsCounter = 0;
let imagesToRemoveInput;

$(document).ready(function () {
	imagesToRemoveInput = $('#images-to-remove');
	// clear the value
	imagesToRemoveInput.val('');

	// get the images added by edit mode
	let productImages = $('#images-input .images-wrapper').find('.image-preview');
	// loop over each image and add the click event listener on the delete button
	$.each(productImages, function (i, image) { 
		// get the delete button and add the event listener
		$(image).find('.delete-btn').on('click', (e)=> {
			if (removeInput(e)) {
				removeImage(e);
			}
		});
	});

	// add an empty input to add a file
	addInput();
});

/**
 * Append a div with a label and a file input
 */
function addInput() {
	let input = $('<div>')
		.addClass('image-preview')
		.append(
			$('<div>')
				.addClass('cross')
		)
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

/**
 * Remove an input to delete the file
 * @param {object} e 
 */
function removeInput(e) {
	let confirmation = confirm('Are you sure you want to remove the image?');
	if (confirmation) {
		$(e.target).parent().remove();
	}
	return confirmation;
}

function removeImage(e) {
	// get the id from the image
	let id = $(e.target).parent().find('input[type=hidden]').val();
	// append the id to the input with the images to delete
	imagesToRemoveInput.val(imagesToRemoveInput.val() + ','+ id);
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
				// .append(
				// 	$('<img>')
				// 		.prop('src', fileReader.result)
				// )
				.css({
					'background-image': `url(${fileReader.result})`,
				})
				.append(
					$('<div>')
						.addClass('delete-btn')
						.on('click', (e)=> {
							removeInput(e);
						})
				)
				.find('.cross').remove();
		})

		// add another input when it ends
		addInput();
	}
}