<?php
require_once(__DIR__ . "/global.php");
require_once(__DIR__ . "/view/form_view.php");
session_start();
HtmlHeader("DeletePlayer", "jungle.css");

if (!empty($_POST['id']))
{
    $id = (int)$_POST['id'];
    $okay = isset($_POST['okay']) ? $_POST['okay'] : 'none';

    if (!IsAdmin())
    {
        echo "Missing permission<br>";
        ViewOkayButton('index.php', false); // no auto forwarding
        fok();
    }

    if ($okay === 'none')
    {
?>
    <h1>Are you sure?</h1>
    <h2>You can't undo the deletion of a player!</h2>
    <span>delete player with id=<?php echo $id; ?></span>
    <form action="delete_player.php" method="post">
        <input type="hidden" name="okay" value="delete">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="submit" name="action" value="delete">
    </form>
    <form action="delete_player.php" method="post">
        <input type="hidden" name="okay" value="back">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="submit" name="action" value="back">
    </form>
<?php
        fok();
    }
    else if ($okay === "delete")
    {
        echo "Deleted player entry with ID=$id";
        $db = new PDO(PLAYER_CONTRIBUTE_DATABASE);
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $stmt = $db->prepare("DELETE FROM Players WHERE ID = ?;");
        $stmt->execute(array($id));
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows)
        {
            echo "SQL output: </br>";
            print_r($rows);
        }
        ViewOkayButton('admin_edit_players.php', false);
        fok();
    }
    else
    {
        echo "Stopped deletion.</br>";
        ViewOkayButton('admin_edit_players.php', false);
        fok();
    }
}
else
{
    echo "Missing id";
    ViewOkayButton('admin_edit_players.php', false);
}

fok();
?>
