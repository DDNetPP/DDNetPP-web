<?php
function ViewContributePlayerForm($name, $id = 0, $edit = null)
{
    if (!$edit)
    {
        echo "<h1>Adding player $name</h1>";
    } else {
        echo "<h1>Editing player $name</h1>";
    }
    $aka = isset($edit['aka']) ? $edit['aka'] : '';
    $skin_name = isset($edit['skin_name']) ? $edit['skin_name'] : '';
    $skin_color_body = isset($edit['skin_color_body']) ? $edit['skin_color_body'] : '';
    $skin_color_feet = isset($edit['skin_color_feet']) ? $edit['skin_color_feet'] : '';
    $info = isset($edit['info']) ? $edit['info'] : '';
    $clan = isset($edit['clan']) ? $edit['clan'] : '';
    $clan_page = isset($edit['clan_page']) ? $edit['clan_page'] : '';
    $skills = isset($edit['skills']) ? $edit['skills'] : '';
    $yt_name = isset($edit['yt_name']) ? $edit['yt_name'] : '';
    $yt_link = isset($edit['yt_link']) ? $edit['yt_link'] : '';
    $teerace = isset($edit['teerace']) ? $edit['teerace'] : '';
    $ddnet = isset($edit['ddnet']) ? $edit['ddnet'] : '';
    $ddnet_mapper = isset($edit['ddnet_mapper']) ? $edit['ddnet_mapper'] : '';
    $editors = isset($edit['editors']) ? $edit['editors'] : '';
    $last_editor = isset($edit['last_editor']) ? $edit['last_editor'] : '';
?>
    TODO: add preview

    <form action="save_player.php" method="post">
<?php
        if ($edit)
        {
            echo "
            name:</br>
            <input type=\"text\" name=\"submit_player\" value=\"$name\"></br>
            <input type=\"hidden\" name=\"type\" value=\"edit\">";
        } else {
?>
        <input type="hidden" name="submit_player" value="<?php echo $name;?>">
        <input type="hidden" name="type" value="add">
<?php
        }
?>
        <input type="hidden" name="player_id" value="<?php echo $id;?>">
        aka:<br>
        <input type="text" name="aka" value="<?php echo $aka;?>"><br>
        skin:<br>
        <input type="text" name="skin_name" value="<?php echo $skin_name;?>"><br>
        skin colorcode (body):<br>
        <input type="text" name="skin_color_body" value="<?php echo $skin_color_body;?>"><br>
        skin color (feet):<br>
        <input type="text" name="skin_color_feet" value="<?php echo $skin_color_feet;?>"><br>
        info:<br>
        <textarea name="info" rows="5" cols="64"><?php echo $info;?></textarea><br>
        clan:<br>
        <input type="text" name="clan" value="<?php echo $clan;?>"><br>
        clan page (url):<br>
        <input type="text" name="clanpage" value="<?php echo $clan_page;?>"><br>
        skills:<br>
        <input type="text" name="skills" value="<?php echo $skills;?>"><br>
        youtube name:<br>
        <input type="text" name="yt_name" value="<?php echo $yt_name;?>"><br>
        youtube link:<br>
        <input type="text" name="yt_link" value="<?php echo $yt_link;?>"><br>
        teerace:<br>
        <input type="text" name="teerace" value="<?php echo $teerace;?>"><br>
        ddnet:<br>
        <input type="text" name="ddnet" value="<?php echo $ddnet;?>"><br>
        ddnet mapper (username):<br>
        <input type="text" name="ddnet_mapper" value="<?php echo $ddnet_mapper;?>"><br>
        <br>
        <input type="submit" value="submit"><br>
    </form>
<?php
}

function ViewPlayer($row, $is_admin)
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
    $skills = $row['Skills'];
    $yt_name = $row['yt_name'];
    $yt_link = $row['yt_link'];
    $teerace = $row['Teerace'];
    $ddnet = $row['DDNet'];
    $ddnet_mapper = $row['DDNetMapper'];
    $ddnet_link = $ddnet;
    $ddnet_mapper_link = $ddnet_mapper;
    if ($is_admin)
    {
?>
<form action="players.php" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="submit" name="action" value="derelease" />
</form>
<?php
    }
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
        if ($skills)
            echo "<a><strong>Skill:</strong> $skills</a></br>";
        echo "
        </div><br><hr><br>
        ";
}
?>
