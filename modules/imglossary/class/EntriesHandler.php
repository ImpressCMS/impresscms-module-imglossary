<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: class/EntriesHandler.php
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

defined( 'ICMS_ROOT_PATH' ) or die ( 'ICMS root path not defined' );

class mod_imglossary_EntriesHandler extends icms_ipf_Handler {
	public function __construct( &$db ) {
		parent::__construct( $db, 'entries', 'entryID', '', '', basename( dirname( dirname( __FILE__ ) ) ) );
	}
}