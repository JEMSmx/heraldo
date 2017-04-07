<?php

/**
 * Initialization file for template files
 *
 * This file is automatically included as a result of $config->prependTemplateFile
 * option specified in your /site/config.php.
 *
 * You can initialize anything you want to here. In the case of this beginner profile,
 * we are using it just to include another file with shared functions.
 *
 */

include_once("./_func.php");


$pos = strpos($input->urlSegment, "categoria");
if($page->template == "home" && $pos===false){
	if ($page->template == "home" && $input->urlSegment) {
	  require("./{$input->urlSegment}.php");
	  exit;
	}
}


