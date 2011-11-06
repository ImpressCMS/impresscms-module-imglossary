<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: print.php
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
 
include 'header.php';

foreach ( $_POST as $k => $v ) {
	${$k} = $v;
}

foreach ( $_GET as $k => $v )	{
	${$k} = $v;
}

if ( empty( $entryID ) ) {
	redirect_header( 'index.php' );
}

function printPage( $entryID ) {

	$glossdirname = basename( dirname( __FILE__ ) );
	
	global $icmsConfig;
	
	$result1 = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE entryID=' . $entryID . ' AND submit=0 ORDER BY datesub' );
	list( $entryID, $categoryID, $term, $init, $definition, $ref, $url, $uid, $submit, $datesub, $counter, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub ) = icms::$xoopsDB -> fetchrow( $result1 );

	$result2 = icms::$xoopsDB -> query( 'SELECT name FROM ' . icms::$xoopsDB -> prefix ( 'imglossary_cats' ) . ' WHERE categoryID=' . $categoryID );
	list ($name) = icms::$xoopsDB -> fetchRow( $result2 );

	$result3 = icms::$xoopsDB -> query( 'SELECT name, uname FROM ' . icms::$xoopsDB -> prefix( 'users' ) . ' WHERE uid=' . $uid );
	list( $authorname, $username ) = icms::$xoopsDB -> fetchRow( $result3 );

	$datetime = formatTimestamp( $datesub, icms::$module -> config['dateformat'] );
	$categoryname = icms_core_DataFilter::htmlSpecialchars( $name );
	$term = icms_core_DataFilter::htmlSpecialchars( $term );
	$definition = str_replace( '[pagebreak]', '<br style="page-break-after:always;">', $definition );
	$definition = icms_core_DataFilter::htmlSpecialchars( $definition, $html, $smiley, $xcodes, 1, $breaks );
	
	if ( $authorname == '' ) {
		$authorname = icms_core_DataFilter::htmlSpecialchars( $username );
	} else {
		$authorname = icms_core_DataFilter::htmlSpecialchars( $authorname );
	}
	
	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
	echo '<html><head>';
	echo '<title>' . $icmsConfig['sitename'] . '</title>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=' . _CHARSET . '" />';
	echo '<meta name="robots" content="noindex,nofollow" />';
	echo '<meta name="author" content="' . $icmsConfig['sitename'] . '" />';
	echo '<meta name="copyright" content="Copyright (c) ' . formatTimestamp( time(), 'Y' ) . ' by ' . $icmsConfig['sitename'] . '" />';
	echo '<meta name="description" content="' . $icmsConfig['slogan'] . '" />';
	echo '<meta name="generator" content="' . ICMS_VERSION . '" />';

	echo '<body bgcolor="#ffffff" text="#000000">
			<font face="Verdana, Arial, Helvetica, sans-serif">
			<div style="width: 650px; border: 1px solid #000; padding: 20px;">
			  <div style="text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;">
			    <img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/imglossary_logo.png" border="0" alt="" />
			    <h2 style="margin: 0;">' . $term . '</h2>
			  </div>
			  <div>
			</div>';
		
	if ( icms::$module -> config['multicats'] == 1 )	{
		echo '<div>' . _MD_IMGLOSSARY_ENTRYCATEGORY . '<b>' . $categoryname . '</b></div>';
	}
	echo '<div style="padding-bottom: 6px; border-bottom: 1px solid #ccc;">' . _MD_IMGLOSSARY_SUBMITTER . '<b>' . $authorname . '</b></div><br />
			<h3 style="margin: 0;">' . $term . '</h3>
			<p>' . $definition . '</p>
			<div style="padding-top: 12px; border-top: 2px solid #ccc;">
			 <b>' . _MD_IMGLOSSARY_SENT . '</b>' . $datetime . '<br />
			</div>
			</div>
			<br />
			</font>
		  </body>
		  </html>';
}

printPage( intval( $entryID ) );
?>