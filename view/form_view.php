<?php
function ViewOkayButton($page = 'index.php', $auto_forward = true)
{
    if ($auto_forward)
    {
?>
        <script>
            window.setTimeout(function() 
            {
                window.location.href='<?php echo $page; ?>';
            }, 2500);
            document.addEventListener("keydown", keyDownHandler, false);
            function keyDownHandler(e)
            {
                window.location.href='<?php echo $page; ?>';
            }
        </script>
<?php
    }
?>
        <form>
            <input type="button" value="okay" onclick="window.location.href='<?php echo $page; ?>'">
        </form>
<?php
}
?>
