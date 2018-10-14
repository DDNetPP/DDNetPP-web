<?php

function IsPlayerInDatabase($player, $contribute)
{
    $db = NULL; // idk baut scoping in php but this might help
    if ($contribute)
    {
        $db = new PDO(PLAYER_CONTRIBUTE_DATABASE);
    }
    else
    {
        $db = new PDO(PLAYER_DATABASE);
    }
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
            return "'$name' already exists";
        }
        else
        {
            return "'$name' aka '$aka' already exists";
        }
    }
    return false;
}

function CanAddPlayer($player)
{
    $rls = IsPlayerInDatabase($player, PLAYER_DATABASE);
    $con = IsPlayerInDatabase($player, PLAYER_CONTRIBUTE_DATABASE);
    return !($rls || $con);
}

function AddNewPlayer($attrs)
{
    if (!CanAddPlayer($attrs[0]))
    {
        return "ERROR: player in database already";
    }

    $db = new PDO(PLAYER_CONTRIBUTE_DATABASE);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    /*
    $stmt = $db->prepare("
    INSERT INTO Players
    (Name, AKA, Info, Type) VALUES (?, ?, ?, 'add');
    ");
    */


    $stmt = $db->prepare("
    INSERT INTO Players
    (Name, AKA, SkinName, SkinColorBody, SkinColorFeet,
    Info, Clan, ClanPage, Skills,
    yt_name, yt_link, Teerace, DDNet, DDNetMapper,
    Editors, LastEditor, Type)
    VALUES (
    ?, ?, ?, ?, ?,
    ?, ?, ?, ?,
    ?, ?, ?, ?, ?,
    ?, ?, 'add'
    );
    ");


    $stmt->execute($attrs);

    /*

    $stmt->execute(array(
    $attrs['name'], $attrs['aka'], $attrs['skin_name'], $attrs['skin_color_body'], $attrs['skin_color_feet'],
    $attrs['info'], $attrs['clan'], $attrs['clan_page'], $attrs['skills'],
    $attrs['yt_name'], $attrs['yt_link'], $attrs['teerace'], $attrs['ddnet'], $attrs['ddnet_mapper']
    ));
    */
    return NULL;
}

function MoveRowToOtherDataBase($src, $dst, $id)
{
    // getting all the values from source db
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
    $editor = $rows[0]['editor'];
    $last_editor = $rows[0]['last_editor'];

    // save all values in destination database
    // if dst = contributor then the default type will handle the type
    $db = new PDO($dst);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $stmt = $db->prepare("
    INSERT INTO Players
    (Name, AKA, SkinName, SkinColorBody, SkinColorFeet,
    Info, Clan, ClanPage, Skills,
    yt_name, yt_link, Teerace, DDNet, DDNetMapper,
    Editors, LastEditor)
    VALUES (
    ?, ?, ?, ?, ?,
    ?, ?, ?, ?,
    ?, ?, ?, ?, ?,
    ?, ?
    );
    ");
    $stmt->execute(array(
    $name, $aka, $skin_name, $skin_color_body, $skin_color_feet,
    $info, $clan, $clan_page, $skills,
    $yt_name, $yt_link, $teerace, $ddnet, $ddnet_mapper,
    $editor, $last_editor
    ));

    // delete from source database
    $db = new PDO($src);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $stmt = $db->prepare("DELETE FROM Players WHERE ID = ?;");
    $stmt->execute(array($id));
}
?>
