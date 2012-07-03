<?php

include 'header.php';

$title = '<h1>Login</h1>';

if($_GET['loginError'] == 'userNotFound')
	$content = '<p id="missingFieldMsg">Falscher Username oder Passwort</p>';
	
else if($_GET['loginError'] == 'emptyUsername')
	$content = '<p id="missingFieldMsg">Bitte Usernamen und Passwort angeben</p>';

else
	$content = '<p id="missingFieldMsg"></p>';

$content .= '
	<form id="loginForm" action="login.php" method="post">
		<ul
			<li>
				<label>Benutzername</label>
				<input id="nickname" name="nickname" type="text" placeholder="Benutzername" autofocus/>
			</li>
			<li>
				<label>Passwort</label>
				<input id="password" name="password" type="password" placeholder="Passwort"/>
			</li>
			<li>
				<input id="loginButton" type="submit" name="login" value="Login" />
			</li>
		</ul
	</form>
';

include 'footer.php';
?>
