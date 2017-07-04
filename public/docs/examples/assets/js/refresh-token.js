$(document).ready(function () {

    console.log('-- init --');
    function refresh_token(e) {

        console.log('-- refresh token --');

        e.preventDefault();

        var $form = $(this);

        $.ajax({
            type: 'post',
            url: 'client-ajax.php',
            data: new FormData($form[0]),
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log('-- success --');
                console.log(response);

                if(response.status == 'success') {

                    $('#refreshed-token').html(response.token.access_token).css('color', 'green');

                    if(response.api_test) {
                        if(response.api_test.status == 'success') {
                            $('#refresh-token-api-test-results').html('Authorized').css('color', 'green');
                        } else {
                            $('#refresh-token-api-test-results').html(response.api_test.message).css('color', 'red');
                        }
                    }

                } else {
                    $('#refreshed-token').html(response.message).css('color', 'red');
                }
            },
            error: function (response) {
                console.log('-- error --');
                console.log(response);
                $('#refreshed-token').html(response.message).css('color', 'red');
            }
        });

    }

    $(document).on('submit', '.oauth2-refresh-token-form', refresh_token);

});