var Typeahead = function () {
    return {
        init: function () {
            $.ajax({
                url: '/get-payment-term/',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var e = data;

                    var a, n, o, t, i, s;
                    $("#term_of_payment").typeahead({
                        hint: !0,
                        highlight: !0,
                        minLength: 1
                    }, {
                        name: "states",
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
                }
            });

        }
    }
}();
jQuery(document).ready(function () {
    Typeahead.init()
});
