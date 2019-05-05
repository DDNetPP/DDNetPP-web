<?php
/****************
*  global.php   *
*****************/

//includes
require_once(__DIR__ . "/login_cookies.php");
require_once(__DIR__ . "/usefull_functions.php");


//debug
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

//constants
const DDPP_USER = "chiller";

/*
    PLAYER_DATABSE only holds all released players
    .schema
    CREATE TABLE "Players" (
    `ID`    INTEGER PRIMARY KEY AUTOINCREMENT,
    `Name`  TEXT,
    `AKA`   TEXT,
    `SkinName`  TEXT DEFAULT 'default',
    `SkinColorBody` INTEGER,
    `SkinColorFeet` INTEGER,
    `Clan`  TEXT,
    `ClanPage`  TEXT,
    `Clan2` TEXT,
    `ClanPage2` TEXT,
    `Skills`    TEXT,
    `yt_name`   TEXT,
    `yt_link`   TEXT,
    `DDNet` TEXT,
    `DDNetMapper`   TEXT,
    `KoG`   TEXT,
    `Teerace`   TEXT,
    `StartYear` INTEGER,
    `Info`  TEXT,
    `Editors`   TEXT,
    `LastEditDate`  TEXT,
    `LastEditor`    TEXT,
    `Type`  TEXT DEFAULT 'only_for_compability'
    );

    PLAYER_CONTRIBUTE_DATABASE is used for the edit requests
    The Status column holds release state and stuff
    Status states:
        0 = Archived/deleted (also blocks user form from adding this name agian)
        1 = Currently being edited
        2 = Finished edit pullrequest
        STATUS released (3) got removed since the row swaps database now
    Type states:
        'add'       = request to add a new player
        'edit'      = request to edit a player
        'derelease' = dereleased player

    .schema
    CREATE TABLE "Players" (
    `ID`    INTEGER PRIMARY KEY AUTOINCREMENT,
    `Name`  TEXT,
    `AKA`   TEXT,
    `SkinName`  TEXT DEFAULT 'default',
    `SkinColorBody` INTEGER,
    `SkinColorFeet` INTEGER,
    `Clan`  TEXT,
    `ClanPage`  TEXT,
    `Clan2` TEXT,
    `ClanPage2` TEXT,
    `Skills`    TEXT,
    `yt_name`   TEXT,
    `yt_link`   TEXT,
    `DDNet` TEXT,
    `DDNetMapper`   TEXT,
    `KoG`   TEXT,
    `Teerace`   TEXT,
    `StartYear` INTEGER,
    `Info`  TEXT,
    `Editors`   TEXT,
    `LastEditDate`  TEXT,
    `LastEditor`    TEXT,
    `Status`    INTEGER DEFAULT 1,
    `Type`  TEXT DEFAULT 'derelease'
    );
*/

//paths
const PLAYER_DATABASE = "sqlite:/var/www/html/DDNetPP-web/players/TeeworldsPlayers.db";
const PLAYER_CONTRIBUTE_DATABASE = "sqlite:/var/www/html/DDNetPP-web/players/TeeworldsPlayers_contribute.db";
const ABSOLUTE_DATABASE_PATH = "sqlite:/home/chiller/git/TeeworldsData/accounts.db";
const SCRIPTS_PATH = "/home/chiller/ddpp_database/web_scripts";
const SCRIPTS_TEST_SRV_PATH = "/home/chiller/ddpp_database/web_scripts/test_srv";
const UPDATE_SCRIPTS_SCRIPT_PATH = "/var/www/update_ddpp_scripts.sh";


const WEB_DATABASE_PATH_RAW = SCRIPTS_PATH . "/db/ddnetpp-web.db";
//const WEB_DATABASE_PATH_RAW = "/var/www/DDNetPP/database.db";
//const WEB_DATABASE_PATH = WEB_DATABASE_PATH_RAW;
const WEB_DATABASE_PATH = "sqlite:" . WEB_DATABASE_PATH_RAW;

//config
const IS_MINER = false;
const IS_COOKIE_LOGIN = true;
const IS_ALLOWED_TMP_GITHUB = true;
const HOTKEY_PAGES = ["Home", "Clan", "Server", "Players", "Account", "ServerPanel"];

?>
