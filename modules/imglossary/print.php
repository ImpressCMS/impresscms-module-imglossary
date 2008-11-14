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
	
	global $xoopsConfig, $xoopsDB, $xoopsModule, $xoopsModuleConfig, $myts;
	
	$result1 = $xoopsDB -> query( 'SELECT * FROM ' . $xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE entryID=' . $entryID . ' AND submit=0 ORDER BY datesub' );
	list( $entryID, $categoryID, $term, $init, $definition, $ref, $url, $uid, $submit, $datesub, $counter, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub ) = $xoopsDB -> fetchrow( $result1 );

	$result2 = $xoopsDB -> query( 'SELECT name FROM ' . $xoopsDB -> prefix ( 'imglossary_cats' ) . ' WHERE categoryID=' . $categoryID );
	list ($name) = $xoopsDB -> fetchRow( $result2 );

	$result3 = $xoopsDB -> query( 'SELECT name, uname FROM ' . $xoopsDB -> prefix( 'users' ) . ' WHERE uid=' . $uid );
	list( $authorname, $username ) = $xoopsDB -> fetchRow( $result3 );

	$datetime = formatTimestamp( $datesub, $xoopsModuleConfig['dateformat'] );
	$categoryname = $myts -> makeTboxData4Show( $name );
	$term = $myts -> makeTboxData4Show( $term );
	$definition = str_replace( "[pagebreak]", "<br style=\"page-break-after:always;\">", $definition );
	$definition = $myts -> displayTarea( $definition, $html, $smiley, $xcodes, 1, $breaks );
	
	if ( $authorname == '' ) {
		$authorname = $myts -> makeTboxData4Show( $username );
	} else {
		$authorname = $myts -> makeTboxData4Show( $authorname );
	}
	
	echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
	echo "<html>\n<head>\n";
	echo "<title>" . $xoopsConfig['sitename'] . "</title>\n";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
	echo "<meta name='ROBOTS' content='noindex,nofollow' />\n";
	echo "<meta name='AUTHOR' content='" . $xoopsConfig['sitename'] . "' />\n";
	echo "<meta name='COPYRIGHT' content='Copyright (c) " . formatTimestamp( time(), "Y" ) . " by " . $xoopsConfig['sitename'] . "' />\n";
	echo "<meta name='DESCRIPTION' content='" . $xoopsConfig['slogan'] . "' />\n";
	echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n\n\n";

	echo "<body bgcolor='#ffffff' text='#000000'>
			<font face='Verdana, Arial, Helvetica, sans-serif'>
			<div style='width: 650px; border: 1px solid #000; padding: 20px;'>
			<div style='text-align: center; display: block; padding-bottom: 12px; margin: 0 0 6px 0; border-bottom: 2px solid #ccc;'><img src='" . ICMS_URL . "/modules/" . $glossdirname . "/images/imglossary_logo.png' border='0' alt='' /><h2 style='margin: 0;'>" . $term . "</h2></div><div></div>";
	if ( $xoopsModuleConfig['multicats'] == 1 )	{
		echo "<div>" . _MD_IMGLOSSARY_ENTRYCATEGORY . "<b>" . $categoryname . "</b></div>";
	}
	echo "<div style='padding-bottom: 6px; border-bottom: 1px solid #ccc;'>" . _MD_IMGLOSSARY_SUBMITTER . "<b>" . $authorname . "</b></div>
			<h3 style='margin: 0;'>" . $term . "</h3>
			<p>" . $definition . "</p>
			<div style='padding-top: 12px; border-top: 2px solid #ccc;'><b>" . _MD_IMGLOSSARY_SENT . "</b>&nbsp;" . $datetime . "<br /></div>
			</div>
			<br />
			</font>
		  </body>
		  </html>";
}

printPage( $entryID );

?>