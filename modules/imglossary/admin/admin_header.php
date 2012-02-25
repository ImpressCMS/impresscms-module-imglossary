<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: admin/admin_header.php
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

include '../../../include/cp_header.php';

include_once ICMS_ROOT_PATH . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/include/common.php';
include_once ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/include/functions.php';
include_once ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/class/myts_extended.php';

$imglmyts = new imglossaryTextSanitizer(); // MyTextSanitizer object

if ( is_object( icms::$user) ) {
	if ( !icms::$user -> isAdmin( icms::$module -> getVar( 'mid' ) ) ) {
		redirect_header( ICMS_ROOT_PATH . '/', 1, _NOPERM );
		exit();
	}
} else {
	redirect_header ( ICMS_ROOT_PATH . '/', 1, _NOPERM );
	exit();
}

global $imglmyts;
?>