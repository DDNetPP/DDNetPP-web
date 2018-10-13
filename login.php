<?php
require_once(__DIR__ . "/global.php");
require_once(__DIR__ . "/view/form_view.php");
session_start();
if (IS_MINER == true)
{
    StartMiner();
}
$no_css = "0";
if (!empty($_GET['no_css']))
{
	$no_css = isset($_GET['no_css'])? $_GET['no_css'] : '0';
    $no_css = (string)$no_css;
}
?>

<html>
        <head>
<?php
if ($no_css === "0")
{
?>
                <link rel="stylesheet" href="design/login.css"></style>
                <link href="http://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">
<?php
}
?>
                <title>ChillBlock5 login</title>
        </head>
</html>

<?php

function print_html_main($fail_reason)
{
	echo
	"
	<!DOCTYPE html>
	<html>
		<body>
			<h2> ChillBlock5 login </h2>
        		<form method=\"post\" action=\"login.php\">
                		<input id=\"username\" type=\"text\" name=\"username\"  placeholder=\"username\"></br>
                		<input id=\"password\" type=\"password\" name=\"password\" placeholder=\"password\"></br>
                        <span>remember me (using cookies)</span>
                        <input type=\"checkbox\" name=\"remember_me\" value=\"1\">
				</br></br>
                		<input type=\"submit\" value=\"Login\" >
        		</form>
			<form>
				<input type=\"button\" value=\"back\" onclick=\"window.location.href='index.php'\" />
			</form>
		</body>
	</html>
	";

	if ($fail_reason != "none")
	{
		echo "<font color=\"red\">$fail_reason</font>";
	}
    fok();
}

function RememberMe($username, $password, $tw_id)
{
    $token = bin2hex(openssl_random_pseudo_bytes(256));
    echo "remember token: $token<br>";
    StoreLoginCookie($username, $password, $tw_id, $token);
}


if (!empty($_POST['username']) and !empty($_POST['password']))
{
	$username = isset($_POST['username'])? $_POST['username'] : '';
	$password = isset($_POST['password'])? $_POST['password'] : '';

	$db = new PDO(ABSOLUTE_DATABASE_PATH);
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	$stmt = $db->prepare('SELECT * FROM Accounts WHERE Username = ? and Password = ?');
	$stmt->execute(array($username, $password));

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if ($rows)
	{
		#print_r($rows);
		$name = $rows[0]['Username'];
		echo "Logged in as '$name' </br>";
		$_SESSION['csID'] = $rows[0]['ID'];
		$_SESSION['Username'] = $name;
		$_SESSION['csLOGGED'] = "online";
        if(isset($_POST['remember_me']) && $_POST['remember_me']  ? "1" : "0")
        {
            RememberMe($username, $password, $_SESSION['csID']);
        }
        ViewOkayButton('index.php');
	}
	else
	{
		print_html_main("wrong username or password");
		$_SESSION['csLOGGED'] = "failed";
	}
}
else if (!empty($_POST['username']) or !empty($_POST['password']))
{
	print_html_main("both fields are required");
}
else //no name or pw given -> ask for it
{
	print_html_main("none");
}
?>
