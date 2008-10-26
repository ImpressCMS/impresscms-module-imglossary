<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: request.php
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

include 'header.php';

global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsModuleConfig;

if ( empty( $_POST['submit'] ) ) {
	include ICMS_ROOT_PATH . '/header.php';
	include 'include/requestform.php';
	include ICMS_ROOT_PATH . '/footer.php';
} else {
	// Captcha Hack
	if ( @include_once ICMS_ROOT_PATH . '/class/captcha/captcha.php' ) {
		if ( $xoopsModuleConfig['captcha'] == 1 ) {
			$xoopsCaptcha = XoopsCaptcha::instance();
				if ( ! $xoopsCaptcha -> verify( true ) ) {
						redirect_header( 'request.php', 2, $xoopsCaptcha -> getMessage() );
				}
			}
		}			
	// Captcha Hack
	extract( $_POST );
	$display = 'D';
	$myts =& MyTextSanitizer::getInstance();
	$usermail = ( isset( $_POST['usermail'] ) ) ? $myts -> stripSlashesGPC( $_POST['usermail'] ) : '';
	$username = ( isset( $_POST['username'] ) ) ? $myts -> stripSlashesGPC( $_POST['username'] ) : '';
	$reqterm  = ( isset( $_POST['reqterm'] ) ) ? $myts -> makeTboxData4Save( $_POST['reqterm'] ) : '';
	$notifypub = (isset($_POST['notifypub'])) ? intval($_POST['notifypub']) : 1;
	$html   = ( isset( $_POST['html'] ) ) ? intval( $_POST['html'] ) : 1;
	$smiley = ( isset( $_POST['smiley'] ) ) ? intval( $_POST['smiley'] ) : 1;
	$xcodes = ( isset( $_POST['xcodes'] ) ) ? intval( $_POST['xcodes'] ) : 1;
	if ( $xoopsUser ) {
		$user = $xoopsUser -> getVar( 'uid' );
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

	$xoopsDB -> query( "INSERT INTO " . $xoopsDB -> prefix( 'imglossary_entries' ) . " (entryID, term, init, ref, url, uid, submit, datesub, html, smiley, xcodes, offline, notifypub, request ) VALUES ('', '$reqterm', '$init', '$ref', '$url', '$user', '$submit', '$date', '$html', '$smiley', '$xcodes', '$offline', '$notifypub', '$request' )" );

	$adminmail = $xoopsConfig['adminmail'];

	if ( $xoopsUser ) {
		$logname = $xoopsUser -> getVar( 'uname', 'E');
	} else {
		$logname = $xoopsConfig['anonymous'];
	}

	if ( $xoopsUser ) {
		$result = $xoopsDB -> query( "SELECT email FROM " . $xoopsDB -> prefix( 'users' ) . " WHERE uname=" . $logname );
		list($address) = $xoopsDB -> fetchRow( $result );
	} else {
		$address = $xoopsConfig['adminmail'];
	}

	if ( $xoopsModuleConfig['mailtoadmin'] == 1 )	{
		$adminMessage = sprintf( _MD_IMGLOSSARY_WHOASKED, $logname );
		$adminMessage .= "<b>" . $reqterm . "</b>\n";
		$adminMessage .= "" . _MD_IMGLOSSARY_EMAILLEFT . " $address\n";
		$adminMessage .= "\n";
		if ( $notifypub == '1' ) {
			$adminMessage .= _MD_IMGLOSSARY_NOTIFYONPUB;
		}
		$adminMessage .= "\n" . $HTTP_SERVER_VARS['HTTP_USER_AGENT'] . "\n";
		$subject = $xoopsConfig['sitename'] . " - " . _MD_IMGLOSSARY_DEFINITIONREQ;
		$xoopsMailer =& getMailer();
		$xoopsMailer -> useMail();
		$xoopsMailer -> setToEmails( $xoopsConfig['adminmail'] );
		$xoopsMailer -> setFromEmail( $address );
		$xoopsMailer -> setFromName( $xoopsConfig['sitename'] );
		$xoopsMailer -> setSubject( $subject );
		$xoopsMailer -> setBody( $adminMessage );
		$xoopsMailer -> send();
		$messagesent = sprintf( _MD_IMGLOSSARY_MESSAGESENT, $xoopsConfig['sitename'] ) . "<br />" . _MD_IMGLOSSARY_THANKS1 . "";
		}

	$conf_subject = _MD_IMGLOSSARY_THANKS2;
	$userMessage = sprintf( _MD_IMGLOSSARY_GOODDAY2, $logname );
	$userMessage .= "\n\n";
	$userMessage .= sprintf( _MD_IMGLOSSARY_THANKYOU, $xoopsConfig['sitename'] );
	$userMessage .= "\n";
	$userMessage .= sprintf( _MD_IMGLOSSARY_REQUESTSENT, $xoopsConfig['sitename'] );
	$userMessage .= "\n";
	$userMessage .= "--------------\n";
	$userMessage .= "" . $xoopsConfig['sitename'] . " " . _MD_IMGLOSSARY_WEBMASTER . "\n"; 
	$userMessage .= "" . $xoopsConfig['adminmail'] . "";
	$xoopsMailer =& getMailer();
	$xoopsMailer -> useMail();
	$xoopsMailer -> setToEmails( $address );
	$xoopsMailer -> setFromEmail( $xoopsConfig['adminmail'] );
	$xoopsMailer -> setFromName( $xoopsConfig['sitename'] );
	$xoopsMailer -> setSubject( $conf_subject );
	$xoopsMailer -> setBody( $userMessage );
	$xoopsMailer -> send();
	
	if ( $xoopsModuleConfig['mailtoadmin'] == 1 ) {
		$messagesent .= sprintf( _MD_IMGLOSSARY_SENTCONFIRMMAIL, $address );
	} else {
		$messagesent = sprintf( _MD_IMGLOSSARY_SENTCONFIRMMAIL, $address );
	}
	redirect_header( 'index.php', 2, $messagesent );
}
?>