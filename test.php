<?php
require_once(__DIR__ . "/global.php");
require_once(__DIR__ . "/login_cookies.php");

function AskForToken()
{
?>
    <form method="post" action="test.php">
        <input type="text" name="token">
    </form>
<?php
}

function TestCookieTokens()
{
    if (isset($_COOKIE['token']))
    {
        $token = $_COOKIE['token'];
        echo "found token: $token<br>trying to login...<br>";
        $login_status = LoadLoginCookie($token);
        echo "loaded login status<br>";
        if ($login_status)
        {
            echo "login succesfull<br>";
        }
        else
        {
            echo "login failed<br>";
        }
    }
    else
    {
        if (!empty($_POST['token']))
        {
            $token = $_POST['token'];
            echo "saving tokem: $token as cookie<br>";
            setCookie('token', $token);
            $ip = $_SERVER['REMOTE_ADDR'];
            $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
            echo "saving token in database with country: $details->country <br>";
            StoreLoginCookie("username", "pass", $token);
            
        }
        else
        {
            AskForToken();
        }
    }
}
?>
