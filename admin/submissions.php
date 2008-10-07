<?php
/**
 * $Id: submissions.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

// -- General Stuff -- //
include 'admin_header.php';
$myts =& MyTextSanitizer::getInstance();
$op = '';

foreach ( $_POST as $k => $v ) {
	${$k} = $v;
} 

foreach ( $_GET as $k => $v ) {
	${$k} = $v;
} 

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];

// -- Edit function -- //
function editentry( $entryID = '' ) {
	// Initialize all variables before we start
	$block = 1;
	$html = 1;
	$smiley = 1;
	$xcodes = 1;
	$breaks = 1;
	$offline = 1;
	$submit = 1;
	$categoryID = 0;
	$term = '';
	$definition = '';
	$ref = '';
	$url = '';

	global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule, $myts; 

	include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

	// Since this is a submission, the id exists, so retrieve data: we're editing an entry
	$result = $xoopsDB -> query( "SELECT categoryID, term, definition, ref, url, uid, submit, datesub, html, smiley, xcodes, breaks, block, offline, notifypub FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE entryID='$entryID'" );
	list( $categoryID, $term, $definition, $ref, $url, $uid, $submit, $datesub, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub ) = $xoopsDB -> fetchrow( $result );

	$query = $xoopsDB -> query ( "SELECT name FROM " . $xoopsDB -> prefix ( 'imglossary_cats' ) . " WHERE categoryID=$categoryID ");
	list($name) = $xoopsDB -> fetchRow( $query );

	if ( $xoopsDB -> getRowsNum( $result ) == 0 ) {
		redirect_header( "index.php", 1, _AM_WB_NOARTTOEDIT );
		exit();
	}
	adminMenu( 3, _AM_WB_SUBMITS . " > '" . $term . "'" );
	echo "<h3 style=\"color: #2F5376; margin-top: 6px; \">" . _AM_WB_ADMINENTRYMNGMT . "</h3>";
	$sform = new XoopsThemeForm( _AM_WB_AUTHENTRY . ": $term" , "op", xoops_getenv( 'PHP_SELF' ) );

	$sform -> setExtra( 'enctype="multipart/form-data"' );

	if ( $xoopsModuleConfig['multicats'] == 1 )	{
		$mytree = new XoopsTree( $xoopsDB -> prefix( 'imglossary_cats' ), "categoryID" , "0" );

		ob_start();
			$sform -> addElement( new XoopsFormHidden( 'categoryID', $categoryID ) );
			$mytree -> makeMySelBox( "name", "name", $categoryID );
			$sform -> addElement( new XoopsFormLabel( _AM_WB_CATNAME, ob_get_contents() ) );
		ob_end_clean();
		}

// Author selector
	ob_start();
		getuserForm( intval($uid) );
		$sform -> addElement( new XoopsFormLabel( _AM_WB_AUTHOR, ob_get_contents() ) );
	ob_end_clean();

	$term = $myts -> htmlspecialchars( stripSlashes( $term ) );
	$sform -> addElement( new XoopsFormText( _AM_WB_ENTRYTERM, 'term', 50, 80, $term ), true );
	$sform -> addElement( new XoopsFormDhtmlTextArea( _AM_WB_ENTRYDEF, 'definition', $definition, 15, 60 ) );
	$sform -> addElement( new XoopsFormTextArea( _AM_WB_ENTRYREFERENCE, 'ref', $ref, 5, 60 ), false );
	$sform -> addElement( new XoopsFormText( _AM_WB_ENTRYURL, 'url', 50, 80, $url ), false );

	// Code to take entry offline, for maintenance purposes
	$offline_radio = new XoopsFormRadioYN( _AM_WB_SWITCHOFFLINE, 'offline', $offline, ' ' . _AM_WB_YES . '', ' ' . _AM_WB_NO . '' );
	$sform -> addElement( $offline_radio );

	// Code to put entry in block
	$block_radio = new XoopsFormRadioYN( _AM_WB_BLOCK, 'block', $block , ' ' . _AM_WB_YES . '', ' ' . _AM_WB_NO . '' );
	$sform -> addElement( $block_radio );

	$options_tray = new XoopsFormElementTray( _AM_WB_OPTIONS, '<br />' );

	$html_checkbox = new XoopsFormCheckBox( '', 'html', $html );
	$html_checkbox -> addOption( 1, _AM_WB_DOHTML );
	$options_tray -> addElement( $html_checkbox );

	$smiley_checkbox = new XoopsFormCheckBox( '', 'smiley', $smiley );
	$smiley_checkbox -> addOption( 1, _AM_WB_DOSMILEY );
	$options_tray -> addElement( $smiley_checkbox );

	$xcodes_checkbox = new XoopsFormCheckBox( '', 'xcodes', $xcodes );
	$xcodes_checkbox -> addOption( 1, _AM_WB_DOXCODE );
	$options_tray -> addElement( $xcodes_checkbox );

	$breaks_checkbox = new XoopsFormCheckBox( '', 'breaks', $breaks );
	$breaks_checkbox -> addOption( 1, _AM_WB_BREAKS );
	$options_tray -> addElement( $breaks_checkbox );

	$sform -> addElement( $options_tray );

	$sform -> addElement( new XoopsFormHidden( 'entryID', $entryID ) );
	$sform -> addElement( new XoopsFormHidden( 'uid', $uid ) );

	$button_tray = new XoopsFormElementTray( '', '' );
	$hidden = new XoopsFormHidden( 'op', 'authentry' );
	$button_tray -> addElement( $hidden );

	$butt_save = new XoopsFormButton( '', '', _AM_WB_AUTHORIZE, 'submit' );
	$butt_save->setExtra('onclick="this.form.elements.op.value=\'authentry\'"');
	$button_tray->addElement( $butt_save );

	$butt_cancel = new XoopsFormButton( '', '', _AM_WB_CANCEL, 'button' );
	$butt_cancel->setExtra('onclick="history.go(-1)"');
	$button_tray->addElement( $butt_cancel );

	$sform -> addElement( $button_tray );
	$sform -> display();
	unset( $hidden );
} 

/* -- Available operations -- */
switch ( $op ) {
    case "mod":
		xoops_cp_header();
		global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule, $myts;
		$entryID = ( isset( $_POST['entryID'] ) ) ? $_POST['entryID'] : $entryID;
		editentry( $entryID );
		break;

	case "authentry":
		global $xoopsUser, $xoopsConfig, $xoopsDB, $myts;

		$entryID = ( isset( $_POST['entryID'] ) ) ? intval( $_POST['entryID'] ) : 0;
		$categoryID = ( isset( $_POST['categoryID'] ) ) ? intval( $_POST['categoryID'] ) : 0;
		$block = ( isset( $_POST['block'] ) ) ? intval( $_POST['block'] ) : 1;
		$offline = ( isset( $_POST['offline'] ) ) ? intval( $_POST['offline'] ) : 0;
		$breaks = ( isset( $_POST['breaks'] ) ) ? intval( $_POST['breaks'] ) : 1;
		$html = ( isset( $_POST['html'] ) ) ? intval( $_POST['html'] ) : 1;
		$smiley = ( isset( $_POST['smiley'] ) ) ? intval( $_POST['smiley'] ) : 1;
		$xcodes = ( isset( $_POST['xcodes'] ) ) ? intval( $_POST['xcodes'] ) : 1;
		$uid = ( isset( $_POST['uid'] ) ) ? intval( $_POST['uid'] ) : 1;
		$term = $myts -> htmlSpecialChars( $_POST['term'] );
		$definition = $myts -> addSlashes( $_POST['definition'] );
		$ref = $myts -> addSlashes( $_POST['ref'] );
		$url = $myts -> addSlashes( $_POST['url'] );

		$notifypub = ( isset( $_POST['notifypub'] ) ) ? intval( $_POST['notifypub'] ) : 1;

		$submit = 0;
		$offline = 0;
		$request = 0;
		$date = time();

		if ( $xoopsDB -> query( "UPDATE " . $xoopsDB -> prefix( 'imglossary_entries' ) . " SET term='$term', categoryID='$categoryID', definition='$definition', ref='$ref', url='$url', uid='$uid', submit='$submit', datesub='$date', html='$html', smiley='$smiley', xcodes='$xcodes', breaks='$breaks', block='$block', offline='$offline', notifypub='$notifypub', request='$request' WHERE entryID='$entryID'" ) )	{
			redirect_header( "index.php", 1, _AM_WB_ENTRYAUTHORIZED );
		} else {
			redirect_header( "index.php", 1, _AM_WB_ENTRYNOTUPDATED );
		}
		exit();
		break;

	case "del":
		global $xoopsUser, $xoopsConfig, $xoopsDB;
		$confirm = ( isset( $confirm ) ) ? 1 : 0;

		if ( $confirm )	{
			$xoopsDB -> query( "DELETE FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE entryID=$entryID" );
			// delete comments (mondarse)
			xoops_comment_delete( $xoopsModule -> getVar('mid'), $entryID );
			// delete comments (mondarse)
			redirect_header( "index.php", 1, sprintf( _AM_WB_ENTRYISDELETED, $term ) );
			exit();
		} else {
			$entryID = ( isset( $_GET['entryID'] ) ) ? intval( $_GET['entryID'] ) : $entryID;
			$result = $xoopsDB -> query( "SELECT entryID, term FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE entryID=$entryID" );
			list( $entryID, $term ) = $xoopsDB -> fetchrow( $result );
			xoops_cp_header();
			xoops_confirm( array( 'op' => 'del', 'entryID' => $entryID, 'confirm' => 1, 'term' => $term ), 'submissions.php', _AM_WB_DELETETHISENTRY . "<br /><br>" . $term, _AM_WB_DELETE );
			xoops_cp_footer();
		} 
		exit();
        break;

	case "default":
	default:
		xoops_cp_header();
		adminMenu( 3, _AM_WB_SUBMITS );
		echo "<br />";
//		showSubmissions();				##  UNKNOWN FUNCTION!!!  ##
		exit();
		break;
	} 
xoops_cp_footer();

?>