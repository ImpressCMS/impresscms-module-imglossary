<?php 
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: include/requestform.php
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

echo '<div>';
echo '<div style="float: '._GLOBAL_LEFT.'; font-size: smaller;"><a href="' . ICMS_URL . '">' . _MD_IMGLOSSARY_HOME . '</a> ><a href="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/index.php">' . icms::$module -> getVar( 'name' ) . '</a> > ' . _MD_IMGLOSSARY_SUBMITART . '</div>';
echo '<div style="font-size: 18px; text-align: '._GLOBAL_RIGHT.'; font-weight: bold; color: #F3AC03; letter-spacing: -1.5px; margin: 0; line-height: 18px;">' . icms::$module -> getVar( 'name' ) . '</div>';
echo '</div><hr>';

echo '<br /><fieldset style="border: #e8e8e8 1px solid;"><legend style="display: inline; font-weight: bold; font-size: 105%;">' . sprintf( _MD_IMGLOSSARY_ASKFORDEF, icms::$module -> getVar( 'name' ) ) . '</legend>';
echo '<div style="padding: 8px;">' . _MD_IMGLOSSARY_INTROREQUEST . '</div></fieldset><br />';

$username_v = !empty( icms::$user ) ? icms::$user -> getVar( 'uname', 'E' ) : '';
$usermail_v = !empty( icms::$user ) ? icms::$user -> getVar( 'email', 'E' ) : '';
$notifypub = '1';

$rform = new icms_form_Theme( _MD_IMGLOSSARY_REQUESTFORM, 'requestform', 'request.php' );
$rform -> setExtra( 'enctype="multipart/form-data"' );

if ( !icms::$user ) {
	$username_v = _MD_IMGLOSSARY_ANONYMOUS;
}

$name_text = new icms_form_elements_Text( _MD_IMGLOSSARY_USERNAME, 'username', 40, 100, $username_v );
$rform -> addElement( $name_text, false );

$email_text = new icms_form_elements_Text( _MD_IMGLOSSARY_USERMAIL, 'usermail', 40, 100, $usermail_v );
$rform -> addElement( $email_text, false );

$reqterm_text = new icms_form_elements_Text( _MD_IMGLOSSARY_REQTERM, 'reqterm', 40, 150 );
$rform -> addElement( $reqterm_text, true );

//if ( is_object( icms::$user ) ) {
//	$notify_checkbox = new XoopsFormCheckBox( '', 'notifypub', $notifypub );
//	$notify_checkbox -> addOption( 0, _MD_IMGLOSSARY_NOTIFY );
//	$rform -> addElement( $notify_checkbox );
//}

if ( icms::$module -> config['captcha'] ) {
	// Captcha Hack
	$rform -> addElement( new icms_form_elements_Captcha( _SECURITYIMAGE_GETCODE, 'scode' ), true );
	// Captcha Hack
}

$submit_button = new icms_form_elements_Button( '', 'submit', _MD_IMGLOSSARY_SUBMIT, 'submit' );
$rform -> addElement( $submit_button );
$rform -> display();
?>