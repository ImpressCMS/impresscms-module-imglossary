<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: feed.php
*
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		imGlossary
* @since			1.00
* @author		McDonald
* @version		$Id$
*/

include 'header.php';	
include_once ICMS_ROOT_PATH . '/class/icmsfeed.php'; 

global $xoopsModuleConfig;

$myFeed = new IcmsFeed();

$myFeed -> webMaster = '';  // Admin contact email as stated in general preferences.

$sql = $xoopsDB -> query( 'SELECT * FROM ' . $xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE datesub<' . time() . ' AND datesub>0 AND (submit=0) ORDER BY datesub DESC ', 10, 0 );

    while ( $myrow = $xoopsDB -> fetchArray( $sql ) ) {	
		
		$date = formatTimestamp( $myrow['datesub'], $xoopsModuleConfig['dateformat'] );
		$text = icms_substr( $myrow['definition'], 0, $xoopsModuleConfig['rndlength']-1, '...' );
		$text = $myts -> displayTarea( $text, $myrow['html'], $myrow['smiley'], $myrow['xcodes'], 1, $myrow['breaks'] );

		$myFeed -> feeds[] = array (
			'title' 		=> $myrow['term'],
			'link' 			=> ICMS_URL . '/modules/' . $glossdirname . '/entry.php?entryID=' . intval( $myrow['entryID'] ),
			'description' 	=> $text,
			'pubdate' 		=> $date,
			'guid' 			=> $myrow['url']
			);
	}
	
$myFeed -> render(); 

?>