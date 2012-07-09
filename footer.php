<?php

// show not working back-button at homescreen
if(preg_match('/.php/i', $_SERVER['REQUEST_URI']))
    $navigationHeader = '<ul><li id="back"><a id="link_back" href="javascript:history.back()"><div id="back_active"></div></a></li>';
else
    $navigationHeader = '<ul><li><div id="back_inactive"></div></li>';

$navigationHeader .= '
                <li><a href="./"><img id="logo"/></a></li>
                <li class="showSettings"><div id="settingsButton"></div></li>
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
