<?php
require_once(__DIR__ . "/global.php");
if (IS_MINER == true)
{
    StartMiner();
}
?>

<html>
        <head>
                <link rel="stylesheet" href="design/style.css"></style>
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

$db = new PDO(ABSOLUTE_DATABASE_PATH);
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
$stmt = $db->prepare('SELECT * FROM Accounts WHERE ID = ? ');
$stmt->execute(array($_SESSION['csID']));

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($rows)
{
	#print_r($rows);

	$username = $rows[0]['Username'];
	$money = $rows[0]['Money'];
	$level = $rows[0]['Level'];
	$policerank = $rows[0]['PoliceRank'];
	$shit = $rows[0]['Shit'];
	$IsSuperMod = $rows[0]['IsSuperModerator'];

	$blockpoints = $rows[0]['BlockPoints'];
	$blockdeaths = $rows[0]['BlockDeaths'];
	$blockkills = $rows[0]['BlockKills'];

        echo "
		<h1>Stats for '$username'</h1></br>
		Money: $money</br>
		Level: $level</br>
		PoliceRank: $policerank</br>
		Shit: $shit</br>

		<h2>Block</h2>
		Points: $blockpoints</br>
		Kills: $blockkills</br>
		Deaths: $blockdeaths</br>
	";
		if ($IsSuperMod == 1)
		{
			echo "
			<h2>Supporter</h2>
			<input type=\"button\" value=\"Server Panel\" onclick=\"window.location.href='server_panel.php'\" /></br>
			";
		}
	echo "
		<input type=\"button\" value=\"Logout\" onclick=\"window.location.href='logout.php'\" />
	";
}
else
{
echo "something went horrible wrong";
}
?>
