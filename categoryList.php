<?php

include 'header.php';
include 'configParameter.php';
include 'checkGETParams.php';
include 'functions.php';

$type = $_GET['type'];

// show articleType - ex. Lebensmittel
$sql = "SELECT nme FROM articleType WHERE id = ?";
$stmt = $connect -> prepare($sql);
$stmt -> bind_param('i', $type);
$stmt -> execute();
$stmt -> bind_result($articleType);
$stmt -> fetch();
$stmt -> close();

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

$title = '<h1><div id="'. $icon .'"></div>'.utf8_encode($articleType).'</h1>';

// show all categories in this articletype
$sql = "SELECT DISTINCT
            cl.categoryid, cl.nme
        FROM
            article a,
            category_language cl,
            article_category ac
        WHERE
            a.articletypeID = ?
            AND a.id = ac.articleid
            AND ac.categoryid = cl.categoryid
        ORDER BY cl.nme ASC";

$stmt = $connect -> prepare($sql);
$stmt -> bind_param('i', $type);
$stmt -> execute();
$stmt -> bind_result($categoryID, $categoryName);

$content = '<ul>';

while($stmt -> fetch())
{
    // show number of articles in this category
    $stmt2 = $connect2 -> query("SELECT a.nme
                                 FROM
                                    article_category ac,
                                    article a
                                 WHERE
                                    categoryid = $categoryID
                                    AND a.id = ac.articleid
                                    AND a.articleStatusID = '".$articleStatus."'");

    $numberOfArticles = $stmt2 -> num_rows;
    $stmt2 -> close();

    if($numberOfArticles > 0)
        $content .= '
            <a href="productList.php?type='.$type.'&cid='.$categoryID.'" title="'.utf8_encode($categoryName).'"> 
            	<li id="categoryListNavigation">'.word_trim(utf8_encode($categoryName), 35, 2).'<div id="arrowRight"></div><span id="productCount"> ('.$numberOfArticles.')</span></li>
            </a>';
}

$content .= '</ul>';

$stmt -> close();

include 'footer.php';

?>
