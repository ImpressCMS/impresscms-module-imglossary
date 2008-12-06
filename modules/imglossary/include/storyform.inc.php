<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: include/storyform.inc.php
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

global $xoopsUser, $xoopsModule, $xoopsModuleConfig;

include_once ICMS_ROOT_PATH . '/modules/' . $xoopsModule -> dirname() . '/include/functions.php';
include_once ICMS_ROOT_PATH . '/class/xoopstree.php';
include ICMS_ROOT_PATH . '/class/xoopsformloader.php';

$mytree = new XoopsTree( $xoopsDB -> prefix( 'imglossary_cats' ), 'categoryID', '0' );

echo "<div>";
echo "<div style='float: "._GLOBAL_LEFT."; font-size: smaller;'><a href='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/index.php'>" . $xoopsModule -> name() . "</a> | " . _MD_IMGLOSSARY_SUBMITART . "</div>";
echo "<div style='font-size: 18px; text-align: "._GLOBAL_RIGHT."; font-weight: bold; color: #F3AC03; letter-spacing: -1.5px; margin: 0; line-height: 18px;'>" . $xoopsModule -> name() . "</div>";
echo "</div><hr>";

echo "<br /><fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; font-size: 105%;'>" . sprintf( _MD_IMGLOSSARY_SUB_SNEWNAME, ucfirst( $xoopsModule -> name() ) ) . "</legend>";
echo "<div style='padding: 8px;'>". _MD_IMGLOSSARY_GOODDAY . " <b>" . $name . "</b>, " . _MD_IMGLOSSARY_SUB_SNEWNAMEDESC . "</div></fieldset>";

$sform = new XoopsThemeForm( _MD_IMGLOSSARY_SUB_SMNAME, 'storyform', xoops_getenv( 'PHP_SELF' ) );
$sform -> setExtra( 'enctype="multipart/form-data"' );

if ( $xoopsModuleConfig['multicats'] == '1' ) {
	ob_start();
		$mytree -> makeMySelBox( 'name', 'name', $categoryID );
		$sform -> addElement( new XoopsFormLabel( _MD_IMGLOSSARY_CATEGORY, ob_get_contents() ) );
	ob_end_clean();
}

// This part is common to edit/add
$sform -> addElement( new XoopsFormText( _MD_IMGLOSSARY_ENTRY, 'term', 50, 80, $term ), true );

$def_block = imglossary_getWysiwygForm( _MD_IMGLOSSARY_DEFINITION, 'definition', '', 15, 50 );
$def_block -> SetDescription( '<small>' . _MD_IMGLOSSARY_WRITEHERE . '</small>' );
$sform -> addElement( $def_block, false );

$sform -> addElement( new XoopsFormTextArea( _MD_IMGLOSSARY_REFERENCE, 'ref', $ref, 5, 50 ), false );
$sform -> addElement( new XoopsFormText( _MD_IMGLOSSARY_URL, 'url', 50, 80, $url ), false );

if ( is_object( $xoopsUser ) ) {
	$uid = $xoopsUser -> getVar( 'uid' );
	$sform -> addElement( new XoopsFormHidden( 'uid', $uid ) );

	$notify_checkbox = new XoopsFormCheckBox( '', 'notifypub', $notifypub );
	$notify_checkbox -> addOption( 1, _MD_IMGLOSSARY_NOTIFY );
	$sform -> addElement( $notify_checkbox );
}

// VARIOUS OPTIONS
	$options_tray = new XoopsFormElementTray( _MD_IMGLOSSARY_OPTIONS, '<br />' );

	$html_checkbox = new XoopsFormCheckBox( '', 'html', $html );
	$html_checkbox -> addOption( 1, _MD_IMGLOSSARY_DOHTML );
	$options_tray -> addElement( $html_checkbox );

	$smiley_checkbox = new XoopsFormCheckBox( '', 'smiley', $smiley );
	$smiley_checkbox -> addOption( 1, _MD_IMGLOSSARY_DOSMILEY );
	$options_tray -> addElement( $smiley_checkbox );

	$xcodes_checkbox = new XoopsFormCheckBox( '', 'xcodes', $xcodes );
	$xcodes_checkbox -> addOption( 1, _MD_IMGLOSSARY_DOXCODE );
	$options_tray -> addElement( $xcodes_checkbox );

	$breaks_checkbox = new XoopsFormCheckBox( '', 'breaks', $breaks );
	$breaks_checkbox -> addOption( 1, _MD_IMGLOSSARY_BREAKS );
	$options_tray -> addElement( $breaks_checkbox );

	$sform -> addElement( $options_tray );

if ( $xoopsModuleConfig['captcha'] ) {
	// Captcha Hack
	if ( class_exists( 'XoopsFormCaptcha' ) ) { 
		$sform -> addElement( new XoopsFormCaptcha() ); 
	} elseif ( class_exists( 'IcmsFormCaptcha' ) ) { 
		$sform -> addElement( new IcmsFormCaptcha() ); 
	}
	// Captcha Hack 
}

$button_tray = new XoopsFormElementTray( '', '' );
$hidden = new XoopsFormHidden( 'op', 'post' );
$button_tray -> addElement( $hidden );
$button_tray -> addElement( new XoopsFormButton( '', 'post', _MD_IMGLOSSARY_CREATE, 'submit' ) );

$sform -> addElement( $button_tray );
$sform -> display();

include ICMS_ROOT_PATH . '/footer.php';
?>