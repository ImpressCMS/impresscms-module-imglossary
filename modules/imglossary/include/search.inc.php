<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: include/search.inc.php
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

function imglossary_search( $queryarray, $andor, $limit, $offset, $userid )	{

	global $xoopsUser, $xoopsDB;
	
	$sql = "SELECT entryID, term, definition, ref, uid, datesub FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0";

	if ( $userid != 0 ) {
        $sql .= " AND uid=" . $userid . " ";
    }

	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if ( is_array( $queryarray ) && $count = count( $queryarray ) ) {
		$sql .= " AND ( ( term LIKE LOWER('%$queryarray[0]%') OR LOWER(definition) 
							   LIKE LOWER('%$queryarray[0]%') OR LOWER(ref) 
							   LIKE LOWER('%$queryarray[0]%') )";
		for ( $i = 1; $i < $count; $i++ ) {
			$sql .= " $andor ";
			$sql .= "( term LIKE LOWER('%$queryarray[$i]%') OR LOWER(definition) 
						    LIKE LOWER('%$queryarray[$i]%') OR LOWER(ref) 
						    LIKE LOWER('%$queryarray[$i]%') )";
		} 
		$sql .= ") ";
	} 
	$sql .= "ORDER BY entryID DESC";
	$result = $xoopsDB -> query( $sql, $limit, $offset );
    $ret = array();
    $i = 0;

	while ( $myrow = $xoopsDB -> fetchArray( $result ) ) {
		$ret[$i]['image'] = "images/imglossary.png";
		$ret[$i]['link'] = "entry.php?entryID=" . $myrow['entryID'];
		$ret[$i]['title'] = $myrow['term'];
		$ret[$i]['time'] = $myrow['datesub'];
		$ret[$i]['uid'] = $myrow['uid'];
		$i++;
	} 
	return $ret;
} 
?>