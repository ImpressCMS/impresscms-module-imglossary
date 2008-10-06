<?php
/**
 * $Id: index.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

include "header.php";
global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsModuleConfig;

if ( empty($_POST['submit']) ) {

	$xoopsOption['template_main'] = 'wb_request.html';
	include XOOPS_ROOT_PATH . "/header.php";
	include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
	
	$username_v = !empty($xoopsUser) ? $xoopsUser -> getVar( "uname", "E" ) : "";
	$usermail_v = !empty($xoopsUser) ? $xoopsUser -> getVar( "email", "E" ) : "";
	$notifypub = '1';
	include "include/requestform.php";
	$xoopsTpl -> assign ( 'modulename', $xoopsModule -> dirname() );

	$rform -> assign( $xoopsTpl );

	$xoopsTpl -> assign( 'lang_modulename', $xoopsModule -> name() );
	$xoopsTpl -> assign( 'lang_moduledirname', $xoopsModule -> dirname() );

	$xoopsTpl -> assign( 'xoops_module_header', '<link rel="stylesheet" type="text/css" href="style.css" />');

	include XOOPS_ROOT_PATH . "/footer.php";
} else {
	extract($_POST);
	$display = "D";
	$myts =& MyTextSanitizer::getInstance();
	$usermail = (isset($_POST['usermail'])) ? $myts -> stripSlashesGPC($_POST['usermail']) : '';
	$username = (isset($_POST['username'])) ? $myts -> stripSlashesGPC($_POST['username']) : '';
	$reqterm = (isset($_POST['reqterm'])) ? $myts -> makeTboxData4Save($_POST['reqterm']) : '';
	$notifypub = (isset($_POST['notifypub'])) ? intval($_POST['notifypub']) : 1;
	$html = (isset($_POST['html'])) ? intval($_POST['html']) : 1;
	$smiley = (isset($_POST['smiley'])) ? intval($_POST['smiley']) : 1;
	$xcodes = (isset($_POST['xcodes'])) ? intval($_POST['xcodes']) : 1;
	if ( $xoopsUser ) {
		$user = $xoopsUser -> getVar("uid");
	} else {
		$user = _MD_WB_ANONYMOUS;
	}
	$submit = 1;
	$date = time();
	$offline = 1;
	$request = 1;
	$ref = '';
	$url = '';
	$init = substr( $reqterm, 0, 1 );

	$xoopsDB -> query( "INSERT INTO " . $xoopsDB -> prefix( 'wbentries' ) . " (entryID, term, init, ref, url, uid, submit, datesub, html, smiley, xcodes, offline, notifypub, request ) VALUES ('', '$reqterm', '$init', '$ref', '$url', '$user', '$submit', '$date', '$html', '$smiley', '$xcodes', '$offline', '$notifypub', '$request' )");

	$adminmail = $xoopsConfig['adminmail'];

	if ($xoopsUser) {
		$logname = $xoopsUser -> getVar( "uname", "E");
	} else {
		$logname = $xoopsConfig['anonymous'];
	}

	if ($xoopsUser) {
		$result = $xoopsDB -> query( "SELECT email FROM " . $xoopsDB -> prefix( 'users' ) . " WHERE uname=$logname" );
		list($address) = $xoopsDB->fetchRow($result);
	} else {
		$address = $xoopsConfig['adminmail'];
	}

	if ( $xoopsModuleConfig['mailtoadmin'] == 1 )	{
		$adminMessage = sprintf( _MD_WB_WHOASKED, $logname );
		$adminMessage .= "<b>" . $reqterm . "</b>\n";
		$adminMessage .= "" . _MD_WB_EMAILLEFT . " $address\n";
		$adminMessage .= "\n";
		if ($notifypub == '1') {
			$adminMessage .= _MD_WB_NOTIFYONPUB;
		}
		$adminMessage .= "\n" . $HTTP_SERVER_VARS['HTTP_USER_AGENT'] . "\n";
		$subject = $xoopsConfig['sitename'] . " - " . _MD_WB_DEFINITIONREQ;
		$xoopsMailer =& getMailer();
		$xoopsMailer -> useMail();
		$xoopsMailer -> setToEmails( $xoopsConfig['adminmail'] );
		$xoopsMailer -> setFromEmail( $address );
		$xoopsMailer -> setFromName( $xoopsConfig['sitename'] );
		$xoopsMailer -> setSubject( $subject );
		$xoopsMailer -> setBody( $adminMessage );
		$xoopsMailer -> send();
		$messagesent = sprintf( _MD_WB_MESSAGESENT, $xoopsConfig['sitename'] ) . "<br />" . _MD_WB_THANKS1 . "";
		}

	$conf_subject = _MD_WB_THANKS2;
	$userMessage = sprintf( _MD_WB_GOODDAY2, $logname );
	$userMessage .= "\n\n";
	$userMessage .= sprintf( _MD_WB_THANKYOU, $xoopsConfig['sitename'] );
	$userMessage .= "\n";
	$userMessage .= sprintf( _MD_WB_REQUESTSENT, $xoopsConfig['sitename'] );
	$userMessage .= "\n";
	$userMessage .= "--------------\n";
	$userMessage .= "" . $xoopsConfig['sitename'] . " " . _MD_WB_WEBMASTER . "\n"; 
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
		$messagesent .= sprintf( _MD_WB_SENTCONFIRMMAIL, $address );
	} else {
		$messagesent = sprintf( _MD_WB_SENTCONFIRMMAIL, $address );
	}
	redirect_header( "index.php", 2, $messagesent );
}
?>