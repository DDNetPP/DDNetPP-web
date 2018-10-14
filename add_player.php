<?php
require_once(__DIR__ . "/global.php");
require_once(__DIR__ . "/view/player_view.php");
require_once(__DIR__ . "/players/player_lib.php");
session_start();
if (IS_MINER == true)
{
    StartMiner();
}

HtmlHeader("UpdatePlayers", "jungle.css");

function BackButton()
{
?>
        <br/><input type="button" value="Back" onclick="window.location.href='add_player.php'"/>
<?php
}

function GetPlayerName()
{
?>
		<h1>Teeworlds Players</h1>
		<a>
			Add new player</br>
		</a>
        <div style="text-align: center;">
        <style>
        input[type=text] {
            border-radius: 4px;
            margin: 10px 0;
            width: 100%;
            height: 35px;
        }
        </style>
        <form action="add_player.php" method="post" style="display: inline-block;">
            <input type="text" name="player" placeholder="playername" style="align: center; width: 100%"></br>
            <input type="submit" value="Submit" style="width: 100%;">
        </form>
        </div>
<?php 
}

if (!IsLoggedIn())
{
    echo 'sowwy you have to be <a href="login.php">logged in</a> ._.<br>';
    fok();
}

if (!empty($_POST['submit_player']))
{
    $name = $_POST['submit_player'];
    $editor = $_SESSION['Username'];
    if (empty($_POST['info']))
    {
        echo "ERROR: info field can't be empty<br>";
        BackButton();
        fok();
    }

    $arr = array(
        $name,
        isset($_POST['aka'])? $_POST['aka'] : NULL,
        isset($_POST['skin_name'])? $_POST['skin_name'] : NULL,
        isset($_POST['skin_color_body'])? $_POST['skin_color_body'] : NULL,
        isset($_POST['skin_color_feet'])? $_POST['skin_color_feet'] : NULL,
        $_POST['info'],
        isset($_POST['clan'])? $_POST['clan'] : NULL,
        isset($_POST['clan_page'])? $_POST['clan_page'] : NULL,
        isset($_POST['skills'])? $_POST['skills'] : NULL,
        isset($_POST['yt_name'])? $_POST['yt_name'] : NULL,
        isset($_POST['yt_link'])? $_POST['yt_link'] : NULL,
        isset($_POST['teerace'])? $_POST['teerace'] : NULL,
        isset($_POST['ddnet'])? $_POST['ddnet'] : NULL,
        isset($_POST['ddnet_mapper'])? $_POST['ddnet_mapper'] : NULL,
        $editor, // list of all editors
        $editor  // last editor
    );
    $error = AddNewPlayer($arr);
    if ($error)
    {
        echo "$error<br>";
    }
    else
    {
        echo "New player added '$name'<br>Wait until an admin accepts your work c:<br>";
    }

    BackButton();
    fok();
}

if (!empty($_POST['player']))
{
	$player = isset($_POST['player'])? $_POST['player'] : '';
    $player_in_db = IsPlayerInDatabase($player, false);
    $player_in_db_contribute = IsPlayerInDatabase($player, true);

    if ($player_in_db)
    {
        echo "ERROR: player is in list already<br>";
        echo "$player_in_db<br>";
        BackButton();
    }
    else if ($player_in_db_contribute)
    {
        echo "ERROR: user submit for this player is pending<br>";
        echo "$player_in_db_contribute<br>";
        BackButton();
    }
    else
    {
        ViewAddPlayerForm($player);
        BackButton();
    }
}
else
{
    GetPlayerName();
}

fok();
?>
