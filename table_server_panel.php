<?php
require_once("/var/www/html/DDNetPP-web/global.php");

function AddWebTable($sql)
{
   class MyDB_Panel extends SQLite3
   {
      function __construct()
      {
         $this->open($_ENV['WEB_DATABASE_PATH_RAW']);
      }
   }
   $check_db = new MyDB_Panel();
   if(!$check_db) {
      echo $check_db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n</br>";
   }

   $ret = $check_db->exec($sql);
   if(!$ret) {
      echo $check_db->lastErrorMsg() . "</br>";
   } else {
      echo "WebDatabase table created successfully\n</br>";
   }
   $check_db->close();
}

$table_server_panel =<<<EOF
		CREATE TABLE IF NOT EXISTS ServerPanel
		(
		ID					INTEGER		PRIMARY KEY		AUTOINCREMENT,
		Username			TEXT,
        Action              TEXT,
        TimeStamp           DATE,
        IP                  TEXT,
        Location            TEXT,
        Browser             TEXT,
        OS                  TEXT,
        OtherDetails        TEXT
		);
EOF;

$table_login_cookies =<<<EOF
		CREATE TABLE IF NOT EXISTS LoginCookies
		(
		ID					INTEGER		PRIMARY KEY		AUTOINCREMENT,
		Username            TEXT,
        Password            TEXT,
        TwID                INTEGER,
        IP                  TEXT,
        Region              TEXT,
        Country             TEXT,
        Date                DATE,
        Token               TEXT
		);
EOF;

//AddWebTable($table_server_panel); //Currently commented out becuase this is only needed once
//AddWebTable($table_login_cookies);
?>
