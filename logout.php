<head>
    <link rel="stylesheet" href="design/style.css"></style>
    <title>Chilli.* teeworlds page (logout)</title>
</head>

<?php
session_start();
require_once(__DIR__ . "/global.php");
require_once(__DIR__ . "/view/form_view.php");


if ($_SESSION['csLOGGED'] !== "online")
{
	session_destroy();
	echo "you are not logged in";
}
else
{
    DeleteLoginCookie($_SESSION['login_token']);
	session_destroy();
	echo "logged out.";
}

ViewOkayButton('index.php');

?>

