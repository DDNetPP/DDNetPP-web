<?php
function MoveRowToOtherDataBase($src, $dst, $id)
{
    // getting all the values
    $db = new PDO($src);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $stmt = $db->prepare("SELECT * FROM Players WHERE ID = ?;");
    $stmt->execute(array($id));
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows)
    {
        echo "ERROR: failed to get values<br>";
        fok();
    }
    $name = $rows[0]['Name'];
    $aka = $rows[0]['AKA'];
    $skin_name = $rows[0]['SkinName'];
    $skin_color_body = $rows[0]['SkinColorBody'];
    $skin_color_feet = $rows[0]['SkinColorFeet'];
    $info = $rows[0]['Info'];
    $clan = $rows[0]['Clan'];
    $clan_page = $rows[0]['ClanPage'];
    $skills = $rows[0]['Skills'];
    $yt_name = $rows[0]['yt_name'];
    $yt_link = $rows[0]['yt_link'];
    $teerace = $rows[0]['Teerace'];
    $ddnet = $rows[0]['DDNet'];
    $ddnet_mapper = $rows[0]['DDNetMapper'];

    // save all values in contributor database
    $db = new PDO($dst);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $stmt = $db->prepare("
    INSERT INTO Players
    (Name, AKA, SkinName, SkinColorBody, SkinColorFeet,
    Info, Clan, ClanPage, Skills,
    yt_name, yt_link, Teerace, DDNet, DDNetMapper)
    VALUES (
    ?, ?, ?, ?, ?,
    ?, ?, ?, ?,
    ?, ?, ?, ?, ?
    );
    ");
    $stmt->execute(array(
    $name, $aka, $skin_name, $skin_color_body, $skin_color_feet,
    $info, $clan, $clan_page, $skills,
    $yt_name, $yt_link, $teerace, $ddnet, $ddnet_mapper
    ));

    // delete from released database
    $db = new PDO($src);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $stmt = $db->prepare("DELETE FROM Players WHERE ID = ?;");
    $stmt->execute(array($id));
}
?>
