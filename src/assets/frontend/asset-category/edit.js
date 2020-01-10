let TypeAssetEdit = {
    init: function () {

			let _url = window.location.origin;

			let ubah = $('body').on('click', '#typeassetsave', function () {

					let button = $(this);
					let form = button.parents('form');
					let _data = form.serialize();
					let uuid = button.data('uuid');

					$.ajax({
							headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							type: 'put',
							url: `/typeasset/${uuid}`,
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
													timeOut: 5000
											});

											 setTimeout(function(){
												 location.href = `${_url}/typeasset`;
											 }, 2000);
									}
							}
					});
			});

			$('.paging_simple_numbers').addClass('pull-left');
			$('.dataTables_length').addClass('pull-right');
			$('.dataTables_info').addClass('pull-left');
			$('.dataTables_info').addClass('margin-info');
			$('.paging_simple_numbers').addClass('padding-datatable');

			$('.dataTables_filter').on('click', '.refresh', function () {
					$('#coa_datatables').DataTable().ajax.reload();

			});

    }
};

jQuery(document).ready(function () {
    TypeAssetEdit.init();
});
