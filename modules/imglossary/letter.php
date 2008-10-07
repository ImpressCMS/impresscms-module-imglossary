<?php
/**
 * $Id: letter.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

include 'header.php';

global $xoopsUser, $xoopsTpl, $xoopsConfig, $xoopsDB, $modify, $xoopsModuleConfig, $xoopsModule, $ICMS_URL, $indexp; 
$myts =& MyTextSanitizer::getInstance();

$init = isset($_GET['init']) ? $_GET['init'] : 0;

include_once ICMS_ROOT_PATH . '/class/pagenav.php';
include_once ICMS_ROOT_PATH . "/modules/" . $glossdirname . "/include/cleantags.php";

$start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;

$xoopsOption['template_main'] = 'wb_letter.html';
include_once ICMS_ROOT_PATH . '/header.php';

$xoopsTpl -> assign( 'firstletter', $init );
$pubwords = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0" );
$publishedwords = $xoopsDB -> getRowsNum( $pubwords );
$xoopsTpl -> assign( 'publishedwords', $publishedwords );

if ( $xoopsModuleConfig['multicats'] == 1 ) {
	$xoopsTpl -> assign( 'multicats', 1 );
} else {
	$xoopsTpl -> assign( 'multicats', 0 );
}

// To display the linked letter list
$alpha = alphaArray();
$xoopsTpl -> assign( 'alpha', $alpha );

$sql = $xoopsDB -> query ( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE init='#'" );
$howmanyother = $xoopsDB -> getRowsNum( $sql );
$xoopsTpl -> assign( 'totalother', $howmanyother );

if ( $xoopsModuleConfig['multicats'] == 1 )	{
	// To display the list of categories
	$block0 = array();
	$resultcat = $xoopsDB -> query( "SELECT categoryID, name, total FROM " . $xoopsDB -> prefix ( 'imglossary_cats') . " ORDER BY name ASC" );
	while ( list( $catID, $name, $total) = $xoopsDB -> fetchRow( $resultcat ) ) {
		$catlinks = array();
		$xoopsModule = XoopsModule::getByDirname( $glossdirname );
		$catlinks['id'] = $catID;
		$catlinks['total'] = intval($total);
		$catlinks['linktext'] = $myts -> makeTboxData4Show( $name );

		$block0['categories'][] = $catlinks;
	}
	$xoopsTpl -> assign( 'block0', $block0 );
}

// No initial: we need to see all letters
if ( $init == _MD_WB_ALL ) {
	$entriesarray = array();
	$pagetype = 0;

	// How many entries will we show in this page?
	$queryA = "SELECT w.*, c.name AS catname FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " w LEFT JOIN " . $xoopsDB -> prefix( 'imglossary_cats' ) . " c ON w.categoryID=c.categoryID WHERE w.submit=0 AND w.offline=0 ORDER BY w.term ASC";
	$resultA = $xoopsDB -> query( $queryA, $xoopsModuleConfig['indexperpage'], $start );

	$allentries = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0 ORDER BY term ASC" );
	$totalentries = $xoopsDB -> getRowsNum( $allentries );
	$xoopsTpl -> assign( 'totalentries', $totalentries );
	
	while ( list( $entryID, $categoryID, $term, $init, $definition, $ref, $url, $uid, $submit, $datesub, $counter, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub, $request, $comments, $catname ) = $xoopsDB -> fetchRow( $resultA ) ) {
		$eachentry = array();
		$xoopsModule = XoopsModule::getByDirname( $glossdirname );
		$eachentry['dir'] = $glossdirname;

		if ( $xoopsModuleConfig['multicats'] == 1 ) {
			$eachentry['catname'] = $myts -> makeTboxData4Show( $catname );

		}

		$eachentry['id'] = intval( $entryID );
		$eachentry['term'] = ucfirst( $myts -> makeTboxData4Show( $term ) );
		
		if ($comments != 0) {
			$eachentry['comments'] = "<a href='entry.php?entryID=" . $eachentry['id'] . "'>" . $comments . "&nbsp;" . _COMMENTS . "</a>";
		} else {
			$eachentry['comments'] = "<a href='entry.php?entryID=" . $eachentry['id'] . "'>" . _COMMENTS . "&nbsp;?</a>";
		}

		if ( !XOOPS_USE_MULTIBYTES ) {
			//$deftemp = cleanTags( $definition );
			//$deftemp = $myts -> displayTarea( substr ( $deftemp, 0, ( $xoopsModuleConfig['rndlength'] -1 ) ) ) . "...";
			$deftemp = imgloss_substr( $definition, 0, $xoopsModuleConfig['rndlength'], '...' );
			$eachentry['definition'] = $deftemp;
		}

		// Functional links
		$microlinks = serviceLinks( $eachentry );
		$eachentry['microlinks'] = $microlinks;

		$entriesarray['single'][] = $eachentry;
	}
	
	$pagenav = new XoopsPageNav( $totalentries, $xoopsModuleConfig['indexperpage'], $start, 'start' );
	$entriesarray['navbar'] = '<div style="text-align:right;">' . $pagenav -> renderNav() . '</div>';

	$xoopsTpl -> assign ( 'entriesarray', $entriesarray );
	$xoopsTpl -> assign ( 'pagetype', '0' );
	$xoopsTpl -> assign ( 'pageinitial', _MD_WB_ALL );
} else {
	// $init does exist
	$pagetype = 1;
	
	// There IS an initial letter, so we want to show just that letter's terms
	$entriesarray2 = array();

	// How many entries will we show in this page?
	if ( $init == _MD_WB_OTHER ) {
		$queryB = "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0 AND init='#' ORDER BY term ASC";
		$resultB = $xoopsDB -> query( $queryB, $xoopsModuleConfig['indexperpage'], $start );
	} else {
		$queryB = "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0 AND init='$init' AND init!='#' ORDER BY term ASC";
		$resultB = $xoopsDB -> query( $queryB, $xoopsModuleConfig['indexperpage'], $start );
	}

	$entrieshere = $xoopsDB -> getRowsNum( $resultB );
	if ( $entrieshere == 0 ) {
		// redirect_header( "javascript:history.go(-1)", 1, _MD_WB_NOTERMSINLETTER );
		// exit();
		$xoopsTpl -> assign( 'pageinitial', _MD_WB_OTHER );
		$eachentry['init']='';
	} 

	if ( $init == _MD_WB_OTHER ) {
		$allentries = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE init='#' AND submit=0 AND offline=0 ORDER BY term ASC" );
	} else {
		$allentries = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE init='$init' AND init!='#' AND submit=0 AND offline=0 ORDER BY term ASC" );
	}
	
	$totalentries = $xoopsDB -> getRowsNum( $allentries );
	$xoopsTpl -> assign( 'totalentries', $totalentries );
	
	while ( list( $entryID, $categoryID, $term, $init, $definition, $ref, $url, $uid, $submit, $datesub, $counter, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub, $request, $comments ) = $xoopsDB -> fetchRow( $resultB ) ) {
		$eachentry = array();
		$xoopsModule = XoopsModule::getByDirname( $glossdirname );
		$eachentry['dir'] = $xoopsModule -> dirname();

		if ( $xoopsModuleConfig['multicats'] == 1 ) {
			$eachentry['catid'] = intval($categoryID);
			$resultF = $xoopsDB -> query ( "SELECT name FROM " . $xoopsDB -> prefix ( 'imglossary_cats' ) . " WHERE categoryID='$categoryID' ORDER BY name ASC" );
			while ( list( $name) = $xoopsDB -> fetchRow( $resultF ) ) {
				$eachentry['catname'] = $myts -> makeTboxData4Show( $name );
			}
		}

		$eachentry['id'] = intval( $entryID );
		$eachentry['term'] = ucfirst( $myts -> makeTboxData4Show( $term ) );
		$eachentry['init'] = $init;
		
		if ($comments != 0) {
			$eachentry['comments'] = "<a href='entry.php?entryID=" . $eachentry['id'] . "'>" . $comments . "&nbsp;" . _COMMENTS . "</a>";
		} else {
			$eachentry['comments'] = "<a href='entry.php?entryID=" . $eachentry['id'] . "'>" . _COMMENTS . "&nbsp;?</a>";
		}

		if ( !XOOPS_USE_MULTIBYTES ) {
		//	$deftemp = cleanTags($definition);
		//	$deftemp = $myts -> displayTarea ( substr ( $deftemp, 0, ( $xoopsModuleConfig['rndlength'] -1 ) ) ) . "...";
			$deftemp = imgloss_substr( $definition, 0, $xoopsModuleConfig['rndlength'], '...' );
			$eachentry['definition'] = $deftemp;
		}

		// Functional links
		$microlinks = serviceLinks( $eachentry );
		$eachentry['microlinks'] = $microlinks;

		$entriesarray2['single'][] = $eachentry;
	}
	
	$pagenav = new XoopsPageNav( $totalentries, $xoopsModuleConfig['indexperpage'], $start, 'init=' . $eachentry['init'] . '&start' );
	$entriesarray2['navbar'] = '<div style="text-align:right;">' . $pagenav -> renderNav() . '</div>';

	$xoopsTpl -> assign( 'entriesarray2', $entriesarray2 );
	$xoopsTpl -> assign( 'pagetype', '1' );
	if ($eachentry['init'] == '#') {
		$xoopsTpl -> assign( 'pageinitial', _MD_WB_OTHER );
	} else {
		$xoopsTpl -> assign( 'pageinitial', ucfirst( $eachentry['init'] ) );
	}
}

$xoopsTpl -> assign( 'lang_modulename', $xoopsModule -> name() );
$xoopsTpl -> assign( 'lang_moduledirname', $xoopsModule -> dirname() );

$xoopsTpl -> assign( 'alpha', $alpha );

$xoopsTpl -> assign( "xoops_module_header", '<link rel="stylesheet" type="text/css" href="style.css" />' );

include ICMS_ROOT_PATH . "/footer.php";

?>