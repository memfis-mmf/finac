let CoaSelect2 = {
    init: function () {
        $('#coa, #coa_validate').select2({
            placeholder: 'Select a Type'
        });
    }
};

jQuery(document).ready(function () {
    CoaSelect2.init();
    $('#coa').on('change', function () {
        var code = this.value;
        $.ajax({
            url: '/coa/data/'+code,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                document.getElementById('acd').value = data.description;
            }
        });
    });
    
});
