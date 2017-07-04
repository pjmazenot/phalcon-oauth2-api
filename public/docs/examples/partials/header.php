<html>
<head>
    <title>OAuth2 Client Examples - <?php echo isset($title) ? $title : ''; ?></title>

    <link href="assets/css/vendors/bootstrap-3.3.7.min.css" rel="stylesheet"/>
    <style>
        body {
            padding: 20px;
        }
        h1 {
            margin-top: 0;
        }
    </style>

    <script src="assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="assets/js/vendors/bootstrap-3.3.7.min.js"></script>
</head>
<body>

    <nav>
        <a href="client-client_credentials.php">Client Credentials</a> -
        <a href="client-password.php">Password</a> -
        <a href="client-refresh_token.php">Refresh Token</a>
    </nav>

    <br/>
    <br/>

    <h1><?php echo isset($title) ? $title : ''; ?></h1>