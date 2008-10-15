<?php
/**
 * $Id: storyform.inc.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

global $term, $definition, $ref, $url, $xoopsUser, $xoopsModule, $xoopsModuleConfig;

include_once ICMS_ROOT_PATH . '/class/xoopstree.php';
//include ICMS_ROOT_PATH . '/class/xoopslists.php';
include ICMS_ROOT_PATH . '/class/xoopsformloader.php';

$mytree = new XoopsTree( $xoopsDB -> prefix( 'imglossary_cats' ), "categoryID", "0" );

echo "<div>";
echo "<div style='float: left; font-size: smaller;'><a href='" . ICMS_URL . "'>" . _MD_IMGLOSSARY_HOME . "</a> >	<a href='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/index.php'>".$xoopsModule -> name()."</a> > "._MD_IMGLOSSARY_SUBMITART."</div>";
echo "<div style='font-size: 18px; text-align: right; font-weight: bold; color: #F3AC03; letter-spacing: -1.5px; margin: 0; line-height: 18px;'>" . $xoopsModule -> name() . "</div>";
echo "</div><hr>";

echo "<br /><fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; color: #292D30;'>" . sprintf( _MD_IMGLOSSARY_SUB_SNEWNAME, ucfirst( $xoopsModule -> name() ) ) . "</legend>";
echo "<div style='padding: 8px;'>". _MD_IMGLOSSARY_GOODDAY . " <b>" . $name . "</b>, " . _MD_IMGLOSSARY_SUB_SNEWNAMEDESC . "</div></fieldset>";

$sform = new XoopsThemeForm( _MD_IMGLOSSARY_SUB_SMNAME, "storyform", xoops_getenv( 'PHP_SELF' ) );
$sform -> setExtra( 'enctype="multipart/form-data"' );

if ( $xoopsModuleConfig['multicats'] == '1' )	{

	ob_start();
		//$sform -> addElement( new XoopsFormHidden( 'categoryID', $categoryID ) );
		$mytree -> makeMySelBox( "name", "name", $categoryID );
		$sform -> addElement( new XoopsFormLabel( _MD_IMGLOSSARY_CATEGORY, ob_get_contents() ) );
	ob_end_clean();

}

// This part is common to edit/add
$sform -> addElement( new XoopsFormText( _MD_IMGLOSSARY_ENTRY, 'term', 50, 80, $term ), true );

$def_block = new XoopsFormDhtmlTextArea( _MD_IMGLOSSARY_DEFINITION, 'definition', _MD_IMGLOSSARY_WRITEHERE, 15, 50 );
$def_block -> setExtra( 'onfocus="this.select()"' );
$sform -> addElement( $def_block );

$sform -> addElement( new XoopsFormTextArea( _MD_IMGLOSSARY_REFERENCE, 'ref', $ref, 5, 50 ), false );
$sform -> addElement( new XoopsFormText( _MD_IMGLOSSARY_URL, 'url', 50, 80, $url ), false );

if ( is_object( $xoopsUser ) ) {
	$uid = $xoopsUser -> getVar( 'uid' );
	$sform -> addElement( new XoopsFormHidden( 'uid', $uid ) );

	$notify_checkbox = new XoopsFormCheckBox( '', 'notifypub', $notifypub );
	$notify_checkbox -> addOption( 1, _MD_IMGLOSSARY_NOTIFY );
	$sform -> addElement( $notify_checkbox );
} 

$button_tray = new XoopsFormElementTray( '', '' );
$hidden = new XoopsFormHidden( 'op', 'post' );
$button_tray -> addElement( $hidden );
$button_tray -> addElement( new XoopsFormButton( '', 'post', _MD_IMGLOSSARY_CREATE, 'submit' ) );

$sform -> addElement( $button_tray );
//mondarse 
$sform -> display();
//unset( $hidden );
include XOOPS_ROOT_PATH . '/footer.php';
?>