<?php
require_once(__DIR__ . "/global.php");
session_start();
if (IS_MINER == true)
{
    StartMiner();
}

HtmlHeader("UpdatePlayers", "jungle.css");
?>
		<h1>Teeworlds Players</h1>
		<a>
			Update existing player entrys or add a new one</br>
		</a>
        <form action="add_player.php" method="get">
            <input type="text">
            <textarea rows="5" cols="80" id="TITLE"></textarea>
            <input type="submit" value="Submit">
        </form>
        
        <input type="button" value="Add Player" onclick="window.location.href='add_player.php'"/>
        <input type="button" value="Update Player" onclick="window.location.href='update_player.php'"/>
<?php fok(); ?>
