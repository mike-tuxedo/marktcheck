<?php

include 'header.php';
include 'configParameter.php';

$title = "<h1>Produktliste</h1>";

$categoryID = $_GET['cid'];
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
