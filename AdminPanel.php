<?php
require_once(__DIR__ . "/global.php");
if (IS_MINER == true)
{
    StartMiner();
}
?>

<html>
        <head>
                <link rel="stylesheet" href="style.css"></style>
                <link href="http://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">
                <title>Chilli.* teeworlds page</title>
        </head>
	<body>
                <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="clan.php">Clan</a></li>
                        <li><a href="server.php">Server</a></li>
                        <li><a href="players.php">Players</a></li>
                        <li class="active "style="float:right">
                        	<a href="AdminPanel.php">AdminPanel</a>
                        </li>
                </ul>
	</body>
</html>
<?php
session_start();


if ($_SESSION['csLOGGED'] !== "online")
{
	echo "you are not logged in";
	die();
}

if (GetUsernameByID($_SESSION['csID']) == "ChillerDragon")
{
	echo "<h1>Admin panel</h1>";
	echo "hello " . GetUsernameByID($_SESSION['csID']);
?>
<!-- Die Encoding-Art enctype MUSS wie dargestellt angegeben werden -->
<form enctype="multipart/form-data" action="UploadMaps.php" method="POST">
    <!-- MAX_FILE_SIZE muss vor dem Dateiupload Input Feld stehen -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Der Name des Input Felds bestimmt den Namen im $_FILES Array -->
    Diese Datei hochladen: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form>
<?php
}
else
{
	echo "missing permission";
}

	echo "
		<input type=\"button\" value=\"Back\" onclick=\"window.location.href='index.php'\" /></br>
	";
	echo "
		<input type=\"button\" value=\"Logout\" onclick=\"window.location.href='logout.php'\" />
	";
?>
