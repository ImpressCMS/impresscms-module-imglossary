<?php 
/**
 * $Id: index.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
 
include_once ICMS_ROOT_PATH . "/class/xoopsformloader.php";

echo "<div>";
echo "<div style='float: left; font-size: smaller;'><a href='" . ICMS_URL . "'>" . _MD_IMGLOSSARY_HOME . "</a> >	<a href='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/index.php'>".$xoopsModule -> name()."</a> > "._MD_IMGLOSSARY_SUBMITART."</div>";
echo "<div style='font-size: 18px; text-align: right; font-weight: bold; color: #F3AC03; letter-spacing: -1.5px; margin: 0; line-height: 18px;'>" . $xoopsModule -> name() . "</div>";
echo "</div><hr>";

echo "<br /><fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; font-size: 105%;'>" . sprintf( _MD_IMGLOSSARY_ASKFORDEF, ucfirst( $xoopsModule -> name() ) ) . "</legend>";
echo "<div style='padding: 8px;'>". _MD_IMGLOSSARY_INTROREQUEST . "</div></fieldset>";

$username_v = !empty( $xoopsUser ) ? $xoopsUser -> getVar( "uname", "E" ) : "";
$usermail_v = !empty( $xoopsUser ) ? $xoopsUser -> getVar( "email", "E" ) : "";
$notifypub = '1';

$rform = new XoopsThemeForm( _MD_IMGLOSSARY_REQUESTFORM, "requestform", "request.php" );
$rform -> setExtra( 'enctype="multipart/form-data"' );

if ( !$xoopsUser ) {
	$username_v = _MD_IMGLOSSARY_ANONYMOUS;
}

$name_text = new XoopsFormText( _MD_IMGLOSSARY_USERNAME, 'username', 40, 100, $username_v );
$rform -> addElement( $name_text, false );

$email_text = new XoopsFormText( _MD_IMGLOSSARY_USERMAIL, 'usermail', 40, 100, $usermail_v );
$rform -> addElement( $email_text, false );

$reqterm_text = new XoopsFormText( _MD_IMGLOSSARY_REQTERM, 'reqterm', 40, 150 );
$rform -> addElement( $reqterm_text, true );

if ( is_object( $xoopsUser ) ) {
	$notify_checkbox = new XoopsFormCheckBox( '', 'notifypub', $notifypub );
	$notify_checkbox -> addOption( 1, _MD_IMGLOSSARY_NOTIFY );
	$rform -> addElement( $notify_checkbox );
} 

// Captcha Hack
if ( $xoopsModuleConfig['captcha'] == 1 ) {
	$rform -> addElement( new XoopsFormCaptcha() );
}
// Captcha Hack

$submit_button = new XoopsFormButton( "", "submit", _MD_IMGLOSSARY_SUBMIT, "submit" );
$rform -> addElement( $submit_button );
$rform -> display();

?>