<?php
/**
 * $Id: entry.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

// -- General Stuff -- //
include 'admin_header.php';

$op = '';

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];

// -- Edit function -- //
function entryEdit( $entryID = '' ) {
	global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule; 

	/**
	 * Clear all variables before we start
	 */
	if( !isset($block) ) { $block = 1; }
	if( !isset($html) ) { $html = 1; }
	if( !isset($smiley) ) { $smiley = 1; }
	if( !isset($xcodes) ) { $xcodes = 1; }
	if( !isset($breaks) ) { $breaks = 1; }
	if( !isset($offline) ) { $offline = 0; }
	if( !isset($submit) ) { $submit = 0; }
	if( !isset($request) ) { $request = 0; }
	if( !isset($notifypub) ) { $notifypub = 1; }
	if( !isset($categoryID) ) { $categoryID = 1; }
	if( !isset($term) ) { $term = ""; }
	if( !isset($definition) ) {	$definition = _AM_IMGLOSSARY_WRITEHERE;	}
	if( !isset($ref) ) { $ref = ""; }
	if( !isset($url) ) { $url = ""; }

	// If there is a parameter, and the id exists, retrieve data: we're editing an entry
	if ( $entryID )	{
		$result = $xoopsDB -> query( "SELECT categoryID, term, definition, ref, url, uid, submit, datesub, html, smiley, xcodes, breaks, block, offline, notifypub, request FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE entryID=$entryID" );
		list( $categoryID, $term, $definition, $ref, $url, $uid, $submit, $datesub, $html, $smiley, $xcodes, $breaks, $block, $offline, $notifypub, $request ) = $xoopsDB -> fetchrow( $result );

		if ( !$xoopsDB -> getRowsNum( $result ) ) {
			redirect_header( "index.php", 1, _AM_IMGLOSSARY_NOENTRYTOEDIT );
			exit();
		}
		imglossary_adminMenu( _AM_IMGLOSSARY_ENTRIES );

		echo "<h3 style=\"color: #2F5376; margin-top: 6px; \">" . _AM_IMGLOSSARY_ADMINENTRYMNGMT . "</h3>";
		$sform = new XoopsThemeForm( _AM_IMGLOSSARY_MODENTRY . ": $term" , "op", xoops_getenv( 'PHP_SELF' ) );
	} else {
		// there's no parameter, so we're adding an entry

		$result01 = $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " " );
        list( $totalcats ) = $xoopsDB -> fetchRow( $result01 );
		if ( $totalcats == 0 && $xoopsModuleConfig['multicats'] == 1 ) {
			redirect_header( "index.php", 1, _AM_IMGLOSSARY_NEEDONECOLUMN );
			exit();
		}
		imglossary_adminMenu( _AM_IMGLOSSARY_ENTRIES );
		$uid = $xoopsUser -> getVar('uid');
		echo "<h3 style=\"color: #2F5376; margin-top: 6px; \">" . _AM_IMGLOSSARY_ADMINENTRYMNGMT . "</h3>";
		$sform = new XoopsThemeForm( _AM_IMGLOSSARY_NEWENTRY, "op", xoops_getenv( 'PHP_SELF' ) );
	} 

	$sform -> setExtra( 'enctype="multipart/form-data"' );

	// Category selector
	if ( $xoopsModuleConfig['multicats'] == 1 ) {
		$mytree = new XoopsTree( $xoopsDB -> prefix( 'imglossary_cats' ), 'categoryID' , '0' );

		ob_start();
			//$sform -> addElement( new XoopsFormHidden( 'categoryID', $categoryID ) );
			$mytree -> makeMySelBox( 'name', 'name', 0, 0 );
			$sform -> addElement( new XoopsFormLabel( _AM_IMGLOSSARY_CATNAME, ob_get_contents() ) );
		ob_end_clean();
	}

	// Author selector
	ob_start();
		imglossary_getuserForm( intval($uid) );
		$sform -> addElement( new XoopsFormLabel( _AM_IMGLOSSARY_AUTHOR, ob_get_contents() ) );
	ob_end_clean();

	// Term, definition, reference and related URL
	$sform -> addElement( new XoopsFormText( _AM_IMGLOSSARY_ENTRYTERM, 'term', 80, 80, $term ), true );

	$def_block = new XoopsFormDhtmlTextArea( _AM_IMGLOSSARY_ENTRYDEF, 'definition', $definition, 15, 60 );
	if ( $definition == ' . _MD_WB_WRITEHERE . ' ) {
		$def_block -> setExtra( 'onfocus="this.select()"' );
	}
	$sform -> addElement( $def_block );
	$sform -> addElement( new XoopsFormTextArea( _AM_IMGLOSSARY_ENTRYREFERENCE, 'ref', $ref, 5, 60 ), false );
	$sform -> addElement( new XoopsFormText( _AM_IMGLOSSARY_ENTRYURL, 'url', 80, 80, $url ), false );

	// Code to take entry offline, for maintenance purposes
	$offline_radio = new XoopsFormRadioYN( _AM_IMGLOSSARY_SWITCHOFFLINE, 'offline', $offline, ' ' . _YES . '', ' ' ._NO . '' );
	$sform -> addElement( $offline_radio );

	// Code to put entry in block
	$block_radio = new XoopsFormRadioYN( _AM_IMGLOSSARY_BLOCK, 'block', $block, ' ' . _YES . '', ' ' . _NO . '' );
	$sform -> addElement( $block_radio );

	// VARIOUS OPTIONS
	$options_tray = new XoopsFormElementTray( _AM_IMGLOSSARY_OPTIONS, '<br />' );

	$html_checkbox = new XoopsFormCheckBox( '', 'html', $html );
	$html_checkbox -> addOption( 1, _AM_IMGLOSSARY_DOHTML );
	$options_tray -> addElement( $html_checkbox );

	$smiley_checkbox = new XoopsFormCheckBox( '', 'smiley', $smiley );
	$smiley_checkbox -> addOption( 1, _AM_IMGLOSSARY_DOSMILEY );
	$options_tray -> addElement( $smiley_checkbox );

	$xcodes_checkbox = new XoopsFormCheckBox( '', 'xcodes', $xcodes );
	$xcodes_checkbox -> addOption( 1, _AM_IMGLOSSARY_DOXCODE );
	$options_tray -> addElement( $xcodes_checkbox );

	$breaks_checkbox = new XoopsFormCheckBox( '', 'breaks', $breaks );
	$breaks_checkbox -> addOption( 1, _AM_IMGLOSSARY_BREAKS );
	$options_tray -> addElement( $breaks_checkbox );

	$sform -> addElement( $options_tray );

	$sform -> addElement( new XoopsFormHidden( 'entryID', $entryID ) );

	$button_tray = new XoopsFormElementTray( '', '' );
	$hidden = new XoopsFormHidden( 'op', 'addentry' );
	$button_tray -> addElement( $hidden );

	if ( !$entryID ) {
		// there's no entryID? Then it's a new entry
		
		$butt_create = new XoopsFormButton( '', '', _AM_IMGLOSSARY_CREATE, 'submit' );
		$butt_create -> setExtra( 'onclick="this.form.elements.op.value=\'addentry\'"' );
		$button_tray -> addElement( $butt_create );

		$butt_clear = new XoopsFormButton( '', '', _AM_IMGLOSSARY_CLEAR, 'reset' );
		$button_tray -> addElement( $butt_clear );

		$butt_cancel = new XoopsFormButton( '', '', _AM_IMGLOSSARY_CANCEL, 'button' );
		$butt_cancel -> setExtra( 'onclick="history.go(-1)"' );
		$button_tray -> addElement( $butt_cancel );
		
	} else { 
		
		// else, we're editing an existing entry
		$butt_create = new XoopsFormButton( '', '', _AM_IMGLOSSARY_MODIFY, 'submit' );
		$butt_create -> setExtra( 'onclick="this.form.elements.op.value=\'addentry\'"' );
		$button_tray -> addElement( $butt_create );

		$butt_cancel = new XoopsFormButton( '', '', _AM_IMGLOSSARY_CANCEL, 'button' );
		$butt_cancel -> setExtra( 'onclick="history.go(-1)"' );
		$button_tray -> addElement( $butt_cancel );
		
	}

	$sform -> addElement( $button_tray );
	$sform -> display();
	unset( $hidden );
} 

function entrySave( $entryID = '' )	{
	global $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsDB, $myts;
	$entryID = isset($_POST['entryID']) ? intval($_POST['entryID']) : intval($_GET['entryID']);
	if ($xoopsModuleConfig['multicats'] == 1) {
		$categoryID = isset($_POST['categoryID']) ? intval($_POST['categoryID']) : intval($_GET['categoryID']);
	} else { 
		$categoryID = '';
	}
	$block = isset($_POST['block']) ? intval($_POST['block']) : intval($_GET['block']);
//	$breaks = isset($_POST['breaks']) ? intval($_POST['breaks']) : intval($_GET['breaks']);

//	$html = isset($_POST['html']) ? intval($_POST['html']) : intval($_GET['html']);
//	$smiley = isset($_POST['smiley']) ? intval($_POST['smiley']) : intval($_GET['smiley']);
//	$xcodes = isset($_POST['xcodes']) ? intval($_POST['xcodes']) : intval($_GET['xcodes']);
	$offline = isset($_POST['offline']) ? intval($_POST['offline']) : intval($_GET['offline']);
	
	$html = ( isset( $_REQUEST["html"] ) ) ? $_REQUEST["html"] : 1;
    $smiley = ( isset( $_REQUEST["smiley"] ) ) ? $_REQUEST["smiley"] : 1;
    $xcodes = ( isset( $_REQUEST["xcodes"] ) ) ? $_REQUEST["xcodes"] : 1;
    $breaks = isset( $_REQUEST['breaks'] );

	$term = $myts -> addSlashes( $_POST['term'] );
	$init = substr( $term, 0, 1 );

	if ( ereg( "[a-zA-Z]", $init ) ) {
		$init = strtoupper($init);
	} else {
		$init = '#';
	}

	$definition = $myts -> addslashes( trim( $_POST["definition"] ) );
	$ref = isset( $_POST['ref'] ) ? $myts -> addSlashes( $_POST['ref'] ) : '';
	$url = isset( $_POST['url'] ) ? $myts -> addSlashes( $_POST['url'] ) : '';

	$date = time();
	$submit = 0;
	$notifypub = 0;
	$request = 0;
	$uid = isset( $_POST['author'] ) ? intval( $_POST['author'] ) : $xoopsUser -> uid();
	
// Save to database
	if ( !$entryID ) {
		if ( $xoopsDB -> query( "INSERT INTO " . $xoopsDB -> prefix( 'imglossary_entries' ) . " (entryID, categoryID, term, init, definition, ref, url, uid, submit, datesub, html, smiley, xcodes, breaks, block, offline, notifypub, request ) VALUES ('', '$categoryID', '$term', '$init', '$definition', '$ref', '$url', '$uid', '$submit', '$date', '$html', '$smiley', '$xcodes', '$breaks', '$block', '$offline', '$notifypub', '$request' )" ) ) {
			imglossary_calculateTotals();
			redirect_header( "index.php", 1, _AM_IMGLOSSARY_ENTRYCREATEDOK );
		} else {
			redirect_header( "index.php", 1, _AM_IMGLOSSARY_ENTRYNOTCREATED );
		}
	} else { 
		// That is, $entryID exists, thus we're editing an entry
		
		if ( $xoopsDB -> query( "UPDATE " . $xoopsDB -> prefix( 'imglossary_entries' ) . " SET term='$term', categoryID='$categoryID', init='$init', definition='$definition', ref='$ref', url='$url', uid='$uid', submit='$submit', datesub='$date', html='$html', smiley='$smiley', xcodes='$xcodes', breaks='$breaks', block='$block', offline='$offline', notifypub='$notifypub', request='$request' WHERE entryID='$entryID'" ) ) {
			imglossary_calculateTotals();
			redirect_header( "index.php", 1, _AM_IMGLOSSARY_ENTRYMODIFIED );
		} else {
			redirect_header( "index.php", 1, _AM_IMGLOSSARY_ENTRYNOTUPDATED );
		}
	}
}

function entryDelete( $entryID = '' ) {
	global $xoopsDB, $xoopsModule;
	$entryID = isset( $_POST['entryID'] ) ? intval( $_POST['entryID'] ) : intval( $_GET['entryID'] );
	$ok = isset( $_POST['ok'] ) ? intval( $_POST['ok'] ) : 0;
	$result = $xoopsDB -> query( "SELECT entryID, term FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE entryID=$entryID" );
	list( $entryID, $term ) = $xoopsDB -> fetchrow( $result );

	// confirmed, so delete 
	if ( $ok == 1 ) {
		$result = $xoopsDB -> query( "DELETE FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE entryID=$entryID" );
		// delete comments (mondarse)
		xoops_comment_delete( $xoopsModule -> getVar('mid'), $entryID );
		// delete comments (mondarse)
		redirect_header( "index.php", 1, sprintf( _AM_IMGLOSSARY_ENTRYISDELETED, $term ) );
	} else {
		xoops_cp_header();
		xoops_confirm( array( 'op' => 'del', 'entryID' => $entryID, 'ok' => 1, 'term' => $term ), 'entry.php', _AM_IMGLOSSARY_DELETETHISENTRY . "<br /><br />" . $term, _AM_IMGLOSSARY_DELETE );
		xoops_cp_footer();
	}
	exit();
	break;
} 

function entryDefault()	{
	xoops_cp_header();
	entryEdit();
}

/* -- Available operations -- */
switch ( $op ) {
    case "mod":
		xoops_cp_header();
		$entryID = ( isset( $_GET['entryID'] ) ) ? intval( $_GET['entryID'] ) : intval( $_POST['entryID'] );
		entryEdit($entryID);
		break;

	case "addentry":
		entrySave();
		exit();
		break;

	case "del":
		entryDelete();

	case "default":
	default:
		entryDefault();
		break;
} 

xoops_cp_footer();

?>