<?php
include 'header.php';
include 'configParameter.php';

$title = "<h1>Suchergebnis</h1>";

$orgSearchStr = $_GET['searchStr'];
$searchStr = preg_replace('/ |-|_|\+/', '%', '%'.$orgSearchStr.'%');

//Suche nach "Baby Knabberei" ergibt kein Ergebnis, da beides in kombination, nicht in einem Produkt oder einer Kategorie vorkommt.
$sql = "SELECT DISTINCT cl.nme, cl.categoryid
		FROM article_category ac, article a, category_language cl
		WHERE (a.nme LIKE ? OR cl.nme LIKE ? OR a.barcode LIKE ?)
			AND ac.articleid = a.id
			AND ac.categoryid = cl.categoryid
		ORDER BY cl.nme ASC";

$stmt = $connect -> prepare($sql);
$stmt -> bind_param('sss', $searchStr, $searchStr, $searchStr);
$stmt -> execute();
$stmt -> bind_result($categoryName, $categoryID);

$cntResults = 0;

$content .= '<ul>';

while($stmt -> fetch())
{
	$cntResults++;
	
	//if the searchstring is in the current category, then take all product from this category
	if(preg_match('/'.$orgSearchStr.'/i', $categoryName) > 0)
	{
		$sql2 = "	SELECT COUNT(*) 
					FROM article_category ac
				 	WHERE ac.categoryid = ?";

		$stmt2 = $connect2 -> prepare($sql2);
		$stmt2 -> bind_param('i', $categoryID);
	}
	else
	{
		$sql2 = "	SELECT COUNT(*) 
					FROM article_category ac, article a
				 	WHERE (a.nme LIKE ? OR a.keyword LIKE ? OR a.barcode LIKE ?)
				 		AND ac.categoryid = ?
				 		AND a.id = ac.articleid
				 		AND a.articleStatusID = ?";

		$stmt2 = $connect2 -> prepare($sql2);
		$stmt2 -> bind_param('sssis', $searchStr, $searchStr, $searchStr, $categoryID, $articleStatus);
	}

	$stmt2 -> execute();
	$stmt2 -> bind_result($numberOfArticles);
	$stmt2 -> fetch();
	$stmt2 -> close();
	
	if($numberOfArticles > 0)
		$content .= '<li class="searchResultListNavigation">
						<a href="productList.php?cid='.$categoryID.'&sstr='.$orgSearchStr.'">'.utf8_encode($categoryName).' ('.$numberOfArticles.')</a>
					</li>';
}

if($content == '<ul>')
	$content .= 'Kein Ergebnis für diese Suchanfrage gefunden</ul>';
	
else if($cntResults > 10)
	$content .= '</div><li class="searchResultListNavigationLast" id="showMoreResults">zeige mehr</li></ul>';

else
	$content .= '</ul>';

$stmt -> close();

include 'footer.php';

?>
