<?php
echo "[rcon]:";
$shellout= shell_exec("./cb5_rcon.exp");
echo( '<pre>' );
echo( $shellout );
echo( '</pre>' );

echo "<input type=\"button\" value=\"back\" onclick=\"window.location.href='index.html'\" />";
?>
