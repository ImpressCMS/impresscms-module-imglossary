<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: include/common.php
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

defined( 'ICMS_ROOT_PATH' ) or die( 'ICMS root path not defined' );

if ( !defined( 'IMGLOSSARY_DIRNAME' ) ) define( 'IMGLOSSARY_DIRNAME', $modversion['dirname'] = basename( dirname( dirname( __FILE__ ) ) ) );
if ( !defined( 'IMGLOSSARY_URL' ) ) define( 'IMGLOSSARY_URL', ICMS_URL . '/modules/' . IMGLOSSARY_DIRNAME . '/' );
if ( !defined( 'IMGLOSSARY_ROOT_PATH' ) ) define( 'IMGLOSSARY_ROOT_PATH', ICMS_ROOT_PATH . '/modules/' . IMGLOSSARY_DIRNAME . '/' );
if ( !defined( 'IMGLOSSARY_IMAGES_URL' ) ) define( 'IMGLOSSARY_IMAGES_URL', IMGLOSSARY_URL . 'images/' );
if ( !defined( 'IMGLOSSARY_ADMIN_URL' ) ) define( 'IMGLOSSARY_ADMIN_URL', IMGLOSSARY_URL . 'admin/' );

// Include the common language file of the module
icms_loadLanguageFile( 'imglossary', 'common' );