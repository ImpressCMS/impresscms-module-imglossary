<?PHP
/**
 * $Id: index.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
 
 function imglossary_searchform() {
 
	global $xoopsDB, $xoopsModuleConfig;
 
	calculateTotals();
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
			$xoopsTpl -> assign ( 'empty', '1' );
		}

		// To display the search form
		$searchform = '<table width="100%">';
		$searchform .= '<form name="op" id="op" action="search.php" method="post">';
		$searchform .= '<tr><td style="text-align: right; line-height: 200%">';
		$searchform .= _MD_IMGLOSSARY_LOOKON . '</td><td width="10">&nbsp;</td><td style="text-align: left;">';
		$searchform .= '<select name="type"><option value="1">' . _MD_IMGLOSSARY_TERMS . '</option><option value="2">' . _MD_IMGLOSSARY_DEFINS . '</option>';
		$searchform .= '<option value="3">' . _MD_IMGLOSSARY_TERMSDEFS . '</option></select></td></tr>';
		if ( $xoopsModuleConfig['multicats'] == 1 ) {
			$searchform .= '<tr><td style="text-align: right; line-height: 200%">' . _MD_IMGLOSSARY_CATEGORY . '</td>';
			$searchform .= '<td>&nbsp;</td><td style="text-align: left;">';
			$resultcat = $xoopsDB -> query( "SELECT categoryID, name FROM " . $xoopsDB -> prefix ( 'imglossary_cats' ) . " ORDER BY categoryID" );
			$searchform .= '<select name="categoryID">';
			$searchform .= '<option value="0">' . _MD_IMGLOSSARY_ALLOFTHEM . '</option>';
			while ( list( $categoryID, $name ) = $xoopsDB -> fetchRow( $resultcat ) ) {
				$searchform .= '<option value="$categoryID">$categoryID : $name</option>';
			}
			$searchform .= '</select></td></tr>';
		}
		$searchform .= '<tr><td style="text-align: right; line-height: 200%">';
		$searchform .= _MD_IMGLOSSARY_TERM . '</td><td>&nbsp;</td><td style="text-align: left;">';
		$searchform .= '<input type="text" name="term" /></td></tr><tr>';
		$searchform .= '<td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" value="' . _MD_IMGLOSSARY_SEARCH . '" />';
		$searchform .= '</td></tr></form></table>';
		$xoopsTpl -> assign( 'searchform', $searchform );
 
 }
 ?>