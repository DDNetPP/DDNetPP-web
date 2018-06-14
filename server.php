<?php
require_once(__DIR__ . "/global.php");
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
  			<li><a class="active" href="server.php">Server</a></li>
  			<li><a href="players.php">Players</a></li>
			<li style="float:right">
			<?php
				if (!empty($_SESSION['csLOGGED']) && $_SESSION['csLOGGED'] === "online")
				{
				    echo "<a href=\"account.php\">Account</a>";
				}
				else
				{
				    echo "<a href=\"login.php\">Login</a>";
				}
			?>
                        </li>
		</ul>
		<h1>ChillBlock5 Block Server</h1>
		<a>
			IP: 149.202.127.134:8303</br>
			Name: ChillBlock Server by ChillerDragon [Chilli.*]</br>
			Gametype: DDraceNetwork++</br>
			Map: ChillBlock5</br>
		</a>
		<img src="img/ChillBlock5_race.png" height="300"/>
		<h2>General Server info</h2>
		<a>
			The ChillBlock server is basically a block server.</br>
			But there is more. The map has also a small race</br>
			and more ddrace stuff is planned.</br></br>

			And the server runs a special unique modification.</br>
			It is based on DDraceNetwork and has many new stuff.</br>
			We have a money and account system. Check</br>
			the chatcommand '/accountinfo' on the server for more</br>
			information how to login.</br>
			Money and xp can be earned during farming on moneytiles,</br>
			playing the race or blocking other tees.</br></br>

			We Also have quests and minigames on the server</br>
			which allows you to play agianst or with friends and collect</br>
			money and xp.</br>
			Check the ingame commands</br>
			'/quest' and '/minigames list'</br>
			for more information.</br>

			We also have alot more stuff like serverside</br>
			blocker bots and block stats.</br>
			And the developer team of the mod is</br>
			working on the mod all the time to bring some</br>
			new features.</br>
		</a>
		<h2>Ranks (Moderator/SuperModerator)</h2>
		<a>
			The ChillBlock server trys to offer you</br>
			the best gameplay conditions without</br>
			noobadmins and overpowered ingame ranks.</br>
			There are no cheats like tele, super, jetpack and other</br>
			stuff which destroys the fair gameplay.</br></br>

			But we do have two ranks which can be purchased by</br>
			all users who are willing to support the server.</br>

			We have the Moderator rank</br>
			and the SuperModerator.</br>
			The SuperModerator can do all things</br>
			the Moderator can do and more.</br></br>

			Price (30 days):</br>
				<li>Moderator: 3 euro</li></br>
				<li>SuperModerator: 5 euro</li></br></br>

			By buying a rank you help to keep the server running.</br>
			Sadly we currently only accept Bitcoin as payment method.</br>

			<h3> Moderator Skills </h3>
			'/say_srv' to send chat messages as server</br>
			'/give bloody' to get bloody</br>
			'/give rainbow' to get rainbow</br>
			'/bomb ban (player)' to ban (player) from bombgames (1min max)</br>
			'/hook rainbow' to get rainbow hook</br>

			<h3> SuperModerator Skills </h3>
			'/broadcast_srv' to send server broadcasts to all players</br>
			'/give strong_bloody' to get stronger bloody</br>
			'/give atom' to become an atom (looks kewl)</br>
			'/give trail' to get an trail</br>
			'/give rainbow (player)' to offer rainbow to (player)</br>
			'/give bloody (player)' to offer bloody to (player)</br>
			'/bomb ban (player)' to ban (player) from bombgames (5min max)</br>
			'/hook bloody' to get bloody hook</br>
			'/room invite (player)' to invite (player) to the special room (under the spawn)</br>
			'/room kick (player)' to kick (player) out of the room</br>
			'/togglespawn' to change spawnpoint between normal and supermod</br>
		</a>
	</body>
</html>
