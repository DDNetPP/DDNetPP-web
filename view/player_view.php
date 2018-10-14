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
?>
