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
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* ----------------------------------------------------------------------------------------------------------
* @package		Wordbook - a multicategory glossary
* @since			1.16
* @author		hsalazar
* ----------------------------------------------------------------------------------------------------------
* @package		imGlossary - a multicategory glossary
* @since			1.00
* @author		modified by McDonald
* @version		$Id$
*/

global $term, $definition, $ref, $url, $xoopsUser, $xoopsModule, $xoopsModuleConfig;

include_once ICMS_ROOT_PATH . '/class/xoopstree.php';
include ICMS_ROOT_PATH . '/class/xoopsformloader.php';

$mytree = new XoopsTree( $xoopsDB -> prefix( 'imglossary_cats' ), "categoryID", "0" );

echo "<div>";
echo "<div style='float: left; font-size: smaller;'><a href='" . ICMS_URL . "'>" . _MD_IMGLOSSARY_HOME . "</a> >	<a href='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/index.php'>".$xoopsModule -> name()."</a> > "._MD_IMGLOSSARY_SUBMITART."</div>";
echo "<div style='font-size: 18px; text-align: right; font-weight: bold; color: #F3AC03; letter-spacing: -1.5px; margin: 0; line-height: 18px;'>" . $xoopsModule -> name() . "</div>";
echo "</div><hr>";

echo "<br /><fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; font-size: 105%;'>" . sprintf( _MD_IMGLOSSARY_SUB_SNEWNAME, ucfirst( $xoopsModule -> name() ) ) . "</legend>";
echo "<div style='padding: 8px;'>". _MD_IMGLOSSARY_GOODDAY . " <b>" . $name . "</b>, " . _MD_IMGLOSSARY_SUB_SNEWNAMEDESC . "</div></fieldset>";

$sform = new XoopsThemeForm( _MD_IMGLOSSARY_SUB_SMNAME, "storyform", xoops_getenv( 'PHP_SELF' ) );
$sform -> setExtra( 'enctype="multipart/form-data"' );

if ( $xoopsModuleConfig['multicats'] == '1' ) {
	ob_start();
		//$sform -> addElement( new XoopsFormHidden( 'categoryID', $categoryID ) );
		$mytree -> makeMySelBox( "name", "name", $categoryID );
		$sform -> addElement( new XoopsFormLabel( _MD_IMGLOSSARY_CATEGORY, ob_get_contents() ) );
	ob_end_clean();
}

// This part is common to edit/add
$sform -> addElement( new XoopsFormText( _MD_IMGLOSSARY_ENTRY, 'term', 50, 80, $term ), true );

$def_block = imglossary_getWysiwygForm( _MD_IMGLOSSARY_DEFINITION, 'definition', _MD_IMGLOSSARY_WRITEHERE, 15, 50 );
$def_block -> setExtra( 'onfocus="this.select()"' );
$sform -> addElement( $def_block, true );

$sform -> addElement( new XoopsFormTextArea( _MD_IMGLOSSARY_REFERENCE, 'ref', $ref, 5, 50 ), false );
$sform -> addElement( new XoopsFormText( _MD_IMGLOSSARY_URL, 'url', 50, 80, $url ), false );

if ( is_object( $xoopsUser ) ) {
	$uid = $xoopsUser -> getVar( 'uid' );
	$sform -> addElement( new XoopsFormHidden( 'uid', $uid ) );

	$notify_checkbox = new XoopsFormCheckBox( '', 'notifypub', $notifypub );
	$notify_checkbox -> addOption( 1, _MD_IMGLOSSARY_NOTIFY );
	$sform -> addElement( $notify_checkbox );
}

// Captcha Hack
if ( $xoopsModuleConfig['captcha'] == 1 ) {
	$sform -> addElement( new XoopsFormCaptcha() );
}
// Captcha Hack 

$button_tray = new XoopsFormElementTray( '', '' );
$hidden = new XoopsFormHidden( 'op', 'post' );
$button_tray -> addElement( $hidden );
$button_tray -> addElement( new XoopsFormButton( '', 'post', _MD_IMGLOSSARY_CREATE, 'submit' ) );

$sform -> addElement( $button_tray );
$sform -> display();

include XOOPS_ROOT_PATH . '/footer.php';
?>