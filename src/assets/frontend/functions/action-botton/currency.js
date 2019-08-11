let save_changes_button = function () {
    $('.btn-success').removeClass('add-currency');
    $('.btn-success').addClass('edit-currency');
    $('.btn-success').html("<span><i class='fa fa-save'></i><span> Save Changes</span></span>");
    $('.btn-warning').removeClass('reset');
    $('.btn-warning').addClass('update-reset');
}

let save_button = function () {
    $('.btn-success').removeClass('edit-currency');
    $('.btn-success').addClass('add-currency');
    $('.btn-success').html("<span><i class='fa fa-save'></i><span> Save New</span></span>");
    $('.btn-warning').addClass('reset');
    $('.btn-warning').removeClass('update-reset');
}


let simpan = $('.modal-footer').on('click', '.clse', function () {
    save_button();
});
