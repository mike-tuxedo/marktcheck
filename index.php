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
    $greeting = '<div id="welcome"></div>';

$searchField = '
  <form action="searchRequest.php" method="GET">
  <input id="submit" type="submit" value="" name="go" />
   <input id="searchField" class="autocomplete" name="searchStr" type="text" placeholder="Gib ein Produkt ein" onkeyup="doAutocomplete(this.value);" autocomplete="off" />

      <div id="autocompleteBox" style="display: none;">
          <img src="images/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
          <div id="autocompleteList"></div>
      </div>
  </form>';

$content = '
	<p id="note">Derzeit kannst du aus über <span style="font-family: QuorumStdBlack">'.$numberOfArticles.'</span> Produkten auswählen.</p>
	<ul>
		<a href="categoryList.php?type=1" title="Lebensmittel"><li class="typeList buttonSmall"><div id="food"></div><div id="food_text">Essen</div></li></a>
		
		<a href="categoryList.php?type=2" title="Getränke">
			<li class="typeList buttonSmall">
				<div id="drinks"></div><div id="drinks_text">Trinken</div>
			</li>
		</a>
		
		<a href="categoryList.php?type=3" title="Kosmetik">
			<li class="typeList buttonSmall">
				<div id="cosmetics"></div><div id="cosmetics_text">Kosmetik</div>
			</li>
		</a>
		
		<a href="barcodeScanner.php">
			<li class="typeList buttonLarge">
				<div id="barcode"></div><div id="barcode_text">Barcode-Scanner</div>
			</li>
		</a>
		
		<a href="shoppingList.php">
			<li class="typeList buttonLarge">
				<div id="shoppingcard"></div><div id="shoppingcard_text">Einkaufsliste</div>
			</li>
		</a>
		</ul>';

include 'footer.php';

?>
