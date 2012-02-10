<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: blocks/random_term.php
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

function b_entries_random_show() {

	global $icmsConfig;
	$myts =& MyTextSanitizer::getInstance();

	include_once ICMS_ROOT_PATH . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/include/functions.php';

	$adminlinks = '';
	$block = array();

	$sql = 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND offline=0';
	list ( $numrows ) = icms::$xoopsDB -> fetchRow( icms::$xoopsDB -> query( $sql ) );
	if ( $numrows > 1 ) {
		$numrows = $numrows - 1;
		mt_srand( ( double )microtime() * 1000000 );
		$entrynumber = mt_rand( 0, $numrows );
	} else {
		$entrynumber = 0;
	}

	$hModule = icms::handler( 'icms_module' );
	$hModConfig = icms::$config;
	$imgModule =& $hModule -> getByDirname( basename( dirname( dirname( __FILE__ ) ) ) );
	$module_id = $imgModule -> getVar( 'mid' );
	$module_name = basename( dirname( dirname( __FILE__ ) ) );
	$imgConfig =& $hModConfig -> getConfigsByCat( 0, $imgModule -> getVar( 'mid' ) );

	$result = icms::$xoopsDB -> query ( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND offline=0 LIMIT ' . $entrynumber . ', 1');

	while ( $myrow = icms::$xoopsDB -> fetchArray( $result ) ) {
		$entryID = $myrow['entryID'];
		$term = '<a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/entry.php?entryID=' . $entryID . '">' . $myrow['term'] . '</a>';

		if ( !XOOPS_USE_MULTIBYTES ) {
			$definition = icms_core_DataFilter::icms_substr( $myrow['definition'], 0, $imgConfig['rndlength'] -1, '...' );
		}
		$definition = $myts -> displayTarea( $definition, $myrow['html'], $myrow['smiley'], $myrow['xcodes'], 0, $myrow['breaks'] );
		$categoryID = $myrow['categoryID'];
		
		$result_cat = icms::$xoopsDB -> query( 'SELECT categoryID, name FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' WHERE categoryID=' . $categoryID );
		list( $categoryID, $name ) = icms::$xoopsDB -> fetchRow( $result_cat );
		$category = '<div style="font-size: x-small; font-weight: normal; padding: 4px; margin: 0;"><a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/category.php?categoryID=' . $categoryID . '">' . $name . '</a></div>';
		
		$userlinks = '
		<a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/makepdf.php?entryID=' . $entryID . '" target="_blank">
			<img src="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/images/icon/pdf.png" border="0" alt="' . _MB_IMGLOSSARY_PDFTERM . '" />
		</a>
		<a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/print.php?entryID=' . $entryID . '" target="_blank">
			<img src="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/images/icon/print.png" border="0" alt="' . _MB_IMGLOSSARY_PRINTTERM . '" />
		</a>
		<a href="mailto:?subject=' . sprintf( _MB_IMGLOSSARY_INTENTRY, $icmsConfig['sitename'] ) . '&amp;body=' . sprintf( _MB_IMGLOSSARY_INTENTRYFOUND, $icmsConfig['sitename'] ) . ':  ' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/entry.php?entryID=' . $entryID . '" target="_blank">
			<img src="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/images/icon/email.png" border="0" alt="' . _MB_IMGLOSSARY_SENDTOFRIEND . '" />
		</a>';

		// Functional links
		if ( icms::$user ) {
			if ( icms::$user -> isAdmin() ) {
				$adminlinks = '<a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/admin/index.php"><img src="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/images/icon/computer.png" border="0" alt="' . _MB_IMGLOSSARY_ADMININDEX . '" /></a>';
				$adminlinks .= '<a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/admin/entry.php?op=mod&entryID=' . $entryID . '"><img src="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/images/icon/edit.png" border="0" alt="' . _MB_IMGLOSSARY_EDITTERM . '" /></a>';
				$adminlinks .= '<a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/admin/entry.php?op=del&entryID=' . $entryID . '"><img src="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/images/icon/delete.png" border="0" alt="' . _MB_IMGLOSSARY_DELTERM . '" /></a>';
			}
		}
		
		$block['dirname'] = basename( dirname( dirname( __FILE__ ) ) );
		if ( $imgConfig['multicats'] == 1 ) {
			$block['category'] =  $category;
			$block['term'] = '<h4 class="term">' . $term . '</h4>';
			$block['definition'] =	'<div style="padding: 4px;">' . $definition . '</div>';
			$block['seemore'] = '<div style="font-size: x-small; padding: 4px;">
									<a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/index.php">' . _MB_IMGLOSSARY_SEEMORE . '</a>
								 </div>';
			$block['icons'] = '<div style="padding: 4px;">' . $adminlinks . $userlinks . '</div>';			
		} else {
			$block['term'] = '<h4 class="term">' . $term . '</h4>';
			$block['definition'] = '<div style="padding: 4px;">' . $definition . '</div>';
			$block['seemore'] = '<div style="font-size: x-small; padding: 4px;">
									<a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/index.php">' . _MB_IMGLOSSARY_SEEMORE . '</a>
								 </div>';
			$block['icons'] = '<div style="padding: 4px;">&nbsp;' . $adminlinks . $userlinks . '</div>';
			
		}
	}
	return $block;
}
?>