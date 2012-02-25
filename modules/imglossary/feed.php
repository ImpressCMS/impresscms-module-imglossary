<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: feed.php
*
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		imGlossary
* @since		1.00
* @author		McDonald
* @version		$Id$
*/

include 'header.php';
include_once ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/class/icmsfeed.php'; 

global $icmsConfig;

if ( icms::$module -> config['rssfeed'] ) {

	$myFeed = new icmsFeed();
	$myFeed -> webMaster = $icmsConfig['adminmail']; // Admin contact email as stated in general preferences.
	$myFeed -> editor = $icmsConfig['adminmail'];
	$myFeed -> image = array( 'url' => ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/imglossary_iconsbig.png' );
	$myFeed -> width  = 32; // max. width  = 144px
	$myFeed -> height = 32; // max. height = 400px
	$myFeed -> title = $icmsConfig['sitename'];
	$myFeed -> generator = ICMS_VERSION_NAME . ' (module: imGlossary ' . number_format( icms::$module -> getVar( 'version' ) / 100 , 2, '.', '' ) . ')';
	$myFeed -> category = icms::$module -> getVar( 'name' );
	$myFeed -> ttl = 60;
	$myFeed -> copyright = 'Copyright ' . formatTimestamp( time(), 'Y' ) . ' - ' . $icmsConfig['sitename'];

	$sql = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE datesub<' . time() . ' AND datesub>0 AND (submit=0) ORDER BY datesub DESC ', icms::$module -> config['rssfeedtotal'], 0 );
	while ( $myrow = icms::$xoopsDB -> fetchArray( $sql ) ) {

		// First get the main category name of the term
		$sql2 = icms::$xoopsDB -> query( 'SELECT name FROM ' . icms::$xoopsDB -> prefix('imglossary_cats') . ' WHERE categoryid=' . $myrow['categoryid'] );
		$mycat = icms::$xoopsDB -> fetchArray( $sql2 );
		$category = htmlspecialchars( $mycat['name'] );

		$title = htmlspecialchars( $myrow['term'] );
		$date  = formatTimestamp( $myrow['datesub'], 'r' );
		$text  = icms_core_DataFilter::icms_substr( $myrow['definition'], 0, icms::$module -> config['rndlength'], '...' );
		$text  = htmlspecialchars( $text );
		$link  = ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/entry.php?entryid=' . $myrow['entryid'];

		// Get author of 
		$member_handler = icms::handler( 'icms_member' );
		$user =& $member_handler -> getUser( $myrow['uid'] );
		if ( $myrow['uid'] == -1 ) {
			$author = _MD_IMGLOSSARY_ANONYMOUS;
		} else {
			$author = icms::$user -> getVar( 'uname' );
		}

		$myFeed -> feeds[] = array (
			'title' 		=> $title,
			'link'			=> $link,
			'description'	=> $text,
			'pubdate' 		=> $date,
			'category'		=> $category,
			'author'		=> $author,
			'guid'			=> $link
		);
	}

	$myFeed -> render();

} else {

	echo 'RSS feed for ' . icms::$module -> getVar( 'name' ) . ' is turned off.';

}
?>