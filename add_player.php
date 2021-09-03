<?php
require_once(__DIR__ . "/global.php");
require_once(__DIR__ . "/view/player_view.php");
require_once(__DIR__ . "/players/player_lib.php");
session_start();

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

if (!empty($_POST['player']))
{
	$player = isset($_POST['player'])? $_POST['player'] : '';
    $player_in_db = IsPlayerInDatabase($player, PLAYER_DATABASE);
    $player_in_db_contribute = IsPlayerInDatabase($player, PLAYER_CONTRIBUTE_DATABASE);

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
        // ViewContributePlayerForm($name, $id, $edit, $rls)
        ViewContributePlayerForm($player, 0, false, false);
        BackButton();
    }
}
else
{
    GetPlayerName();
}

fok();
?>
