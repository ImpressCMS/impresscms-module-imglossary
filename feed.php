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

global $xoopsModuleConfig, $xoopsModule;

if ( $xoopsModuleConfig['rssfeed'] ) {

$myFeed = new IcmsFeed();

$myFeed -> webMaster = '';  // Admin contact email as stated in general preferences.
$myFeed -> image = array( 'url' => ICMS_ROOT_PATH . '/modules/' . $glossdirname . '/images/imglossary_iconsbig.png' );
$myFeed -> title = $xoopsConfig['sitename'] . ' : ' . $xoopsModule -> getVar( 'name' );

$sql = $xoopsDB -> query( 'SELECT * FROM ' . $xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE datesub<' . time() . ' AND datesub>0 AND (submit=0) ORDER BY datesub DESC ', $xoopsModuleConfig['rssfeedtotal'], 0 );
while ( $myrow = $xoopsDB -> fetchArray( $sql ) ) {	
	
	// First get the main category name of the term
	$sql2 = $xoopsDB -> query( 'SELECT name FROM ' . $xoopsDB -> prefix('imglossary_cats') . ' WHERE categoryID=' . $myrow['categoryID'] );
	$mycat = $xoopsDB -> fetchArray( $sql2 );
	$category = htmlspecialchars( $mycat['name'] );
		
	$title = htmlspecialchars( $myrow['term'] );
	$date  = formatTimestamp( $myrow['datesub'], 'D, d M Y H:i:s' );
	$text  = icms_substr( $myrow['definition'], 0, $xoopsModuleConfig['rndlength']-1, '...' );
	$text  = htmlspecialchars( $myts -> displayTarea( $text, $myrow['html'], $myrow['smiley'], $myrow['xcodes'], 1, $myrow['breaks'] ) );
	$link  = ICMS_URL . '/modules/' . $glossdirname . '/entry.php?entryID=' . intval( $myrow['entryID'] );
	
	// Get author of 
	$member_handler =& xoops_gethandler( 'member' );
	$user =& $member_handler -> getUser( $myrow['uid'] );
	if ( $myrow['uid'] == -1 ) {
		$author = _MD_IMGLOSSARY_ANONYMOUS;
	} else {
		$author = $user -> getVar( 'uname' );
	}

	$myFeed -> feeds[] = array (
		'title' 		=> $title,
		'link' 			=> $link,
		'description' 	=> $text,
		'pubdate' 		=> $date,
		'category'		=> $category,
		'author'		=> $author,
		'guid' 			=> $link
	);
}

$myFeed -> render();

} else { echo 'RSS feed for ' . $xoopsModule -> getVar( 'name' ) . ' is turned off.'; }

?>