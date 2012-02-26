<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: include/onupdate.inc.php
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
* @since		1.03
* @author		modified by McDonald
* @version		$Id$
*/
 
if ( !defined( 'ICMS_ROOT_PATH' ) ) { die( 'ICMS root path not defined' ); }

define( 'IMGLOSSARY_DB_VERSION', 2 );

function icms_module_update_imglossary( &$module, $oldversion = null, $dbversion = null ) {
	return TRUE;
}

function icms_module_install_imglossary( $module ) {
	return TRUE;
}