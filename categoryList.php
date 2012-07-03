<?php

include 'header.php';
include 'configParameter.php';
include 'checkGETParams.php';

$type = $_GET['type'];

// show articleType - ex. Lebensmittel
$sql = "SELECT nme FROM articleType WHERE id = ?";
$stmt = $connect -> prepare($sql);
$stmt -> bind_param('i', $type);
$stmt -> execute();
$stmt -> bind_result($articleType);
$stmt -> fetch();
$stmt -> close();

$title = '<h1>'.utf8_encode($articleType).'</h1>';

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
            <li id="categoryListNavigation">
                <a href="productList.php?cid='.$categoryID.'" title="'.utf8_encode($categoryName).'">'.utf8_encode($categoryName).' <span id="productCount"> ('.$numberOfArticles.')</span></a>
            </li>';
}

$content .= '</ul>';

$stmt -> close();

include 'footer.php';

?>
