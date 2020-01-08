let DepartmentSelect2 = {
    init: function () {
        $('select[name="department"], #department_validate').select2({
            placeholder: 'Select a Department'
        });
    }
};

jQuery(document).ready(function () {
    DepartmentSelect2.init();
});
