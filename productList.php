<?php

include 'header.php';
include 'configParameter.php';
include 'functions.php';

/*
 * SQL query for the breadcumbs in the product list
 */

$type = $_GET['type'];
$categoryID = $_GET['cid'];

// sql statement for headline 
$sql = "
	SELECT nme FROM category_language	
	WHERE categoryid = ?
";

$stmt = $connect -> prepare($sql);
$stmt -> bind_param('i', $categoryID);
$stmt -> execute();
$stmt -> bind_result($product_name);
$stmt -> fetch();
$stmt -> close();

// choose the right icon for the header in the category list
switch($type){
	case 1:
		$category = 'Lebensmittel';
		$icon = 'food_green';
		break;
	case 2:
		$category = 'Getränke';
		$icon = 'drinks_green';
		break;
	case 3:
		$category = 'Kosmetik';
		$icon = 'cosmetics_green';
		break;
}

$title = '<h1><div id="'. $icon .'"></div>'. $category .' > ' . word_trim(utf8_encode($product_name), 20, 3) . '</h1>';

/*
 * SQL query to get the id, name and the valuation of the article
 */

$searchStr = preg_replace('/ |-|_|\+/', '%', '%'.$_GET['sstr'].'%');

$sql = "
	SELECT DISTINCT a.nme, ac.articleid, ac.categoryid, av.animalprotection_vclassid, av.ecologic_vclassid, av.social_vclassid
	FROM article_category ac
	INNER JOIN articleValuation av ON ac.articleid = av.articleid
	INNER JOIN article a ON a.id = av.articleid
	WHERE ac.categoryid = ?
	AND (a.nme LIKE ? OR a.keyword LIKE ? OR a.barcode LIKE ?)
	AND a.articleStatusID = ?
	ORDER BY a.nme ASC";

$stmt = $connect -> prepare($sql);
$stmt -> bind_param('issss', $categoryID, $searchStr, $searchStr, $searchStr, $articleStatus);
$stmt -> execute();
$stmt -> bind_result($articleName, $articleID, $categoryID, $animal, $eco, $social);

$content = '<ul>';

while($stmt -> fetch())
{
	// alternative with complete words
	$articleNameShown = word_trim(utf8_encode($articleName), 30, 3);
	/*if(strlen(utf8_encode($articleName)) > 30)
		$articleNameShown = substr(utf8_encode($articleName), 0, 30).' ...';
	else
		$articleNameShown = utf8_encode($articleName);
	*/
	
	// proove if criteria was set by the organisation 
	
	$sum = 0;
	$count = 0;
	
	if ($animal >= 0) {
		$sum += $animal;
		$count++;	
	}
	else {
		$animal = 0;
	}
	if ($eco >= 0) {
		$sum += $eco;	
		$count++;
	}
	else {
		$eco = 0;
	}
	if ($social >= 0) {
		$sum += $social;
		$count++;	
	}
	else {
		$social = 0;
	}
	
	// calculate the mean value
	
	if($count >= 0){
		$mean = ( $animal + $eco + $social ) / $count;
	}
	else{
		$mean = 0;
	}

	$content .= '
		<a href="productDetail.php?aid='.$articleID.'" id="'.utf8_encode($articleName).'" title="'.utf8_encode($articleName).'">
			<li id="productListNavigation">'.$articleNameShown.'
				<div class="arrowRight"></div>';

				// green
				if(0 < $mean && $mean <= 1.5){
					$content .= '<div class="circle green"></div>';
				}
				//orange
				else if(1.5 < $mean && $mean <= 2.4){
					$content .= '<div class="circle orange"></div>';
				}
				//red
				else if(2.4 < $mean){
					$content .= '<div class="circle red"></div>';
				}
				
			$content .= '</li>
		</a>';
}

$content .= '</ul>';

$stmt -> close();


include 'footer.php';

?>
