<?php
require_once(__DIR__ . "/global.php");
session_start();
if (IS_MINER == true)
{
    StartMiner();
}
HtmlHeader("Admin Players", "jungle.css");
function PrintEditInfo($status, $editor, $lasteditdate, $id)
{
?>
    <div class="edit-info-box">
<?php
    echo "<b>STATUS:</b> $status</br>";
    echo "<b>EDITOR:</b> $editor</br>";
    echo "<b>LastEdit:</b> $lasteditdate</br>";
    echo "<b>ID:</b> $id</br>";
    //TODO: add buttons to delete/archive/release the entry
    if ($status === "0")
    {
        echo "<h1>ARCHIVED!</h1>";
    }
    else
    {
?>
    <form action="admin_edit_players.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" name="action" value="archive" />
    </form>
<?php
    }
?>
    <form action="admin_edit_players.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" name="action" value="delete" />
    </form>
    </div>
    <style>
    .edit-info-box {
        padding: 5%;
        padding-top: 2%;
        margin-top: 5%;
        margin-bottom: 5%;

        /* old */
        /*margin-right: 20%;*/
        /*margin-left: 20%;*/

        /* new */
        min-width: 200px;
        max-width: 700px;
        margin-right: auto;
        margin-left: auto;

        border: 2px solid darkgrey;
        /*border-bottom-left-radius: 16px;*/
        /*border-bottom-right-radius: 16px;*/
        border-radius: 10px;
        background: rgba(77,255,77,0.5);
        box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);
    }
    </style>
<?php
}

function PrintPlayerInfo($name, $aka, $clan, $clan_page, $info, $yt_name, $yt_link, $ddnet, $ddnet_mapper, $ddnet_mapper_link, $teerace, $skill)
{
            echo "<h1>$name</h1>";
			if (file_exists("players/img_players/Teeworlds_$name.png"))
				echo "<img src=\"players/img_players/Teeworlds_$name.png\"><br>";
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
}

function GetTotalPages($items_per_page, $hide)
{
    if ($hide)
    {
        $SQL_pages_base = "SELECT COUNT(*) AS TotalPages FROM Players WHERE Status <> 3 AND Status <> 0";
    }
    else
    {
        $SQL_pages_base = "SELECT COUNT(*) AS TotalPages FROM Players WHERE Status <> 3";
    }
        
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

    /********************************************
     *                                          *
     *   Global Scope start!                    *
     *   from here on the execution starts      *
     *                                          *
     *                                          *
     ********************************************/

    if (!empty($_POST['action']))
    {
        $action = (string)$_POST['action'];
        if ($action === "archive")
        {
            $id = (int)$_POST['id'];
            echo "yo archivvin!!! ID=$id";
            $db = new PDO(PLAYER_DATABASE);
            $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            $stmt = $db->prepare("UPDATE Players SET Status = 0 WHERE ID = ?;");
            $stmt->execute(array($id));
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows)
            {
                echo "SQL output: <br/>";
                print_r($rows);
            }
        }
        else if ($action === "delete")
        {
            $id = (int)$_POST['id'];
            echo "yo deletin!!! ID=$id";
            $db = new PDO(PLAYER_DATABASE);
            $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            $stmt = $db->prepare("DELETE FROM Players WHERE ID = ?;");
            $stmt->execute(array($id));
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows)
            {
                echo "SQL output: <br/>";
                print_r($rows);
            }
        }
        else
        {
            echo "Error: unknown action!";
            fok();   
        }      
    }

    $hide_archive = false;
    if (!empty($_GET['hide_archive']))
    {
        $hide = $_GET['hide_archive'];
        if ($hide === "1")
        {
            $hide_archive = true;
        }
        else if ($hide === "0")
        {
            $hide_archive = false;
        }
    }

	$SQL_playerlist_query_base = "SELECT * FROM Players WHERE ID > ? ";
    if ($hide_archive)
    {
        $SQL_playerlist_query_hide = " AND Status <> 3 AND Status <> 0 ";
    }
    else
    {
        $SQL_playerlist_query_hide = " AND Status <> 3 ";
    }
	//$SQL_playerlist_query_condition = "AND Status = 3 ";
	//$SQL_playerlist_query_order_by = "ORDER BY x DESC ";
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
	$SQL_execution_string = $SQL_playerlist_query_base . $SQL_playerlist_query_hide . $SQL_playerlist_query_range;
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
            // actual data
			$name = $row['Name'];
			$aka = $row['AKA'];
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
            
            // edit data
            $status = $row['Status'];
            $editor = $row['LastEditor'];
            $lasteditdate = $row['LastEditDate'];
            $id = $row['ID'];
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
			";
            PrintEditInfo($status, $editor, $lasteditdate, $id);
            PrintPlayerInfo($name, $aka, $clan, $clan_page, $info, $yt_name, $yt_link, $ddnet, $ddnet_mapper, $ddnet_mapper_link, $teerace, $skill);
			
			echo "
			</div><br><hr><br>
			";
		}
		/****************************** MAIN PLAYER FORMAT END ************************************/
		
		$total_pages = GetTotalPages($players_per_page, $hide_archive);
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
		echo "All player entries are released.</br>";
		echo "<input type=\"button\" value=\"view released players\" onclick=\"window.location.href='players.php'\"/>";
	}
	fok();
?>




