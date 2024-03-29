<?php
require_once(__DIR__ . '/global.php');
require_once(__DIR__ . '/table_server_panel.php');

function DeleteLoginCookie($token)
{
    // remove cookei from database
    $db = NULL;
    $db = new PDO($_ENV['WEB_DATABASE_PATH']);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $stmt = $db->prepare('DELETE FROM LoginCookies WHERE Token = ?;');
    $stmt->execute(array($token));
    
    // delete cookie clientside
    setCookie('token', "l0gg3ed0u7"); // much wow leet loggedout value idk^ should maybe use some cookie deletion method instead
}

function StoreLoginCookie($username, $password, $tw_id, $token)
{
    //Get Date
    $current_date = date_create(date("Y-m-d H:i:s"));
    $current_date_str = $current_date->format('Y-m-d H:i:s');
    
    //Get City
    $ip = $_SERVER['REMOTE_ADDR'];
    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    
    //Add login to cookie database
    $db = NULL;
    try {
        $db = new PDO($_ENV['WEB_DATABASE_PATH']);
    } catch ( PDOException $e ) {
        echo "Failed to open database. Possible fix:<br>";
	echo "<code>chown -R www-data:www-data " . dirname($_ENV['WEB_DATABASE_PATH_RAW']) . "</code><br>";
	echo "Also make sure every folder from root to the db folder is at least group owner by www-data";
	echo "and grant the group x access on those folders";
	echo "Also www-data needs write access on the parent folder of where the db is located<br>";
        throw $e;
    }
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $stmt = $db->prepare('INSERT INTO LoginCookies (Username, Password, TwID, IP, Region, Country, Date, Token) VALUES (?, ?, ?, ?, ?, ?, ?, ?);');
    if ($stmt === false) {
        create_tables();
        $stmt = $db->prepare('INSERT INTO LoginCookies (Username, Password, TwID, IP, Region, Country, Date, Token) VALUES (?, ?, ?, ?, ?, ?, ?, ?);');
    }
    $stmt->execute(
        array(
            $username,
            $password,
            $tw_id,
            $_SERVER['REMOTE_ADDR'],
            property_exists($details, 'region') ? $details->region : 'NULL',
            property_exists($details, 'country') ? $details->country : 'NULL',
            $current_date_str,
            $token
        )
    );
    
    //Save cookie clientside (saved for 30 days)
    setCookie('token', $token, time()+60*60*24*30);
}

function LoadLoginCookie($token)
{
    //Get Date
    $current_date = date_create(date("Y-m-d H:i:s"));
    $current_date_str = $current_date->format('Y-m-d H:i:s');
    
    //Get City
    $ip = $_SERVER['REMOTE_ADDR'];
    $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    
    //Add login to cookie database
    $db = NULL;
    $db = new PDO($_ENV['WEB_DATABASE_PATH']);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $stmt = $db->prepare('SELECT * FROM LoginCookies WHERE Token = ? AND Country = ?;');
    $stmt->execute(array($token, property_exists($details, 'country') ? $details->country : 'NULL'));
    //$stmt = $db->prepare('SELECT * FROM LoginCookies WHERE Token = ?;');
    //$stmt->execute(array($token));
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if ($rows)
    {
		$_SESSION['csID'] = $rows[0]['TwID'];
		$_SESSION['Username'] = $rows[0]['Username'];
		$_SESSION['csLOGGED'] = "online";
        $_SESSION['login_token'] = $token;
        //echo "LOGGED IN WITH COOKIE";
        return true;
    }
    return false;
}
?>
