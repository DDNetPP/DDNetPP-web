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
                        	<a href="account.php">Account</a>
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

$db = new PDO('sqlite:/home/chiller/ddpp_database/accounts.db');
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
$stmt = $db->prepare('SELECT * FROM Accounts WHERE ID = ? ');
$stmt->execute(array($_SESSION['csID']));

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($rows)
{
	$username = $rows[0]['Username'];
	$IsSuperMod = $rows[0]['IsSuperModerator'];
	$IsSupporter = $rows[0]['IsSupporter'];
	if ($IsSupporter !== "1")
	{
		echo "missing permission.<br>";
		die();
	}

	//echo "<h1>Server Panel</h1><a>Restarting BlmapChill...</a></br>";
	//shell_exec("/home/chiller/ddpp_database/web_scripts/restart_BlmapChill.sh");
	echo "currently in dev...";

    if (!empty($_GET['action']))
    {
        $action = isset($_GET['action'])? $_GET['action'] : '';
        $action = (string)$action;
        if ($action === "restart")
        {
        }
    }


	echo "
		</br><input type=\"button\" value=\"Logout\" onclick=\"window.location.href='logout.php'\" />
	";
}
else
{
echo "something went horrible wrong";
}
?>
