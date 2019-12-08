let Payroll = {
    init: function () {
        $('#all_employee').on('click', function () {
            $('#employee').select2('val','All').end();
            $('#employee').prop('disabled', true);
        });
        $('#employee_choose').on('click', function () {
            $('#employee').removeAttr("disabled");
        });
    }
};

jQuery(document).ready(function () {
    Payroll.init();
});
