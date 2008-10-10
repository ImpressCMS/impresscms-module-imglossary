<?php
/**
 * $Id: entry.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

include 'header.php';

include_once ICMS_ROOT_PATH . "/class/module.textsanitizer.php"; 

global $xoopsUser, $xoopsConfig, $xoopsDB, $modify, $xoopsModuleConfig, $xoopsModule; 
$myts =& MyTextSanitizer::getInstance();

$entryID = isset($_GET['entryID']) ? intval($_GET['entryID']) : 0;
$entryID = intval( $entryID );

$xoopsOption['template_main'] = 'imglossary_entry.html';
include ICMS_ROOT_PATH . "/header.php";

if ( $xoopsModuleConfig['multicats'] == 1 ) {
	$xoopsTpl -> assign( 'multicats', 1 );
} else {
	$xoopsTpl -> assign( 'multicats', 0 );
}

// If there's no entries yet in the system...
$pubwords = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0" );
$publishedwords = $xoopsDB -> getRowsNum ( $pubwords );
$xoopsTpl->assign('publishedwords', $publishedwords);
if ( $publishedwords == 0 )	{
	$xoopsTpl -> assign ( 'empty', '1' );
	$xoopsTpl -> assign ( 'stillnothing', _MD_IMGLOSSARY_STILLNOTHINGHERE );
}

// To display the linked letter list
$alpha = imglossary_alphaArray();
$xoopsTpl -> assign( 'alpha', $alpha );

$sql = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE init='#'" );
$howmanyother = $xoopsDB -> getRowsNum( $sql );
$xoopsTpl -> assign( 'totalother', $howmanyother );

if ( $xoopsModuleConfig['multicats'] == 1 )	{
	// To display the list of categories
	$block0 = array();
	$resultcat = $xoopsDB -> query( "SELECT categoryID, name, total FROM " . $xoopsDB -> prefix ( 'imglossary_cats' ) . " ORDER BY name ASC" );
	while ( list( $catID, $name, $total ) = $xoopsDB -> fetchRow( $resultcat ) ) {
		$catlinks = array();
		$xoopsModule = XoopsModule::getByDirname( $glossdirname );
		$catlinks['id'] = $catID;
		$catlinks['total'] = intval( $total );
		$catlinks['linktext'] = $myts -> makeTboxData4Show( $name );

		$block0['categories'][] = $catlinks;
	}
	$xoopsTpl -> assign( 'block0', $block0 );
}

if ( !$entryID ) {
	$result = $xoopsDB -> query( "SELECT entryID, categoryID, term, init, definition, ref, url, uid, submit, datesub, counter, html, smiley, xcodes, breaks, block, offline, notifypub FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE datesub<" . time() . " AND datesub>0 AND (submit=0) ORDER BY datesub DESC", 1, 0 );
} else {
	if ( !$xoopsUser || ( $xoopsUser -> isAdmin( $xoopsModule -> mid() ) && $xoopsModuleConfig['adminhits'] == 1 ) || ( $xoopsUser && !$xoopsUser -> isAdmin( $xoopsModule -> mid() ) ) ) {
		$xoopsDB -> queryF( "UPDATE " . $xoopsDB -> prefix( 'imglossary_entries' ) . " SET counter=counter+1 WHERE entryID='$entryID'" );
	}	

	$result = $xoopsDB -> query( "SELECT entryID, categoryID, term, init, definition, ref, url, uid, submit, datesub, counter, html, smiley, xcodes, breaks, block, offline, notifypub FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE entryID='$entryID'" );
	}

while ( list( $entryID, $categoryID, $term, $init, $definition, $ref, $url, $uid, $submit, $datesub, $counter, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub ) = $xoopsDB -> fetchRow( $result ) ) {
	$thisterm = array();
	$xoopsModule = XoopsModule::getByDirname( $glossdirname );
	$thisterm['id'] = intval( $entryID );

	if ( $xoopsModuleConfig['multicats'] == 1 )	{
		$thisterm['categoryID'] = intval($categoryID);
		$catname = $xoopsDB -> query ( "SELECT name FROM " . $xoopsDB -> prefix ( 'imglossary_cats' ) . " WHERE categoryID='$categoryID'");
		while ( list( $name ) = $xoopsDB -> fetchRow ( $catname ) ) {
			$thisterm['catname'] = $myts -> makeTboxData4Show( $name );
		}
	}

	$glossaryterm = $myts -> makeTboxData4Show( $term );
	$thisterm['term'] = ucfirst( $myts -> makeTboxData4Show( $term ) );
	if ( $init == '#' ) {
		$thisterm['init'] = _MD_IMGLOSSARY_OTHER;
	} else {
		$thisterm['init'] = ucfirst($init);
	}

	if ( $xoopsModuleConfig['linkterms'] == 1 ) {
		$definition = imglossary_linkterms( $definition, $term, $glossaryterm );		
	}

	$thisterm['definition'] = $myts -> displayTarea( $definition, $html, $smiley, $xcodes, 1, $breaks );
	
	$thisterm['ref'] = $myts -> makeTboxData4Show( $ref );
	$thisterm['url'] = $myts -> makeClickable( $url, $allowimage = 0 );
	$thisterm['submitter'] = xoops_getLinkedUnameFromId( $uid );
	$thisterm['submit'] = intval( $submit );
	$thisterm['datesub'] = formatTimestamp( $datesub, $xoopsModuleConfig['dateformat'] );
	$thisterm['counter'] = intval( $counter );
	$thisterm['block'] = intval( $block );
	$thisterm['offline'] = intval( $offline );
	$thisterm['notifypub'] = intval( $notifypub );
	$thisterm['dir'] = $glossdirname;
	}
$xoopsTpl -> assign( 'thisterm', $thisterm );

$microlinks = imglossary_serviceLinks( $thisterm );   // Get icons

$xoopsTpl -> assign( 'microlinks', $microlinks );

$xoopsTpl -> assign( 'lang_modulename', $xoopsModule -> name() );
$xoopsTpl -> assign( 'lang_moduledirname', $glossdirname );

$xoopsTpl -> assign( 'entryID', $entryID );
$xoopsTpl -> assign( 'xoops_pagetitle', $thisterm['term'] );
$xoTheme -> addMeta( 'meta', 'description', icms_substr( strip_tags($thisterm['definition']), 0, 250, '' ) );
$xoopsTpl -> assign( 'submitted', sprintf( _MD_IMGLOSSARY_SUBMITTED, $thisterm['submitter'], $thisterm['datesub'] ) );
$xoopsTpl -> assign( 'counter', sprintf( _MD_IMGLOSSARY_COUNT, $thisterm['counter'] ) );

$xoopsTpl -> assign( "xoops_module_header", '<link rel="stylesheet" type="text/css" href="style.css" />' );

//Comments
include ICMS_ROOT_PATH . '/include/comment_view.php';

include_once ICMS_ROOT_PATH . '/footer.php';
?>