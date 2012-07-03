<?php

include 'header.php';
include 'configParameter.php';

$sql = "SELECT COUNT(*) 
		FROM article_category ac, article a 
		WHERE a.id = ac.articleid AND a.articleStatusID = ?";
$stmt = $connect -> prepare($sql);
$stmt -> bind_param('s', $articleStatus);
$stmt -> execute();
$stmt -> bind_result($numberOfArticles);
$stmt -> fetch();
$stmt -> close();

if($_SESSION[ 'USER' ])
    $greeting = '<p>Hallo '.$_SESSION[ 'USER' ].', du kannst nun deinen Einkaufszettel bearbeiten oder private Einstellungen vornehmen</p>';
else
    $greeting = '<img id="welcome" src="images/welcome.png" />';

$searchField = '
    <form action="searchRequest.php" method="GET">
	   <input id="searchField" class="autocomplete" name="searchStr" type="text" placeholder="Gib ein Produkt ein" onkeyup="doAutocomplete(this.value);" autocomplete="off" />
	   <input id="submit" type="submit" value="" name="go" />

        <div id="autocompleteBox" style="display: none;">
            <img src="images/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
            <div id="autocompleteList"></div>
        </div>
    </form>';

$content = '
	<p class="note">Derzeit kannst du aus über <span style="font-family: QuorumStdBlack">'.$numberOfArticles.'</span> Produkten auswählen.</p>
    <ul>
    	<li class="typeList buttonSmall"><a href="categoryList.php?type=1" title="Lebensmittel"><img src="images/food.png" alt="Lebensmittel" /></a></li>
    	<li class="typeList buttonSmall"><a href="categoryList.php?type=2" title="Getränke"><img src="images/drinks.png" alt="Getränke" /></a></li>
    	<li class="typeList buttonSmall"><a href="categoryList.php?type=3" title="Kosmetik"><img src="images/cosmetics.png" alt="Kosmetik"/></a></li>
    	<li class="typeList buttonLarge"><a href="barcodeScanner.php"><img src="images/scanner.png" /></a></li>
   	    <li class="typeList buttonLarge"><a href="shoppingList.php"><img src="images/shoppinglist.png" /></a></li>
   	</ul>';

include 'footer.php';

?>
