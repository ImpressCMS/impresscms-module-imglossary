<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: include/functions.php
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


// RTL feature
if( !defined( '_GLOBAL_LEFT' ) ) {
	define( '_GLOBAL_LEFT', ( ( defined( '_ADM_USE_RTL' ) && _ADM_USE_RTL ) ? 'right' : 'left' ) );		// type here right in rtl languages
} 
if( !defined( '_GLOBAL_RIGHT') ) {
	define( '_GLOBAL_RIGHT', ( ( defined( '_ADM_USE_RTL' ) && _ADM_USE_RTL ) ? 'left' : 'right' ) );	// type here left in rtl languages
} 

// imglossary_getLinkedUnameFromId()
// @param integer $userid Userid of author etc
// @param integer $name:  0 Use Usenamer 1 Use realname
// @return
function imglossary_getLinkedUnameFromId( $userid = 0, $name = 0 ) {
		if ( !is_numeric( $userid ) ) {
		 	return $userid;
		}
		$userid = intval( $userid );
		if ( $userid > 0 ) {
			$member_handler = icms::handler( 'icms_member' );
			$user =& $member_handler -> getUser( $userid );
			if ( is_object($user) ) {
				$ts =& MyTextSanitizer::getInstance();
				$username = $user -> getVar( 'uname' );
				$usernameu = $user -> getVar( 'name' ); 
				if ( ($name) && !empty( $usernameu ) ) {
					$username = $user -> getVar( 'name' );
				}
				if ( !empty( $usernameu ) ) {
					$linkeduser = "$usernameu [<a href='" . ICMS_ROOT_PATH . "/userinfo.php?uid=" . $userid . "'>" . $ts -> htmlSpecialChars( $username ) . "</a>]";
				} else {
					$linkeduser = '<a href="' . ICMS_ROOT_PATH . '/userinfo.php?uid=' . $userid . '">' . $ts -> htmlSpecialChars( $username ) .'</a>';
				}
				return $linkeduser;
			}
		}
		return $GLOBALS['icmsConfig']['anonymous'];
}

function imglossary_calculateTotals() {
	$result01 = icms::$xoopsDB -> query( 'SELECT categoryID, total FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) );
	list( $totalcategories ) = icms::$xoopsDB -> getRowsNum( $result01 );
	while ( list ( $categoryID, $total ) = icms::$xoopsDB -> fetchRow( $result01 ) ) {
		$newcount = imglossary_countByCategory ( $categoryID );
		icms::$xoopsDB -> queryF( "UPDATE " . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . " SET total='$newcount' WHERE categoryID='$categoryID'" );
	}
}

function imglossary_countByCategory( $c ) {
	$count = 0;
	$sql = icms::$xoopsDB -> query( "SELECT * FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 and offline=0 AND categoryID='$c'" );
	while ( $myrow = icms::$xoopsDB -> fetchArray( $sql ) ) {
		$count++;
	}
	return $count;
} 

function imglossary_countCats() {
	$cats = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) );
	$totalcats = icms::$xoopsDB -> getRowsNum( $cats );
	return $totalcats;
}

function imglossary_countWords() {
	$pubwords = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND offline=0 AND request=0' );
	$publishedwords = icms::$xoopsDB -> getRowsNum( $pubwords );
	return $publishedwords;
}

function imglossary_alphaArray() {
	$alpha = array();
	for ($a = 65; $a < (65+26); $a++ ) {
		$letterlinks = array();
		$initial = chr( $a );
		$sql = icms::$xoopsDB -> query( "SELECT * FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0 AND init='$initial'" );
		$howmany = icms::$xoopsDB -> getRowsNum( $sql );
		$letterlinks['total'] = $howmany;
		$letterlinks['id'] = chr( $a );
		$letterlinks['linktext'] = chr( $a );
		$letterlinks['title'] = ' ' . mb_strtolower( _MD_IMGLOSSARY_TERMS, _CHARSET );
		$alpha['initial'][] = $letterlinks;
	}
	return $alpha;
}

function imglossary_serviceLinks( $variable ) {
	global $icmsConfig;
	// Functional links
	$srvlinks = '';
	if ( icms::$user ) {
		if ( icms::$user -> isAdmin() ) {
			$srvlinks .= '<a href="admin/index.php" ><img src="images/icon/computer.png" border="0" alt="' . _MD_IMGLOSSARY_ADMININDEX . '" /></a>&nbsp;';
			$srvlinks .= '<a href="admin/entries.php?op=mod&entryID=' . $variable['id'] . '" ><img src="images/icon/edit.png" border="0" alt="' . _MD_IMGLOSSARY_EDITTERM . '" /></a>&nbsp;';
			$srvlinks .= '<a href="admin/entries.php?op=del&entryID=' . $variable['id'] . '" target="_self"><img src="images/icon/delete.png" border="0" alt="' . _MD_IMGLOSSARY_DELTERM . '" /></a>&nbsp;';
		}
	}
	$srvlinks .= '<a href="makepdf.php?entryID=' . $variable['id'] . '" target="_blank"><img src="images/icon/pdf.png" border="0" alt="' . _MD_IMGLOSSARY_PDFTERM . '" /></a>&nbsp;';
	$srvlinks .= '<a href="print.php?entryID=' . $variable['id'] . '" target="_blank"><img src="images/icon/print.png" border="0" alt="' . _MD_IMGLOSSARY_PRINTTERM . '" /></a>&nbsp;';
	$srvlinks .= '<a href="mailto:?subject=' . sprintf(_MD_IMGLOSSARY_INTENTRY, $icmsConfig["sitename"]) . '&amp;body=' . sprintf(_MD_IMGLOSSARY_INTENTRYFOUND, $icmsConfig['sitename']) . ':  ' . ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar('dirname') . '/entry.php?entryID=' . $variable['id'] . '" target="_blank"><img src="images/icon/email.png" border="0" alt="' . _MD_IMGLOSSARY_SENDTOFRIEND . '" ></a>&nbsp;';
//	$srvlinks .= "<a href='entry.php?entryID=" . $variable['id'] . "'><img src=\"images/icon/comments.png\" border=\"0\" alt=\"" . _COMMENTS . "\" ></a>&nbsp;";
	return $srvlinks;
}

function imglossary_showSearchForm() {
	global $icmsConfig;
	$searchform = '<table width="100%">';
	$searchform .= '<form name="op" id="op" action="search.php" method="post">';
	$searchform .= '<tr><td style="text-align: ' . _GLOBAL_RIGHT . '; line-height: 200%">';
	$searchform .= _MD_IMGLOSSARY_LOOKON . '</td><td width="10">&nbsp;</td><td style="text-align: ' . _GLOBAL_LEFT . ';">';
	$searchform .= '<select name="type"><option value="1">' . _MD_IMGLOSSARY_TERMS . '</option>';
	$searchform .= '<option value="2">' . _MD_IMGLOSSARY_DEFINS . '</option>';
	$searchform .= '<option value="3">' . _MD_IMGLOSSARY_TERMSDEFS . '</option></select></td></tr>';

	if ( icms::$module -> config['multicats'] == 1 ) {
		$searchform .= '<tr><td style="text-align: ' . _GLOBAL_RIGHT . '; line-height: 200%">' . _MD_IMGLOSSARY_CATEGORY . '</td>';
		$searchform .= '<td>&nbsp;</td><td style="text-align: ' . _GLOBAL_LEFT . ';">';
		$resultcat = icms::$xoopsDB -> query( "SELECT categoryID, name FROM " . icms::$xoopsDB -> prefix ( 'imglossary_cats' ) . " ORDER BY categoryID" );
		$searchform .= '<select name="categoryID">';
		$searchform .= '<option value="0">' . _MD_IMGLOSSARY_ALLOFTHEM . '</option>';
		while ( list( $categoryID, $name ) = icms::$xoopsDB -> fetchRow( $resultcat ) ) {
			$searchform .= '<option value="' . $categoryID . '">' . $categoryID . ' : ' . $name . '</option>';
		}
		$searchform .= '</select></td></tr>';
	}

	$searchform .= '<tr><td style="text-align: ' . _GLOBAL_RIGHT . '; line-height: 200%">';
	$searchform .= _MD_IMGLOSSARY_TERM . '</td><td>&nbsp;</td><td style="text-align: ' . _GLOBAL_LEFT . ';">';
	$searchform .= '<input type="text" name="term" /></td></tr><tr>';
	$searchform .= '<td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" value="' . _MD_IMGLOSSARY_SEARCH . '" />';
	$searchform .= '</td></tr></form></table>';
	return $searchform;
}

function imglossary_getHTMLHighlight( $needle, $haystack, $hlS, $hlE ) {
	$parts = explode( '>', $haystack );
	foreach ( $parts as $key => $part ) {
		$pL = '';
		$pR = '';
		if( ( $pos = strpos( $part, '<' ) ) === false )
			$pL = $part;
		elseif ( $pos > 0 ) {
			$pL = substr( $part, 0, $pos );
			$pR = substr( $part, $pos, strlen( $part ) );
		}
		if( $pL != '' )
			$parts[$key] = preg_replace( '|(' . quotemeta($needle) . ')|iU', $hlS . '\\1' . $hlE, $pL ) . $pR;
	}
	return ( implode( '>', $parts ) );
}

function imglossary_adminMenu( $currentoption = 0, $breadcrumb = '' ) {
	icms::$module -> displayAdminMenu( $currentoption, icms::$module -> getVar( 'name' ) . ' | ' . $breadcrumb );
}

function imglossary_linkterms( $definition, $glossaryterm ) {
	// Code to make links out of glossary terms
	$parts = explode( '¤', $definition );

	// First, retrieve all terms from the glossary...
	$allterms = icms::$xoopsDB -> query( 'SELECT entryID, term FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND offline=0' );
	while ( list( $entryID, $term ) = icms::$xoopsDB -> fetchrow( $allterms ) ) {
		foreach( $parts as $key => $part ) {
			if ( $term != $glossaryterm ) {
				// singular
				$term_q = preg_quote( $term, '/' );
				$search_term = "/\b$term_q\b/i";
				$replace_term = '<span><b><a href="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/entry.php?entryID=' . intval( $entryID ) . '">' . $term . '</a></b></span>';
				$parts[$key] = preg_replace( $search_term, $replace_term, $parts[$key] );

				// plural
				$term = $term . 's';
				$term_q = preg_quote( $term, '/' );
				$search_term = "/\b$term_q\b/i";
				$replace_term = '<span><b><a style="color: #2F5376;" href="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/entry.php?entryID=' . intval( $entryID ) . '">' . $term . '</a></b></span>';
				$parts[$key] = preg_replace( $search_term, $replace_term, $parts[$key] );

				// plural with e
				$term = $term . 'es';
				$term_q = preg_quote( $term, '/' );
				$search_term = "/\b$term_q\b/i";
				$replace_term = '<span><b><a style="color: #2F5376;" href="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/entry.php?entryID=' . intval( $entryID ) . '">' . $term . '</a></b></span>';
				$parts[$key] = preg_replace( $search_term, $replace_term, $parts[$key] );

			}
		}
	}
	$definition = implode( '¤', $parts );
	return $definition;
}

// Check if Dictionary module is installed
function imglossary_dictionary_module_included() {
	static $imglossary_dictionary_module_included;
	if ( !isset( $imglossary_dictionary_module_included ) ) {
		$modules_handler = icms::handler( 'icms_module' );
		$dict_mod = $modules_handler -> getByDirName( 'dictionary' );
		if ( !$dict_mod ) {
			$dict_mod = false;
		} else {
			$imglossary_dictionary_module_included = $dict_mod -> getVar( 'isactive' ) == 1;
		}
	}
	return $imglossary_dictionary_module_included;
}

// Check if Wordbook module is installed
function imglossary_wordbook_module_included() {
	static $imglossary_wordbook_module_included;
	if ( !isset( $imglossary_wordbook_module_included ) ) {
		$modules_handler = icms::handler( 'icms_module' );
		$dict_mod = $modules_handler -> getByDirName( 'wordbook' );
		if ( !$dict_mod ) {
			$dict_mod = false;
		} else {
			$imglossary_wordbook_module_included = $dict_mod -> getVar( 'isactive' ) == 1;
		}
	}
	return $imglossary_wordbook_module_included;
}

// Check if Wiwimod module is installed
function imglossary_wiwimod_module_included() {
	static $imglossary_wiwimod_module_included;
	if ( !isset( $imglossary_wiwimod_module_included ) ) {
		$modules_handler = icms::handler( 'icms_module' );
		$dict_mod = $modules_handler -> getByDirName( 'wiwimod' );
		if ( !$dict_mod ) {
			$dict_mod = false;
		} else {
			$imglossary_wiwimod_module_included = $dict_mod -> getVar( 'isactive' ) == 1;
		}
	}
	return $imglossary_wiwimod_module_included;
}

function imglossary_getWysiwygForm( $caption, $name, $value ) {
	$isadmin = ( ( is_object( icms::$user ) && !empty( icms::$user ) ) && icms::$user -> isAdmin( icms::$module -> getVar('mid') ) ) ? true : false;
	if ( $isadmin == true ) {
		$formuser = icms::$module -> config['form_options'];
	} else {
		$formuser = icms::$module -> config['form_optionsuser'];
	}

	switch( $formuser ) {

		case 'fck':
			$editor = imglossary_fckeditor( $caption, $name, $value );
			break;

		case 'tinyeditor':
			$editor = imglossary_tinyeditor( $caption, $name, $value );
			break;

		case 'tinymce' :
			$editor = imglossary_tinymce( $caption, $name, $value );    
			break;

	}

	return $editor;
}

function imglossary_fckeditor( $caption, $name, $value ) {
	if ( file_exists( ICMS_ROOT_PATH . '/editors/FCKeditor/formfckeditor.php' ) ) {
		include_once( ICMS_ROOT_PATH . '/editors/FCKeditor/formfckeditor.php' );
		$editor = new XoopsFormFckeditor( array( 'caption' => $caption, 'name' => $name, 'value' => $value, 'width' => '100%', 'height' => '300px' ), true );
	} else {
		$editor = new icms_form_elements_Dhtmltextarea( $caption, $name, $value, 35, 60 );
	}
	return $editor;
}

function imglossary_tinyeditor( $caption, $name, $value ) {
	if ( file_exists( ICMS_ROOT_PATH . '/class/xoopseditor/tinyeditor/formtinyeditortextarea.php' ) ) {
		include_once( ICMS_ROOT_PATH . '/class/xoopseditor/tinyeditor/formtinyeditortextarea.php' );
		$editor = new XoopsFormTinyeditorTextArea( array( 'caption' => $caption, 'name' => $name, 'value' => $value, 'width' => '100%', 'height' => '300px' ) );
	} else {
		$editor = new icms_form_elements_Dhtmltextarea( $caption, $name, $value, 35, 60 );
	}
	return $editor;
}	

function imglossary_tinymce( $caption, $name, $value ) {
	if ( file_exists( ICMS_ROOT_PATH . '/editors/tinymce/formtinymce.php' ) ) {
		include_once( ICMS_ROOT_PATH . '/editors/tinymce/formtinymce.php' );
		$editor = new XoopsFormTinymce( array( 'caption' => $caption, 'name' => $name, 'value' => $value, 'width' => '100%', 'height' => '300px', 0 ) );
	} else {
		$editor = new icms_form_elements_Dhtmltextarea( $caption, $name, $value, $editor_configs['rows'], $editor_configs['cols'] );
	}
	return $editor;
}

function imglossary_helptip( $description ) {
	$helptip = '<img class="helptip" src="'. ICMS_IMAGES_SET_URL . '/actions/acp_help.png" alt="View help text" title="View help text" /><span class="helptext">' . $description . '</span>';
	return $helptip;
}
?>