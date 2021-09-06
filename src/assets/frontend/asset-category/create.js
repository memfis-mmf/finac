let TypeAssetCreate = {
	init: function () {

		let _url = window.location.origin;

		let simpan = $('body').on('click', '#typeassetsave', function () {

				let form = $(this).parents('form');
				let _data = form.serialize();

				$.ajax({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: 'post',
						url: '/typeasset',
						data: _data,
						success: function (data) {
								if (data.errors) {
										if (data.errors.code) {
												$('#code-error').html(data.errors.code[0]);

												document.getElementById('code').value = code;
												document.getElementById('name').value = name;
												document.getElementById('type').value = type;
												document.getElementById('level').value = level;
												document.getElementById('description').value = description;
												coa_reset();
										}
								} else {
										toastr.success('Data saved.', 'Success', {
												timeOut: 5000
										});

										setTimeout(function(){
											location.href = `${_url}/typeasset`;
										}, 2000);

										$('#code-error').html('');
								}
						}
				});
		});

	}
};

jQuery(document).ready(function () {
    TypeAssetCreate.init();
});
