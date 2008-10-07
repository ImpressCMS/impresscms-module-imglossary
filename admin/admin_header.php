<?php
/**
 * $Id: admin_header.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

include '../../../mainfile.php';
include '../../../include/cp_header.php';

$glossdirname = basename( dirname( dirname( __FILE__ ) ) );

// Commented this part out because I think it's not needed here (McDonald)
//if ( file_exists("../language/".$xoopsConfig['language']."/main.php") ) 
//	{
//	include "../language/".$xoopsConfig['language']."/main.php";
//	}
//else 
//	{
//	include "../language/english/main.php";
//	}

include_once ICMS_ROOT_PATH . '/modules/' . $glossdirname . '/include/functions.php';

include_once ICMS_ROOT_PATH . '/class/xoopstree.php';
include_once ICMS_ROOT_PATH . '/class/xoopslists.php';
include_once ICMS_ROOT_PATH . '/class/xoopsformloader.php';
include_once ICMS_ROOT_PATH . '/kernel/module.php';
$myts =& MyTextSanitizer::getInstance();

if ( is_object( $xoopsUser) ) {
	$xoopsModule = XoopsModule::getByDirname( $glossdirname );
	if ( !$xoopsUser -> isAdmin( $xoopsModule -> mid() ) ) {
		redirect_header( ICMS_ROOT_PATH . "/", 1, _NOPERM );
		exit();
	}
} else {
	redirect_header ( ICMS_ROOT_PATH . "/", 1, _NOPERM );
	exit();
}

?>