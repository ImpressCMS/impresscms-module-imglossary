<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: entry.php
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

include 'header.php';

include_once ICMS_ROOT_PATH . '/class/module.textsanitizer.php'; 
include_once ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/include/sbookmarks.php';

global $xoTheme; 

$entryID = isset($_GET['entryID']) ? intval($_GET['entryID']) : 0;
$entryID = intval( $entryID );

$xoopsOption['template_main'] = 'imglossary_entry.html';
include ICMS_ROOT_PATH . '/header.php';

if ( icms::$module -> config['multicats'] == 1 ) {
	$xoopsTpl -> assign( 'multicats', 1 );
} else {
	$xoopsTpl -> assign( 'multicats', 0 );
}

// If there's no entries yet in the system...
$pubwords = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND offline=0' );
$publishedwords = icms::$xoopsDB -> getRowsNum ( $pubwords );
$xoopsTpl -> assign( 'publishedwords', $publishedwords );
if ( $publishedwords == 0 )	{
	$xoopsTpl -> assign ( 'empty', '1' );
	$xoopsTpl -> assign ( 'stillnothing', _MD_IMGLOSSARY_STILLNOTHINGHERE );
}

// To display the linked letter list
$alpha = imglossary_alphaArray();
$xoopsTpl -> assign( 'alpha', $alpha );

$sql = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE init=1' );
$howmanyother = icms::$xoopsDB -> getRowsNum( $sql );
$xoopsTpl -> assign( 'totalother', $howmanyother );

if ( icms::$module -> config['multicats'] == 1 ) {
	// To display the list of categories
	$block0 = array();
	$resultcat = icms::$xoopsDB -> query( 'SELECT categoryID, name, total FROM ' . icms::$xoopsDB -> prefix ( 'imglossary_cats' ) . ' ORDER BY name ASC' );
	while ( list( $catID, $name, $total ) = icms::$xoopsDB -> fetchRow( $resultcat ) ) {
		$catlinks = array();
		$imglossModule = icms::$module -> getVar( 'dirname' );
		$catlinks['id'] = $catID;
		$catlinks['total'] = intval( $total );
		$catlinks['linktext'] = icms_core_DataFilter::htmlSpecialchars( $name );
		$block0['categories'][] = $catlinks;
	}
	$xoopsTpl -> assign( 'block0', $block0 );
}

if ( !$entryID ) {
	$result = icms::$xoopsDB -> query( 'SELECT entryID, categoryID, term, init, definition, ref, url, uid, submit, datesub, counter, html, smiley, xcodes, breaks, block, offline, notifypub FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE datesub<' . time() . ' AND datesub>0 AND (submit=0) ORDER BY datesub DESC', 1, 0 );
} else {
	if ( !icms::$user || ( icms::$user -> isAdmin( icms::$module -> getVar('mid') ) && icms::$module -> config['adminhits'] == 1 ) || ( icms::$user && !icms::$user -> isAdmin( icms::$module -> getVar('mid') ) ) ) {
		icms::$xoopsDB -> queryF( 'UPDATE ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' SET counter=counter+1 WHERE entryID=' . $entryID );
	}

	$result = icms::$xoopsDB -> query( 'SELECT entryID, categoryID, term, init, definition, ref, url, uid, submit, datesub, counter, html, smiley, xcodes, breaks, block, offline, notifypub FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE entryID=' . $entryID );
	}

while ( list( $entryID, $categoryID, $term, $init, $definition, $ref, $url, $uid, $submit, $datesub, $counter, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub ) = icms::$xoopsDB -> fetchRow( $result ) ) {
	$thisterm = array();
	// $imglossModule = icms::$module -> getVar( 'dirname' );
	$thisterm['id'] = intval( $entryID );

	if ( icms::$module -> config['multicats'] == 1 ) {
		$thisterm['categoryID'] = intval( $categoryID );
		$catname = icms::$xoopsDB -> query ( 'SELECT name FROM ' . icms::$xoopsDB -> prefix ( 'imglossary_cats' ) . ' WHERE categoryID=' . $categoryID );
		while ( list( $name ) = icms::$xoopsDB -> fetchRow ( $catname ) ) {
			$thisterm['catname'] = icms_core_DataFilter::htmlSpecialchars( $name );
		}
	}

	$glossaryterm = icms_core_DataFilter::htmlSpecialchars( $term );
	$thisterm['term'] = icms_core_DataFilter::htmlSpecialchars( $term );
	if ( $init == 1 ) {
		$thisterm['init'] = _MD_IMGLOSSARY_OTHER;
	} else {
		$thisterm['init'] = $init;
	}

	if ( icms::$module -> config['linkterms'] == 1 ) {
		$definition = imglossary_linkterms( $definition, $glossaryterm );
		$html = 1;
	}
	if ( $breaks ) {
		$thisterm['definition'] = icms_core_DataFilter::checkVar( $definition, 'text', 'output' );
	} else {
		$thisterm['definition'] = icms_core_DataFilter::checkVar( $definition, 'html', 'output' );
	}
	$thisterm['ref'] = icms_core_DataFilter::htmlSpecialchars( $ref );
	$thisterm['url'] = icms_core_DataFilter::makeClickable( $url, $allowimage = 0 );
	$thisterm['submitter'] = icms_member_user_Handler::getUserLink( $uid );
	$thisterm['submit'] = intval( $submit );
	$thisterm['datesub'] = formatTimestamp( $datesub, icms::$module -> config['dateformat'] );
	$thisterm['counter'] = intval( $counter );
	$thisterm['block'] = intval( $block );
	$thisterm['offline'] = intval( $offline );
	$thisterm['notifypub'] = intval( $notifypub );
	$thisterm['dir'] = icms::$module -> getVar( 'dirname' );
}
$xoopsTpl -> assign( 'thisterm', $thisterm );

$microlinks = imglossary_serviceLinks( $thisterm ); // Get icons
$xoopsTpl -> assign( 'microlinks', $microlinks );
$xoopsTpl -> assign( 'lang_modulename', icms::$module -> getVar('name') );
$xoopsTpl -> assign( 'lang_moduledirname', icms::$module -> getVar( 'dirname' ) );
$xoopsTpl -> assign( 'entryID', $entryID );
$xoopsTpl -> assign( 'icms_pagetitle', $thisterm['term'] );

if ( is_object( $xoTheme ) ) {
	$xoTheme -> addMeta( 'meta', 'description', icms_core_DataFilter::icms_substr( strip_tags( $thisterm['definition'] ), 0, 250, '' ) );
} else {
	$xoopsTpl -> assign( 'icms_meta_description', icms_core_DataFilter::icms_substr( strip_tags( $thisterm['definition'] ), 0, 250, '' ) );
}

if ( icms::$module -> config['showsubmitter'] ) {
	$xoopsTpl -> assign( 'submitter', sprintf( _MD_IMGLOSSARY_SUBMITTED, $thisterm['submitter'] ) );
}
$xoopsTpl -> assign( 'submitdate', sprintf( _MD_IMGLOSSARY_SUBMITDATE, $thisterm['datesub'] ) );
$xoopsTpl -> assign( 'counter', sprintf( _MD_IMGLOSSARY_COUNT, $thisterm['counter'] ) );
$xoopsTpl -> assign( 'showsbookmarks', icms::$module -> config['showsbookmarks'] );
$xoopsTpl -> assign( 'sbookmarks', imglossary_sbmarks( $entryID, $thisterm['term'] ) );
$xoopsTpl -> assign( 'icms_module_header', '<link rel="stylesheet" type="text/css" href="style'.(( defined('_ADM_USE_RTL') && _ADM_USE_RTL )?'_rtl':'').'.css" />' );

//Comments
include ICMS_ROOT_PATH . '/include/comment_view.php';

include_once ICMS_ROOT_PATH . '/footer.php';
?>