let ProjectSelect2 = {
    init: function () {
        $('#project, #project_validate').select2({
            placeholder: 'Select a Project'
        });
    }
};

jQuery(document).ready(function () {
    ProjectSelect2.init();
});
