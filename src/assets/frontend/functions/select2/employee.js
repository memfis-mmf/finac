let EmployeeSelect2 = {
    init: function () {
        $('select[name^=employee], #employee_validate').select2({
            placeholder: 'Select an Employee',
            allowClear: true
        });
    }
};

jQuery(document).ready(function () {
    EmployeeSelect2.init();
});
