let save_changes_button = function () {
    $('.btn-success').removeClass('add-unit');
    $('.btn-success').addClass('edit-unit');
    $('.btn-success').html("<span><i class='fa fa-save'></i><span> Save Changes</span></span>");
    $('.btn-warning').removeClass('reset');
    $('.btn-warning').addClass('update-reset');
}

let save_button = function () {
    $('.btn-success').removeClass('edit-unit');
    $('.btn-success').addClass('add-unit');
    $('.btn-success').html("<span><i class='fa fa-save'></i><span> Save New</span></span>");
    $('.btn-warning').addClass('reset');
    $('.btn-warning').removeClass('update-reset');
}


let simpan = $('.modal-footer').on('click', '.clse', function () {
    save_button();
});
