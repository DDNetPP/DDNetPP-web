<?php
require_once(__DIR__ . "/global.php");
require_once(__DIR__ . "/view/player_view.php");
require_once(__DIR__ . "/players/player_lib.php");
session_start();
HtmlHeader("Players", "jungle.css", "TeeAssembler.css");

function GetTotalPages($items_per_page)
{
    // Status column got removed and only used by the contribute database
    //$SQL_pages_base = "SELECT COUNT(*) AS TotalPages FROM Players WHERE Status = 3";
    $SQL_pages_base = "SELECT COUNT(*) AS TotalPages FROM Players;";
    
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

    $is_admin = IsAdmin();
    if ($is_admin)
    {
        echo '
        <input type="button"  value="admin" onclick="window.location.href=\'admin_edit_players.php\'">
        ';
        if (!empty($_POST['action']))
        {
            $action = $_POST['action'];
            if ($action == "derelease")
            {
                $id = (int)$_POST['id'];
                echo "derleasing player ID=$id<br>";
                MoveRowToOtherDataBase(PLAYER_DATABASE, PLAYER_CONTRIBUTE_DATABASE, $id);
            }
        }
    }
        


    $SQL_playerlist_query_base = "SELECT * FROM Players WHERE ID > ? ";
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
            ViewPlayer($row, $is_admin);
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

