<?php
require_once(__DIR__ . "/global.php");
require_once(__DIR__ . "/ClientInfos.php");
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

if ($_SESSION['csLOGGED'] !== "online")
{
	echo "you are not logged in";
	die();
}

function LogServerPanelAction($action)
{
        //Get Date
        $current_date = date_create(date("Y-m-d H:i:s"));
        $current_date_str = $current_date->format('Y-m-d H:i:s');
        
        //Get City
        $ip = $_SERVER['REMOTE_ADDR'];
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
        //echo "City: " . $details->city;
        
        //Get Operating system
        $user_os = getOS($_SERVER['HTTP_USER_AGENT']);
        
        //Get Browser
        $user_browser = getBrowser($_SERVER['HTTP_USER_AGENT']);
        
        //Add login to login history
        $db = NULL;
	    $db = new PDO(WEB_DATABASE_PATH);
	    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	    $stmt = $db->prepare('INSERT INTO ServerPanel (Username, Action, TimeStamp, IP, Location, Browser, OS, OtherDetails) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
	    $stmt->execute(array($_SESSION['Username'], $action, $current_date_str, $_SERVER['REMOTE_ADDR'], $details->city, $user_browser, $user_os, $_SERVER['HTTP_USER_AGENT']));
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

    if (!empty($_GET['action']))
    {
        $action = isset($_GET['action'])? $_GET['action'] : '';
        $action = (string)$action;
        $out = "error: action not found";
        if ($action === "start_restart")
        {
            $cmd = "cd " . SCRIPTS_PATH . ";sudo " . SCRIPTS_PATH . "/init_restart.sh";
            //echo "cmd: <br/>$cmd<br/>";
            $out = shell_exec($cmd);
        }
        else if ($action === "stop_restart")
        {
            $cmd = "cd " . SCRIPTS_PATH . ";sudo " . SCRIPTS_PATH . "/cancle_restart.sh";
            //echo "cmd: <br/>$cmd<br/>";
            $out = shell_exec($cmd);
        }
        else if ($action === "status_restart")
        {
            $out = shell_exec("cat " . SCRIPTS_PATH . "/status_restart_*.log");
        }
        else if ($action === "start_github")
        {
            $cmd = "cd " . SCRIPTS_PATH . ";sudo -u " . DDPP_USER . " " . SCRIPTS_PATH . "/github_update.sh";
            echo "cmd: <br/>$cmd<br/>";
            $out = shell_exec($cmd);
        }
        else if ($action === "restart_chillerbot_bl")
        {
            $cmd = "cd " . SCRIPTS_PATH . ";sudo -u " . DDPP_USER . " " . SCRIPTS_PATH . "/restart_bot_bl.sh";
            echo "cmd: <br/>$cmd<br/>";
            $out = shell_exec($cmd);
        }
        else if ($action === "restart_chillerbot_cb")
        {
            $cmd = "cd " . SCRIPTS_PATH . ";sudo -u " . DDPP_USER . " " . SCRIPTS_PATH . "/restart_bot_cb.sh";
            echo "cmd: <br/>$cmd<br/>";
            $out = shell_exec($cmd);
        }
        else if ($action === "update_ddpp_scripts")
        {
            $cmd = "sudo -u " . DDPP_USER . " " . UPDATE_SCRIPTS_SCRIPT_PATH;
            echo "cmd: <br/>$cmd<br/>";
            $out = shell_exec($cmd);
        }
        else if ($action === "ddpp_shutdown_cb_on")
        {
            $cmd = "cd " . SCRIPTS_PATH . ";sudo -u " . DDPP_USER . " " . SCRIPTS_PATH . "/ddpp_shutdown_chillblock.sh 2 1";
            echo "cmd: <br/>$cmd<br/>";
            $out = shell_exec($cmd);
        }
        else if ($action === "ddpp_shutdown_bl_on")
        {
            $cmd = "cd " . SCRIPTS_PATH . ";sudo -u " . DDPP_USER . " " . SCRIPTS_PATH . "/ddpp_shutdown_BlmapChill.sh 2 1";
            echo "cmd: <br/>$cmd<br/>";
            $out = shell_exec($cmd);
        }
        else if ($action === "ddpp_shutdown_cb_off")
        {
            $cmd = "cd " . SCRIPTS_PATH . ";sudo -u " . DDPP_USER . " " . SCRIPTS_PATH . "/ddpp_shutdown_chillblock.sh 2 0";
            echo "cmd: <br/>$cmd<br/>";
            $out = shell_exec($cmd);
        }
        else if ($action === "ddpp_shutdown_bl_off")
        {
            $cmd = "cd " . SCRIPTS_PATH . ";sudo -u " . DDPP_USER . " " . SCRIPTS_PATH . "/ddpp_shutdown_BlmapChill.sh 2 0";
            echo "cmd: <br/>$cmd<br/>";
            $out = shell_exec($cmd);
        }
        echo "Output:<br/>$out";
        LogServerPanelAction($action);
    }
?>
        <form method="get">
        <h1 id="zone-night">Night restart (FORCE)</h1>
        <br/><input type="button" value="start restart.sh" onclick="window.location.href='server_panel.php?action=start_restart'"/>
        <br/><input type="button" value="stop restart.sh" onclick="window.location.href='server_panel.php?action=stop_restart'"/>
        <br/><input type="button" value="status restart.sh" onclick="window.location.href='server_panel.php?action=status_restart'"/>
        <h1 id="zone-github">Night(02:00) veto vote shutdown (restart)</h1>
        <br/><input type="button" value="start chillblock" onclick="window.location.href='server_panel.php?action=ddpp_shutdown_cb_on'"/>
        <br/><input type="button" value="stop chillblock" onclick="window.location.href='server_panel.php?action=ddpp_shutdown_cb_off'"/>
        <br/><input type="button" value="start blmapchill" onclick="window.location.href='server_panel.php?action=ddpp_shutdown_bl_on'"/>
        <br/><input type="button" value="stop blmapchill" onclick="window.location.href='server_panel.php?action=ddpp_shutdown_bl_off'"/>
        <h1 id="zone-github">Github updates</h1>
        <br/><input type="button" value="start github_update.sh" onclick="window.location.href='server_panel.php?action=start_github'"/>
        <br/><input type="button" value="update scripts/cfgs" onclick="window.location.href='server_panel.php?action=update_ddpp_scripts'"/>
<br/><br/>
        <h1 id="zone-danger">Force server restart NOW</h1>
        <h2 id="zone-danger">WARNING DANGER ZONE</h2>
        <br/><input type="button" id="btn-danger" value="restart chillerbot/srv BlmapChill" onclick="window.location.href='server_panel.php?action=restart_chillerbot_bl'"/>
        <br/><input type="button" id="btn-danger" value="restart chillerbot/srv ChillBlock5" onclick="window.location.href='server_panel.php?action=restart_chillerbot_cb'"/>
        </form>
<?php


	echo "
		</br><input type=\"button\" value=\"Logout\" onclick=\"window.location.href='logout.php'\" />
	";
}
else
{
echo "something went horrible wrong";
}
?>
