<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: index.php
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

$op = '';

$start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;
$start = intval( $start );

$columna = array ();

// Options
switch ( $op ) {
	case 'default':
	default:

		global $icmsConfig, $myts, $xoopsTpl, $xoopsOption;

		$xoopsOption['template_main'] = 'imglossary_index.html';
		include  ICMS_ROOT_PATH . '/header.php';

		imglossary_calculateTotals();
		$xoopsTpl -> assign( 'multicats', intval( icms::$module -> config['multicats'] ) );

		// Counts
		if ( icms::$module -> config['multicats'] == 1 ) {
			$totalcats = imglossary_countCats();
			$xoopsTpl -> assign( 'totalcats', $totalcats );
		}
		$publishedwords = imglossary_countWords();
		$xoopsTpl -> assign( 'publishedwords', $publishedwords );

		if ( icms::$module -> config['multicats'] == 1 ) {
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

		$sql = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix ( 'imglossary_entries' ) . ' WHERE init=1' );
		$howmanyother = icms::$xoopsDB -> getRowsNum( $sql );
		$xoopsTpl -> assign( 'totalother', $howmanyother );

		if ( icms::$module -> config['multicats'] == 1 ) {
			// To display the list of categories
			$block0 = array();
			$resultcat = icms::$xoopsDB -> query( 'SELECT categoryID, name, total FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' ORDER BY name ASC' );
			while ( list( $catID, $name, $total ) = icms::$xoopsDB -> fetchRow( $resultcat ) ) {
				$catlinks = array();
				$catlinks['id'] = $catID;
				$catlinks['total'] = intval( $total );
				$catlinks['linktext'] = $name;
				$block0['categories'][] = $catlinks;
			}
			$xoopsTpl -> assign( 'block0', $block0 );
		}

		// To display the recent entries block
		$block1 = array();
		$result05 = icms::$xoopsDB -> query( 'SELECT entryID, term, datesub FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE datesub<' . time() . ' AND datesub>0 AND submit=0 AND offline=0 AND request=0 ORDER BY datesub DESC', icms::$module -> config['indexperpage'], 0 );

		// If there are definitions
		if ( $publishedwords > 0 ) {
			while ( list( $entryID, $term, $datesub ) = icms::$xoopsDB -> fetchRow( $result05 ) ) {
				$newentries = array();
				$linktext = icms_core_DataFilter::htmlSpecialchars( $term );
				$newentries['linktext'] = $linktext;
				$newentries['id'] = $entryID;
				$newentries['date'] = formatTimestamp( $datesub, 's' );
				$block1['newstuff'][] = $newentries;
			} 
			$xoopsTpl -> assign( 'block', $block1 );
		}

		// To display the most read entries block
		$block2 = array();
		$result06 = icms::$xoopsDB -> query( 'SELECT entryID, term, counter FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE datesub<' . time() . ' AND datesub>0 AND submit=0 AND offline=0 AND request=0 ORDER BY counter DESC', icms::$module -> config['indexperpage'], 0 );

		// If there are definitions
		if ( $publishedwords > 0 ) {
			while ( list( $entryID, $term, $counter ) = icms::$xoopsDB -> fetchRow($result06)) {
				$popentries = array();
				$linktext = icms_core_DataFilter::htmlSpecialchars( $term );
				$popentries['linktext'] = $linktext;
				$popentries['id'] = $entryID;
				$popentries['counter'] = intval( $counter );
				$block2['popstuff'][] = $popentries;
			}
			$xoopsTpl -> assign( 'block2', $block2);
		}

		// To display the random term block
		list( $numrows ) = icms::$xoopsDB -> fetchRow( icms::$xoopsDB -> query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND offline=0' ) );
		if ( $numrows > 1 ) {
			$numrows = $numrows-1;
			mt_srand((double)microtime()*1000000);
			$entrynumber = mt_rand( 0, $numrows );
		} else {
			$entrynumber = 0;
		}

		$resultZ = icms::$xoopsDB -> query( 'SELECT categoryID, entryID, term, definition, html, smiley, xcodes, breaks, comments FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND offline=0 LIMIT ' . $entrynumber . ', 1' );

		$zerotest = icms::$xoopsDB -> getRowsNum( $resultZ );
		if ( $zerotest != 0 ) {
			while( $myrow = icms::$xoopsDB -> fetchArray( $resultZ ) ) {
				$random = array();
				$random['entryID'] = $myrow['entryID'];
				$random['id'] = $myrow['entryID'];
				$random['term'] = $myrow['term'];
				$random['comments'] = '<a href="entry.php?entryID=' . $myrow['entryID'] . '"><img src="images/icon/comments.png" border="0" alt="' . _COMMENTS . ' (' . $myrow['comments'] . ')" title="' . _COMMENTS .' (' . $myrow['comments'] . ')" /></a>';

				if ( !XOOPS_USE_MULTIBYTES ) {
					if ( $myrow['breaks'] ) {
						$random['definition'] = icms_core_DataFilter::icms_substr( icms_core_DataFilter::checkVar( $myrow['definition'], 'text', 'output' ), 0, icms::$module -> config['rndlength']-1, '...' );
					} else {
						$random['definition'] = icms_core_DataFilter::icms_substr( icms_core_DataFilter::checkVar( $myrow['definition'], 'html', 'output' ), 0, icms::$module -> config['rndlength']-1, '...' );
					}
				}

				if ( icms::$module -> config['multicats'] == 1 ) {
					$random['categoryID'] = $myrow['categoryID'];
		
					$resultY = icms::$xoopsDB -> query( 'SELECT categoryID, name FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' WHERE categoryID=' . $myrow['categoryID'] );
					list( $categoryID, $name ) = icms::$xoopsDB -> fetchRow( $resultY );
					$random['categoryname'] = $myts -> displayTarea( $name );
				}
			}
			$xoopsTpl -> assign( 'random', $random );
			$microlinks = imglossary_serviceLinks( $random );
		}
		if ( icms::$user && icms::$user -> isAdmin() ) {

			// To display the submitted and requested terms box
			$xoopsTpl -> assign( 'userisadmin', 1 );

			$blockS = array();
			$resultS = icms::$xoopsDB -> query( 'SELECT entryID, term FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE datesub<' . time() . ' AND datesub>0 AND submit=1 AND offline=1 AND request=0 ORDER BY term' );
			$totalSwords = icms::$xoopsDB -> getRowsNum( $resultS );

			// If there are definitions
			if ( $totalSwords > 0 ) {
				while ( list( $entryID, $term ) = icms::$xoopsDB -> fetchRow( $resultS ) ) {
					$subentries = array();
					$linktext = icms_core_DataFilter::htmlSpecialchars( $term );
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
				$resultR = icms::$xoopsDB -> query( 'SELECT entryID, term FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE datesub<' . time() . ' AND datesub>0 AND request=1 ORDER BY term' );
				$totalRwords = icms::$xoopsDB -> getRowsNum( $resultR );

				// If there are definitions
				if ( $totalRwords > 0 ) {
					while ( list( $entryID, $term ) = icms::$xoopsDB -> fetchRow( $resultR ) ) {
						$reqentries = array();
						$linktext = icms_core_DataFilter::htmlSpecialchars( $term );
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
				$resultR = icms::$xoopsDB -> query( 'SELECT entryID, term FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE datesub<' . time() . ' AND datesub>0 AND request=1 ORDER BY term' );
				$totalRwords = icms::$xoopsDB -> getRowsNum ( $resultR );

				// If there are definitions
				if ( $totalRwords > 0 ) {
					while ( list( $entryID, $term ) = icms::$xoopsDB -> fetchRow( $resultR ) ) {
						$reqentries = array();
						$linktext = icms_core_DataFilter::htmlSpecialchars( $term );
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
		$xoopsTpl -> assign( 'lang_modulename', icms::$module -> getVar( 'name' ) );
		$xoopsTpl -> assign( 'lang_moduledirname', icms::$module -> getVar( 'dirname' ) );
		if ( $zerotest != 0 ) {
			$xoopsTpl -> assign( 'microlinks', $microlinks . $random['comments'] );
		}
		$xoopsTpl -> assign( 'showcenter', icms::$module -> config['showcenter'] );
		$xoopsTpl -> assign( 'showrandom', icms::$module -> config['showrandom'] );

}

if ( icms::$module -> config['rssfeed'] ) {
	$xoopsTpl -> assign( 'rssfeed', icms::$module -> config['rssfeed'] );
	$xoopsTpl -> assign( 'feed', '<a href="feed.php" target="_blank"><img src="images/icon/feed.png" border="0" alt="' . _MD_IMGLOSSARY_FEED . '" title="' . _MD_IMGLOSSARY_FEED . '" /></a>' ); // Displays feed icon on index page
	$xoopsTpl -> assign( 'icms_module_header', '<link rel="alternate" type="application/rss+xml" title="' . _MD_IMGLOSSARY_FEED . '" href="feed.php" />' );
}

include ICMS_ROOT_PATH . '/footer.php';
?>