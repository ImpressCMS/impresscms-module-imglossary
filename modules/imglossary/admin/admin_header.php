<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: admin/admin_header.php
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

include '../../../mainfile.php';
include '../../../include/cp_header.php';

$glossdirname = basename( dirname( dirname( __FILE__ ) ) );

include_once ICMS_ROOT_PATH . '/modules/' . $glossdirname . '/include/functions.php';
include_once ICMS_ROOT_PATH . '/class/xoopstree.php';
include_once ICMS_ROOT_PATH . '/class/xoopslists.php';
include_once ICMS_ROOT_PATH . '/class/xoopsformloader.php';
include_once ICMS_ROOT_PATH . '/kernel/module.php';
$myts =& MyTextSanitizer::getInstance();

if ( is_object( $xoopsUser) ) {
	$xoopsModule = XoopsModule::getByDirname( $glossdirname );
	if ( !$xoopsUser -> isAdmin( $xoopsModule -> mid() ) ) {
		redirect_header( ICMS_ROOT_PATH . "/", 1, _NOPERM );
		exit();
	}
} else {
	redirect_header ( ICMS_ROOT_PATH . "/", 1, _NOPERM );
	exit();
}

?>