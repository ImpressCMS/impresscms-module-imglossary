<?php
/**
 * $Id: menu.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Soapbox
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

 $glossdirname = basename( dirname( dirname( __FILE__ ) ) );

include_once ICMS_ROOT_PATH . '/modules/' . $glossdirname . '/include/functions.php';
$adminmenu[0]['title'] = _MI_IMGLOSSARY_ADMENU1;
$adminmenu[0]['link'] = "admin/index.php";
$adminmenu[1]['title'] = _MI_IMGLOSSARY_ADMENU3;
$adminmenu[1]['link'] = "admin/entry.php";
$adminmenu[2]['title'] = _MI_IMGLOSSARY_ADMENU2;
$adminmenu[2]['link'] = "admin/category.php";
$adminmenu[3]['title'] = _MI_IMGLOSSARY_ADMENU4;
$adminmenu[3]['link'] = "admin/myblocksadmin.php";
$adminmenu[4]['title'] = _MI_IMGLOSSARY_ADMENU5;
$adminmenu[4]['link'] = "index.php";

if (imglossary_dictionary_module_included()) {
	$adminmenu[5]['title'] = _MI_IMGLOSSARY_ADMENU6 . ' Dictionary';
	$adminmenu[5]['link'] = "admin/importdictionary.php";
}

if (imglossary_wordbook_module_included()) {
	$adminmenu[6]['title'] = _MI_IMGLOSSARY_ADMENU6 . ' Wordbook';
	$adminmenu[6]['link'] = "admin/importwordbook.php";
}

global $xoopsModule;
if ( isset( $xoopsModule ) ) {

	$i = -1;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule -> getVar( 'mid' );

	$i++;
	$headermenu[$i]['title'] = _AM_IMGLOSSARY_GOMOD;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $xoopsModule -> getVar( 'dirname' );

	$i++;
	$headermenu[$i]['title'] = _AM_IMGLOSSARY_UPDATEMOD;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $xoopsModule->getVar('dirname');

	$i++;
	$headermenu[$i]['title'] = _AM_IMGLOSSARY_ABOUT;
	$headermenu[$i]['link'] = ICMS_URL . '/modules/' . $xoopsModule -> getVar( 'dirname' ) . '/admin/about.php';
}

?>