<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: icms_version.php
*
* @copyright	http://www.xoops.org/ The XOOPS Project
* @copyright	XOOPS_copyrights.txt
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ---------------------------------------------------------------
* @package		Wordbook - a multicategory glossary
* @since		1.16
* @author		hsalazar
* ---------------------------------------------------------------
* 				imGlossary - a multicategory glossary
* @since		1.00
* @author		modified by McDonald
* @version		$Id$
*/

if ( !defined( 'ICMS_ROOT_PATH' ) ) die( 'ICMS root path not defined' );

global $icmsConfig;

if ( file_exists( ICMS_ROOT_PATH . '/modules/' . basename( dirname( __FILE__ ) ) . '/language/'. $icmsConfig['language'] . '/moduleabout.php' ) ) {
	include_once ICMS_ROOT_PATH . '/modules/' . basename( dirname( __FILE__ ) ) . '/language/'. $icmsConfig['language'] . '/moduleabout.php';
} else { include_once ICMS_ROOT_PATH . '/modules/' . basename( dirname( __FILE__ ) ) . '/language/english/moduleabout.php'; }

// ** General information
$modversion = array(
	'name'				=> _MI_IMGLOSSARY_MD_NAME,
	'version'			=> 1.04,
	'status'			=> 'Trunk',
	'status_version'	=> 'Trunk',
	'date'				=> 'xx xxxxxx 201x',

	'description'		=> _MI_IMGLOSSARY_MD_DESC,
	'author'			=> 'McDonald',
	'credits'			=> 'hsalazar (author of Wordbook), Dario Garcia (additions to Wordbook), Catzwolf',
	'license'			=> 'GNU General Public License (GPL)',
	'image'				=> 'images/imglossary_logo.png',
	'iconbig'			=> 'images/imglossary_iconsbig.png',
	'iconsmall'			=> 'images/imglossary_iconsmall.png',
	'dirname'			=> basename( dirname( __FILE__ ) ),
	'modname'			=> 'imglossary'
);

// ** Contributors **
$modversion['people']['developers'] [] = '<a href="http://community.impresscms.org/userinfo.php?uid=179" target="_blank">McDonald</a>&nbsp;&nbsp;<span style="font-size: smaller;">( pietjebell31 [at] hotmail [dot] com )</span>';

$modversion['people']['testers'][] = '&middot; <a href="http://community.impresscms.org/userinfo.php?uid=14" target="_blank">GibaPhp</a>';
$modversion['people']['testers'][] = '&middot; <a href="http://community.impresscms.org/userinfo.php?uid=480" target="_blank">algalochkin</a>';

$modversion['people']['translators'][] = '&middot; <a href="http://community.impresscms.org/userinfo.php?uid=480" target="_blank">algalochkin</a> (Russian)';
$modversion['people']['translators'][] = '&middot; <a href="http://community.impresscms.org/userinfo.php?uid=97" target="_blank">debianus</a> (Spanish)';
$modversion['people']['translators'][] = '&middot; <a href="http://community.impresscms.org/userinfo.php?uid=14" target="_blank">GibaPhp</a> (Portuguese-Brazil)';
$modversion['people']['translators'][] = '&middot; <a href="http://community.impresscms.org/userinfo.php?uid=179" target="_blank">McDonald</a> (Dutch)';
$modversion['people']['translators'][] = '&middot; <a href="http://community.impresscms.org/userinfo.php?uid=10" target="_blank">sato-san</a> (German)';
$modversion['people']['translators'][] = '&middot; <a href="http://community.impresscms.org/userinfo.php?uid=392" target="_blank">stranger</a> (Persian)';
$modversion['people']['translators'][] = '&middot; <a href="http://community.impresscms.org/userinfo.php?uid=371" target="_blank">wuddel</a> (German)';

$modversion['people']['other'][] = '&middot; <a href="http://www.famfamfam.com" target="_blank">famfamfam</a> (icons)';
$modversion['people']['other'][] = '&middot; <a href="http://materia.infinitiv.it" target="_blank">Materia</a> (icons)';

// ** If Release Candidate **
 $modversion['warning'] = _MODABOUT_IMGLOSSARY_WARNING_RC;

// ** If Final  **
// $modversion['warning'] = _MODABOUT_IMGLOSSARY_WARNING_FINAL;

// ** Admin things **
$modversion['hasAdmin']		= 1;
$modversion['adminindex']	= 'admin/index.php';
$modversion['adminmenu']	= 'admin/menu.php';

$modversion['onInstall']	= 'include/onupdate.inc.php';
$modversion['onUpdate']		= 'include/updatedb.php';

// Tables created by sql file (without prefix!)
$modversion['object_items'][1] = 'cats';
$modversion['object_items'][2] = 'entries';

$modversion['tables'] = icms_getTablesArray( $modversion['dirname'], $modversion['object_items'] );

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'imglossary_search';

// Menu
$modversion['hasMain'] = 1;
$hModConfig = icms::$config;
$hModule = icms::handler( 'icms_module' );
if ( $imglossaryModule =& $hModule -> getByDirname( basename( dirname( __FILE__ ) ) ) ) {
	$imglossaryConfig =& $hModConfig -> getConfigsByCat( 0, $imglossaryModule -> getVar( 'mid' ) );
	if ( ( icms::$user && ( $imglossaryConfig['allowsubmit'] == 1 ) ) || ( $imglossaryConfig['anonpost'] == 1 ) ) {
		$modversion['sub'][1]['name']	= _MI_IMGLOSSARY_SUB_SMNAME1;
		$modversion['sub'][1]['url']	= 'submit.php';
	}
}

$modversion['sub'][2]['name']	= _MI_IMGLOSSARY_SUB_SMNAME2;
$modversion['sub'][2]['url']	= 'request.php';
$modversion['sub'][3]['name']	= _MI_IMGLOSSARY_SUB_SMNAME3;
$modversion['sub'][3]['url']	= 'search.php';

if (!$imglossaryModule =& $hModule -> getByDirname( basename( dirname( __FILE__ ) ) ) == false ) {
	$MyModIsActive = $imglossaryModule -> getVar( 'isactive' ); //tested if installed and active
} else {
	$MyModIsActive = '0'; //not installed
}

if ($MyModIsActive == '1') {
	$sql = icms::$xoopsDB -> query( 'SELECT categoryid, name FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . '' );
	$i = 4;
	$hModConfig = icms::$config;
	$hModule = icms::handler( 'icms_module' );
	if ($imglossaryModule =& $hModule -> getByDirname( basename( dirname( __FILE__ ) ) ) ) {
		$imglossaryConfig =& $hModConfig -> getConfigsByCat( 0, $imglossaryModule -> getVar( 'mid' ) );
		if ( isset( $imglossaryConfig['catsinmenu'] ) && $imglossaryConfig['catsinmenu'] == 1 )	{
			while ( list( $categoryid, $name ) = icms::$xoopsDB -> fetchRow( $sql ) ) {
				$modversion['sub'][$i]['name'] = $name;
				$modversion['sub'][$i]['url'] = 'category.php?categoryid=' . $categoryID;
				$i++;
			} 
		}
	}
}

// Blocks
$modversion['blocks'][1]['file'] = 'entries_new.php';
$modversion['blocks'][1]['name'] = _MI_IMGLOSSARY_ENTRIESNEW;
$modversion['blocks'][1]['description'] = 'Shows new entries';
$modversion['blocks'][1]['show_func'] = 'b_entries_new_show';
$modversion['blocks'][1]['edit_func'] = 'b_entries_new_edit';
$modversion['blocks'][1]['options'] = 'datesub|5|d F Y';
$modversion['blocks'][1]['template'] = 'imglossary_entries_new.html';

$modversion['blocks'][2]['file'] = 'entries_top.php';
$modversion['blocks'][2]['name'] = _MI_IMGLOSSARY_ENTRIESTOP;
$modversion['blocks'][2]['description'] = 'Shows popular entries';
$modversion['blocks'][2]['show_func'] = 'b_entries_top_show';
$modversion['blocks'][2]['edit_func'] = 'b_entries_top_edit';
$modversion['blocks'][2]['options'] = 'counter|5';
$modversion['blocks'][2]['template'] = 'imglossary_entries_top.html';

$modversion['blocks'][3]['file'] = 'random_term.php';
$modversion['blocks'][3]['name'] = _MI_IMGLOSSARY_RANDOMTERM;
$modversion['blocks'][3]['description'] = 'Shows a random term';
$modversion['blocks'][3]['show_func'] = 'b_entries_random_show';
$modversion['blocks'][3]['template'] = 'imglossary_entries_random.html';

// Templates
$modversion['templates'][1]['file']			= 'imglossary_category.html';
$modversion['templates'][1]['description']	= 'Display categories';

$modversion['templates'][2]['file']			= 'imglossary_index.html';
$modversion['templates'][2]['description']	= 'Display index';

$modversion['templates'][3]['file']			= 'imglossary_entry.html';
$modversion['templates'][3]['description']	= 'Display entry';

$modversion['templates'][4]['file']			= 'imglossary_letter.html';
$modversion['templates'][4]['description']	= 'Display letter';

$modversion['templates'][5]['file']			= 'imglossary_search.html';
$modversion['templates'][5]['description']	= 'Search in glossary';

$modversion['templates'][6]['file']			= 'imglossary_rss.html';
$modversion['templates'][6]['description']	= 'RSS feed';

$modversion['templates'][7]['file']			= 'imglossary_moduleabout.html';
$modversion['templates'][7]['description']	= 'Module about';

$modversion['templates'][8]['file']			= 'imglossary_admin_index.html';
$modversion['templates'][8]['description']	= 'Admin index';

// Config Settings (only for modules that need config settings generated automatically)
$i = 0;
$i++;
$modversion['config'][$i]['name'] = 'showcenter';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_SHOWCENTER';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_SHOWCENTERDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'showrandom';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_SHOWRANDOM';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_SHOWRANDOMDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'allowsubmit';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_ALLOWSUBMIT';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_ALLOWSUBMITDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'anonpost';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_ANONSUBMIT';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_ANONSUBMITDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'captcha';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_CAPTCHA';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_CAPTCHADSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'form_options';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_EDITORADMIN';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_EDITORADMINDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'tinymce';
$modversion['config'][$i]['options'] =  array(	_MI_IMGLOSSARY_FORM_FCK => 'fck',
												_MI_IMGLOSSARY_FORM_TINYEDITOR => 'tinyeditor',
												_MI_IMGLOSSARY_FORM_TINYMCE => 'tinymce' );
$i++;
$modversion['config'][$i]['name'] = 'form_optionsuser';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_EDITORUSER';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_EDITORUSERDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'tinymce';
$modversion['config'][$i]['options'] =  array(	_MI_IMGLOSSARY_FORM_FCK => 'fck',
												_MI_IMGLOSSARY_FORM_TINYEDITOR => 'tinyeditor',
												_MI_IMGLOSSARY_FORM_TINYMCE => 'tinymce' );
$i++;
$modversion['config'][$i]['name'] = 'dateformat';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_DATEFORMAT';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_DATEFORMATDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'd-M-Y H:i';
$i++;
$modversion['config'][$i]['name'] = 'perpage';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_PERPAGE';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_PERPAGEDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = array( '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50 );
$i++;
$modversion['config'][$i]['name'] = 'indexperpage';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_PERPAGEINDEX';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_PERPAGEINDEXDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = array( '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50 );
$i++;
$modversion['config'][$i]['name'] = 'autoapprove';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_AUTOAPPROVE';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_AUTOAPPROVEDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'multicats';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_MULTICATS';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_MULTICATSDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'catsinmenu';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_CATSINMENU';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_CATSINMENUDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'sortcats';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_SORTCATS';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_SORTCATSDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'name';
$modversion['config'][$i]['options'] = array(	'_MI_IMGLOSSARY_TITLE' => 'name', '_MI_IMGLOSSARY_WEIGHT' => 'weight' );
$i++;
$modversion['config'][$i]['name'] = 'adminhits';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_ALLOWADMINHITS';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_ALLOWADMINHITSDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'mailtoadmin';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_MAILTOADMIN';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_MAILTOADMINDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'rndlength';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_RANDOMLENGTH';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_RANDOMLENGTHDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 500;
$i++;
$modversion['config'][$i]['name'] = 'linkterms';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_LINKTERMS';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_LINKTERMSDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'showsubmitter';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_SHOWSUBMITTER';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_SHOWSUBMITTERDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'showsbookmarks';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_SHOWSBOOKMARKS';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_SHOWSBOOKMARKSDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'searchcolor';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_SEARCHCOLOR';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_SEARCHCOLORDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '#FFFF00';
$i++;
$modversion['config'][$i]['name'] = 'rssfeed';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_SELECTFEED';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_SELECTFEED_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'rssfeedtotal';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_FEEDSTOTAL';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_FEEDSTOTALDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '15';
$i = 0;

//Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'entryID';
$modversion['comments']['pageName'] = 'entry.php';

$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'imglossary_com_approve';
$modversion['comments']['callback']['update'] = 'imglossary_com_update';
?>