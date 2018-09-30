<?php
require_once(__DIR__ . "/global.php");
session_start();
if (IS_MINER == true)
{
    StartMiner();
}
HtmlHeader("Players", "jungle.css", "TeeAssembler.css");

function GetTotalPages($items_per_page)
{
    $SQL_pages_base = "SELECT COUNT(*) AS TotalPages FROM Players WHERE Status = 3";
    
    $db = new PDO(PLAYER_DATABASE);
    $rows = $db->query($SQL_pages_base);
    $rows = $rows->fetchAll();
    $db = NULL;
    if ($rows)
    {
        $TotalPlayers = $rows[0]['TotalPages'];
        
        //PROBLEM: if the value is not a float but an int the last page is full but it says there is another one
        //HACKY WORK AROUND: 
        $float_pages = $TotalPlayers / $items_per_page;
        $int_pages = (int)$float_pages;
        if ($float_pages > $int_pages) //only say there is a new page if its more than a even number (1 = 0, 1.1 = 2, 2 = 1, 2.1 = 3)
            return $int_pages;
        else
            return $int_pages - 1;
    }
    return -1;
}


	$SQL_playerlist_query_base = "SELECT * FROM Players WHERE ID > ? AND Status = 3 ";
	//$SQL_playerlist_query_condition = "AND Status = 3 ";
	$SQL_playerlist_query_order_by = "ORDER BY Name ASC ";
	$SQL_playerlist_query_range = "LIMIT 10 OFFSET 0 ";

	$players_per_page = 10;
	$players_page = 0;
	$players_offset = 0;
	if (!empty($_GET['players']) && is_numeric($_GET['players']))
	{
		$players_per_page = $_GET['players'];
		$players_per_page = (int)$players_per_page;
	}
	if (!empty($_GET['page']) && is_numeric($_GET['page']))
	{
		$players_page = $_GET['page'];
		$players_page = (int)$players_page;
		
		if ($players_page < 0)
			$players_page = 0;
		
		$players_offset = $players_page * $players_per_page;
	}
	$SQL_playerlist_query_range = "LIMIT $players_per_page OFFSET $players_offset ";
	
	$db = new PDO(PLAYER_DATABASE);
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	$SQL_execution_string = $SQL_playerlist_query_base . $SQL_playerlist_query_order_by . $SQL_playerlist_query_range;
	$stmt = $db->prepare($SQL_execution_string);
	//echo "ececuted: $SQL_execution_string <br>";
	$stmt->execute(array(0));
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if ($rows)
	{
		#print_r($rows);
		#$name = $rows[0]['Username'];
		#$_SESSION['csID'] = $rows[0]['ID'];
		
		/***************************** MAIN PLAYER FORMAT START **********************************/
		foreach ($rows as $row)
		{
			$name = $row['Name'];
			$aka = $row['AKA'];
            $id = $row['ID'];
            $skin_name = $row['SkinName'];
            $skin_color_body = $row['SkinColorBody'];
            $skin_color_feet = $row['SkinColorFeet'];
			$info = $row['Info'];
			$clan = $row['Clan'];
			$clan_page = $row['ClanPage'];
			$skill = $row['Skills'];
			$yt_name = $row['yt_name'];
			$yt_link = $row['yt_link'];
			$teerace = $row['Teerace'];
			$ddnet = $row['DDNet'];
			$ddnet_mapper = $row['DDNetMapper'];
			$ddnet_link = $ddnet;
			$ddnet_mapper_link = $ddnet_mapper;
			if ($ddnet)
			{
				if ($ddnet == "name")
				{
					$ddnet_link = "https://ddnet.tw/players/$name/";
				}
			}
			if ($ddnet_mapper)
			{
				if ($ddnet_mapper == "name")
				{
					$ddnet_mapper_link = "https://ddnet.tw/mappers/$name/";
				}
			}
			
			echo "
			<div id=\"$name\"\>
			<h1>$name</h1>
			";
        
            // Print Assembles Tee by TeeAssembler.css
            // Thanks to Alexander_
echo "
        <style>
        .tee[skin$id] div {
          background-image: url(TeeworldsDB/skins/$skin_name.png);
        }
        </style>
";
?>
        <div class="tee" <?php echo "skin$id"; ?>>
            <div class="head-shadow"></div>
            <div class="back-foot-shadow"></div>
            <div class="back-foot"></div>
            <div class="head"></div>
            <div class="front-foot-shadow"></div>
            <div class="front-foot"></div>
            <div class="lEye"></div>
            <div class="rEye"></div>
        </div>
<?php
			
            /*
            //old picture system
			if (file_exists("players/img_players/Teeworlds_$name.png"))
            {
				echo "<img src=\"players/img_players/Teeworlds_$name.png\"><br>";
            }
            */
			if ($aka)
			{
				echo "<a><strong>AKA:</strong> $aka<br></a>";
			}
			if ($clan)
			{
				if ($clan_page)
				{
					echo "<a><strong>Clan:</strong><a href=\"$clan_page\">$clan</a><br></a>";
				}
				else
				{
					echo "<a><strong>Clan:</strong> $clan<br></a>";
				}
			}
			if ($info)
				echo "<a><strong>Info:</strong> $info<br></a>";
			if ($yt_name and $yt_link)
				echo "<a><strong>YouTube:</strong> <a href=\"$yt_link\">$yt_name</a><br></a>";
			if ($ddnet)
			{
				echo "<a><strong>DDNet:</strong> <a href=\"$ddnet_link\">$name</a><br></a>";
			}
			if ($ddnet_mapper)
			{
				echo "<a><strong>DDNet Mapper:</strong><a href=\"$ddnet_mapper_link\">$name</a><br></a>";
			}
			if ($teerace)
				echo "<a><strong>Teerace:</strong> <a href=\"$teerace\">$name</a><br></a>";
			if ($skill)
				echo "<a><strong>Skill:</strong> $skill</a></br>";
			echo "
			</div><br><hr><br>
			";
		}
		/****************************** MAIN PLAYER FORMAT END ************************************/
		
		$total_pages = GetTotalPages($players_per_page);
		if ($total_pages == 0 and $players_page == 0) //all players fitt on one page --> dont show that we are on page 0/0
			fok();
		echo "<a><br>page: $players_page/$total_pages<br></a>";
		$nxt_page = $players_page + 1;
		$prv_page = $players_page - 1;
		if ($players_page > 0)
		{
			echo "<input type=\"button\" value=\"<- Previous page\" onclick=\"window.location.href='players.php?players=$players_per_page&page=$prv_page'\"/>";
		}
		if ($players_page < $total_pages)
		{
			echo "<input type=\"button\" value=\"Next page -->\" onclick=\"window.location.href='players.php?players=$players_per_page&page=$nxt_page'\"/>";
		}
	}
	else
	{
		echo "something went wrong .-.";
		echo "<input type=\"button\" value=\"reset\" onclick=\"window.location.href='players.php?players=10&page=0'\"/>";
	}
	fok();
?>




