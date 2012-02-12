<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: submit.php
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

include '../../mainfile.php';

include ICMS_ROOT_PATH . '/header.php';

global $icmsConfig;

$result = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) );
if ( icms::$xoopsDB -> getRowsNum( $result ) == '0' && icms::$module -> config['multicats'] == '1' ) {
	redirect_header( 'index.php', 1, _AM_IMGLOSSARY_NOCOLEXISTS );
	exit();
}

if ( !is_object( icms::$user ) && icms::$module -> config['anonpost'] == 0 ) {
	redirect_header( 'index.php', 1, _NOPERM );
	exit();
}

if ( is_object( icms::$user ) && icms::$module -> config['allowsubmit'] == 0 ) {
	redirect_header( 'index.php', 1, _NOPERM );
	exit();
}

$op = 'form';

if ( isset( $_POST['post'] ) ) {
	$op = trim( 'post' );
} elseif ( isset( $_POST['edit'] ) ) {
	$op = trim( 'edit' );
}

if( !isset( $_POST['suggest'] ) ) {
	$suggest = isset( $_GET['suggest'] ) ? intval( $_GET['suggest'] ) : 0;
} else {
	$suggest = intval( $_POST['suggest'] );
}

if ( $suggest > 0 ) {
	$terminosql = icms::$xoopsDB -> query( 'SELECT term FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE datesub<' . time() . ' AND datesub>0 AND request=1 AND entryID=' . $suggest . '' );
	list( $termino ) = icms::$xoopsDB -> fetchRow( $terminosql );
} else {
	$termino = '';
}

switch ( $op ) {
	case 'post':

		global $icmsConfig;

		if ( icms::$module -> config['captcha'] == 1 ) {
			// Captcha Hack
			// Verify entered code 
			$icmsCaptcha = icms_form_elements_captcha_Object::instance();
			if ( !$icmsCaptcha -> verify( true ) ) {
				redirect_header( 'submit.php', 2, $icmsCaptcha -> getMessage() );
			}
			// Captcha Hack
		}

		include_once ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/include/functions.php';

		$html = 1;
		if ( icms::$user ) {
			$uid = icms::$user -> getVar( 'uid' );
			if ( icms::$user -> isAdmin( icms::$module -> getVar( 'mid' ) ) ) {
				$html = empty( $html ) ? 0 : 1;
			} 
		} else {
			if ( icms::$module -> config['anonpost'] == 1 ) {
				$uid = 0;
			} else {
				redirect_header( 'index.php', 3, _NOPERM );
				exit();
			}
		}

		$notifypub = isset( $notifypub ) ? intval( $notifypub ) : 1;

		if ( icms::$module -> config['multicats'] == 1 ) {
			$categoryID = intval( $_POST['categoryID'] );
		} else {
			$categoryID = 0;
		}

		$term = icms_core_DataFilter::htmlSpecialChars( $_POST['term'] );
		$init = substr( $term, 0, 1 );
		$definition = icms_core_DataFilter::addSlashes( $_POST['definition'] );
		$ref = icms_core_DataFilter::addSlashes( $_POST['ref'] );
		$url = icms_core_DataFilter::addSlashes( $_POST['url'] );

		if ( empty($url) ) {
			$url = '';
		}

		$datesub = time();
		$submit = 1;
		$offline = 1;
		$request = 0;

		if ( icms::$module -> config['autoapprove'] == 1 ) {
			$submit = 0;
			$offline = 0;
		} 

		$result = icms::$xoopsDB -> query( "INSERT INTO " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " (entryID, categoryID, term, init, definition, ref, url, uid, submit, datesub, offline, notifypub ) VALUES ('', '$categoryID', '$term', '$init', '$definition', '$ref', '$url', '$uid', '$submit', '$datesub', '$offline', '$notifypub')" );
		$entryID = icms::$xoopsDB -> getInsertId();

		if ( $result ) {
			if ( !is_object( icms::$user ) ) {
				$username = _MD_IMGLOSSARY_GUEST;
				$usermail = '';
			} else {
				$username = icms::$user -> getVar( 'uname', 'E' );
				$result = icms::$xoopsDB -> query( 'SELECT email FROM ' . icms::$xoopsDB -> prefix( 'users' ) . ' WHERE uname=$username' );
				list( $usermail ) = icms::$xoopsDB -> fetchRow( $result );
			}

			if ( icms::$module -> config['mailtoadmin'] == 1 ) {
				$adminMessage = sprintf( _MD_IMGLOSSARY_WHOSUBMITTED, $username );
				$adminMessage .= '<b>' . $term . '</b>\n';
				$adminMessage .= _MD_IMGLOSSARY_EMAILLEFT . ' $usermail\n';
				$adminMessage .= '\n';

				if ($notifypub == '1') {
					$adminMessage .= _MD_IMGLOSSARY_NOTIFYONPUB;
				}

				$adminMessage .= '\n' . $_SERVER['HTTP_USER_AGENT'] . '\n';
				$subject = $icmsConfig['sitename'] . " - " . _MD_IMGLOSSARY_DEFINITIONSUB;
				$xoopsMailer = new icms_messaging_Handler();
				$xoopsMailer -> useMail();
				$xoopsMailer -> setToEmails( $icmsConfig['adminmail'] );
				$xoopsMailer -> setFromEmail( $usermail );
				$xoopsMailer -> setFromName( $icmsConfig['sitename'] );
				$xoopsMailer -> setSubject( $subject );
				$xoopsMailer -> setBody( $adminMessage );
				$xoopsMailer -> send();
				$messagesent = sprintf( _MD_IMGLOSSARY_MESSAGESENT, $icmsConfig['sitename'] ) . '<br />' . _MD_IMGLOSSARY_THANKS1;
			}

			if ( icms::$module -> config['autoapprove'] == 1 ) {
				redirect_header( 'index.php', 2, _MD_IMGLOSSARY_RECEIVEDANDAPPROVED );
			} else {
				redirect_header( 'index.php', 2, _MD_IMGLOSSARY_RECEIVED );
			}
		} else {
			redirect_header( 'submit.php', 2, _MD_IMGLOSSARY_ERRORSAVINGDB );
		}
		exit();
		break;

	case 'form':
	default:
		global $_SERVER;

		if ( !is_object( icms::$user ) ) {
			$name = _MD_IMGLOSSARY_GUEST;
		} else {
			$name = ucfirst( icms::$user -> getVar( 'uname' ) );
		}

		$block = 1;
		$categoryID = 0;
		$notifypub = 0;
		$term = $termino;
		$definition = '';
		$ref = '';
		$url = '';

		include_once 'include/storyform.inc.php';

		$sform -> assign( $xoopsTpl );

		break;
} 
?>