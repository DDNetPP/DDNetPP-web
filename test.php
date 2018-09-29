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

HtmlHeader("Server", "test site", "jungle.css");
?>
		<h1>ChillBlock5 Block Server</h1>
		<a>
			IP: 149.202.127.134:8303</br>
			Name: ChillBlock Server by ChillerDragon [Chilli.*]</br>
			Gametype: DDraceNetwork++</br>
			Map: ChillBlock5</br>
		</a>
<?php fok(); ?>
