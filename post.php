<?php
session_start();
require_once(__DIR__ . "/global.php");

if(isset($_SESSION['name'])){
    
    
    //set_time_limit(400);

    //$out = shell_exec("/home/chiller/ddpp_database/say_all_servers.sh hi");
    //$out = shell_exec("/home/chiller/ddpp_database/exp_rcon_api/say_exp_server.exp CENSORED_PASSWORD 1336 hi");
    //echo "out: $out";
    
    
    set_time_limit(420);
    
    
    //shell_exec("/home/chiller/ddpp_database/say_all_servers.sh \"[webchat]" . $_SESSION['name'] . ":" . $text ."\"");
    //$out = shell_exec("/home/chiller/ddpp_database/say_all_servers.sh hi");
    $out = shell_exec("/home/chiller/ddpp_database/exp_rcon_api/say_exp_server.exp CENSORED_PASSWORD 1336 $text");
    //$out = shell_exec("/home/chiller/ddpp_database/exp_rcon_api/say_exp_server.exp CENSORED_PASSWORD 1336 hi");
    echo $out;
    //sleep(60);
    
    $text = $_POST['text'];
     
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b> out ( $out ) ".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($fp);
}
?>