<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: admin/index.php
*
* @copyright	http://www.xoops.org/ The XOOPS Project
* @copyright	XOOPS_copyrights.txt
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		Wordbook - a multicategory glossary
* @since		1.16
* @author		hsalazar
* ----------------------------------------------------------------------------------------------------------
* 				imGlossary - a multicategory glossary
* @since		1.00
* @author		modified by McDonald
* @version		$Id$
*/

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
	$block = $entry_array['block'] ? $entry_array['block'] : 0;
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

	echo "<h3 style=\"color: #2F5376; margin-top: 6px; \">" . _AM_IMGLOSSARY_ADMINENTRYMNGMT . "</h3>";
	$sform = new icms_form_Theme( _AM_IMGLOSSARY_NEWENTRY, 'op', '' );
	$sform -> setExtra( 'enctype="multipart/form-data"' );

	// Term, definition, reference and related URL
	$sform -> addElement( new icms_form_elements_Text( _AM_IMGLOSSARY_ENTRYTERM, 'term', 50, 100, $term ), true );

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
	$sform -> addElement( new icms_form_elements_select_User( _AM_IMGLOSSARY_AUTHOR, 'uid', true, $uid ) );

	// Definition
	$def_block = imglossary_getWysiwygForm( _AM_IMGLOSSARY_ENTRYDEF, 'definition', $definition );
	$def_block -> setDescription( _AM_IMGLOSSARY_WRITEHERE );
	$sform -> addElement( $def_block, false );

	// Reference
	$reference = new icms_form_elements_Textarea( _AM_IMGLOSSARY_ENTRYREFERENCE, 'ref', $ref, 5, 60 );
	$reference -> setDescription( _AM_IMGLOSSARY_ENTRYREFERENCEDSC );
	$sform -> addElement( $reference, false );

	// Related site (url)
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

function entryDefault() {
	icms_cp_header();
	entryEdit();
}

function entrySave( $entryID = '' ) {

	global $icmsConfig, $imglmyts;

	$entryID = isset( $_POST['entryID'] ) ? intval( $_POST['entryID'] ) : intval( $_GET['entryID'] );
	if ( icms::$module -> config['multicats'] == 1 ) {
		$categoryID = isset( $_POST['categoryID'] ) ? intval( $_POST['categoryID'] ) : intval( $_GET['categoryID'] );
	} else { 
		$categoryID = '';
	}
	$definition = icms_core_DataFilter::addSlashes( trim( $_POST['definition'] ) );
	$ref = isset( $_POST['ref'] ) ? icms_core_DataFilter::addSlashes( $_POST['ref'] ) : '';
	$url = isset( $_POST['url'] ) ? icms_core_DataFilter::addSlashes( $_POST['url'] ) : '';
	$uid = $_POST['uid'];
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

	$term = icms_core_DataFilter::addSlashes( $_POST['term'] );
	$init = substr( $term, 0, 1 );

	if ( preg_match( "/[a-zA-Z]/", $init ) ) {
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
		icms_core_Message::confirm( array( 'op' => 'del', 'entryID' => $entryID, 'ok' => 1, 'term' => $term ), 'entries.php', _AM_IMGLOSSARY_DELETETHISENTRY . "<br /><br />" . $term, _AM_IMGLOSSARY_DELETE );
		icms_cp_footer();
	}
	exit();
	break;
}

/* -- Available operations -- */
switch ( $op ) {
	case 'mod':
		icms_cp_header();
		$entryID = ( isset( $_GET['entryID'] ) ) ? intval( $_GET['entryID'] ) : intval( $_POST['entryID'] );
		entryEdit( $entryID );
		break;

	case 'newentry':
		entryDefault();
		break;

	case 'addentry':
		entrySave();
		exit();
		break;

	case 'del':
		entryDelete();
		break;

	case 'default':
	default:

		$startentry = isset( $_GET['startentry'] ) ? intval( $_GET['startentry'] ) : 0;
		$startcat = isset( $_GET['startcat'] ) ? intval( $_GET['startcat'] ) : 0;
		$startsub = isset( $_GET['startsub'] ) ? intval( $_GET['startsub'] ) : 0;
		$datesub = isset( $_GET['datesub'] ) ? intval( $_GET['datesub'] ) : 0;
		$entryID = '';

		icms_cp_header();
		global $icmsConfig, $entryID;

		imglossary_adminMenu( 0, _AM_IMGLOSSARY_INDEX );


		$result01 = icms::$xoopsDB -> query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) );
			list( $totalcategories ) = icms::$xoopsDB -> fetchRow( $result01 );
		$result02 = icms::$xoopsDB -> query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0' );
			list( $totalpublished ) = icms::$xoopsDB -> fetchRow( $result02 );
		$result03 = icms::$xoopsDB -> query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=1 AND request=0' );
			list( $totalsubmitted ) = icms::$xoopsDB -> fetchRow( $result03 );
		$result04 = icms::$xoopsDB -> query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=1 AND request=1' );
			list( $totalrequested ) = icms::$xoopsDB -> fetchRow( $result04 );

		$style = 'border: #CCCCCC 1px solid; padding: 4px; background-color: #E8E8E8; margin: 1px; font-size: .9em; border-radius: 4px;';
		$style_fldst = 'border: #E8E8E8 1px solid; border-radius: 6px;';
		$style_lgnd = 'display: inline; font-weight: bold; padding-bottom: 8px;';
		$style_bttn = 'float: ' . _GLOBAL_LEFT . '; font-size: 11px; border-radius: 4px; border: 1px solid #5E5D63; color: #000000; background-color: #EFEFEF; padding: 2px 4px; text-align: center;';


		echo '<fieldset style="' . $style_fldst . '">';
		echo '<legend style="' . $style_lgnd . '">' . _AM_IMGLOSSARY_INVENTORY . '</legend>';
		echo '<div style="padding: 10px;"><span style="' . $style . '"> ' . _AM_IMGLOSSARY_TOTALENTRIES . ' <b>' . $totalpublished . ' </b></span>&nbsp;&nbsp;';
		if (icms::$module -> config['multicats'] == 1) {
			echo '<span style="' . $style . '"> ' . _AM_IMGLOSSARY_TOTALCATS . ' <b>' . $totalcategories . ' </b></span>&nbsp;&nbsp;';
		}
		echo '<span style="' . $style . '"> ' . _AM_IMGLOSSARY_TOTALSUBM . ' <b>' . $totalsubmitted . ' </b></span>&nbsp;&nbsp;';
		echo '<span style="' . $style . '"> ' . _AM_IMGLOSSARY_TOTALREQ . ' <b>' . $totalrequested . ' </b></span></div>';
		echo '</fieldset>';


		$imglossary_entries_handler = icms_getModuleHandler( 'entries', basename( dirname( dirname( __FILE__ ) ) ), 'imglossary' );
		$imglossary_cats_handler = icms_getModuleHandler( 'cats', basename( dirname( dirname( __FILE__ ) ) ), 'imglossary' );

		$objectTable = new icms_ipf_view_Table( $imglossary_entries_handler );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'entryID', 'center', 50 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'term' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'uid', 'center' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'datesub', 'center', 150 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'offline', 'center', 50 ) );
		$icmsAdminTpl -> assign( 'imglossary_entries_table', $objectTable -> fetch() );
		
		
		$objectTable = new icms_ipf_view_Table( $imglossary_cats_handler );
		$objectTable -> addColumn(new icms_ipf_view_Column( 'categoryID', 'center', 50 ) );
		$objectTable -> addColumn(new icms_ipf_view_Column( 'name' ) );
		$objectTable -> addColumn(new icms_ipf_view_Column( 'description', 'center' ) );
		$objectTable -> addColumn(new icms_ipf_view_Column( 'weight', 'center', 100 ) );
		$icmsAdminTpl -> assign( 'imglossary_cats_table', $objectTable -> fetch() );
		
		
		$criteria = new icms_db_criteria_Compo();
		$criteria -> add( new icms_db_criteria_Item( 'submit', 1 ) );
		$criteria -> add( new icms_db_criteria_Item( 'request', 0 ) );

		$objectTable = new icms_ipf_view_Table( $imglossary_entries_handler, $criteria );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'entryID', 'center', 50 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'term' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'uid', 'center' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'datesub', 'center', 150 ) );
		$icmsAdminTpl -> assign( 'imglossary_submissions_table', $objectTable -> fetch() );
		
		
		$criteria = new icms_db_criteria_Compo();
		$criteria -> add( new icms_db_criteria_Item( 'submit', 1 ) );
		$criteria -> add( new icms_db_criteria_Item( 'request', 1 ) );

		$objectTable = new icms_ipf_view_Table( $imglossary_entries_handler, $criteria );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'entryID', 'center', 50 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'term' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'uid', 'center' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'datesub', 'center', 150 ) );
		$icmsAdminTpl -> assign( 'imglossary_request_table', $objectTable -> fetch() );
		
		
		$criteria = new icms_db_criteria_Compo();
		$criteria -> add( new icms_db_criteria_Item( 'offline', 1 ) );

		$objectTable = new icms_ipf_view_Table( $imglossary_entries_handler, $criteria );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'entryID', 'center', 50 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'term' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'uid', 'center' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'datesub', 'center', 150 ) );
		$icmsAdminTpl -> assign( 'imglossary_offline_table', $objectTable -> fetch() );
		
		
		$icmsAdminTpl -> display( 'db:imglossary_admin_index.html' );
		
		break;
	} 
icms_cp_footer();
?>