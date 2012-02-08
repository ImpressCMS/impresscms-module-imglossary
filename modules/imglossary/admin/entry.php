<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: admin/entry.php
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

// -- General Stuff -- //
include 'admin_header.php';

$op = '';

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];

// -- Edit function -- //
function entryEdit( $entryID = 0 ) {
	global $icmsConfig, $imglmyts; 

	$sql = 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE entryID=' . $entryID;
    if ( !$result = icms::$xoopsDB -> query( $sql ) ) {
        icms::$logger -> handleError( E_USER_WARNING, $sql, __FILE__, __LINE__ );
        return false;
    } 
    $entry_array = icms::$xoopsDB -> fetchArray( icms::$xoopsDB -> query( $sql ) );
	
	$categoryID = $entry_array['categoryID'] ? $entry_array['categoryID'] : 0;
	$term = $entry_array['term'] ? $imglmyts -> htmlSpecialCharsStrip( $entry_array['term'] ) : '';
	$definition = $entry_array['definition'] ? $imglmyts -> htmlSpecialCharsStrip( $entry_array['definition'] ) : '';
    $ref = $entry_array['ref'] ? $imglmyts -> htmlSpecialCharsStrip( $entry_array['ref'] ) : '';
    $url = $entry_array['url'] ? $imglmyts -> htmlSpecialCharsStrip( $entry_array['url'] ) : '';
	$uid = $entry_array['uid'] ? $entry_array['uid'] : 0;
	$submit = $entry_array['submit'] ? $entry_array['submit'] : 0;
    $datesub = $entry_array['datesub'] ? $entry_array['datesub'] : time();
	$html = $entry_array['html'];
	$smiley = $entry_array['smiley'];
	$xcodes = $entry_array['xcodes'];
	$breaks = $entry_array['breaks'];
	$block = $entry_array['block'];
	$offline = $entry_array['offline'] ? $entry_array['offline'] : 0;
    $notifypub = $entry_array['notifypub'] ? $entry_array['notifypub'] : 1;
    $request = $entry_array['request'] ? $entry_array['request'] : 0;

	$result01 = icms::$xoopsDB -> query( "SELECT COUNT(*) FROM " . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . " " );
	list( $totalcats ) = icms::$xoopsDB -> fetchRow( $result01 );
	
	if ( $totalcats == 0 && icms::$module -> config['multicats'] == 1 ) {
		redirect_header( 'index.php', 1, _AM_IMGLOSSARY_NEEDONECOLUMN );
		exit();
	}
	
	imglossary_adminMenu( 1, _AM_IMGLOSSARY_ENTRIES );
	$uid = icms::$user -> getVar('uid');
	echo "<h3 style=\"color: #2F5376; margin-top: 6px; \">" . _AM_IMGLOSSARY_ADMINENTRYMNGMT . "</h3>";
	$sform = new icms_form_Theme( _AM_IMGLOSSARY_NEWENTRY, 'op', '' );
	$sform -> setExtra( 'enctype="multipart/form-data"' );

	// Category selector
	if ( icms::$module -> config['multicats'] == 1 ) {
		$mytree = new icms_view_Tree( icms::$xoopsDB -> prefix( 'imglossary_cats' ), 'categoryID' , '0' );
		ob_start();
			//$sform -> addElement( new icms_form_elements_Hidden( 'categoryID', $categoryID ) );
			$mytree -> makeMySelBox( 'name', 'name', $categoryID, 0 );
			$sform -> addElement( new icms_form_elements_Label( _AM_IMGLOSSARY_CATNAME, ob_get_contents() ) );
		ob_end_clean();
	}

	// Author selector
	ob_start();
		imglossary_getuserForm( intval($uid) );
		$sform -> addElement( new icms_form_elements_Label( _AM_IMGLOSSARY_AUTHOR, ob_get_contents() ) );
	ob_end_clean();

	// Term, definition, reference and related URL
	$sform -> addElement( new icms_form_elements_Text( _AM_IMGLOSSARY_ENTRYTERM, 'term', 80, 80, $term ), true );

	$def_block = imglossary_getWysiwygForm( _AM_IMGLOSSARY_ENTRYDEF, 'definition', $definition );
	$def_block -> setDescription( _AM_IMGLOSSARY_WRITEHERE );
	$sform -> addElement( $def_block, false );
	
	$reference = new icms_form_elements_Textarea( _AM_IMGLOSSARY_ENTRYREFERENCE, 'ref', $ref, 5, 60 );
	$reference -> setDescription( _AM_IMGLOSSARY_ENTRYREFERENCEDSC );
	$sform -> addElement( $reference, false );
	
	$ent_url = new icms_form_elements_Text( _AM_IMGLOSSARY_ENTRYURL, 'url', 80, 80, $url );
	$ent_url -> setDescription( _AM_IMGLOSSARY_ENTRYURLDSC );
	$sform -> addElement( $ent_url, false );

	// Code to take entry offline, for maintenance purposes
	$offline_radio = new icms_form_elements_Radioyn( _AM_IMGLOSSARY_SWITCHOFFLINE, 'offline', $offline, ' ' . _YES . '', ' ' ._NO . '' );
	$sform -> addElement( $offline_radio );

	// Code to put entry in block
	$block_radio = new icms_form_elements_Radioyn( _AM_IMGLOSSARY_BLOCK, 'block', $block, ' ' . _YES . '', ' ' . _NO . '' );
	$sform -> addElement( $block_radio );

	// VARIOUS OPTIONS
	$options_tray = new icms_form_elements_Tray( _AM_IMGLOSSARY_OPTIONS, '<br /><br />' );

	$html_checkbox = new icms_form_elements_Checkbox( '', 'html', $html );
	$html_checkbox -> addOption( 1, _AM_IMGLOSSARY_DOHTML );
	$options_tray -> addElement( $html_checkbox );

	$smiley_checkbox = new icms_form_elements_Checkbox( '', 'smiley', $smiley );
	$smiley_checkbox -> addOption( 1, _AM_IMGLOSSARY_DOSMILEY );
	$options_tray -> addElement( $smiley_checkbox );

	$xcodes_checkbox = new icms_form_elements_Checkbox( '', 'xcodes', $xcodes );
	$xcodes_checkbox -> addOption( 1, _AM_IMGLOSSARY_DOXCODE );
	$options_tray -> addElement( $xcodes_checkbox );

	$breaks_checkbox = new icms_form_elements_Checkbox( '', 'breaks', $breaks );
	$breaks_checkbox -> addOption( 1, _AM_IMGLOSSARY_BREAKS );
	$options_tray -> addElement( $breaks_checkbox );

	$sform -> addElement( $options_tray );

	$sform -> addElement( new icms_form_elements_Hidden( 'entryID', $entryID ) );

	$button_tray = new icms_form_elements_Tray( '', '' );
	$hidden = new icms_form_elements_Hidden( 'op', 'addentry' );
	$button_tray -> addElement( $hidden );

	if ( !$entryID ) {
		// there's no entryID? Then it's a new entry
		
		$butt_create = new icms_form_elements_Button( '', '', _AM_IMGLOSSARY_CREATE, 'submit' );
		$butt_create -> setExtra( 'onclick="this.form.elements.op.value=\'addentry\'"' );
		$button_tray -> addElement( $butt_create );

		$butt_clear = new icms_form_elements_Button( '', '', _AM_IMGLOSSARY_CLEAR, 'reset' );
		$button_tray -> addElement( $butt_clear );

		$butt_cancel = new icms_form_elements_Button( '', '', _AM_IMGLOSSARY_CANCEL, 'button' );
		$butt_cancel -> setExtra( 'onclick="history.go(-1)"' );
		$button_tray -> addElement( $butt_cancel );
		
	} else { 
		
		// else, we're editing an existing entry
		$butt_create = new icms_form_elements_Button( '', '', _AM_IMGLOSSARY_MODIFY, 'submit' );
		$butt_create -> setExtra( 'onclick="this.form.elements.op.value=\'addentry\'"' );
		$button_tray -> addElement( $butt_create );

		$butt_cancel = new icms_form_elements_Button( '', '', _AM_IMGLOSSARY_CANCEL, 'button' );
		$butt_cancel -> setExtra( 'onclick="history.go(-1)"' );
		$button_tray -> addElement( $butt_cancel );
		
	}

	$sform -> addElement( $button_tray );
	$sform -> display();
	unset( $hidden );
} 

function entrySave( $entryID = '' )	{
	
	global $icmsConfig, $imglmyts;
	
	$entryID = isset( $_POST['entryID'] ) ? intval( $_POST['entryID'] ) : intval( $_GET['entryID'] );
	if ( icms::$module -> config['multicats'] == 1 ) {
		$categoryID = isset( $_POST['categoryID'] ) ? intval( $_POST['categoryID'] ) : intval( $_GET['categoryID'] );
	} else { 
		$categoryID = '';
	}
	$definition = $imglmyts -> addslashes( trim( $_POST['definition'] ) );
	$ref = isset( $_POST['ref'] ) ? $imglmyts -> addslashes( $_POST['ref'] ) : '';
	$url = isset( $_POST['url'] ) ? $imglmyts -> addslashes( $_POST['url'] ) : '';
	$uid = isset( $_POST['author'] ) ? intval( $_POST['author'] ) : icms::$user -> uid();
	$block = ( $_POST['block'] == 1 ) ? 1 : 0;
	if ( $block == 0 ) {
		$offline = 1;
	} else {
		$offline = ( $_POST['offline'] == 1 ) ? 1 : 0;
	}
	$html = isset( $_REQUEST['html'] ) ? 1 : 0;
    $smiley = isset( $_REQUEST['smiley'] ) ? 1 : 0;
    $xcodes = isset( $_REQUEST['xcodes'] ) ? 1 : 0;
    $breaks = isset( $_REQUEST['breaks'] ) ? 1 : 0;

	$term = $imglmyts -> addSlashes( $_POST['term'] );
	$init = substr( $term, 0, 1 );

	if ( ereg( "[a-zA-Z]", $init ) ) {
		$init = strtoupper( $init );
	} else {
		$init = '1';
	}

	$date = time();
	$submit = 0;
	$notifypub = 0;
	$request = 0;

// Save to database
	if ( !$entryID ) {
		if ( icms::$xoopsDB -> query( "INSERT INTO " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " (entryID, categoryID, term, init, definition, ref, url, uid, submit, datesub, html, smiley, xcodes, breaks, block, offline, notifypub, request ) VALUES ('', '$categoryID', '$term', '$init', '$definition', '$ref', '$url', '$uid', '$submit', '$date', '$html', '$smiley', '$xcodes', '$breaks', '$block', '$offline', '$notifypub', '$request' )" ) ) {
			imglossary_calculateTotals();
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_ENTRYCREATEDOK );
		} else {
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_ENTRYNOTCREATED );
		}
	} else { 
		// That is, $entryID exists, thus we're editing an entry
		
		if ( icms::$xoopsDB -> query( "UPDATE " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " SET term='$term', categoryID='$categoryID', init='$init', definition='$definition', ref='$ref', url='$url', uid='$uid', submit='$submit', html='$html', smiley='$smiley', xcodes='$xcodes', breaks='$breaks', block='$block', offline='$offline', notifypub='$notifypub', request='$request' WHERE entryID='$entryID'" ) ) {
			imglossary_calculateTotals();
			redirect_header( "index.php", 1, _AM_IMGLOSSARY_ENTRYMODIFIED );
		} else {
			redirect_header( "index.php", 1, _AM_IMGLOSSARY_ENTRYNOTUPDATED );
		}
	}
}

function entryDelete( $entryID = '' ) {
	$entryID = isset( $_POST['entryID'] ) ? intval( $_POST['entryID'] ) : intval( $_GET['entryID'] );
	$ok = isset( $_POST['ok'] ) ? intval( $_POST['ok'] ) : 0;
	$result = icms::$xoopsDB -> query( "SELECT entryID, term FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE entryID=$entryID" );
	list( $entryID, $term ) = icms::$xoopsDB -> fetchrow( $result );

	// confirmed, so delete 
	if ( $ok == 1 ) {
		$result = icms::$xoopsDB -> query( "DELETE FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE entryID=$entryID" );
		// delete comments (mondarse)
		xoops_comment_delete( icms::$module -> getVar('mid'), $entryID );
		// delete comments (mondarse)
		redirect_header( 'index.php', 1, sprintf( _AM_IMGLOSSARY_ENTRYISDELETED, $term ) );
	} else {
		icms_cp_header();
		icms_core_Message::confirm( array( 'op' => 'del', 'entryID' => $entryID, 'ok' => 1, 'term' => $term ), 'entry.php', _AM_IMGLOSSARY_DELETETHISENTRY . "<br /><br />" . $term, _AM_IMGLOSSARY_DELETE );
		icms_cp_footer();
	}
	exit();
	break;
} 

function entryDefault()	{
	icms_cp_header();
	entryEdit();
}

/* -- Available operations -- */
switch ( $op ) {
    case 'mod':
		icms_cp_header();
		$entryID = ( isset( $_GET['entryID'] ) ) ? intval( $_GET['entryID'] ) : intval( $_POST['entryID'] );
		entryEdit($entryID);
		break;

	case 'addentry':
		entrySave();
		exit();
		break;

	case 'del':
		entryDelete();

	case 'default':
	default:
		entryDefault();
		break;
} 
icms_cp_footer();
?>