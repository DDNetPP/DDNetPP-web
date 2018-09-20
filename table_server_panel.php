<?php
require_once("/var/www/html/DDNetPP-web/global.php");

function CreateTableServerPanel()
{
   class MyDB_Panel extends SQLite3
   {
      function __construct()
      {
         $this->open(WEB_DATABASE_PATH_RAW) ;
      }
   }
   $check_db = new MyDB_Panel() ;
   if(!$check_db) {
      echo $check_db->lastErrorMsg() ;
   } else {
      echo "Opened database successfully\n";
   }

	$sql =<<<EOF
		CREATE TABLE ServerPanel
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

   $ret = $check_db->exec($sql) ;
   if(!$ret) {
      echo $check_db->lastErrorMsg() . "</br>";
   } else {
      echo "ServerPanel Table created successfully\n</br>";
   }
   $check_db->close();
}
//CreateTableServerPanel(); //Currently commented out becuase this is only needed once
?>
