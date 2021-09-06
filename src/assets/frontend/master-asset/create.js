let AssetCreate = {
	init: function () {

		let _url = window.location.origin;

		let simpan = $('body').on('click', '#master_asset_save', function () {

				let form = $(this).parents('form');
				let _data = form.serialize();

				$.ajax({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type: 'post',
						url: '/asset',
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
												timeOut: 2000
										});

										setTimeout(function(){
											location.href = `${_url}/asset/${data.uuid}/edit`;
										}, 2000);
								}
						}
				});
		});

	}
};

jQuery(document).ready(function () {
    AssetCreate.init();
});
