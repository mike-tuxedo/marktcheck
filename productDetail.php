<?php

include 'header.php';
include 'configParameter.php';
include 'checkGETParams.php';
include 'functions.php';

$articleID = $_GET['aid'];

// valuations of this product
$sql = "SELECT 
			vlAnimal.valuationclassid, vlAnimal.nme, vlAnimal.description, 
			vlEco.valuationclassid, vlEco.nme, vlEco.description, 
			vlSocial.valuationclassid, vlSocial.nme, vlSocial.description
		FROM articleValuation av
			LEFT JOIN valuationclass_language vlAnimal ON av.animalprotection_vclassid = vlAnimal.valuationclassid
			LEFT JOIN valuationclass_language vlEco ON av.ecologic_vclassid = vlEco.valuationclassid
			LEFT JOIN valuationclass_language vlSocial ON av.social_vclassid = vlSocial.valuationclassid
		WHERE av.articleid = ?";

$stmt = $connect -> prepare($sql);
$stmt -> bind_param('i', $articleID);
$stmt -> execute();
$stmt -> bind_result($valuationID['animal'], $valuationName['animal'], $valuationDescription['animal'], $valuationID['eco'], $valuationName['eco'], $valuationDescription['eco'], $valuationID['social'], $valuationName['social'], $valuationDescription['social']);
$stmt -> fetch();
$stmt -> close();

$sql = "SELECT 
			a.nme, a.brand, a.pricefrom, a.substancedeclaredtxt, 
			ast.gpSort, 
			c.nme, c.infoGMO, cl.nme, cl.note_public
		FROM 
			articleStatus ast, 
			company c, 
			article a
		LEFT JOIN company cl ON a.producerid = cl.id
		WHERE 
			a.id = ? 
			AND a.articleStatusID = ast.statusID 
			AND a.salescompanyid = c.id";

$stmt = $connect -> prepare($sql);
$stmt -> bind_param('i', $articleID);
$stmt -> execute();
$stmt -> bind_result($articleName, $articleBrand, $articlePrice, $articleSubstance, $articleStatus, $companyName, $companyInfoGMO, $manufacturerName, $manufacturerNote);
$stmt -> fetch();
$stmt -> close();

$content .= '
<div id="productDetail">
	
	<h1>'.word_trim(utf8_encode($articleName), 40, 4).'</h1>
	
	<div id="productDetailHeader">
		<div class="highlight_green">Wertung:</div>
			<a href="addRemoveProduct.php?product='.$articleName.'&action=add"><div id="addToCart"></div></a>';
			
			// price of the product
			if(!empty($articlePrice))
				$content .= '<p id="price">ab '.$articlePrice.' EUR</p>';	
			
			$ratingID = array('animal', 'eco', 'social');
			$i = 0;
			
			// calculate valuation of each class
			foreach($valuationID as $key => $value)
			{
				if($value > 0){
					$content .= '
						<div class="ratingContainer">'.$valuationNameCategory[$key].'
						<div class="ratings">';
						
							// green
							if(0 < $value && $value <= 1.5){
								$content .= '<div class="ratingIcons" 
								id="'. $ratingID[$i] .'_green"></div>';
							}
							//orange
							else if(1.5 < $value && $value <= 2.4){
								$content .= '<div class="ratingIcons" 
								id="'. $ratingID[$i] .'_orange"></div>';
							}
							//red
							else if(2.4 < $value){
								$content .= '<div class="ratingIcons" 
								id="'. $ratingID[$i] .'_red"></div>';
							}
					
					$content .= '
						</div>
					</div>';
				}
				$i++;
			}
			
if(!empty($brand))
	$content .= '<p id="brand">Marke: '.utf8_encode($brand).'</p>';

$content .= '
	</div>
</div>
<div id="productDetailNavigation">
	<a href="#">Bewertungen</a>
	<span>';
	
	foreach($valuationName as $key => $value)
	{
		$content .= '<p class="valuationCategory">'.ucfirst($key).'</p>';
		
		if($valuationID[$key] > 0)
			$content .= $valuationNameArray[utf8_encode($value)].
						'<p class="valuationDescription">'.utf8_encode($valuationDescription[$key]).'</p>';
		else 
			$content .= '<p class="valuationNotFound">keine Bewertung</p>';			
	}
	
	$content .= '</span>';
	
	if(!empty($manufacturerName))
	{
		$content .= '
			<a href="#">Hersteller</a>
			<span>
				<p class="valuationCategory">'.utf8_encode($manufacturerName).'</p>';
		
		if(!empty($manufacturerNote))		
			$content .= '<p class="toCenter">'.utf8_encode($manufacturerNote).'</p>';
		else	
			$content .= '<p class="toCenter">Es sind uns keine weiteren Informationen zu diesem Hersteller bekannt.</p>';
			
		$content .= '</span>';	
	}
	
	if(!empty($articleSubstance))
		$content .= '
			<a href="#">Inhaltsstoffe</a>
			<span>
				<p class="toCenter">'.utf8_encode($articleSubstance).'</p>
			</span>';	
	
	if(!empty($articleSubstance))
	{
		$content .= '
			<a href="#">Vertreiber</a>
			<span>
				<p class="valuationCategory">'.utf8_encode($companyName).'</p>';
				
		if(!empty($companyInfoGMO))	
			$content .= '<p class="toCenter"><strong>InfoGMO</strong><br /> '.utf8_encode($companyInfoGMO).'</p>';
		else 
			$content .= '<p class="toCenter">Es sind uns keine weiteren Informationen zu diesem Vertreiber bekannt.</p>';
			
		$content .= '</span>';
	}	
	
$content .= '</div>	';

include 'footer.php';

?>
