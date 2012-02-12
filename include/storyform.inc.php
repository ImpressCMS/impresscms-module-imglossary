<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: include/storyform.inc.php
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

include_once ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/include/functions.php';
$mytree = new icms_view_Tree( icms::$xoopsDB -> prefix( 'imglossary_cats' ), 'categoryID', '0' );

echo '<link rel="stylesheet" type="text/css" href="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/style.css" />';

echo "<div>";
echo "<div style='float: "._GLOBAL_LEFT."; font-size: smaller;'><a href='" . ICMS_URL . "/modules/" . icms::$module -> getVar( 'dirname' ) . "/index.php'>" . icms::$module -> getVar( 'name' ) . "</a> | " . _MD_IMGLOSSARY_SUBMITART . "</div>";
echo "<div style='font-size: 18px; text-align: "._GLOBAL_RIGHT."; font-weight: bold; color: #F3AC03; letter-spacing: -1.5px; margin: 0; line-height: 18px;'>" . icms::$module -> getVar( 'name' ) . "&nbsp;</div>";
echo "</div><hr>";

echo "<br /><fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; font-size: 105%;'>" . sprintf( _MD_IMGLOSSARY_SUB_SNEWNAME, ucfirst( icms::$module -> getVar( 'name' ) ) ) . "</legend>";
echo "<div style='padding: 8px;'>". _MD_IMGLOSSARY_GOODDAY . " <b>" . $name . "</b>, " . _MD_IMGLOSSARY_SUB_SNEWNAMEDESC . "</div></fieldset><br />";

$sform = new icms_form_Theme( _MD_IMGLOSSARY_SUB_SMNAME, 'storyform', '' );
$sform -> setExtra( 'enctype="multipart/form-data"' );

// This part is common to edit/add
$sform -> addElement( new icms_form_elements_Text( _MD_IMGLOSSARY_ENTRY, 'term', 50, 80, $term ), true );

if ( icms::$module -> config['multicats'] == '1' ) {
	ob_start();
		$mytree -> makeMySelBox( 'name', 'name', $categoryID );
		$sform -> addElement( new icms_form_elements_Label( _MD_IMGLOSSARY_CATEGORY, ob_get_contents() ) );
	ob_end_clean();
}

$def_block = imglossary_getWysiwygForm( _MD_IMGLOSSARY_DEFINITION . imglossary_helptip( _MD_IMGLOSSARY_WRITEHERE ), 'definition', '' );
$sform -> addElement( $def_block, false );

$sform -> addElement( new icms_form_elements_TextArea( _MD_IMGLOSSARY_REFERENCE . imglossary_helptip( _MD_IMGLOSSARY_REFERENCEDSC ), 'ref', $ref, 5, 50 ), false );
$sform -> addElement( new icms_form_elements_Text( _MD_IMGLOSSARY_URL . imglossary_helptip( _MD_IMGLOSSARY_URLDSC ), 'url', 50, 80, $url ), false );

if ( is_object( icms::$user ) ) {
	$uid = icms::$user -> getVar( 'uid' );
	$sform -> addElement( new icms_form_elements_Hidden( 'uid', $uid ) );
	$notifypub = 1;
	$notify_checkbox = new icms_form_elements_Checkbox( _MD_IMGLOSSARY_NOTIFY, 'notifypub', $notifypub );
	$notify_checkbox -> addOption( '','' );
	$sform -> addElement( $notify_checkbox );
}

if ( icms::$module -> config['captcha'] ) {
	// Captcha Hack
	$sform -> addElement( new icms_form_elements_Captcha( _SECURITYIMAGE_GETCODE, 'scode' ), true );
	// Captcha Hack 
}

$button_tray = new icms_form_elements_Tray( '', '' );
$hidden = new icms_form_elements_Hidden( 'op', 'post' );
$button_tray -> addElement( $hidden );
$button_tray -> addElement( new icms_form_elements_Button( '', 'post', _MD_IMGLOSSARY_CREATE, 'submit' ) );

$sform -> addElement( $button_tray );
$sform -> display();

include ICMS_ROOT_PATH . '/footer.php';
?>