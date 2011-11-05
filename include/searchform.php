<?PHP
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: include/searchform.php
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		XOOPS_copyrights.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* ----------------------------------------------------------------------------------------------------------
* @package		Wordbook - a multicategory glossary
* @since			1.16
* @author		hsalazar
* ----------------------------------------------------------------------------------------------------------
* @package		imGlossary - a multicategory glossary
* @since			1.00
* @author		modified by McDonald
* @version		$Id$
*/
 
 function imglossary_searchform() {
	calculateTotals();
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
			$xoopsTpl -> assign ( 'empty', '1' );
		}

		// To display the search form
		$searchform = '<table width="100%">';
		$searchform .= '<form name="op" id="op" action="search.php" method="post">';
		$searchform .= '<tr><td style="text-align: '._GLOBAL_RIGHT.'; line-height: 200%">';
		$searchform .= _MD_IMGLOSSARY_LOOKON . '</td><td width="10">&nbsp;</td><td style="text-align: '._GLOBAL_LEFT.';">';
		$searchform .= '<select name="type"><option value="1">' . _MD_IMGLOSSARY_TERMS . '</option><option value="2">' . _MD_IMGLOSSARY_DEFINS . '</option>';
		$searchform .= '<option value="3">' . _MD_IMGLOSSARY_TERMSDEFS . '</option></select></td></tr>';
		if ( icms::$module -> config['multicats'] == 1 ) {
			$searchform .= '<tr><td style="text-align: '._GLOBAL_RIGHT.'; line-height: 200%">' . _MD_IMGLOSSARY_CATEGORY . '</td>';
			$searchform .= '<td>&nbsp;</td><td style="text-align: '._GLOBAL_LEFT.';">';
			$resultcat = icms::$xoopsDB -> query( "SELECT categoryID, name FROM " . icms::$xoopsDB -> prefix ( 'imglossary_cats' ) . " ORDER BY categoryID" );
			$searchform .= '<select name="categoryID">';
			$searchform .= '<option value="0">' . _MD_IMGLOSSARY_ALLOFTHEM . '</option>';
			while ( list( $categoryID, $name ) = icms::$xoopsDB -> fetchRow( $resultcat ) ) {
				$searchform .= '<option value="$categoryID">$categoryID : $name</option>';
			}
			$searchform .= '</select></td></tr>';
		}
		$searchform .= '<tr><td style="text-align: '._GLOBAL_RIGHT.'; line-height: 200%">';
		$searchform .= _MD_IMGLOSSARY_TERM . '</td><td>&nbsp;</td><td style="text-align: '._GLOBAL_LEFT.';">';
		$searchform .= '<input type="text" name="term" /></td></tr><tr>';
		$searchform .= '<td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" value="' . _MD_IMGLOSSARY_SEARCH . '" />';
		$searchform .= '</td></tr></form></table>';
		$xoopsTpl -> assign( 'searchform', $searchform );
 }
 ?>