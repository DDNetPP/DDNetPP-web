<?php
require_once(__DIR__ . '/global.php');

function _dbg_log($msg) {
	// echo "$msg\n</br>";
}

class MyDB_Panel extends SQLite3
{
	function __construct()
	{
		$this->open($_ENV['WEB_DATABASE_PATH_RAW']);
	}
	function __destruct() {
		_dbg_log("Closing database.");
		$this->close();
	}
}

function AddWebTable($sql)
{
	$check_db = new MyDB_Panel();
	if(!$check_db) {
		_dbg_log($check_db->lastErrorMsg());
	} else {
		_dbg_log("Opened database successfully");
	}

	$ret = $check_db->exec($sql);
	if(!$ret) {
		_dbg_log($check_db->lastErrorMsg() . "</br>");
	} else {
		_dbg_log("WebDatabase table created successfully");
	}
	$check_db->close();
}

function create_tables() {
	$table_server_panel =<<<EOF
	CREATE TABLE IF NOT EXISTS ServerPanel
	(
		ID				INTEGER		PRIMARY KEY		AUTOINCREMENT,
		Username		TEXT,
		Action			TEXT,
		TimeStamp		DATE,
		IP				TEXT,
		Location		TEXT,
		Browser			TEXT,
		OS				TEXT,
		OtherDetails	TEXT
	);
	EOF;

	$table_login_cookies =<<<EOF
	CREATE TABLE IF NOT EXISTS LoginCookies
	(
		ID			INTEGER		PRIMARY KEY		AUTOINCREMENT,
		Username	TEXT,
		Password	TEXT,
		TwID		INTEGER,
		IP			TEXT,
		Region		TEXT,
		Country		TEXT,
		Date		DATE,
		Token		TEXT
	);
	EOF;
	AddWebTable($table_server_panel);
	AddWebTable($table_login_cookies);
}

?>
