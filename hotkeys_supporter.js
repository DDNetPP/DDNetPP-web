document.addEventListener("keydown", keyDownHandler, false);
function keyDownHandler(e)
{
    if (e.keyCode == 49) // 1
    {
        document.location = 'index.php';
    }
    else if (e.keyCode == 50) // 2
    {
        document.location = 'clan.php';
    }
    else if (e.keyCode == 51) // 3
    {
        document.location = 'server.php';
    }
    else if (e.keyCode == 52) // 4
    {
        document.location = 'players.php';
    }
    else if (e.keyCode == 53) // 5
    {
        document.location = 'server_panel.php';
    }
    else if (e.keyCode == 54) // 6
    {
        document.location = 'account.php';
    }
}
