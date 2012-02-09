<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: category.php
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
* @version		1.00
*/

include 'header.php';

global $icmsConfig, $modify, $indexp; 

$categoryID = intval( isset($_GET['categoryID']) ? intval($_GET['categoryID']) : 0 );
$start = intval( isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0 );

$xoopsOption['template_main'] = 'imglossary_category.html';
include_once ICMS_ROOT_PATH . '/header.php';

$xoopsTpl -> assign( 'multicats', intval( icms::$module -> config['multicats'] ) );

// If there's no entries yet in the system...
$pubwords = icms::$xoopsDB -> query( "SELECT * FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0" );
$publishedwords = icms::$xoopsDB -> getRowsNum ( $pubwords );
if ( $publishedwords == 0 ) {
	redirect_header( ICMS_URL, 1, _MD_IMGLOSSARY_STILLNOTHINGHERE );
	exit();
}
$xoopsTpl -> assign( 'publishedwords', $publishedwords );

// To display the list of linked initials
$alpha = imglossary_alphaArray();
$xoopsTpl -> assign( 'alpha', $alpha );

$sql = icms::$xoopsDB -> query( "SELECT * FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE init='1'" );
$howmanyother = icms::$xoopsDB -> getRowsNum( $sql );
$xoopsTpl -> assign( 'totalother', $howmanyother );

if ( icms::$module -> config['multicats'] == 1 ) {
	// To display the list of categories
	$block0 = array();
	$resultcat = icms::$xoopsDB -> query( "SELECT categoryID, name, total FROM " . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . " ORDER BY " . icms::$module -> config['sortcats'] . " ASC" );
	while ( list( $catID, $name, $total) = icms::$xoopsDB -> fetchRow( $resultcat ) ) {
		$catlinks = array();
		// $imglossModule = icms::$module -> getVar( 'dirname' );
		$catlinks['id'] = $catID;
		$catlinks['total'] = intval( $total );
		$catlinks['linktext'] = icms_core_DataFilter::htmlSpecialchars( $name );
		$block0['categories'][] = $catlinks;
	}
	$xoopsTpl -> assign( 'block0', $block0 );
}

// No ID of category: we need to see all categories descriptions
if ( !$categoryID == _MD_IMGLOSSARY_ALLCATS ) {
	// How many categories are there?
	$resultcats = icms::$xoopsDB -> query( "SELECT * FROM " . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . " ORDER BY " . icms::$module -> config['sortcats'] . "" );
	$totalcats = icms::$xoopsDB -> getRowsNum( $resultcats );
	if ( $totalcats == 0 ) {
		redirect_header( "javascript:history.go(-1)", 1, _MD_IMGLOSSARY_NOCATSINSYSTEM );
		exit();
	}

	// If there's no $categoryID, we want to show just the categories with their description
	$catsarray = array();

	// How many categories will we show in this page?
	$queryA = "SELECT * FROM " . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . " ORDER BY " . icms::$module -> config['sortcats'] . " ASC";
	$resultA = icms::$xoopsDB -> query( $queryA, icms::$module -> config['indexperpage'], $start );

	while ( list( $categoryID, $name, $description, $total ) = icms::$xoopsDB -> fetchRow( $resultA ) ) {
		$eachcat = array();
		$eachcat['dir'] = icms::$module -> getVar( 'dirname' );
		$eachcat['id'] = $categoryID;
		$eachcat['name'] = icms_core_DataFilter::htmlSpecialchars( $name );
		$eachcat['description'] = icms_core_DataFilter::htmlSpecialchars( $description );
		// Total entries in this category
		$entriesincat = imglossary_countByCategory( $categoryID );
		$eachcat['total'] = intval( $entriesincat );
		$catsarray['single'][] = $eachcat;
	}
	$pagenav = new icms_view_PageNav( $totalcats, icms::$module -> config['indexperpage'], $start, 'categoryID=' . $eachcat['id'] . '&start' );
	$catsarray['navbar'] = '<div style="text-align:'._GLOBAL_RIGHT.';">' . $pagenav -> renderNav() . '</div>';

	$xoopsTpl -> assign( 'catsarray', $catsarray );
	$xoopsTpl -> assign( 'pagetype', '0' );
} else {
	// There IS a $categoryID, thus we show only that category's description
	$catdata = icms::$xoopsDB -> query( "SELECT categoryID, name, description, total FROM " . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . " WHERE categoryID=$categoryID" );
	while ( list( $categoryID, $name, $description, $total ) = icms::$xoopsDB -> fetchRow( $catdata ) ) {
		if ( $total == 0 ) {
			$xoopsTpl -> assign( 'singlecat', _MD_IMGLOSSARY_NOENTRIESINCAT );
		}
		$singlecat = array();
		$singlecat['dir'] = icms::$module -> getVar('dirname');
		$singlecat['id'] = $categoryID;
		$singlecat['name'] = icms_core_DataFilter::htmlSpecialchars( $name );
		$singlecat['description'] = icms_core_DataFilter::htmlSpecialchars( $description );
		// Total entries in this category
		$entriesincat = imglossary_countByCategory( $categoryID );
		$singlecat['total'] = intval( $entriesincat );
		$xoopsTpl -> assign( 'singlecat', $singlecat );

		// Entries to show in current page
		$entriesarray = array();

		// Now we retrieve a specific number of entries according to start variable	
		$queryB = "SELECT entryID, term, definition, html, smiley, xcodes, breaks, comments FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE categoryID=$categoryID AND submit=0 AND offline=0 ORDER BY term ASC";
		$resultB = icms::$xoopsDB -> query( $queryB, icms::$module -> config['indexperpage'], $start );

		while ( list( $entryID, $term, $definition, $html, $smiley, $xcodes, $breaks, $comments ) = icms::$xoopsDB -> fetchRow( $resultB ) ) {
			$eachentry = array();
			$eachentry['dir'] = icms::$module -> getVar( 'dirname' );
			$eachentry['id'] = $entryID;
			$eachentry['term'] = icms_core_DataFilter::htmlSpecialchars( $term );
			if ( !XOOPS_USE_MULTIBYTES ) {
				if ( icms::$module -> config['linkterms'] == 1 ) {
					$definition = imglossary_linkterms( $definition, $term, $eachentry['term'] );
					$html = 1;
				}
				$deftemp = icms_core_DataFilter::icms_substr( $definition, 0, icms::$module -> config['rndlength']-1, '...' );
				if ( $breaks ) {
					$deftemp = icms_core_DataFilter::checkVar( $deftemp, 'text', 'output' );
				} else {
					$deftemp = icms_core_DataFilter::checkVar( $deftemp, 'html', 'output' );
				}
				$eachentry['definition'] = $deftemp;
			}

		$eachentry['comments'] = '<a href="entry.php?entryID=' . $eachentry['id'] . '"><img src="images/icon/comments.png" border="0" alt="' . _COMMENTS .' (' . $comments.')" title="' . _COMMENTS .' (' . $comments.')" /></a>';

			// Functional links
			$microlinks = imglossary_serviceLinks( $eachentry ) . $eachentry['comments'];
			$eachentry['microlinks'] = $microlinks;
			$entriesarray['single'][] = $eachentry;
		}
	}

	$navstring = "categoryID=" . $singlecat['id'] . "&start";
	$pagenav = new icms_view_PageNav( $entriesincat, icms::$module -> config['indexperpage'], $start, $navstring);
	$entriesarray['navbar'] = '<div style="text-align:'._GLOBAL_RIGHT.';">' . $pagenav -> renderNav() . '</div>';

	$xoopsTpl -> assign( 'entriesarray', $entriesarray );
	$xoopsTpl -> assign( 'pagetype', '1' );
	}

$xoopsTpl -> assign( 'lang_modulename', icms::$module -> getVar('name') );
$xoopsTpl -> assign( 'lang_moduledirname', icms::$module -> getVar( 'dirname' ) );

// This will let us include the module's styles in the theme
$xoopsTpl -> assign( 'icms_module_header', '<link rel="stylesheet" type="text/css" href="style'.(( defined('_ADM_USE_RTL') && _ADM_USE_RTL )?'_rtl':'').'.css" />');

include ICMS_ROOT_PATH . '/footer.php';
?>