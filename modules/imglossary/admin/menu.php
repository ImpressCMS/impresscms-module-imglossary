<?php
/**
 * $Id: menu.php
 * Module: imGlossary - a multicategory glossary 
 * Author: McDonald
 * Licence: GNU
 */
 
$glossdirname = basename( dirname( dirname( __FILE__ ) ) );

include_once ICMS_ROOT_PATH . '/modules/' . $glossdirname . '/include/functions.php';

$adminmenu[0]['title'] = _MI_IMGLOSSARY_ADMENU1;
$adminmenu[0]['link']  = "admin/index.php";
$adminmenu[1]['title'] = _MI_IMGLOSSARY_ADMENU3;
$adminmenu[1]['link']  = "admin/entry.php";
$adminmenu[2]['title'] = _MI_IMGLOSSARY_ADMENU2;
$adminmenu[2]['link']  = "admin/category.php";
$adminmenu[3]['title'] = _MI_IMGLOSSARY_ADMENU4;
$adminmenu[3]['link']  = "admin/myblocksadmin.php";

if ( imglossary_dictionary_module_included() ) {
	$adminmenu[4]['title'] = _MI_IMGLOSSARY_ADMENU6 . ' Dictionary';
	$adminmenu[4]['link']  = "admin/importdictionary.php";
}

if ( imglossary_wordbook_module_included() ) {
	$adminmenu[5]['title'] = _MI_IMGLOSSARY_ADMENU6 . ' Wordbook';
	$adminmenu[5]['link']  = "admin/importwordbook.php";
}

global $xoopsModule;

if ( isset( $xoopsModule ) ) {

	$i = -1;

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link']  = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule -> getVar( 'mid' );

	$i++;
	$headermenu[$i]['title'] = _AM_IMGLOSSARY_GOMOD;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/' . $xoopsModule -> getVar( 'dirname' );

	$i++;
	$headermenu[$i]['title'] = _AM_IMGLOSSARY_UPDATEMOD;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $xoopsModule->getVar('dirname');

	$i++;
	$headermenu[$i]['title'] = _AM_IMGLOSSARY_ABOUT;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/' . $xoopsModule -> getVar( 'dirname' ) . '/admin/about.php';
}

?>