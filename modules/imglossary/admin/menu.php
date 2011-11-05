<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: admin/menu.php
*
* @copyright	http://www.xoops.org/ The XOOPS Project
* @copyright	XOOPS_copyrights.txt
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		Wordbook - a multicategory glossary
* @since		1.16
* @author		hsalazar
* ----------------------------------------------------------------------------------------------------------
* 				imGlossary - a multicategory glossary
* @since		1.00
* @author		modified by McDonald
* @version		$Id$
*/

include_once ICMS_ROOT_PATH . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/include/functions.php';

$adminmenu[0]['title'] = _MI_IMGLOSSARY_ADMENU1;
$adminmenu[0]['link']  = "admin/index.php";
$adminmenu[0]['icon']  = 'images/icon/main.png'; // 32x32 px for options bar (tabs) 
$adminmenu[0]['small'] = 'images/icon/main_small.png'; // 16x16 px for drop down

$adminmenu[1]['title'] = _MI_IMGLOSSARY_ADMENU3;
$adminmenu[1]['link']  = "admin/entry.php";
$adminmenu[1]['icon']  = 'images/icon/entry.png';
$adminmenu[1]['small'] = 'images/icon/entry_small.png';

// Display tab 'Add category' if set in Preferences
//if ( icms::$module -> config['multicats'] ) {
	$adminmenu[2]['title'] = _MI_IMGLOSSARY_ADMENU2;
	$adminmenu[2]['link']  = "admin/category.php";
	$adminmenu[2]['icon']  = 'images/icon/folder.png';
	$adminmenu[2]['small'] = 'images/icon/folder_small.png';
//}

if ( imglossary_dictionary_module_included() ) {
	$adminmenu[3]['title'] = _MI_IMGLOSSARY_ADMENU6 . ' Dictionary';
	$adminmenu[3]['link']  = 'admin/importdictionary.php';
	$adminmenu[3]['icon']  = 'images/icon/dictionary.png';
}

if ( imglossary_wordbook_module_included() ) {
	$adminmenu[4]['title'] = _MI_IMGLOSSARY_ADMENU6 . ' Wordbook';
	$adminmenu[4]['link']  = 'admin/importwordbook.php';
	$adminmenu[4]['icon']  = 'images/icon/wordbook.png';
}

if ( imglossary_wiwimod_module_included() ) {
	$adminmenu[5]['title'] = _MI_IMGLOSSARY_ADMENU6 . ' Wiwimod';
	$adminmenu[5]['link']  = 'admin/importwiwimod.php';
	$adminmenu[5]['icon']  = 'images/icon/wiwimod.png';
}

if ( isset( icms::$module ) ) {

	icms_loadLanguageFile( basename( dirname( dirname( __FILE__ ) ) ), 'admin' );
	
	$module = icms::handler( 'icms_module' ) -> getByDirname( basename( dirname( dirname( __FILE__ ) ) ), TRUE );
	$i = -1;

	$i++;
	$headermenu[$i]['title'] = _AM_IMGLOSSARY_GOMOD;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) );

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link']  = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $module -> getVar( 'mid' );

	$i++;
	$headermenu[$i]['title'] = _AM_IMGLOSSARY_UPDATEMOD;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . basename( dirname( dirname( __FILE__ ) ) );

	$i++;
	$headermenu[$i]['title'] = _AM_IMGLOSSARY_ABOUT;
	$headermenu[$i]['link']  = ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/admin/about.php';
}
?>