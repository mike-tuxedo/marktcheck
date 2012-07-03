<?php

// show not working back-button at homescreen
if(preg_match('/.php/i', $_SERVER['REQUEST_URI']))
    $navigationHeader = '<ul><li id="back"><a id="link_back" href="javascript:history.back()"><img src="images/back.png" alt="back" /></a></li>';
else
    $navigationHeader = '<ul><li id="back"><img src="images/back_inactive.png" alt="back" /></li>';

$navigationHeader .= '
                <li><a href="./"><img id="logo" src="images/logo.png" /></a></li>
                <li class="showSettings"><img src="images/settings.png" /></li>
                </ul>';

##############
# Templatesystem
##############
include("function/template.php");

$template = new template("layout.html");

$template->readtemplate();

$template->replace("NAVIGATION_HEADER", $navigationHeader);
$template->replace("TITLE", $title);
$template->replace("CONTENT", $content);
$template->replace("SEARCHFIELD", $searchField);
$template->replace("GREETING", $greeting);

##############
# Publizieren
##############
$template->parse();

?>
