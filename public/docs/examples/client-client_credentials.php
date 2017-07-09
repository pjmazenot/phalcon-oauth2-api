<?php $title = 'Generate access token by client credentials'; ?>

<?php include 'partials/header.php'; ?>

<p style="color: red;">
	You need to add a client in your database before using the test script. You can use our samples in the config/sql folder.
</p>

<?php include 'partials/client-client_credentials-form.php'; ?>

<?php include 'partials/api-test-results-generate-token.php'; ?>

<?php include 'partials/footer.php'; ?>
