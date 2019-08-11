let save_chagnes_button = function () {
    $('.btn-success').removeClass('add');
    $('.btn-success').addClass('update');
    $('.btn-success').html("<span><i class='fa fa-save'></i><span>Save Changes</span></span>");
};

let save_new_button = function () {
    if ($('.update')[0]) {
        $('.btn-success').removeClass('update');
        $('.btn-success').addClass('add');
        $('.btn-success').html("<span><i class='fa fa-save'></i><span>Save New</span></span>");
    }
};

let close = $('.modal-footer').on('click', '.close', function () {
    save_new_button();
});
