$(document).ready(function () {
    // customer = function () {
    //     $.ajax({
    //         url: '/get-customers/',
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function (data) {

    //             $('select[name="filter"]').empty();

                // $('select[name="filter"]').append(
                //     '<option value=""> Select a Customer </option>'
                // );

                // $.each(data, function (key, value) {
                    // alert('test');
                    $('select[name="filter"]').append(
                        '<option value="1">tes</option>'
                    );
                    $('select[name="filter"]').append(
                        '<option value="2">tes2</option>'
                    );
                    // alert('test2');

                    // });
    //         }
    //     });
    // };

    // customer();
});

// $(document).ready(function () {
//     filter = function () {
//             $('select[name="filter"]').append(
//                 '<option value=""> Select a Filter </option>',
//                 '<option value=""> Test 1</option>',
//                 '<option value=""> Test 2</option>',
//                 '<option value=""> Test 3</option>',
//             );
//         };
//     filter();
// });
