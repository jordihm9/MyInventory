'use strict';

function requestProduct(productId) {
	$.ajax({
		type: "POST",
		url: "/product/info",
		data: {
			'id': productId
		},
		success: function (data, textStatus, jqXHR) {
			if (data.product !== undefined) {
				openDialog(data.product);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			// console.log(jqXHR);
		}
	});
}

/**
 * Send a request to the server to delete a product by id
 */
function requestDelete() {
	$.ajax({
		type: "POST",
		url: "/product/delete",
		data: new FormData($('#delete-product-form')[0]),
		processData: false,
		contentType: false,
		success: function (data, textStatus, jqXHR) {
			if (data === 'Product deleted') {
				$('#product-container').hide();
				
				$('#success-container').addClass('show')
				.find('.message').text('Product deleted successfully.');
				
				// wait 2.5 sec and reload the page
				setTimeout(()=> {
					location.reload();
				}, 2500);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			//
		}
	});
}

function openDialog(product) {
	cleanDialog();

	const productContainer = $('#product-container');

	productContainer.find('.title').text(product.title);
	productContainer.find('.description').text(product.description);
	let unitPrice = Number(product.unit_price).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	productContainer.find('.unit-price').text(unitPrice);
	productContainer.find('.quantity').text(product.quantity);
	let totalPrice = Number(product.total_price).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	productContainer.find('.total-price').text(totalPrice);

	if (product.category !== null) {
		productContainer.find('.category').text(product.category.name);
	}
	if (product.subcategory !== null) {
		productContainer.find('.subcategory').text(product.subcategory.name);
	}

	productContainer.find('.condition').text(product.condition.name);
	productContainer.find('.state').text(product.state.name);

	if (product.images.length >= 1) {
		for (const image of product.images) {
			$('.product__images').append(
				$('<img>').prop('src', `/storage/${image.url}`)
			);
		}
	}

	let deleteForm = $('#delete-product-form');

	deleteForm.find('input[name=product]').val(product.id);

	deleteForm.on('submit', (e)=> {
			e.preventDefault();
			requestDelete();
		});

	let editBtn = productContainer.find('.edit-btn-link');
	editBtn.prop('href', editBtn.prop('href') + product.id);

	// make it visible
	$('.outer').addClass('show')
		.find('.close-btn').on('click', ()=> {
			$('.outer').removeClass('show');
		});
}

function cleanDialog() {
	const productContainer = $('#product-container');

	productContainer.find('.title').text('');
	productContainer.find('.description').text('');
	productContainer.find('.unit-price').text('');
	productContainer.find('.quantity').text('');
	productContainer.find('.total-price').text('');
	productContainer.find('.subcategory').text('');
	productContainer.find('.category').text('');
	productContainer.find('.condition').text('');
	productContainer.find('.state').text('');

	productContainer.find('.product__images').html('');

	const editBtn = productContainer.find('a').prop('href', '/product/edit?id=');
}