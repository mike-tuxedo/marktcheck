<?php
include 'header.php';

$title = '<h1>Einkaufsliste</h1>';

//check if user is declared
if($_SESSION['USER'])
{
	//vorerst nur eine Einkaufsliste die immerwieder gelöscht werden kann und bearbeitet werden kann.
	$user = $_SESSION['USER'];

	$stmt = $connect -> prepare("SELECT * FROM fhs_baskets WHERE usernme = ?");
	$stmt -> bind_param('s', $user);
	$stmt -> execute();
	$stmt -> bind_result($id, $nme, $user, $products);
	$stmt -> fetch();
	$stmt -> close();

	$content .= '<h1>Deine Einkaufsliste:</h1><ol>';

	//convert the String to an Array (it's magic) and list all products, if there are ones
	$productArray = unserialize($products);

	if(sizeof($productArray) > 0)
	{
		foreach ($productArray as $key)
			$content .= '<li>'.$key.'<a href="addRemoveProduct.php?product='.$key.'&action=remove"><strong>delete</strong></a></li>';
			
		$content .= '</ol>';
	}
	else
		$content .= '<li>Sie haben keine Produkte auf ihrer Liste</li></ol>';
}
else
	//give response to the user the he/she has to bo registrated and logged in for a basket
	$content .= '<p>Du musst dich einloggen um eine Einkaufliste zu erstellen:</p>
				<p><a href="settingsLogin.php"><button id="loginButton" />Zum Login</button></a></p>
				<p>Du bist neu hier, dann registrier dich doch ganz einfach bei uns:</p>
				<p><a href="settingsSignup.php"><button id="settingsButton" />Zum Registrieren</button></a></p>';

include 'footer.php';

?>
