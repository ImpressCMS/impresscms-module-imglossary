<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: admin/category.php
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

function categoryEdit( $categoryID = '' ) {
	$weight = 0;
	$name = '';
	$description = '';

	global $xoopsUser, $xoopsConfig, $xoopsDB, $modify, $xoopsModuleConfig, $xoopsModule; 

	// If there is a parameter, and the id exists, retrieve data: we're editing a column
	if ( $categoryID ) {
		$result = $xoopsDB -> query( "SELECT categoryID, name, description, total, weight FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " WHERE categoryID = '$categoryID'" );
		list( $categoryID, $name, $description, $total, $weight ) = $xoopsDB -> fetchrow( $result );

		if ( $xoopsDB -> getRowsNum( $result ) == 0 ) {
			redirect_header( 'category.php', 1, _AM_IMGLOSSARY_NOCATTOEDIT );
			exit();
		} 
		
		xoops_cp_header();
		imglossary_adminMenu( 2, _AM_IMGLOSSARY_CATS );

		echo "<h3 style=\"color: #2F5376; margin-top: 6px; \">" . _AM_IMGLOSSARY_CATSHEADER . "</h3>";
		$sform = new XoopsThemeForm( _AM_IMGLOSSARY_MODCAT . ": $name" , "op", xoops_getenv( 'PHP_SELF' ) );
	} else {
		xoops_cp_header();
		imglossary_adminMenu( 2, _AM_IMGLOSSARY_CATS );

		echo "<h3 style=\"color: #2F5376; margin-top: 6px; \">" . _AM_IMGLOSSARY_CATSHEADER . "</h3>";
		$sform = new XoopsThemeForm( _AM_IMGLOSSARY_NEWCAT, "op", xoops_getenv( 'PHP_SELF' ) );
	} 

	$sform -> setExtra( 'enctype="multipart/form-data"' );
    $sform -> addElement( new XoopsFormText( _AM_IMGLOSSARY_CATNAME, 'name', 80, 80, $name ), true );
	$sform -> addElement( new XoopsFormTextArea( _AM_IMGLOSSARY_CATDESCRIPT, 'description', $description, 7, 60 ) );
    $sform -> addElement( new XoopsFormText( _AM_IMGLOSSARY_CATPOSIT, 'weight', 4, 4, $weight ), false );
	$sform -> addElement( new XoopsFormHidden( 'categoryID', $categoryID ) );

	$button_tray = new XoopsFormElementTray( '', '' );
	$hidden = new XoopsFormHidden( 'op', 'addcat' );
	$button_tray -> addElement( $hidden );

	// No ID for column -- then it's new column, button says 'Create'
    if ( !$categoryID ) {
		$butt_create = new XoopsFormButton( '', '', _AM_IMGLOSSARY_CREATE, 'submit' );
		$butt_create -> setExtra( 'onclick="this.form.elements.op.value=\'addcat\'"' );
		$button_tray -> addElement( $butt_create );

		$butt_clear = new XoopsFormButton( '', '', _AM_IMGLOSSARY_CLEAR, 'reset' );
		$button_tray -> addElement( $butt_clear );

		$butt_cancel = new XoopsFormButton( '', '', _AM_IMGLOSSARY_CANCEL, 'button' );
		$butt_cancel -> setExtra( 'onclick="history.go(-1)"' );
		$button_tray -> addElement( $butt_cancel );
	} else { 
		// button says 'Update'
		$butt_create = new XoopsFormButton( '', '', _AM_IMGLOSSARY_MODIFY, 'submit' );
		$butt_create -> setExtra( 'onclick="this.form.elements.op.value=\'addcat\'"' );
		$button_tray -> addElement( $butt_create );

		$butt_cancel = new XoopsFormButton( '', '', _AM_IMGLOSSARY_CANCEL, 'button' );
		$butt_cancel -> setExtra( 'onclick="history.go(-1)"' );
		$button_tray -> addElement( $butt_cancel );
	} 

	$sform -> addElement( $button_tray );
	$sform -> display();
	unset( $hidden );
} 

function categoryDelete( $categoryID = '' ) {
	global $xoopsDB, $xoopsModule;
	$categoryID = isset($_POST['categoryID']) ? intval($_POST['categoryID']) : intval($_GET['categoryID']);
	$ok = isset($_POST['ok']) ? intval($_POST['ok']) : 0;
	$result = $xoopsDB -> query( "SELECT categoryID, name FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " WHERE categoryID=$categoryID" );
	list( $categoryID, $name ) = $xoopsDB -> fetchrow( $result );

	// confirmed, so delete 
	if ( $ok == 1 ) {
			//get all entries in the category
			$result3 = $xoopsDB -> query( "SELECT entryID FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE categoryID=$categoryID" );
			//now for each entry, delete the coments
			while ( list($entryID) = $xoopsDB -> fetchRow($result3) ) {
				xoops_comment_delete( $xoopsModule -> getVar('mid'), $entryID );
			}		
		$result = $xoopsDB -> query( "DELETE FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " WHERE categoryID=$categoryID" );
		$result2 = $xoopsDB -> query( "DELETE FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE categoryID=$categoryID" );
		redirect_header( 'index.php', 1, sprintf( _AM_IMGLOSSARY_CATISDELETED, $name ) );
	} else {
		xoops_cp_header();
		xoops_confirm( array( 'op' => 'del', 'categoryID' => $categoryID, 'ok' => 1, 'name' => $name ), 'category.php', _AM_IMGLOSSARY_DELETETHISCAT . "<br /><br>" . $name, _AM_IMGLOSSARY_DELETE );
		xoops_cp_footer();
	}
} 

function categorySave ( $categoryID = '' ) {
	global $xoopsUser, $xoopsConfig, $xoopsDB, $modify, $myts, $categoryID;
	$categoryID = isset( $_POST['categoryID'] ) ? intval( $_POST['categoryID'] ) : intval( $_GET['categoryID'] );
	$weight = isset( $_POST['weight'] ) ? intval( $_POST['weight'] ) : intval( $_GET['weight'] );
	$name = isset( $_POST['name'] ) ? htmlSpecialChars( $_POST['name'] ) : htmlSpecialChars( $_GET['name'] );
	$description = isset( $_POST['description'] ) ? htmlSpecialChars( $_POST['description'] ) : htmlSpecialChars( $_GET['description'] );
	$description = $myts -> xoopsCodeDecode( $description, $allowimage=0 );

	// Run the query and update the data
	if ( !$_POST['categoryID'] ) {
		if ( $xoopsDB -> query( "INSERT INTO " . $xoopsDB -> prefix( 'imglossary_cats' ) . " (categoryID, name, description, weight) VALUES ('', '$name', '$description', '$weight')" ) ) {
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_CATCREATED );
		} else {
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_NOTUPDATED );
		} 
	} else {
		if ( $xoopsDB -> queryF( "UPDATE " . $xoopsDB -> prefix( 'imglossary_cats' ) . " SET name='$name', description='$description', weight='$weight' WHERE categoryID='$categoryID'" ) ) {
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_CATMODIFIED );
		} else {
			redirect_header( 'index.php', 1, _AM_IMGLOSSARY_NOTUPDATED );
		} 
	} 
}

switch ( $op ) {
	case 'mod':
		$categoryID = isset( $_POST['categoryID'] ) ? intval( $_POST['categoryID'] ) : intval( $_GET['categoryID'] );
		categoryEdit( $categoryID );
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
		global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig;
		if ( $xoopsModuleConfig['multicats'] != 1 ) {
			redirect_header( 'index.php', 1, sprintf( _AM_IMGLOSSARY_SINGLECAT, '' ) );
			exit();
		}		
        categoryEdit();
        break;
} 

xoops_cp_footer();

?>