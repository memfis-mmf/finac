let TaskcardRelationshipSelect2 = {
    init: function () {
        $('#relationship, #relationship_validate').select2({
            placeholder: 'Select a Taskcard'
        });
    }
};

jQuery(document).ready(function () {
    TaskcardRelationshipSelect2.init();
});
