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

$adminmenu[0]['title'] = _MI_IMGLOSSARY_ADMENU1;
$adminmenu[0]['link']  = 'admin/index.php';
$adminmenu[0]['icon']  = 'images/icon/main.png'; // 32x32 px for options bar (tabs) 
$adminmenu[0]['small'] = 'images/icon/main_small.png'; // 16x16 px for drop down

$adminmenu[1]['title'] = _MI_IMGLOSSARY_ADMENU3;
$adminmenu[1]['link']  = 'admin/entries.php?op=newentry';
$adminmenu[1]['icon']  = 'images/icon/entry.png';
$adminmenu[1]['small'] = 'images/icon/entry_small.png';

// Display tab 'Add category' if set in Preferences
$adminmenu[2]['title'] = _MI_IMGLOSSARY_ADMENU2;
$adminmenu[2]['link']  = 'admin/cats.php';
$adminmenu[2]['icon']  = 'images/icon/folder.png';
$adminmenu[2]['small'] = 'images/icon/folder_small.png';

if ( isset( icms::$module ) ) {

	icms_loadLanguageFile( basename( dirname( dirname( __FILE__ ) ) ), 'admin' );

	$module = icms::handler( 'icms_module' ) -> getByDirname( basename( dirname( dirname( __FILE__ ) ) ), true );
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