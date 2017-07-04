$(document).ready(function () {

    console.log('-- init --');
    function generate_token(e) {

        console.log('-- generate token --');

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

                    $('#generated-token').html(response.token.access_token).css('color', 'green');

                    if(response.api_test) {
                        if(response.api_test.status == 'success') {
                            $('#generate-token-api-test-results').html('Authorized').css('color', 'green');
                        } else {
                            $('#generate-token-api-test-results').html(response.api_test.message).css('color', 'red');
                        }
                    }

                    var $refreshTokenForm = $('.oauth2-refresh-token');
                    if($refreshTokenForm.length) {

                        $refreshTokenForm.find('[name="client_id"]').val($form.find('[name="client_id"]').val());
                        $refreshTokenForm.find('[name="client_secret"]').val($form.find('[name="client_secret"]').val());
                        $refreshTokenForm.find('[name="scope"]').val($form.find('[name="scope"]').val());

                        $refreshTokenForm.find('[name="refresh_token"]').val(response.token.refresh_token);

                    }

                } else {
                    $('#generated-token').html(response.message).css('color', 'red');
                }
            },
            error: function (response) {
                console.log('-- error --');
                console.log(response);
                $('#generated-token').html(response.message).css('color', 'red');
            }
        });

    }

    $(document).on('submit', '.oauth2-generate-token-form', generate_token);

});