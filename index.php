<?php
require_once(__DIR__ . "/global.php");
session_start();
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
 			<li><a class="active" href="index.php">Home</a></li>
  			<li><a href="clan.php">Clan</a></li>
  			<li><a href="server.php">Server</a></li>
  			<li><a href="players.php">Players</a></li>
			<li style="float:right">
			<?php
				if (!empty($_SESSION['csLOGGED']) && $_SESSION['csLOGGED'] === "online")
				{
				    echo "<a href=\"account.php\">Account</a>";
				}
				else
				{
				    echo "<a href=\"login.php\">Login</a>";
				}
			?>
			</li>
		</ul>
		<h1>ChillBlock5 Server</h1>
	</body>
</html>

<?php
$db = new PDO(ABSOLUTE_DATABASE_PATH);
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

/*
$rowsLEVEL = $db->query('SELECT Username, Level FROM Accounts ORDER BY Exp DESC LIMIT 20');
if ($rowsLEVEL)
{
	echo "<h2>Best farmer</h2>";
	$rowsLEVEL = $rowsLEVEL->fetchAll();
	for ($i = 0;$i < 20;$i++)
	{
		$username = $rowsLEVEL[$i]['Username'];
		$level = $rowsLEVEL[$i]['Level'];
		echo $i+1 . ". $username - $level </br>";
	}
}

$rowsPOINTS = $db->query('SELECT Username, BlockPoints FROM Accounts ORDER BY BlockPoints DESC LIMIT 20');
if ($rowsPOINTS)
{
	echo "<h2>Best Blocker</h2>";
	$rowsPOINTS = $rowsPOINTS->fetchAll();
	for ($i = 0;$i < 20; $i++)
	{
        	$username = $rowsPOINTS[$i]['Username'];
        	$points = $rowsPOINTS[$i]['BlockPoints'];
		echo $i+1 . ". $username - $points </br>";
	}
}
*/
$rowsLEVEL = $db->query('SELECT LastLogoutIGN1, Level FROM Accounts ORDER BY Exp DESC LIMIT 20');
/*
$stmt = $db->prepare('SELECT ? , ? FROM Accounts ORDER BY Exp DESC LIMIT 20');
$para1 = "LastLogoutIGN1";
$para2 = "Level";
$stmt->execute(array($para1, $para2));
$rowsLEVEL = $stmt->fetchAll(PDO::FETCH_ASSOC);
*/
if ($rowsLEVEL)
{
        echo "<h2>Best farmer</h2>";
        $rowsLEVEL = $rowsLEVEL->fetchAll();
        for ($i = 0;$i < 20;$i++)
        {
                $username = $rowsLEVEL[$i]['LastLogoutIGN1'];
                $level = $rowsLEVEL[$i]['Level'];
                echo $i+1 . ". $username - $level </br>";
        }
}

$rowsPOINTS = $db->query('SELECT LastLogoutIGN1, BlockPoints FROM Accounts ORDER BY BlockPoints DESC LIMIT 20');
if ($rowsPOINTS)
{
        echo "<h2>Best Blocker</h2>";
        $rowsPOINTS = $rowsPOINTS->fetchAll();
        for ($i = 0;$i < 20; $i++)
        {
                $username = $rowsPOINTS[$i]['LastLogoutIGN1'];
                $points = $rowsPOINTS[$i]['BlockPoints'];
                echo $i+1 . ". $username - $points </br>";
        }
}
?>
