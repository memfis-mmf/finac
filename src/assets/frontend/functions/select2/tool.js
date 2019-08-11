let ToolSelect2 = {
    init: function () {
        $('#tool, #tool_validate').select2({
            placeholder: 'Select a Tool'
        });
    }
};

jQuery(document).ready(function () {
    ToolSelect2.init();
});
