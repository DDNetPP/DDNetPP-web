<?php
require_once(__DIR__ . "/global.php");
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

function MainPlayerForm()
{
?>
    SOME PLAYER FORM
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

function IsPlayerInDatabase($player, $contribute)
{
    $db = NULL; // idk baut scoping in php but this might help
    if ($contribute)
    {
        $db = new PDO(PLAYER_CONTRIBUTE_DATABASE);
    }
    else
    {
        $db = new PDO(PLAYER_DATABASE);
    }
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	$stmt = $db->prepare('SELECT * FROM Players WHERE Name = ? COLLATE NOCASE OR AKA = ? COLLATE NOCASE;');
	$stmt->execute(array($player, $player));

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if ($rows)
	{
        $name = $rows[0]['Name'];
		$aka = $rows[0]['AKA'];
        if (empty($aka))
        {
            return "'$name' already exists";
        }
        else
        {
            return "'$name' aka '$aka' already exists";
        }
    }
    return false;
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
        echo "adding player '$player'<br>";
        MainPlayerForm();
        BackButton();
    }
}
else
{
    GetPlayerName();
}

fok();
?>
