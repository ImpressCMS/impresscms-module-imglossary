<?php
/**
 * $Id: header.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
 
global $xoopsModule;

include "../../mainfile.php";

$glossdirname = basename( dirname( __FILE__ ) );

include_once XOOPS_ROOT_PATH . "/modules/" . $glossdirname . "/include/functions.php";
$myts = &MyTextSanitizer::getInstance();

?>