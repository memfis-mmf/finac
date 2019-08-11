var Typeahead = function () {
    return {
        init: function () {
            // $.ajax({
            //     url: '/get-takcard-non-routine-types/',
            //     type: 'GET',
            //     dataType: 'json',
            //     success: function (data) {
                    var e = ["Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming"];

                    var a, n, o, t, i, s;
                    $("#version").typeahead({
                        hint: !0,
                        highlight: !0,
                        minLength: 1
                    }, {
                        name: "version",
                        source: (a = e, function (e, n) {
                            var o;
                            o = [], substrRegex = new RegExp(e, "i"), $.each(a, function (e, a) {
                                substrRegex.test(a) && o.push(a)
                            }), n(o)
                        })
                    }), n = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.whitespace,
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        local: e
                    })
                // }
            // });

        }
    }
}();
jQuery(document).ready(function () {
    Typeahead.init()
});
