<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: blocks/random_term.php
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

function b_entries_random_show() {

	$glossdirname = basename( dirname( dirname( __FILE__ ) ) );

	global $xoopsDB, $xoopsConfig, $xoopsUser;
	$myts =& MyTextSanitizer::getInstance();

	include_once ICMS_ROOT_PATH . "/modules/" . $glossdirname . "/include/functions.php";

	$adminlinks = '';
	$block = array();
	$block['title'] = _MB_IMGLOSSARY_RANDOMTITLE;
		
	list ( $numrows ) = $xoopsDB -> fetchRow( $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0" ) );
	if ( $numrows > 1 ) {
		$numrows = $numrows - 1;
		mt_srand( ( double )microtime() * 1000000 );
		$entrynumber = mt_rand( 0, $numrows );
	} else {
		$entrynumber = 0;
	}

	$hModule =& xoops_gethandler( 'module' );
	$hModConfig =& xoops_gethandler( 'config' );
	$wbModule =& $hModule -> getByDirname( $glossdirname );
	$module_id = $wbModule -> getVar( 'mid' );
	$module_name = $wbModule -> getVar( 'dirname' );
	$wbConfig =& $hModConfig -> getConfigsByCat( 0, $wbModule -> getVar( 'mid' ) );

	$result = $xoopsDB -> query ( "SELECT entryID, categoryID, term, definition FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0 LIMIT $entrynumber, 1");

	while ( $myrow = $xoopsDB -> fetchArray( $result ) ) {
		$entryID = $myrow['entryID'];
		$term = $myrow['term'];

		if ( !XOOPS_USE_MULTIBYTES ) {
			$definition = icms_substr( $myrow['definition'], 0, $wbConfig['rndlength'] -1, '...' );
		}

		$categoryID = $myrow['categoryID'];
		$result_cat = $xoopsDB -> query( "SELECT categoryID, name FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " WHERE categoryID=" . $categoryID . "");
		list( $categoryID, $name ) = $xoopsDB -> fetchRow( $result_cat );
		$categoryname = $name;

		// Functional links
		if ( $xoopsUser ) {
			if ( $xoopsUser -> isAdmin() ) {
				$adminlinks = '<a href="' . ICMS_URL . '/modules/' . $glossdirname . '/admin/index.php" ><img src="' . ICMS_URL . '/modules/' . $glossdirname . '/images/icon/computer.png" border="0" alt="' . _MB_IMGLOSSARY_ADMININDEX . '" /></a>&nbsp;';
				$adminlinks .= '<a href="' . ICMS_URL . '/modules/' . $glossdirname . '/admin/entry.php?op=mod&entryID=' . $entryID . '" target="_self"><img src="' . ICMS_URL . '/modules/' . $glossdirname . '/images/icon/edit.png" border="0" alt="' . _MB_IMGLOSSARY_EDITTERM . '" /></a>&nbsp;';
				$adminlinks .= '<a href="' . ICMS_URL . '/modules/' . $glossdirname . '/admin/entry.php?op=del&entryID=' . $entryID . '" target="_self"><img src="' . ICMS_URL . '/modules/' . $glossdirname . '/images/icon/delete.png" border="0" alt="' . _MB_IMGLOSSARY_DELTERM . '" /></a>&nbsp;';
			}
		}
		$userlinks = '<a href="' . ICMS_URL . '/modules/' . $glossdirname . '/makepdf.php?entryID=' . $entryID . '" target="_blank"><img src="' . ICMS_URL . '/modules/' . $glossdirname . '/images/icon/pdf.png" border="0" alt="' . _MB_IMGLOSSARY_PDFTERM . '" /></a>&nbsp;<a href="' . ICMS_URL . '/modules/' . $glossdirname . '/print.php?entryID=' . $entryID . '" target="_blank"><img src="' . ICMS_URL . '/modules/' . $glossdirname . '/images/icon/print.png" border="0" alt="' . _MB_IMGLOSSARY_PRINTTERM . '" /></a>&nbsp;<a href="mailto:?subject=' . sprintf( _MB_IMGLOSSARY_INTENTRY, $xoopsConfig['sitename'] ) . '&amp;body=' . sprintf( _MB_IMGLOSSARY_INTENTRYFOUND, $xoopsConfig['sitename'] ) . ':  ' . ICMS_URL . '/modules/' . $glossdirname . '/entry.php?entryID=' . $entryID . '" target="_blank"><img src="' . ICMS_URL . '/modules/' . $glossdirname . '/images/icon/email.png" border="0" alt="' . _MB_IMGLOSSARY_SENDTOFRIEND . '" /></a>&nbsp;';

		if ( $wbConfig['multicats'] == 1 ) {
			$block['content'] = '<div style="font-size: x-small; font-weight: normal; padding: 4px; margin: 0;">' . _MB_IMGLOSSARY_CATEGORY . '<a href="' . ICMS_URL . '/modules/' . $glossdirname . '/category.php?categoryID=' . $categoryID . '">' . $categoryname . '</a></div>';
			$block['content'] .= '<div style="padding: 4px; color: #456; background-color: #E8E6E2;"><h5 style="margin: 0;"><a href="' . ICMS_URL . '/modules/' . $glossdirname . '/entry.php?entryID=' . $entryID . '">' . $term . '</a></h5></div><div style="padding: 4px;">' . $definition . '</div>';
			$block['content'] .= '<div><div style="float: left; padding: 4px;">' . $adminlinks . $userlinks . '</div><div style="float: right; font-size: x-small; padding: 4px;"><a href="' . ICMS_URL . '/modules/' . $glossdirname . '/index.php">' . _MB_IMGLOSSARY_SEEMORE . '</a></div>&nbsp;</div>';
		} else {
			$block['content'] = '<div style="padding: 4px; color: #456; background-color: #E8E6E2;"><h5 style="margin: 0;"><a style="margin: 0;" href="' . ICMS_URL . '/modules/' . $glossdirname . '/entry.php?entryID=$entryID">$term</a></h5></div><div style="padding: 4px;">' . $definition . '</div>';
			$block['content'] .= '<div><div style="float: left; padding: 4px;">&nbsp;' . $adminlinks . $userlinks . '</div><div style="float: right; font-size: x-small; padding: 4px;"><a href="' . ICMS_URL . '/modules/' . $glossdirname . '/index.php">' . _MB_IMGLOSSARY_SEEMORE . '</a>&nbsp;</div>&nbsp;</div>';
		}
	}
	
	return $block;
}
?>