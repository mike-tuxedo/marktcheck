<?php

include 'header.php';

$title = '<h1>Signup</h1>';

if($_GET['regisError'] == 'alreadyInUse')
	$content = '<p id="missingFieldMsg">User oder Email wird schon benutzt</p>';
	
else if($_GET['regisError'] == 'wrongValues')
	$content = '<p id="missingFieldMsg">Die Angaben enthalten nicht erlaubte Zeichen</p>';

else
	$content = '<p id="missingFieldMsg"></p>';

$content .= '<form id="signUp" action="signup.php" method="POST">
				<ul>
					<li>
						<label for="nickname">Name</label><br/>
						<input id="nickname" type="text" name="nickname" autofocus placeholder="Max"/>
					</li>
					<li>
						<label for="email">eMail</label><br/>
						<input id="email" type="email" name="email" placeholder="max.muster@gmail.com"/>
					</li>
					<li>
						<label for="password">Passwort</label><br/>
						<input id="password" type="password" name="password" placeholder="Passwort"/>
					</li>
					<li>
						<input id="signupButton" type="submit" value="Anmelden"/>
					</li>
				</ul>
			</form>';

include 'footer.php';

?>
