<?php
session_start();
require_once(__DIR__ . "/global.php");

function shell_prepare($str) {
    $str = str_replace("'", ' ', $str);
    $str = str_replace('"', ' ', $str);
    $str = str_replace('$', ' ', $str);
    $str = str_replace('`', ' ', $str);
    $str = str_replace('(', ' ', $str);
    $str = str_replace(')', ' ', $str);
    $str = str_replace('.', ' ', $str);
    $str = str_replace('/', ' ', $str);
    $str = str_replace('<', ' ', $str);
    $str = str_replace('>', ' ', $str);
    $str = str_replace(';', ' ', $str);
    return $str;
}

if(isset($_SESSION['name'])){
    $text = $_POST['message'];
    $cmd = 'cd ' . $_ENV['BLMAPCHILL_SERVER_PATH']
        . ' && ./lib/econ.sh '
        . "'say \"[webchat]<" . shell_prepare($_SESSION['name']) . '>: ' . shell_prepare($text) . "\"'";
    $out = shell_exec($cmd);

    $fp = fopen('log.html', 'a');
    fwrite($fp,
        "<div class='msgln'>(".date("g:i A").") <b>"
        . stripslashes(htmlspecialchars($_SESSION['name']))
        . '</b>: '
        . stripslashes(htmlspecialchars($text))
        . '<br></div>');
    fclose($fp);
}
?>
