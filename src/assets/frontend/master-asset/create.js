let AssetCreate = {
	init: function () {

		let _url = window.location.origin;

    $.ajax({
        url: _url+'/asset/data/',
        type: 'GET',
        dataType: 'json',
        success: function (data) {

            $('select#asset_category_id').empty();

            $.each(data, function (key, value) {
							console.log(key);
              $('select#asset_category_id').append(
                  '<option value="' + key + '">' + value + '</option>'
              );
            });
        }
    });

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
										toastr.success('Data berhasil disimpan.', 'Sukses', {
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
