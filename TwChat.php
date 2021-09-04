<?php
require_once(__DIR__ . "/global.php");
session_start();

function loginForm() {
	echo '
    <div id="loginform">
    <form action="TwChat.php" method="post">
        <p>Please enter your name to continue:</p>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" />
        <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
    </div>
    ';
}

function check_logfile_permissions($fp) {
	if (!$fp) {
		echo '<br/><span>Error: failed to open log. Try this permissions fix:</span><br/>';
		echo '<code>cd ' . __DIR__ . ' && touch log.html && chown www-data:www-data log.html</code><br/>';
		fok();
	}
	return $fp;
}

if (isset($_POST['enter'])) {
	if ($_POST['name'] != "") {
		$_SESSION ['name'] = stripslashes(htmlspecialchars($_POST ['name']));
		$fp = fopen('log.html', 'a');
		check_logfile_permissions($fp);
		fwrite($fp, "<div class='msgln'><i>User " . htmlspecialchars($_SESSION ['name']) . " has joined the chat session.</i><br></div>" );
		fclose($fp);
	} else {
		echo '<span class="error">Please type in a name</span>';
	}
}

if (isset($_GET['logout'])) {
	// Simple exit message
	$fp = fopen("log.html", 'a');
	check_logfile_permissions($fp);
	fwrite ($fp, "<div class='msgln'><i>User " . htmlspecialchars($_SESSION ['name']) . " has left the chat session.</i><br></div>" );
	fclose ($fp);
	
	session_destroy ();
	header("Location: TwChat.php"); // Redirect the user
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
            <link type="text/css" rel="stylesheet" href="style.css" />
            <title>Teeworlds chat</title>
    </head>
<body>
	<?php
	if (!isset($_SESSION['name'])) {
		loginForm ();
	} else {
		?>
<div id="wrapper">
		<div id="menu">
			<p class="welcome">
				Welcome, <b><?php echo htmlspecialchars($_SESSION['name']); ?></b>
			</p>
			<p class="logout">
				<button id="exit" onclick="window.location = 'TwChat.php?logout=true'">Exit Chat</button>
			</p>
			<div style="clear: both"></div>
		</div>
		<div id="chatbox"><?php
		if (file_exists('log.html') && filesize('log.html') > 0) {
			$handle = fopen('log.html', 'r' );
			check_logfile_permissions($handle);
			$contents = fread($handle, filesize('log.html'));
			fclose($handle);

			echo $contents;
		}
		?></div>

		<form name="chat-form" id="chat-form" action="">
			<input name="message" type="text" id="message" size="63" />
			<input name="send" type="submit" id="send" value="Send" />
		</form>
	</div>
	<script type="text/javascript"
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
	<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
});

function loadLog(){		
	var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
	$.ajax({
		url: "log.html",
		cache: false,
		success: function(html){		
			$("#chatbox").html(html); //Insert chat log into the #chatbox div	
			
			//Auto-scroll			
			var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
			if(newscrollHeight > oldscrollHeight){
				$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
			}				
	  	},
	});
}

setInterval(loadLog, 1000);
</script>
<?php
	}
	?>
	<script src="js/tw_chat.js"></script>
	<script type="text/javascript"
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
	<script type="text/javascript">
</script>
</body>
</html>
