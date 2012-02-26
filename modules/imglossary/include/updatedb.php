<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: iclude/update.php
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

$imglossary_modversion	= icms::$module -> getVar( 'version' );
$imglossary_dbversion	= icms::$module -> getVar( 'dbversion' );
	if ( $imglossary_dbversion = 1 ) {
		$db =& Database::getInstance();
		$sql = "ALTER TABLE " . $db -> prefix( 'imglossary_entries' ) . " CHANGE `entryID` `entryid` INT(11) NOT NULL AUTO_INCREMENT";
		$db -> query( $sql );
		$sql = "ALTER TABLE " . $db -> prefix( 'imglossary_entries' ) . " CHANGE `categoryID` `categoryid` INT(11) NOT NULL DEFAULT 0";
		$db -> query( $sql );
		$sql = "ALTER TABLE " . $db -> prefix( 'imglossary_cats' ) . " CHANGE `categoryID` `categoryid` INT(11) NOT NULL AUTO_INCREMENT";
		$db -> query( $sql );
		// Set DB Version
		define( 'IMGLOSSARY_DB_VERSION', 2 );
	}
?>