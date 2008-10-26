<?php 
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: blocks/entries_new.php
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
 
function b_entries_new_show( $options )	{

	$glossdirname = basename( dirname( dirname( __FILE__ ) ) );
	
	global $xoopsDB, $xoopsUser;
	$myts = & MyTextSanitizer :: getInstance();

	$words = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "" );
	$totalwords = $xoopsDB -> getRowsNum( $words );

	$block = array();
	$sql = "SELECT entryID, term, datesub FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE datesub<" . time() . " AND datesub>0 AND submit=0 AND offline=0 ORDER BY " . $options[0] . " DESC";
	$result = $xoopsDB -> query( $sql, $options[1], 0 );

	$hModule =& xoops_gethandler( 'module' );
	$hModConfig =& xoops_gethandler( 'config' );
	$wbModule =& $hModule -> getByDirname( $glossdirname );
	$module_id = $wbModule -> getVar( 'mid' );
	$module_name = $wbModule -> getVar( 'dirname' );
	$wbConfig =& $hModConfig -> getConfigsByCat( 0, $wbModule -> getVar( 'mid' ) );

	if ( $totalwords > 0 ) {
		// If there are definitions
		while ( list( $entryID, $term, $datesub ) = $xoopsDB -> fetchRow( $result ) ) {
			$newentries = array();
			$xoopsModule = XoopsModule::getByDirname( $glossdirname );
			$linktext = $myts -> makeTboxData4Show( $term );
			$newentries['dir'] = $xoopsModule -> dirname();
			$newentries['linktext'] = $linktext;
			$newentries['id'] = $entryID;
			$newentries['date'] = "<span style='font-size: x-small;'>" . formatTimestamp( $datesub, $options[2] ) . "</span>";

			$block['newstuff'][] = $newentries;
		} 
	}
	return $block;
} 

function b_entries_new_edit( $options )	{
	$form = "" . _MB_IMGLOSSARY_ORDER . "&nbsp;<select name='options[]'>";

	$form .= "<option value='datesub'";
	if ( $options[0] == "datesub" )	{
		$form .= " selected='selected'";
	} 
	
	$form .= ">" . _MB_IMGLOSSARY_DATE . "</option>\n";
	$form .= "<option value='counter'";
	
	if ( $options[0] == "counter" )	{
		$form .= " selected='selected'";
	} 
	
	$form .= ">" . _MB_IMGLOSSARY_HITS . "</option>\n";
	$form .= "<option value='weight'";
	if ( $options[0] == "weight" ) {
		$form .= " selected='selected'";
	} 
	
	$form .= ">" . _MB_IMGLOSSARY_WEIGHT . "</option>\n";
	$form .= "</select>\n";
	$form .= "&nbsp;<br />" . _MB_IMGLOSSARY_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . _MB_IMGLOSSARY_TERMS . "";
	$form .= "&nbsp;<br />" . _MB_IMGLOSSARY_DATEFORMAT . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_IMGLOSSARY_DATEFORMATMANUAL;

	return $form;
} 
?>