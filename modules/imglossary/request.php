<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: request.php
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

include 'header.php';

global $icmsConfig;

if ( empty( $_POST['submit'] ) ) {
	include ICMS_ROOT_PATH . '/header.php';
	include 'include/requestform.php';
	include ICMS_ROOT_PATH . '/footer.php';
} else {

	if ( icms::$module -> config['captcha'] ) {
		// Captcha Hack
		// Verify entered code 
		$icmsCaptcha = icms_form_elements_captcha_Object::instance(); 
		if ( !$icmsCaptcha -> verify( true ) ) { 
			redirect_header( 'submit.php', 2, $icmsCaptcha -> getMessage() ); 
		}
		// Captcha Hack
	}

	extract( $_POST );
	$display	= 'D';
	$usermail	= ( isset( $_POST['usermail'] ) ) ? icms_core_DataFilter::stripSlashesGPC( $_POST['usermail'] ) : '';
	$username	= ( isset( $_POST['username'] ) ) ? icms_core_DataFilter::stripSlashesGPC( $_POST['username'] ) : '';
	$reqterm	= ( isset( $_POST['reqterm'] ) ) ? icms_core_DataFilter::addSlashes( $_POST['reqterm'] ) : '';
	$notifypub	= ( isset($_POST['notifypub'] ) ) ? intval( $_POST['notifypub'] ) : 1;

	if ( icms::$user ) {
		$user = icms::$user -> getVar( 'uid' );
	} else {
		$user = _MD_IMGLOSSARY_ANONYMOUS;
	}
	$submit = 1;
	$date = time();
	$offline = 1;
	$request = 1;
	$ref = '';
	$url = '';
	$init = substr( $reqterm, 0, 1 );

	icms::$xoopsDB -> query( "INSERT INTO " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " (entryid, term, init, ref, url, uid, submit, datesub, offline, notifypub, request ) VALUES ('', '$reqterm', '$init', '$ref', '$url', '$user', '$submit', '$date', '$offline', '$notifypub', '$request' )" );

	$adminmail = $icmsConfig['adminmail'];

	if ( icms::$user ) {
		$logname = icms::$user -> getVar( 'uname', 'E');
	} else {
		$logname = $icmsConfig['anonymous'];
	}

	if ( icms::$user ) {
		$result = icms::$xoopsDB -> query( 'SELECT email FROM ' . icms::$xoopsDB -> prefix( 'users' ) . ' WHERE uname=' . $logname );
		list($address) = icms::$xoopsDB -> fetchRow( $result );
	} else {
		$address = $icmsConfig['adminmail'];
	}

	if ( icms::$module -> config['mailtoadmin'] == 1 )	{
		$adminMessage = sprintf( _MD_IMGLOSSARY_WHOASKED, $logname );
		$adminMessage .= '<b>' . $reqterm . '</b>\n';
		$adminMessage .= _MD_IMGLOSSARY_EMAILLEFT . ' $address\n';
		$adminMessage .= '\n';
		if ( $notifypub == '1' ) {
			$adminMessage .= _MD_IMGLOSSARY_NOTIFYONPUB;
		}
		$adminMessage .= '\n' . $HTTP_SERVER_VARS['HTTP_USER_AGENT'] . '\n';
		$subject = $icmsConfig['sitename'] . " - " . _MD_IMGLOSSARY_DEFINITIONREQ;
		$xoopsMailer = new icms_messaging_Handler();
		$xoopsMailer -> useMail();
		$xoopsMailer -> setToEmails( $icmsConfig['adminmail'] );
		$xoopsMailer -> setFromEmail( $address );
		$xoopsMailer -> setFromName( $icmsConfig['sitename'] );
		$xoopsMailer -> setSubject( $subject );
		$xoopsMailer -> setBody( $adminMessage );
		$xoopsMailer -> send();
		$messagesent = sprintf( _MD_IMGLOSSARY_MESSAGESENT, $icmsConfig['sitename'] ) . '<br />' . _MD_IMGLOSSARY_THANKS1;
	}

	$conf_subject = _MD_IMGLOSSARY_THANKS2;
	$userMessage = sprintf( _MD_IMGLOSSARY_GOODDAY2, $logname );
	$userMessage .= '\n\n';
	$userMessage .= sprintf( _MD_IMGLOSSARY_THANKYOU, $icmsConfig['sitename'] );
	$userMessage .= '\n';
	$userMessage .= sprintf( _MD_IMGLOSSARY_REQUESTSENT, $icmsConfig['sitename'] );
	$userMessage .= '\n';
	$userMessage .= '--------------\n';
	$userMessage .= $icmsConfig['sitename'] . ' ' . _MD_IMGLOSSARY_WEBMASTER . '\n'; 
	$userMessage .= $icmsConfig['adminmail'];
	$xoopsMailer = new icms_messaging_Handler();
	$xoopsMailer -> useMail();
	$xoopsMailer -> setToEmails( $address );
	$xoopsMailer -> setFromEmail( $icmsConfig['adminmail'] );
	$xoopsMailer -> setFromName( $icmsConfig['sitename'] );
	$xoopsMailer -> setSubject( $conf_subject );
	$xoopsMailer -> setBody( $userMessage );
	$xoopsMailer -> send();

	if ( icms::$module -> config['mailtoadmin'] == 1 ) {
		$messagesent .= sprintf( _MD_IMGLOSSARY_SENTCONFIRMMAIL, $address );
	} else {
		$messagesent = sprintf( _MD_IMGLOSSARY_SENTCONFIRMMAIL, $address );
	}
	redirect_header( 'index.php', 2, $messagesent );
}
?>