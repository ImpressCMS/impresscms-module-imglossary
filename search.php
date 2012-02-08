<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: search.php
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		XOOPS_copyrights.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		Wordbook - a multicategory glossary
* @since			1.16
* @author		hsalazar
* ----------------------------------------------------------------------------------------------------------
* 				imGlossary - a multicategory glossary
* @since			1.00
* @author		modified by McDonald
* @version		$Id$
*/
 
$xoopsOption['pagetype'] = "search";

include 'header.php';

$xoopsOption['template_main'] = 'imglossary_search.html';
include ICMS_ROOT_PATH . '/header.php';

global $searchtype, $xoopsTpl;

// Check if search is enabled site-wide
$config_handler = icms::$config;
$xoopsConfigSearch =& $config_handler -> getConfigsByCat( ICMS_CONF_SEARCH );
if ( $xoopsConfigSearch['enable_search'] != 1 ) {
	header( 'Location: ' . ICMS_URL . '/index.php' );
	exit();
}

extract( $_GET );
extract( $_POST, EXTR_OVERWRITE );

$action = isset( $action ) ? trim( $action ) : "search";
$query = isset( $term ) ? trim( $term ) : "";
$start = isset( $start ) ? intval( $start ) : 0;
$categoryID = isset( $categoryID ) ? intval( $categoryID ) : 0;
$type = isset( $type ) ? intval( $type ) : 3;
$queries = array();

if ( icms::$module -> config['multicats'] == 1 ) {
	$xoopsTpl -> assign( 'multicats', 1 );
} else {
	$xoopsTpl -> assign( 'multicats', 0 );
}

// Configure search parameters according to selector
$query = stripslashes( $query );
if ( $type == "1" ) { 
	$searchtype = "term LIKE '%$query%' "; 
}
if ( $type == "2" ) { 
	$searchtype = "definition LIKE '%$query%' "; 
}
if ( $type == "3" ) { 
	$searchtype = "term LIKE '%$query%' OR definition LIKE '%$query%' "; 
}

if ( icms::$module -> config['multicats'] == 1 ) {
	// If the look is in a particular category
	if ( $categoryID > 0 ) { 
		$andcatid = "AND categoryID='$categoryID'"; 
	} else { 
		$andcatid = ""; 
	}
} else {
	$andcatid = "";
}

// Counter
$totalcats = imglossary_countCats();
$publishedwords = imglossary_countWords();
$xoopsTpl -> assign( 'totalcats', $totalcats );
$xoopsTpl -> assign( 'publishedwords', $publishedwords );

// If there's no term here (calling directly search page)
if ( !$query ) {
	// Display message saying there's no term and explaining how to search

	$xoopsTpl -> assign( 'intro', _MD_IMGLOSSARY_NOSEARCHTERM );
	// Display search form
	$searchform = imglossary_showSearchForm();
	$xoopsTpl -> assign( 'searchform', $searchform );
} else {
	// IF there IS term, count number of results

	$searchquery = icms::$xoopsDB -> query( "SELECT COUNT(*) AS nrows FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE " . $searchtype . " AND submit=0 AND offline=0 " . $andcatid );
	list($results) = icms::$xoopsDB -> fetchRow( $searchquery );
	//$results = icms::$xoopsDB -> getRowsNum ( $searchquery );

	if ( $results == 0 ) {
		// There's been no correspondences with the searched terms
		$xoopsTpl -> assign( 'intro', _MD_IMGLOSSARY_NORESULTS );
		// Display search form
		$searchform = imglossary_showSearchForm();
		$xoopsTpl -> assign( 'searchform', $searchform );
	} else {	
		// $results > 0 -> there were search results
		// Show paginated list of results
		// We'll put the results in an array
		$resultset = array();

		// How many results will we show in this page?
		$queryA = "SELECT w.entryID, w.categoryID, w.term, w.init, w.definition, w.html, w.smiley, w.xcodes, w.breaks, c.name AS catname FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " w LEFT JOIN " . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . " c ON w.categoryID=c.categoryID WHERE " . $searchtype . " AND w.submit=0 AND w.offline=0 ORDER BY w.term ASC";
		$resultA = icms::$xoopsDB -> query( $queryA, icms::$module -> config['indexperpage'], $start );
		
		//while (list( $entryID, $categoryID, $term, $init, $definition ) = icms::$xoopsDB->fetchRow($resultA))
		while ( list( $entryID, $categoryID, $term, $init, $definition, $html, $smiley, $xcodes, $breaks, $catname ) = icms::$xoopsDB -> fetchRow( $resultA ) ) {
			$eachresult = array();
		//	icms::$module = XoopsModule::getByDirname( $glossdirname );
			$eachresult['dir'] = icms::$module -> getVar( 'dirname' );
			$eachresult['entryID'] = $entryID;
			$eachresult['categoryID'] = $categoryID;
			$eachresult['term'] = icms_core_DataFilter::htmlSpecialChars( $term );
			$eachresult['catname'] = icms_core_DataFilter::htmlSpecialChars( $catname );
			$tempdef = icms_core_DataFilter::checkVar( $definition, 'html', 'output' );
			$eachresult['definition'] = imglossary_getHTMLHighlight( $query, $tempdef, '<b style="background-color: ' . icms::$module -> config['searchcolor'] . ';">', '</b>' );

			// Functional links
			$microlinks = imglossary_serviceLinks( $eachresult['entryID'] );
			$eachresult['microlinks'] = $microlinks;
			$resultset['match'][] = $eachresult;
			}
		// Msg: there's # results
		$xoopsTpl -> assign( 'intro', sprintf( _MD_IMGLOSSARY_THEREWERE, $results, $query ) );
		
		$linkstring = "term=" . $query . "&start";
		$pagenav = new icms_view_PageNav( $results, icms::$module -> config['indexperpage'], $start, $linkstring );
		$resultset['navbar'] = '<div style="text-align:'._GLOBAL_RIGHT.';">' . $pagenav -> renderNav() . '</div>';

		$xoopsTpl -> assign( 'resultset', $resultset );

		// Display search form
		$searchform = imglossary_showSearchForm();
		$xoopsTpl -> assign( 'searchform', $searchform );
	}
}

// Assign variables and close
$xoopsTpl -> assign( 'lang_modulename', icms::$module -> getVar( 'name' ) );
$xoopsTpl -> assign( 'lang_moduledirname', icms::$module -> getVar( 'dirname' ) );

$xoopsTpl -> assign( "icms_module_header", '<link rel="stylesheet" type="text/css" href="style'.(( defined('_ADM_USE_RTL') && _ADM_USE_RTL )?'_rtl':'').'.css" />' );

include ICMS_ROOT_PATH . '/footer.php';
?>