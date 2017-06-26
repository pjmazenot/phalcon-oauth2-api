<html>
<head>
	<title>Examples - Generate access token by client credentials</title>

	<link
		href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		rel="stylesheet"
		integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
		crossorigin="anonymous">
	<style>
		body {
			padding: 20px;
		}
		h1 {
			margin-top: 0;
		}
	</style>

	<script
		src="https://code.jquery.com/jquery-3.2.1.min.js"
		integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
		crossorigin="anonymous"></script>
	<script
		src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</head>
<body>

<h1>Generate access token by client credentials</h1>

<p style="color: red;">
	You need to add a client in your database before using the test script. You can use our samples in the config/sql folder.
</p>

<h2>Generate</h2>

<form id="oauth2-form" class="form-inline">

	<input type="hidden" name="grant_type" value="client_credentials" />
	<input type="hidden" name="scope" value="full_access" />

	<div class="form-group">
		<label class="sr-only" for="client_id">Client ID</label>
		<input type="text" class="form-control" id="client_id" name="client_id" placeholder="Client ID"/>
	</div>
	<div class="form-group">
		<label class="sr-only" for="client_secret">Client Secret</label>
		<input type="text" class="form-control" id="client_secret" name="client_secret" placeholder="Client Secret"/>
	</div>

	<button type="submit" class="btn btn-primary">
		Generate
	</button>
</form>

Generated token (bearer): <strong id="generated-token">Fill out the form and click on the Generate button</strong>

<h2>Test API</h2>

Result: <strong id="api-test-results">Generate an access token, the API test will be automatic</strong>

<script>
	$(document).ready(function () {

		function generate_token(e) {

			e.preventDefault();

			var $form = $('#oauth2-form');

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

						$('#generated-token').html(response.bearer.access_token).css('color', 'green');

						if(response.api_test) {
							if(response.api_test.status == 'success') {
								$('#api-test-results').html('Authorized').css('color', 'green');
							} else {
								$('#api-test-results').html(response.api_test.message).css('color', 'red');
							}
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

		$(document).on('submit', '#oauth2-form', generate_token);

	});
</script>

</body>
</html>
