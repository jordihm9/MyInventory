'use strict';

// hide and show the search and filter container
$('.toggle-search-filter').on('click', ()=> {
	$('#search-filter.container').toggleClass('show');
});

// get the container which has all the products
const productsContainer = $('#products');

// get the search and filter form
const searchFilterForm = $('#search-filter-form');

// get the inputs from the form
const formInputs = searchFilterForm.find('input, select');

// send the request when:
// form is submited
searchFilterForm.on('submit', (e)=> {
	e.preventDefault(); // prevent sending the form to not reaload the page
	makeRequest();
});
// reset form
searchFilterForm.on('reset', ()=> {
	// wait 100 milliseconds to send the request to let reset the form before sending
	setTimeout(()=> {
		makeRequest();
	}, 100);
});
// detect any change on inputs or selects
formInputs.on('change', makeRequest);

/**
 * Send the request to the server asking for the products filtered y the search and filter form
 */
function makeRequest() {
	$.ajax({
		type: "POST",
		url: "/inventory/filter",
		data: new FormData($(searchFilterForm)[0]),
		processData: false,
		contentType: false,
		success: function (data, textStatus, jqXHR) {
			if (jqXHR.status === 200) {
				appendProducts(jqXHR.responseJSON.products);
			}
		}
	});
}

/**
 * Get a list of products, clear the current list and append the products received
 * @param {object} products 
 */
function appendProducts(products) {
	// remove all the products from the current list
	productsContainer.html('');

	if (products !== null && products.length >= 1) {
		// loop over each product and append it to the products
		for (let i = 0; i < products.length; i++) {
			const product = products[i];

			// get the first 30 characters of the title
			let title = product.title.substr(0, 30);
			// check if the original title has more than 30 characters to append 3 dots at the end
			if (product.title.length > 30) {
				title += '...';
			}

			// create the container
			let container = $('<div>')
				.addClass('product')
				.on('click', ()=> {
					requestProduct(product.id)
				});
			
			// create the text box to insert the product title
			let text = $('<div>').addClass('product__text').text(title);
			
			// create the box for the image
			let image = $('<div>').addClass('product__image-container').css({
				'background-image': `url(storage/${product.images[0].url})`,
			});

			// create the button link to edit the product
			let editBtn =
				$('<a>')
					.prop('href', `product/edit?id=${product.id}`)
					.append(
						$('<div>')
							.addClass('edit-btn')
							.append(
								$('<img>')
									.prop('src', 'images/icons/edit.svg')
									.prop('alt', 'edit')
							)
					);

			// each product will be added with delay to make an effect
			setTimeout(()=> {
				productsContainer.append(
					container.append(text).append(image).append(editBtn)
				);
			}, 50*i);
		}
	} else {
		// no products were found
		productsContainer.append(
			$('<div>')
				// .prop('id', 'empty-search')
				.addClass('empty-search text-center')
				.append(
					$('<h2>').text('No products matched the search')
				)
				.css({
					'grid-column': '1 / 4',
					'margin-top': '25%'
				})
		)
	}
}