<?php
function ViewAddPlayerForm($name)
{
?>
    <h1>Adding player '<?php echo $name; ?>'</h1>
    TODO: add preview

    <form action="add_player.php" method="post">
        <input type="hidden" name="submit_player" value="<?php echo $name; ?>">
        aka:<br>
        <input type="text" name="aka"><br>
        skin:<br>
        <input type="text" name="skin_name"><br>
        skin colorcode (body):<br>
        <input type="text" name="skin_color_body"><br>
        skin color (feet):<br>
        <input type="text" name="skin_color_feet"><br>
        info:<br>
        <textarea name="info" rows="5" cols="64"></textarea><br>
        clan:<br>
        <input type="text" name="clan"><br>
        clan page (url):<br>
        <input type="text" name="clanpage"><br>
        skills:<br>
        <input type="text" name="skills"><br>
        youtube name:<br>
        <input type="text" name="yt_name"><br>
        youtube link:<br>
        <input type="text" name="yt_link"><br>
        teerace:<br>
        <input type="text" name="teerace"><br>
        ddnet:<br>
        <input type="text" name="ddnet"><br>
        ddnet mapper (username):<br>
        <input type="text" name="ddnet_mapper"><br>
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
