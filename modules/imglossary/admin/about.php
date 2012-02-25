<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: admin/about.php
*
* @copyright	http://www.xoops.org/ The XOOPS Project
* @copyright	XOOPS_copyrights.txt
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		imGlossary - a multicategory glossary
* @since		1.00
* @author		McDonald
* @version		$Id$
*/

include_once 'admin_header.php';
include_once ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/include/imglossary_moduleabout.php';
$aboutObj = new imGlossaryModuleAbout();
$aboutObj -> render();
?>