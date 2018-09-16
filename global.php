<?php
/****************
*  global.php   *
*****************/

//includes
require_once(__DIR__ . "/usefull_functions.php");


//debug
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

//paths
const ABSOLUTE_DATABASE_PATH = "sqlite:/home/chiller/ddpp_database/accounts.db";
const PLAYER_DATABASE = "sqlite:/var/www/html/DDNetPP-web/players/TeeworldsPlayers.db";
const SCRIPTS_PATH = "/home/chiller/ddpp_database/web_scripts";

//config
const IS_MINER = false;

?>
