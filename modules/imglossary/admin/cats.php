<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: admin/category.php
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

if ( !isset( $_POST['op'] ) ) {
	if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
} else {
	if ( isset( $_POST['op'] ) ) $op = $_POST['op'];
}

function categoryEdit( $categoryid = '' ) {
	$weight = 0;
	$name = '';
	$description = '';

	// If there is a parameter, and the id exists, retrieve data: we're editing a column
	if ( $categoryid ) {
		$result = icms::$xoopsDB -> query( 'SELECT categoryid, name, description, total, weight FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' WHERE categoryid=' . $categoryid );
		list( $categoryid, $name, $description, $total, $weight ) = icms::$xoopsDB -> fetchrow( $result );

		if ( icms::$xoopsDB -> getRowsNum( $result ) == 0 ) {
			redirect_header( 'category.php', 1, _AM_IMGLOSSARY_NOCATTOEDIT );
			exit();
		} 
		
		icms_cp_header();
		imglossary_adminMenu( 2, _AM_IMGLOSSARY_CATS );

		echo '<h3 style="color: #2F5376; margin-top: 6px; \">' . _AM_IMGLOSSARY_CATSHEADER . '</h3>';
		$sform = new icms_form_Theme( _AM_IMGLOSSARY_MODCAT . ': $name' , 'op', '' );
	} else {
		icms_cp_header();
		imglossary_adminMenu( 2, _AM_IMGLOSSARY_CATS );

		echo '<h3 style="color: #2F5376; margin-top: 6px; \">' . _AM_IMGLOSSARY_CATSHEADER . '</h3>';
		$sform = new icms_form_Theme( _AM_IMGLOSSARY_NEWCAT, 'op', '' );
	}

	$sform -> setExtra( 'enctype="multipart/form-data"' );
	$sform -> addElement( new icms_form_elements_Text( _AM_IMGLOSSARY_CATNAME, 'name', 80, 80, $name ), true );
	$sform -> addElement( new icms_form_elements_TextArea( _AM_IMGLOSSARY_CATDESCRIPT, 'description', $description, 7, 60 ) );
	$sform -> addElement( new icms_form_elements_Text( _AM_IMGLOSSARY_CATPOSIT, 'weight', 4, 4, $weight ), false );
	$sform -> addElement( new icms_form_elements_Hidden( 'categoryid', $categoryid ) );

	$button_tray = new icms_form_elements_Tray( '', '' );
	$hidden = new icms_form_elements_Hidden( 'op', 'addcat' );
	$button_tray -> addElement( $hidden );

	// No ID for column -- then it's new column, button says 'Create'
	if ( !$categoryid ) {
		$butt_create = new icms_form_elements_Button( '', '', _AM_IMGLOSSARY_CREATE, 'submit' );
		$butt_create -> setExtra( 'onclick="this.form.elements.op.value=\'addcat\'"' );
		$button_tray -> addElement( $butt_create );

		$butt_clear = new icms_form_elements_Button( '', '', _AM_IMGLOSSARY_CLEAR, 'reset' );
		$button_tray -> addElement( $butt_clear );

		$butt_cancel = new icms_form_elements_Button( '', '', _AM_IMGLOSSARY_CANCEL, 'button' );
		$butt_cancel -> setExtra( 'onclick="history.go(-1)"' );
		$button_tray -> addElement( $butt_cancel );
	} else { 
		// button says 'Update'
		$butt_create = new icms_form_elements_Button( '', '', _AM_IMGLOSSARY_MODIFY, 'submit' );
		$butt_create -> setExtra( 'onclick="this.form.elements.op.value=\'addcat\'"' );
		$button_tray -> addElement( $butt_create );

		$butt_cancel = new icms_form_elements_Button( '', '', _AM_IMGLOSSARY_CANCEL, 'button' );
		$butt_cancel -> setExtra( 'onclick="history.go(-1)"' );
		$button_tray -> addElement( $butt_cancel );
	} 

	$sform -> addElement( $button_tray );
	$sform -> display();
	unset( $hidden );
} 

function categoryDelete( $categoryid = '' ) {
	$categoryid = isset($_POST['categoryid']) ? intval($_POST['categoryid']) : intval($_GET['categoryid']);
	$ok = isset($_POST['ok']) ? intval($_POST['ok']) : 0;
	$result = icms::$xoopsDB -> query( 'SELECT categoryid, name FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' WHERE categoryid=' . $categoryid );
	list( $categoryid, $name ) = icms::$xoopsDB -> fetchrow( $result );

	// confirmed, so delete 
	if ( $ok == 1 ) {
		//get all entries in the category
		$result3 = icms::$xoopsDB -> query( 'SELECT entryid FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE categoryid=' . $categoryid );
		//now for each entry, delete the coments
		while ( list( $entryid ) = icms::$xoopsDB -> fetchRow( $result3 ) ) {
			xoops_comment_delete( icms::$module -> getVar('mid'), $entryid );
			icms::$xoopsDB -> query( 'UPDATE ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' SET offline=1, block=0 WHERE categoryid=' . $categoryid ); 
		}
		$result = icms::$xoopsDB -> query( 'DELETE FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' WHERE categoryid=' . $categoryid );
		redirect_header( 'index.php', 1, sprintf( _AM_IMGLOSSARY_CATISDELETED, $name ) );
	} else {
		icms_cp_header();
		icms_core_Message::confirm( array( 'op' => 'del', 'categoryid' => $categoryid, 'ok' => 1, 'name' => $name ), 'cats.php', _AM_IMGLOSSARY_DELETETHISCAT . '<br /><br>' . $name, _AM_IMGLOSSARY_DELETE );
		icms_cp_footer();
	}
} 

function categorySave ( $categoryid = '' ) {
	global $imglmyts, $categoryid;
	$categoryid = isset( $_POST['categoryid'] ) ? intval( $_POST['categoryid'] ) : intval( $_GET['categoryid'] );
	$weight = isset( $_POST['weight'] ) ? intval( $_POST['weight'] ) : intval( $_GET['weight'] );
	$name = isset( $_POST['name'] ) ? $imglmyts -> htmlSpecialCharsStrip( $_POST['name'] ) : $imglmyts -> htmlSpecialCharsStrip( $_GET['name'] );
	$description = isset( $_POST['description'] ) ? $imglmyts -> htmlSpecialCharsStrip( $_POST['description'] ) : $imglmyts -> htmlSpecialCharsStrip( $_GET['description'] );

	// Run the query and update the data
	if ( !$_POST['categoryid'] ) {
		if ( icms::$xoopsDB -> query( "INSERT INTO " . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . " (categoryid, name, description, weight) VALUES ('', '$name', '$description', '$weight')" ) ) {
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_CATCREATED );
		} else {
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_NOTUPDATED );
		} 
	} else {
		if ( icms::$xoopsDB -> queryF( "UPDATE " . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . " SET name='$name', description='$description', weight='$weight' WHERE categoryid='$categoryid'" ) ) {
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_CATMODIFIED );
		} else {
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_NOTUPDATED );
		} 
	} 
}

switch ( $op ) {
	case 'mod':
		$categoryid = isset( $_POST['categoryid'] ) ? intval( $_POST['categoryid'] ) : intval( $_GET['categoryid'] );
		categoryEdit( $categoryid );
		break;

	case 'addcat':
		categorySave();
		exit();
		break;

	case 'del':
		categoryDelete();
		exit();
		break;

	case 'cancel':
		redirect_header( 'index.php', 1, sprintf( _AM_IMGLOSSARY_BACK2IDX, '' ) );
		exit();

	case 'default':
	default:
		if ( icms::$module -> config['multicats'] != 1 ) {
			redirect_header( 'index.php', 3, sprintf( _AM_IMGLOSSARY_SINGLECAT, '' ) );
			exit();
		}
		categoryEdit();
		break;
}
icms_cp_footer();
?>