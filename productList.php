<?php

include 'header.php';
include 'configParameter.php';
include 'functions.php';

/*
 * SQL query for the breadcumbs in the product list
 */

$type = $_GET['type'];
$categoryID = $_GET['cid'];

/* sql statement for headline */ 
$sql_breadcumb = "
	SELECT nme FROM category_language	
	WHERE categoryid = ?
";

/* execute sql statement */
$stmt_breadcumb = $connect -> prepare($sql_breadcumb);
$stmt_breadcumb -> bind_param('i', $categoryID);
$stmt_breadcumb -> execute();
$stmt_breadcumb -> bind_result($product_name);

// choose the right icon for the header in the category list
switch($type){
	case 1:
		$icon = 'food_green';
		break;
	case 2:
		$icon = 'drinks_green';
		break;
	case 3:
		$icon = 'cosmetics_green';
		break;
}

while($stmt_breadcumb -> fetch()){
	$title = '<h1><div id="'. $icon .'"></div>Lebensmittel > ' . word_trim(utf8_encode($product_name), 35, 2) . '</h1>';
}

$searchStr = preg_replace('/ |-|_|\+/', '%', '%'.$_GET['sstr'].'%');

$sql = "SELECT DISTINCT a.id, a.nme FROM article_category ac, article a, articleType at
		WHERE ac.categoryid = ?
			AND (a.nme LIKE ? OR a.keyword LIKE ? OR a.barcode LIKE ?)
			AND ac.articleid = a.id
			AND a.articleStatusID = ?
		ORDER BY at.nme ASC, a.nme ASC";

$stmt = $connect -> prepare($sql);
$stmt -> bind_param('issss', $categoryID, $searchStr, $searchStr, $searchStr, $articleStatus);
$stmt -> execute();
$stmt -> bind_result($articleID, $articleName);

$content = '<ul>';

while($stmt -> fetch())
{
	if(strlen(utf8_encode($articleName)) > 38)
		$articleNameShown = substr(utf8_encode($articleName), 0, 38).' ...';
	else
		$articleNameShown = utf8_encode($articleName);

	$content .= '
		<li id="productListNavigation">
			<a href="productDetail.php?aid='.$articleID.'" id="'.utf8_encode($articleName).'" title="'.utf8_encode($articleName).'">'.$articleNameShown.'</a>
		</li>';
}

$content .= '</ul>';

$stmt -> close();

include 'footer.php';

?>
