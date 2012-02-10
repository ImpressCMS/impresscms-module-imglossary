<?php 
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: blocks/entries_top.php
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

function b_entries_top_show( $options )	{

	$words = icms::$xoopsDB -> query( "SELECT * FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . "" );
	$totalwords = icms::$xoopsDB -> getRowsNum( $words );

	$block = array();
	$sql = "SELECT entryID, term, counter FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE datesub<" . time() . " AND datesub>0 AND submit=0 AND offline=0 ORDER BY " . $options[0] . " DESC";
	$result = icms::$xoopsDB -> query( $sql, $options[1], 0 );

	if ( $totalwords > 0 ) {
		// If there are definitions
		while ( list( $entryID, $term, $counter ) = icms::$xoopsDB -> fetchRow( $result ) )	{
			$popentries = array();
			$linktext = icms_core_DataFilter::htmlSpecialchars( $term );
			$popentries['dir'] = basename( dirname( dirname( __FILE__ ) ) );
			$popentries['linktext'] = $linktext;
			$popentries['id'] = $entryID;
			$popentries['counter'] = "<span style='font-size: x-small;'>" . intval( $counter ) . "</span>";

			$block['popstuff'][] = $popentries;
		}
	}
	return $block;
}

function b_entries_top_edit( $options ) {

	$form = "" . _MB_IMGLOSSARY_ORDER . "&nbsp;<select name='options[]'>";
	$form .= "<option value='datesub'";

	if ( $options[0] == "datesub" ) {
		$form .= " selected='selected'";
	}
	$form .= ">" . _MB_IMGLOSSARY_DATE . "</option>\n";
	$form .= "<option value='counter'";

	if ( $options[0] == "counter" ) {
		$form .= " selected='selected'";
	}

	$form .= ">" . _MB_IMGLOSSARY_HITS . "</option>\n";
	$form .= "<option value='weight'";

	if ( $options[0] == "weight" ) {
		$form .= " selected='selected'";
	}

	$form .= ">" . _MB_IMGLOSSARY_WEIGHT . "</option>\n";
	$form .= "</select>\n";
	$form .= "&nbsp;" . _MB_IMGLOSSARY_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . _MB_IMGLOSSARY_TERMS . "";

	return $form;
}
?>