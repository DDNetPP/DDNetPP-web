<?php
/****************
*  global.php   *
*****************/

//includes
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/login_cookies.php');
require_once(__DIR__ . '/usefull_functions.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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
const PLAYER_DATABASE = 'sqlite:' . __DIR__ . '/players/TeeworldsPlayers.db';
const PLAYER_CONTRIBUTE_DATABASE = 'sqlite:' . __DIR__ . '/players/TeeworldsPlayers_contribute.db';

//config
const IS_MINER = false;
const IS_COOKIE_LOGIN = true;
const IS_ALLOWED_TMP_GITHUB = true;
const HOTKEY_PAGES = ['Home', 'Clan', 'Server', 'Players', 'Account', 'ServerPanel'];

?>
