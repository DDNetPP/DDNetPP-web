<?php
require_once(__DIR__ . "/global.php");
session_start();
if (IS_MINER == true)
{
    StartMiner();
}

?>
<div class="jungle-background"></div>
<div class="jungle-mid-light-green"></div>
<?php

HtmlHeader("UpdatePlayers", "jungle.css");
?>
		<h1>Teeworlds Players</h1>
		<a>
			some</br>
			text</br>
			about</br>
		</a>
<?php fok(); ?>
