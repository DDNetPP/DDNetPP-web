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

function GetPlayerName()
{
?>
		<h1>Teeworlds Players</h1>
		<a>
			Update existing player entrys or add a new one</br>
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

if (!empty($_POST['player']))
{
	$player = isset($_POST['player'])? $_POST['player'] : '';

	$db = new PDO(PLAYER_DATABASE);
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
            echo "'$name' already exists";
        }
        else
        {
            echo "'$name' aka '$aka' already exists";
        }
        BackButton();
    }
    else
    {
        echo "adding player '$player'";
        BackButton();
    }
}
else
{
    GetPlayerName();
}

fok();
?>
