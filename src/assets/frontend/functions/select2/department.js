let DepartmentSelect2 = {
    init: function () {
        $('select#department, select.department, #department_validate').select2({
            placeholder: 'Select a Department',
            width: '100%'
        });
    }
};

jQuery(document).ready(function () {
    DepartmentSelect2.init();
});
