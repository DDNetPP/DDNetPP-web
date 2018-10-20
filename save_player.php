<?php
require_once(__DIR__ . "/global.php");
require_once(__DIR__ . "/view/player_view.php");
require_once(__DIR__ . "/view/form_view.php");
require_once(__DIR__ . "/players/player_lib.php");
session_start();

HtmlHeader("SavePlayer", "jungle.css");

function BackButton()
{
?>
        <br/><input type="button" value="Back" onclick="window.location.href='contribute_players.php'"/>
<?php
}

if (!IsLoggedIn())
{
    echo 'sowwy you have to be <a href="login.php">logged in</a> ._.<br>';
    fok();
}

if (!empty($_POST['submit_player']))
{
    $name = $_POST['submit_player'];
    $type = isset($_POST['type']) ? $_POST['type'] : null;
    $id = isset($_POST['player_id']) ? $_POST['player_id'] : false;
    $editor = $_SESSION['Username'];
    if (empty($_POST['info']))
    {
        echo "ERROR: info field can't be empty<br>";
        BackButton();
        fok();
    }
    if ($id === false || !is_numeric($id))
    {
        echo "ERROR: missing or invalid id<br>";
        BackButton();
        fok();
    }

    $arr = array(
        $name,
        isset($_POST['aka'])? $_POST['aka'] : NULL,
        isset($_POST['skin_name'])? $_POST['skin_name'] : NULL,
        isset($_POST['skin_color_body'])? $_POST['skin_color_body'] : NULL,
        isset($_POST['skin_color_feet'])? $_POST['skin_color_feet'] : NULL,
        $_POST['info'],
        isset($_POST['clan'])? $_POST['clan'] : NULL,
        isset($_POST['clan_page'])? $_POST['clan_page'] : NULL,
        isset($_POST['skills'])? $_POST['skills'] : NULL,
        isset($_POST['yt_name'])? $_POST['yt_name'] : NULL,
        isset($_POST['yt_link'])? $_POST['yt_link'] : NULL,
        isset($_POST['teerace'])? $_POST['teerace'] : NULL,
        isset($_POST['ddnet'])? $_POST['ddnet'] : NULL,
        isset($_POST['ddnet_mapper'])? $_POST['ddnet_mapper'] : NULL,
        $editor, // list of all editors
        $editor  // last editor
    );


    if ($type === "edit")
    {
        $error = UpdatePlayer($id, $arr);
        if ($error)
        {
            echo "$error<br>";
        }
        else
        {
            echo "Player '$name' edited<br>Wait until an admin accepts your work c:<br>";

            // remove this if users can edit aswell:
            echo "Well you should be admin...";
            ViewOkayButton('admin_edit_players.php');
            fok();
        }
    } else if ($type === "add") {
        $error = AddNewPlayer($arr);
        if ($error)
        {
            echo "$error<br>";
        }
        else
        {
            echo "New player added '$name'<br>Wait until an admin accepts your work c:<br>";
        }
    } else {
        echo "ERROR: unkown save type</br>";   
    }

    BackButton();
    fok();
}
else
{
    echo "nothign to save...<br>";
    ViewOkayButton('index.php', false); // no auto forward
}

?>
