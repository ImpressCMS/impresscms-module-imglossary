<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: letter.php
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

global $xoopsTpl, $icmsConfig, $modify;
$myts =& MyTextSanitizer::getInstance();

$init = trim( StopXSS( $_GET['init'] ) );

$start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;
$start = intval( $start );

$xoopsOption['template_main'] = 'imglossary_letter.html';
include_once ICMS_ROOT_PATH . '/header.php';

$xoopsTpl -> assign( 'firstletter', $init );
$pubwords = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND offline=0' );
$publishedwords = icms::$xoopsDB -> getRowsNum( $pubwords );
$xoopsTpl -> assign( 'publishedwords', $publishedwords );

if ( icms::$module -> config['multicats'] == 1 ) {
	$xoopsTpl -> assign( 'multicats', 1 );
} else {
	$xoopsTpl -> assign( 'multicats', 0 );
}

// To display the linked letter list
$alpha = imglossary_alphaArray();
$xoopsTpl -> assign( 'alpha', $alpha );

$sql = icms::$xoopsDB -> query ( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE init=1' );
$howmanyother = icms::$xoopsDB -> getRowsNum( $sql );
$xoopsTpl -> assign( 'totalother', $howmanyother );

if ( icms::$module -> config['multicats'] == 1 ) {
	// To display the list of categories
	$block0 = array();
	$resultcat = icms::$xoopsDB -> query( 'SELECT categoryID, name, total FROM ' . icms::$xoopsDB -> prefix ( 'imglossary_cats') . ' ORDER BY ' . icms::$module -> config['sortcats'] . ' ASC' );
	while ( list( $catID, $name, $total ) = icms::$xoopsDB -> fetchRow( $resultcat ) ) {
		$catlinks = array();
		$catlinks['id'] = $catID;
		$catlinks['total'] = intval( $total );
		$catlinks['linktext'] = icms_core_DataFilter::htmlSpecialchars( $name );
		$block0['categories'][] = $catlinks;
	}
	$xoopsTpl -> assign( 'block0', $block0 );
}

// No initial: we need to see all letters
if ( $init == _MD_IMGLOSSARY_ALL ) {
	$entriesarray = array();

	// How many entries will we show in this page?
	$queryA = 'SELECT w.*, c.name AS catname FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' w LEFT JOIN ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' c ON w.categoryID=c.categoryID WHERE w.submit=0 AND w.offline=0 ORDER BY w.term ASC';
	$resultA = icms::$xoopsDB -> query( $queryA, icms::$module -> config['indexperpage'], $start );

	$allentries = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND offline=0 ORDER BY term ASC' );
	$totalentries = icms::$xoopsDB -> getRowsNum( $allentries );
	$xoopsTpl -> assign( 'totalentries', $totalentries );

	while ( list( $entryID, $categoryID, $term, $init, $definition, $ref, $url, $uid, $submit, $datesub, $counter, $block, $offline, $notifypub, $request, $comments, $catname ) = icms::$xoopsDB -> fetchRow( $resultA ) ) {
		$eachentry = array();

		if ( icms::$module -> config['multicats'] == 1 ) {
			$eachentry['catname'] = icms_core_DataFilter::htmlSpecialchars( $catname );
			$eachentry['catid'] = $catlinks['id'];
		}

		$eachentry['dir'] = icms::$module -> getVar( 'dirname' );
		$eachentry['id'] = intval( $entryID );
		$eachentry['term'] = icms_core_DataFilter::htmlSpecialchars( $term );
		$eachentry['init'] = _MD_IMGLOSSARY_ALL;
		$eachentry['comments'] = '<a href="entry.php?entryID=' . $eachentry['id'] . '"><img src="images/icon/comments.png" border="0" alt="' . _COMMENTS .' (' . $comments.')" title="' . _COMMENTS .' (' . $comments.')" /></a>';

		if ( !XOOPS_USE_MULTIBYTES ) {
			if ( icms::$module -> config['linkterms'] == 1 ) {
					$definition = imglossary_linkterms( $definition, $term, $eachentry['term'] );
			}
			$eachentry['definition'] = icms_core_DataFilter::icms_substr( icms_core_DataFilter::checkVar( $definition, 'html', 'output' ), 0, icms::$module -> config['rndlength']-1, '...' );
		}

		// Functional links
		$microlinks = imglossary_serviceLinks( $eachentry ) . $eachentry['comments'];
		$eachentry['microlinks'] = $microlinks;
		$entriesarray['single'][] = $eachentry;
	}

	$pagenav = new icms_view_PageNav( $totalentries, icms::$module -> config['indexperpage'], $start, 'init=' . $eachentry['init'] . '&start' );
	$entriesarray['navbar'] = '<div style="text-align:' . _GLOBAL_RIGHT . ';">' . $pagenav -> renderNav() . '</div>';

	$xoopsTpl -> assign ( 'entriesarray', $entriesarray );
	$xoopsTpl -> assign ( 'pagetype', '0' );
	$xoopsTpl -> assign ( 'pageinitial', $eachentry['init'] );
	
} else {
	// $init does exist
	// $pagetype = 1;

	// There IS an initial letter, so we want to show just that letter's terms
	$entriesarray2 = array();

	// How many entries will we show in this page?
	if ( $init == _MD_IMGLOSSARY_OTHER ) {
		$queryB = 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND offline=0 AND init=1 ORDER BY term ASC';
		$resultB = icms::$xoopsDB -> query( $queryB, icms::$module -> config['indexperpage'], $start );
	} elseif ( $init == '1' ) {
		$queryB = 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND offline=0 AND init=1 ORDER BY term ASC';
		$resultB = icms::$xoopsDB -> query( $queryB, icms::$module -> config['indexperpage'], $start );
	} else {
		$queryB = "SELECT * FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0 AND init='$init' AND init!=1 ORDER BY term ASC";
		$resultB = icms::$xoopsDB -> query( $queryB, icms::$module -> config['indexperpage'], $start );
	}
	$entrieshere = icms::$xoopsDB -> getRowsNum( $resultB );

	if ( $entrieshere == 0 ) {
		$xoopsTpl -> assign( 'pageinitial', _MD_IMGLOSSARY_OTHER );
		$eachentry['init'] = '';
	}

	if ( $init == _MD_IMGLOSSARY_OTHER ) {
		$allentries = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE init=1 AND submit=0 AND offline=0 ORDER BY term ASC' );
	} elseif ( $init == '1' ) {
		$allentries = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE init=1 AND submit=0 AND offline=0 ORDER BY term ASC' );
	} else {
		$allentries = icms::$xoopsDB -> query( "SELECT * FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE init='$init' AND init!=1 AND submit=0 AND offline=0 ORDER BY term ASC" );
	}
	$totalentries = icms::$xoopsDB -> getRowsNum( $allentries );

	$xoopsTpl -> assign( 'totalentries', $totalentries );

	while ( list( $entryID, $categoryID, $term, $init, $definition, $ref, $url, $uid, $submit, $datesub, $counter, $block, $offline, $notifypub, $request, $comments ) = icms::$xoopsDB -> fetchRow( $resultB ) ) {
		$eachentry = array();

		if ( icms::$module -> config['multicats'] == 1 ) {
			$eachentry['catid'] = intval( $categoryID );
			$resultF = icms::$xoopsDB -> query ( "SELECT name FROM " . icms::$xoopsDB -> prefix ( 'imglossary_cats' ) . " WHERE categoryID='$categoryID' ORDER BY name ASC" );
			while ( list( $name) = icms::$xoopsDB -> fetchRow( $resultF ) ) {
				$eachentry['catname'] = icms_core_DataFilter::htmlSpecialchars( $name );
			}
		}

		$eachentry['dir'] = icms::$module -> getVar( 'dirname' );
		$eachentry['id'] = intval( $entryID );
		$eachentry['term'] = icms_core_DataFilter::htmlSpecialchars( $term );
		$eachentry['init'] = $init;
		$eachentry['comments'] = '<a href="entry.php?entryID=' . $eachentry['id'] . '"><img src="images/icon/comments.png" border="0" alt="' . _COMMENTS . ' (' . $comments.')" title="' . _COMMENTS . ' (' . $comments . ')" /></a>';

		if ( !XOOPS_USE_MULTIBYTES ) {
			if ( icms::$module -> config['linkterms'] == 1 ) {
					$definition = imglossary_linkterms( $definition, $term, $eachentry['term'] );
			}
			$eachentry['definition'] = icms_core_DataFilter::icms_substr( icms_core_DataFilter::checkVar( $definition, 'html', 'output' ), 0, icms::$module -> config['rndlength']-1, '...' );
		}

		// Functional links
		$microlinks = imglossary_serviceLinks( $eachentry ) . $eachentry['comments'];
		$eachentry['microlinks'] = $microlinks;
		$entriesarray2['single'][] = $eachentry;
	}
	
	$pagenav = new icms_view_PageNav( $totalentries, icms::$module -> config['indexperpage'], $start, 'init=' . $eachentry['init'] . '&start' );
	$entriesarray2['navbar'] = '<div style="text-align:' . _GLOBAL_RIGHT . ';">' . $pagenav -> renderNav() . '</div>';

	$xoopsTpl -> assign( 'entriesarray2', $entriesarray2 );
	$xoopsTpl -> assign( 'pagetype', '1' );
	
	if ( $eachentry['init'] == '1' ) {
		$xoopsTpl -> assign( 'pageinitial', _MD_IMGLOSSARY_OTHER );
		$xoopsTpl -> assign( 'firstletter', _MD_IMGLOSSARY_OTHER );
	} else {
		$xoopsTpl -> assign( 'pageinitial', $eachentry['init'] );
	}
}

$xoopsTpl -> assign( 'lang_modulename', icms::$module -> getVar('name') );
$xoopsTpl -> assign( 'lang_moduledirname', icms::$module -> getVar('dirname') );
$xoopsTpl -> assign( 'alpha', $alpha );
$xoopsTpl -> assign( 'icms_module_header', '<link rel="stylesheet" type="text/css" href="style'.(( defined('_ADM_USE_RTL') && _ADM_USE_RTL )?'_rtl':'').'.css" />' );

include ICMS_ROOT_PATH . '/footer.php';
?>