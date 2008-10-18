<?php
/**
 * $Id: index.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

include 'header.php';

$op = '';

include_once ICMS_ROOT_PATH . '/class/pagenav.php';

$start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;
$start = intval( $start );

$columna = array ();

// Options
switch ( $op ) {
	case "default":
	default:

		global $xoopsUser, $xoopsConfig, $xoopsDB, $myts, $xoopsModuleConfig, $xoopsModule, $xoopsTpl;

		$xoopsOption['template_main'] = 'imglossary_index.html';
		include  ICMS_ROOT_PATH . '/header.php';
		
		imglossary_calculateTotals();
		$xoopsTpl -> assign( 'multicats', intval( $xoopsModuleConfig['multicats'] ) );

		// Counts
		if ( $xoopsModuleConfig['multicats'] == 1 ) {
			$totalcats = imglossary_countCats();
			$xoopsTpl -> assign( 'totalcats', $totalcats );
		}
		$publishedwords = imglossary_countWords();
		$xoopsTpl -> assign( 'publishedwords', $publishedwords );

		if ( $xoopsModuleConfig['multicats'] == 1 ) {
			$xoopsTpl -> assign( 'multicats', 1 );
		} else {
			$xoopsTpl -> assign( 'multicats', 0 );
		}

		// If there are no entries yet in the system...
		if ( $publishedwords == 0 ) {
			$xoopsTpl -> assign( 'empty', '1' );
			$microlinks = '';
		}

		// To display the search form
		$searchform = imglossary_showSearchForm( '' );
		$xoopsTpl -> assign( 'searchform', $searchform );

		// To display the linked letter list
		$alpha = imglossary_alphaArray();
		$xoopsTpl -> assign( 'alpha', $alpha );

		$sql = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix ( 'imglossary_entries' ) . " WHERE init='#'" );
		$howmanyother = $xoopsDB -> getRowsNum( $sql );
		$xoopsTpl -> assign( 'totalother', $howmanyother );

		if ( $xoopsModuleConfig['multicats'] == 1 )	{
			// To display the list of categories
			$block0 = array();
			$resultcat = $xoopsDB -> query( "SELECT categoryID, name, total FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " ORDER BY name ASC" );
			while ( list( $catID, $name, $total) = $xoopsDB -> fetchRow( $resultcat ) ) {
				$catlinks = array();
				$xoopsModule = XoopsModule::getByDirname( $glossdirname );
				$catlinks['id'] = $catID;
				$catlinks['total'] = intval( $total );
				$catlinks['linktext'] = $myts -> makeTboxData4Show( $name );

				$block0['categories'][] = $catlinks;
			}
			$xoopsTpl -> assign( 'block0', $block0 );
		}

		// To display the recent entries block
		$block1 = array();
		$result05 = $xoopsDB -> query( "SELECT entryID, term, datesub FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE datesub<" . time() . " AND datesub>0 AND submit=0 AND offline=0 AND request=0 ORDER BY datesub DESC", $xoopsModuleConfig['indexperpage'], 0 );

		// If there are definitions
		if ( $publishedwords > 0 ) {
			while ( list( $entryID, $term, $datesub ) = $xoopsDB -> fetchRow( $result05 ) ) {
				$newentries = array();
				$xoopsModule = XoopsModule::getByDirname( $glossdirname );
				$linktext = $myts -> makeTboxData4Show( $term );
				$newentries['linktext'] = $linktext;
				$newentries['id'] = $entryID;
				$newentries['date'] = formatTimestamp( $datesub, "s" );

				$block1['newstuff'][] = $newentries;
			} 
			$xoopsTpl -> assign( 'block', $block1 );
		}

		// To display the most read entries block
		$block2 = array();
		$result06 = $xoopsDB -> query( "SELECT entryID, term, counter FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE datesub<" . time() . " AND datesub>0 AND submit=0 AND offline=0 AND request=0 ORDER BY counter DESC", $xoopsModuleConfig['indexperpage'], 0 );

		// If there are definitions
		if ( $publishedwords > 0 ) {
			while ( list( $entryID, $term, $counter ) = $xoopsDB -> fetchRow($result06)) {
				$popentries = array();
				$xoopsModule = XoopsModule::getByDirname( $glossdirname );
				$linktext = $myts -> makeTboxData4Show( $term );
				$popentries['linktext'] = $linktext;
				$popentries['id'] = $entryID;
				$popentries['counter'] = intval( $counter );

				$block2['popstuff'][] = $popentries;
			} 
			$xoopsTpl -> assign( 'block2', $block2);
		}

		// To display the random term block
		list($numrows) = $xoopsDB -> fetchRow( $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0" ) );
		if ( $numrows > 1 ) {
			$numrows = $numrows-1;
			mt_srand((double)microtime()*1000000);
			$entrynumber = mt_rand( 0, $numrows );
		} else {
			$entrynumber = 0;
		}

		$resultZ = $xoopsDB -> query( "SELECT categoryID, entryID, term, definition, html, smiley, xcodes, breaks, comments FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0 LIMIT $entrynumber, 1" );

		$zerotest = $xoopsDB -> getRowsNum( $resultZ );
		if ( $zerotest != 0 ) {
			while( $myrow = $xoopsDB -> fetchArray( $resultZ ) )	{
				$random = array();
				$random['entryID'] = $myrow['entryID'];
				$random['term'] = $myrow['term'];

				if ( !XOOPS_USE_MULTIBYTES ) {
					$deftemp = icms_substr( $myrow['definition'], 0, $xoopsModuleConfig['rndlength']-1, '...' );
					$deftemp1 = $myts -> displayTarea( $deftemp, $myrow['html'], $myrow['smiley'], $myrow['xcodes'], 1, $myrow['breaks'] );
					$random['definition'] = $deftemp1;
					}

				if ( $xoopsModuleConfig['multicats'] == 1 )	{
					$random['categoryID'] = $myrow['categoryID'];
		
					$resultY = $xoopsDB -> query( "SELECT categoryID, name FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " WHERE categoryID=" . $myrow['categoryID'] . " " );
					list( $categoryID, $name ) = $xoopsDB -> fetchRow( $resultY );
					$random['categoryname'] = $myts -> displayTarea( $name );
					}
				}
			$microlinks = imglossary_serviceLinks( $random['entryID'] );

			$xoopsTpl -> assign( 'random', $random );
			}
		if ( $xoopsUser && $xoopsUser -> isAdmin() ) {

				// To display the submitted and requested terms box
				$xoopsTpl -> assign( 'userisadmin', 1 );

				$blockS = array();
				$resultS = $xoopsDB -> query( "SELECT entryID, term FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE datesub<" . time() . " AND datesub>0 AND submit=1 AND offline=1 AND request=0 ORDER BY term" );
				$totalSwords = $xoopsDB -> getRowsNum( $resultS );

				// If there are definitions
				if ( $totalSwords > 0 ) {
					while ( list( $entryID, $term ) = $xoopsDB -> fetchRow( $resultS ) ) {
						$subentries = array();
						$xoopsModule = XoopsModule::getByDirname( $glossdirname );
						$linktext = $myts -> makeTboxData4Show( $term );
						$subentries['linktext'] = $linktext;
						$subentries['id'] = $entryID;

						$blockS['substuff'][] = $subentries;
					}
					$xoopsTpl -> assign( 'blockS', $blockS );
					$xoopsTpl -> assign( 'wehavesubs', 1 );
				} else {
					$xoopsTpl -> assign( 'wehavesubs', 0 );
				}

				$blockR = array();
				$resultR = $xoopsDB -> query( "SELECT entryID, term FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE datesub<" . time() . " AND datesub>0 AND request=1 ORDER BY term" );
				$totalRwords = $xoopsDB -> getRowsNum( $resultR );

				// If there are definitions
				if ( $totalRwords > 0 )	{
					while ( list( $entryID, $term ) = $xoopsDB -> fetchRow( $resultR ) ) {
						$reqentries = array();
						$xoopsModule = XoopsModule::getByDirname( $glossdirname );
						$linktext = $myts -> makeTboxData4Show( $term );
						$reqentries['linktext'] = $linktext;
						$reqentries['id'] = $entryID;

						$blockR['reqstuff'][] = $reqentries;
					} 
					$xoopsTpl -> assign( 'blockR', $blockR );
					$xoopsTpl -> assign( 'wehavereqs', 1);
				} else {
					$xoopsTpl -> assign( 'wehavereqs', 0 );
				}

			} else {
			$xoopsTpl -> assign( 'userisadmin', 0 );
			$blockR = array();
			$resultR = $xoopsDB -> query( "SELECT entryID, term FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE datesub<" . time() . " AND datesub>0 AND request=1 ORDER BY term" );
			$totalRwords = $xoopsDB -> getRowsNum ( $resultR );
             
			// If there are definitions
			if ( $totalRwords > 0 ) {
				while ( list( $entryID, $term ) = $xoopsDB -> fetchRow( $resultR ) ) {
					$reqentries = array();
					$xoopsModule = XoopsModule::getByDirname( $glossdirname );
					$linktext = $myts -> makeTboxData4Show( $term );
					$reqentries['linktext'] = $linktext;
					$reqentries['id'] = $entryID;
                        	
		        	$blockR['reqstuff'][] = $reqentries;
				} 
				$xoopsTpl -> assign( 'blockR', $blockR );
				$xoopsTpl -> assign( 'wehavereqs', 1 );
			} else {
				$xoopsTpl -> assign( 'wehavereqs', 0 );
			}							

		}       	
		// Various strings
		$xoopsTpl -> assign( 'lang_modulename', $xoopsModule -> name() );
		$xoopsTpl -> assign( 'lang_moduledirname', $glossdirname );
		$xoopsTpl -> assign( 'microlinks', $microlinks );
		$xoopsTpl -> assign( 'alpha', $alpha );
		$xoopsTpl -> assign( 'showcenter', $xoopsModuleConfig['showcenter'] );
		$xoopsTpl -> assign( 'showrandom', $xoopsModuleConfig['showrandom'] );
		} 

$xoopsTpl -> assign( "xoops_module_header", '<link rel="stylesheet" type="text/css" href="style.css" />' );

include ICMS_ROOT_PATH . '/footer.php';
?>