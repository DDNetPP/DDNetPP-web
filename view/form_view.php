<?php
function ViewOkayButton($page = 'index.php')
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
        <form>
            <input type="button" value="okay" onclick="window.location.href='<?php echo $page; ?>'">
        </form>
<?php
}
?>
