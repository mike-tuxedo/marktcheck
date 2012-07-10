<?php 

/*
 *	Put all functions which are used in the application in this file
 */

// trim words to a given word count when a certain length is reached
function word_trim($string, $limit, $count, $ellipsis = TRUE){
	
	// sometimes words are connected with a plus which is filtered here 
	// because it is not seen as a word
	if(preg_match('/\+/', $string)){
		$count++;
	}
	
  if(strlen($string) >= $limit){
 		$words = explode(' ', $string);
	  if (count($words) > $count){
	  	//echo "true";
	    array_splice($words, $count);
	    $string = implode(' ', $words);
	    if (is_string($ellipsis)){
	      $string .= $ellipsis;
	    }
	    elseif ($ellipsis){
	      $string .= ' &hellip;';
	    }
	  }
	}
	return $string;
}

?>