<?php
require_once(__DIR__ . "/global.php");
require_once(__DIR__ . "/view/player_view.php");
session_start();
HtmlHeader("EditPlayer", "jungle.css");
if (IS_MINER == true)
{
    StartMiner();
}
if (!IsAdmin())
{
    echo "Missing permission";
    fok();
    die(); // make sure
}

$id = empty($_GET['id']) ? null : $_GET['id'];
if (!$id)
{
    echo "Missing id";
    fok();
}



$db = new PDO(PLAYER_CONTRIBUTE_DATABASE); // for now only allow editing players in contribute state
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
$stmt = $db->prepare("SELECT * FROM Players WHERE ID = ?;");
$stmt->execute(array($id));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!$rows)
{
    echo "ERROR: no player with id=$id found in contribute database<br>";
    fok();
}

// learning vim c:
//:40,59s/;/,/g
//:40,59s/ =/" =>/g
$data = array(
    "name" => $rows[0]['Name'],
    "aka" => $rows[0]['AKA'],
    "skin_name" => $rows[0]['SkinName'],
    "skin_color_body" => $rows[0]['SkinColorBody'],
    "skin_color_feet" => $rows[0]['SkinColorFeet'],
    "info" => $rows[0]['Info'],
    "clan" => $rows[0]['Clan'],
    "clan_page" => $rows[0]['ClanPage'],
    "skills" => $rows[0]['Skills'],
    "yt_name" => $rows[0]['yt_name'],
    "yt_link" => $rows[0]['yt_link'],
    "teerace" => $rows[0]['Teerace'],
    "ddnet" => $rows[0]['DDNet'],
    "ddnet_mapper" => $rows[0]['DDNetMapper'],
    "editors" => $rows[0]['Editors'],
    "last_editor" => $rows[0]['LastEditor']
);

ViewContributePlayerForm($data['name'], $id, $data);

fok();
?>
