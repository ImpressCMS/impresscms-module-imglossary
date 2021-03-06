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

$imglossary_entries_handler = icms_getModuleHandler( 'entries', basename( dirname( dirname( __FILE__ ) ) ), 'imglossary' );
$imglossary_cats_handler = icms_getModuleHandler( 'cats', basename( dirname( dirname( __FILE__ ) ) ), 'imglossary' );

// -- Edit function -- //
function entryEdit( $entryid = 0 ) {
	global $icmsConfig, $imglmyts; 

	$sql = 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE entryid=' . $entryid;
	if ( !$result = icms::$xoopsDB -> query( $sql ) ) {
		icms::$logger -> handleError( E_USER_WARNING, $sql, __FILE__, __LINE__ );
		return false;
	}
	$entry_array = icms::$xoopsDB -> fetchArray( icms::$xoopsDB -> query( $sql ) );

	$categoryid = $entry_array['categoryid'] ? $entry_array['categoryid'] : 0;
	$term = $entry_array['term'] ? $imglmyts -> htmlSpecialCharsStrip( $entry_array['term'] ) : '';
	$definition = $entry_array['definition'] ? $imglmyts -> htmlSpecialCharsStrip( $entry_array['definition'] ) : '';
	$ref = $entry_array['ref'] ? $imglmyts -> htmlSpecialCharsStrip( $entry_array['ref'] ) : '';
	$url = $entry_array['url'] ? $imglmyts -> htmlSpecialCharsStrip( $entry_array['url'] ) : '';
	$uid = $entry_array['uid'] ? $entry_array['uid'] : icms::$user -> getVar( 'uid' );
	$submit = $entry_array['submit'] ? $entry_array['submit'] : 0;
	$datesub = $entry_array['datesub'] ? $entry_array['datesub'] : time();
	$block = $entry_array['block'] ? $entry_array['block'] : 1;
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
		$mytree = new icms_view_Tree( icms::$xoopsDB -> prefix( 'imglossary_cats' ), 'categoryid' , '0' );
		ob_start();
			//$sform -> addElement( new icms_form_elements_Hidden( 'categoryid', $categoryid ) );
			$mytree -> makeMySelBox( 'name', 'name', $categoryid, 0 );
			$sform -> addElement( new icms_form_elements_Label( _AM_IMGLOSSARY_CATNAME, ob_get_contents() ) );
		ob_end_clean();
	}

	// Author selector
	$sform -> addElement( new icms_form_elements_select_User( _AM_IMGLOSSARY_AUTHOR, 'uid', true, $uid ) );

	// Definition
	$def_block = imglossary_getWysiwygForm( _AM_IMGLOSSARY_ENTRYDEF . imglossary_helptip( _AM_IMGLOSSARY_WRITEHERE ), 'definition', $definition );
	$sform -> addElement( $def_block, false );

	// Reference
	$reference = new icms_form_elements_Textarea( _AM_IMGLOSSARY_ENTRYREFERENCE . imglossary_helptip( _AM_IMGLOSSARY_ENTRYREFERENCEDSC ), 'ref', $ref, 5, 60 );
	$sform -> addElement( $reference, false );

	// Related site (url)
	$ent_url = new icms_form_elements_Text( _AM_IMGLOSSARY_ENTRYURL . imglossary_helptip( _AM_IMGLOSSARY_ENTRYURLDSC ), 'url', 80, 80, $url );
	$sform -> addElement( $ent_url, false );

	// Code to take entry offline, for maintenance purposes
	$offline_radio = new icms_form_elements_Radioyn( _AM_IMGLOSSARY_SWITCHOFFLINE, 'offline', $offline, ' ' . _YES . '', ' ' ._NO . '' );
	$sform -> addElement( $offline_radio );

	// Code to put entry in block
	$block_radio = new icms_form_elements_Radioyn( _AM_IMGLOSSARY_BLOCK, 'block', $block, ' ' . _YES . '', ' ' . _NO . '' );
	$sform -> addElement( $block_radio );

	$sform -> addElement( new icms_form_elements_Hidden( 'entryid', $entryid ) );

	$button_tray = new icms_form_elements_Tray( '', '' );
	$hidden = new icms_form_elements_Hidden( 'op', 'addentry' );
	$button_tray -> addElement( $hidden );

	if ( !$entryid ) {
		// there's no entryid? Then it's a new entry
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

function entrySave( $entryid = '' ) {

	global $icmsConfig, $imglmyts;

	$entryid = isset( $_POST['entryid'] ) ? intval( $_POST['entryid'] ) : intval( $_GET['entryid'] );
	if ( icms::$module -> config['multicats'] == 1 ) {
		$categoryid = isset( $_POST['categoryid'] ) ? intval( $_POST['categoryid'] ) : intval( $_GET['categoryid'] );
	} else { 
		$categoryid = '';
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
	if ( !$entryid ) {
		if ( icms::$xoopsDB -> query( "INSERT INTO " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " (entryid, categoryid, term, init, definition, ref, url, uid, submit, datesub, block, offline, notifypub, request ) VALUES ('', '$categoryid', '$term', '$init', '$definition', '$ref', '$url', '$uid', '$submit', '$date', '$block', '$offline', '$notifypub', '$request' )" ) ) {
			imglossary_calculateTotals();
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_ENTRYCREATEDOK );
		} else {
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_ENTRYNOTCREATED );
		}
	} else { 
		// That is, $entryid exists, thus we're editing an entry
		
		if ( icms::$xoopsDB -> query( "UPDATE " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " SET term='$term', categoryid='$categoryid', init='$init', definition='$definition', ref='$ref', url='$url', uid='$uid', submit='$submit', block='$block', offline='$offline', notifypub='$notifypub', request='$request' WHERE entryid='$entryid'" ) ) {
			imglossary_calculateTotals();
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_ENTRYMODIFIED );
		} else {
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_ENTRYNOTUPDATED );
		}
	}
}

function entryDelete( $entryid = '' ) {
	$entryid = isset( $_POST['entryid'] ) ? intval( $_POST['entryid'] ) : intval( $_GET['entryid'] );
	$ok = isset( $_POST['ok'] ) ? intval( $_POST['ok'] ) : 0;
	$result = icms::$xoopsDB -> query( "SELECT entryid, term FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE entryid=$entryid" );
	list( $entryid, $term ) = icms::$xoopsDB -> fetchrow( $result );

	// confirmed, so delete 
	if ( $ok == 1 ) {
		$result = icms::$xoopsDB -> query( "DELETE FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE entryid=$entryid" );
		// delete comments (mondarse)
		xoops_comment_delete( icms::$module -> getVar('mid'), $entryid );
		// delete comments (mondarse)
		redirect_header( 'index.php', 1, sprintf( _AM_IMGLOSSARY_ENTRYISDELETED, $term ) );
	} else {
		icms_cp_header();
		icms_core_Message::confirm( array( 'op' => 'del', 'entryid' => $entryid, 'ok' => 1, 'term' => $term ), 'entries.php', _AM_IMGLOSSARY_DELETETHISENTRY . "<br /><br />" . $term, _AM_IMGLOSSARY_DELETE );
		icms_cp_footer();
	}
	exit();
	break;
}

/* -- Available operations -- */
switch ( $op ) {
	case 'mod':
		icms_cp_header();
		$entryid = ( isset( $_GET['entryid'] ) ) ? intval( $_GET['entryid'] ) : intval( $_POST['entryid'] );
		entryEdit( $entryid );
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

	case 'changeStatus':
		$status = $ret = '';
		$entryid = isset( $_POST['entryid'] ) ? intval( $_POST['entryid'] ) : intval( $_GET['entryid'] );
		$status = $imglossary_entries_handler -> changeOnlineStatus( $entryid, 'offline' );
		$ret = '/modules/' . basename( dirname( dirname( __FILE__) ) ) . '/admin/entries.php';
		if ( $status == 0 ) {
			redirect_header( ICMS_URL . $ret, 2, _AM_IMGLOSSARY_TERM_ONLINE );
		} else {
			redirect_header( ICMS_URL . $ret, 2, _AM_IMGLOSSARY_TERM_OFFLINE );
		}
		break;

	case 'changeWeight':
		foreach ( $_POST['mod_imglossary_Cats_objects'] as $key => $value ) {
			$changed = false;
			$catsObj = $imglossary_cats_handler -> get( $value );
			if ( $catsObj -> getVar( 'weight', 'e' ) != $_POST['weight'][$key] ) {
				$catsObj -> setVar( 'weight', intval( $_POST['weight'][$key] ) );
				$changed = true;
			}
			if ( $changed ) {
				$imglossary_cats_handler -> insert( $catsObj );
			}
		}
		$ret = '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/admin/entries.php';
		redirect_header( ICMS_URL . $ret, 2, _AM_IMGLOSSARY_WEIGHT_UPDATED );
		break;

	case 'default':
	default:

		$startentry = isset( $_GET['startentry'] ) ? intval( $_GET['startentry'] ) : 0;
		$startcat = isset( $_GET['startcat'] ) ? intval( $_GET['startcat'] ) : 0;
		$startsub = isset( $_GET['startsub'] ) ? intval( $_GET['startsub'] ) : 0;
		$datesub = isset( $_GET['datesub'] ) ? intval( $_GET['datesub'] ) : 0;
		$entryid = '';

		icms_cp_header();
		global $icmsConfig, $entryid;

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


		// Entries table
		$objectTable = new icms_ipf_view_Table( $imglossary_entries_handler, false, array() );

		$objectTable -> addHeader('<p style="font-size: 1.1em; font-weight: bold; margin-top: 20px;">' . _AM_IMGLOSSARY_SHOWENTRIES . '</p>');

		$objectTable -> addColumn( new icms_ipf_view_Column( 'entryid', 'center', 50 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'term', _GLOBAL_LEFT, false, 'ViewEntryLink' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'uid', 'center' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'datesub', 'center', 150 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'offline', 'center', 50 ) );

		$objectTable->addCustomAction('getEditEntryLink');
		$objectTable->addCustomAction('getDeleteEntryLink');

		$objectTable -> addQuickSearch( array( 'term' ), _AM_IMGLOSSARY_TERM_SEARCH ); // Search term

		$icmsAdminTpl -> assign( 'imglossary_entries_table', $objectTable -> fetch() );


		// Categories table
		$objectTable = new icms_ipf_view_Table( $imglossary_cats_handler, false, array() );

		$objectTable -> addHeader('<p style="font-size: 1.1em; font-weight: bold; margin-top: 10px;">' . _AM_IMGLOSSARY_SHOWCATS . '</p>');

		$objectTable -> addColumn( new icms_ipf_view_Column( 'categoryid', 'center', 50 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'name', _GLOBAL_LEFT, 200, 'ViewCategoryLink' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'description', _GLOBAL_LEFT, false, 'getDescriptionTeaser' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'total', 'center' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'weight', 'center', 100, 'getWeightControl' ) );

		$objectTable -> addActionButton( 'changeWeight', false, _SUBMIT );

		$objectTable->addCustomAction('getEditCategoryLink');
		$objectTable->addCustomAction('getDeleteCategoryLink');

		$icmsAdminTpl -> assign( 'imglossary_cats_table', $objectTable -> fetch() );


		// Submissions table
		$criteria = new icms_db_criteria_Compo();
		$criteria -> add( new icms_db_criteria_Item( 'submit', 1 ) );
		$criteria -> add( new icms_db_criteria_Item( 'request', 0 ) );

		$objectTable = new icms_ipf_view_Table( $imglossary_entries_handler, $criteria );

		$objectTable -> addHeader('<p style="font-size: 1.1em; font-weight: bold; margin-top: 10px;">' . _AM_IMGLOSSARY_SHOWSUBMISSIONS . '</p>');

		$objectTable -> addColumn( new icms_ipf_view_Column( 'entryid', 'center', 50 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'term', false, false, 'ViewEntryLink' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'uid', 'center' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'datesub', 'center', 150 ) );
		$icmsAdminTpl -> assign( 'imglossary_submissions_table', $objectTable -> fetch() );


		// Requests table
		$criteria = new icms_db_criteria_Compo();
		$criteria -> add( new icms_db_criteria_Item( 'submit', 1 ) );
		$criteria -> add( new icms_db_criteria_Item( 'request', 1 ) );

		$objectTable = new icms_ipf_view_Table( $imglossary_entries_handler, $criteria );

		$objectTable -> addHeader('<p style="font-size: 1.1em; font-weight: bold; margin-top: 10px;">' . _AM_IMGLOSSARY_SHOWREQUESTS . '</p>');

		$objectTable -> addColumn( new icms_ipf_view_Column( 'entryid', 'center', 50 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'term' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'uid', 'center' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'datesub', 'center', 150 ) );
		$icmsAdminTpl -> assign( 'imglossary_request_table', $objectTable -> fetch() );


		// Offline table
		$criteria = new icms_db_criteria_Compo();
		$criteria -> add( new icms_db_criteria_Item( 'offline', 1 ) );

		$objectTable = new icms_ipf_view_Table( $imglossary_entries_handler, $criteria );

		$objectTable -> addHeader('<p style="font-size: 1.1em; font-weight: bold; margin-top: 10px;">' . _AM_IMGLOSSARY_SHOWOFFLINE . '</p>');

		$objectTable -> addColumn( new icms_ipf_view_Column( 'entryid', 'center', 50 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'term' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'uid', 'center' ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'datesub', 'center', 150 ) );
		$objectTable -> addColumn( new icms_ipf_view_Column( 'offline', 'center', 50 ) );
		$icmsAdminTpl -> assign( 'imglossary_offline_table', $objectTable -> fetch() );


		$icmsAdminTpl -> display( 'db:imglossary_admin_index.html' );

		break;
	} 
icms_cp_footer();
?>