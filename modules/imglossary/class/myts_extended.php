<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: /class/myts_extended.php
*
* @copyright	http://www.xoops.org/ The XOOPS Project
* @copyright	XOOPS_copyrights.txt
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		WF-Links 
* @since		1.03
* @author		John N
* ----------------------------------------------------------------------------------------------------------
* 				WF-Links 
* @since		1.03b and 1.03c
* @author		McDonald
* ----------------------------------------------------------------------------------------------------------
* 				imGlossary
* @since		1.01
* @author		McDonald
* @version		$Id$
*/

class imglossaryTextSanitizer extends MyTextSanitizer {
	function imglossaryTextSanitizer() {}
	function htmlSpecialCharsStrip( $text ) {
		return icms_core_DataFilter::htmlSpecialChars( icms_core_DataFilter::stripSlashesGPC( $text) );
	}
}
?>