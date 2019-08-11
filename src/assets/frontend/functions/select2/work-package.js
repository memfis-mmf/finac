let WorkPackageSelect2 = {
    init: function () {
        $('#work-package, #work-package_validate').select2({
            placeholder: 'Select a Work Package'
        });
    }
};

jQuery(document).ready(function () {
    WorkPackageSelect2.init();
});