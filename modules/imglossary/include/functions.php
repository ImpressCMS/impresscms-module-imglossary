<?php
/**
 * $Id: functions.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

/**
 * wb_getLinkedUnameFromId()
 * 
 * @param integer $userid Userid of author etc
 * @param integer $name:  0 Use Usenamer 1 Use realname 
 * @return 
 **/
function imglossary_getLinkedUnameFromId( $userid = 0, $name= 0 ) {
		if ( !is_numeric( $userid ) ) {
		 	return $userid;
		}
		
		$userid = intval( $userid );
		if ( $userid > 0 ) {
            $member_handler =& xoops_gethandler('member');
            $user =& $member_handler -> getUser($userid);

            if ( is_object($user) ) {
                $ts =& MyTextSanitizer::getInstance();
				$username = $user -> getVar('uname');
				$usernameu = $user -> getVar('name'); 
				
				if ( ($name) && !empty($usernameu) ) {
                 	$username = $user -> getVar('name');
                }
				if ( !empty($usernameu)) {
					$linkeduser = "$usernameu [<a href='" . ICMS_ROOT_PATH . "/userinfo.php?uid=" . $userid . "'>" . $ts -> htmlSpecialChars($username) . "</a>]";
				} else {
					$linkeduser = "<a href='" . ICMS_ROOT_PATH . "/userinfo.php?uid=" . $userid . "'>" . $ts -> htmlSpecialChars($username) ."</a>";
				}
				return $linkeduser;
            }
        }
        return $GLOBALS['xoopsConfig']['anonymous'];
}

function imglossary_getuserForm( $user ) {
	global $xoopsDB, $xoopsConfig;

	echo "<select name='author'>";
	echo "<option value='-1'>------</option>";
	$result = $xoopsDB -> query( "SELECT uid, uname FROM " . $xoopsDB -> prefix( 'users' ) . " ORDER BY uname" );

	while( list( $uid, $uname ) = $xoopsDB -> fetchRow( $result ) ) {
		if ( $uid == $user ) {
			$opt_selected = "selected='selected'";
		} else {
			$opt_selected = "";
		}
		echo "<option value='" . $uid . "' $opt_selected>" . $uname . "</option>";
	}
	echo "</select></div>";
}

function imglossary_calculateTotals() {
	global $xoopsUser, $xoopsDB, $xoopsModule;
	$result01 = $xoopsDB -> query( "SELECT categoryID, total FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " " );
	list( $totalcategories ) = $xoopsDB -> getRowsNum( $result01 );
	while (list ( $categoryID, $total ) = $xoopsDB -> fetchRow( $result01 ) ) {
		$newcount = imglossary_countByCategory ( $categoryID );
		$xoopsDB -> queryF( "UPDATE " . $xoopsDB -> prefix( 'imglossary_cats' ) . " SET total='$newcount' WHERE categoryID='$categoryID'" );
	}
}

function imglossary_countByCategory( $c ) {
    global $xoopsUser, $xoopsDB, $xoopsModule;
    $count = 0;
    $sql = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 and offline=0 AND categoryID='$c'" );
    while ( $myrow = $xoopsDB -> fetchArray( $sql ) ) {
		$count++;
	} 
	return $count;
} 

function imglossary_countCats() {
    global $xoopsUser, $xoopsDB, $xoopsModule;
	$cats = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . "" );
	$totalcats = $xoopsDB -> getRowsNum( $cats );
	return $totalcats;
}

function imglossary_countWords() {
    global $xoopsUser, $xoopsDB, $xoopsModule;
	$pubwords = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0 AND request=0" );
	$publishedwords = $xoopsDB -> getRowsNum ( $pubwords );
	return $publishedwords;
}

function imglossary_alphaArray() {
    global $xoopsUser, $xoopsDB, $xoopsModule;
	$alpha = array();
	for ($a = 65; $a < (65+26); $a++ ) {
		$letterlinks = array();
		$initial = chr($a);
		$sql = $xoopsDB -> query ( "SELECT * FROM " . $xoopsDB -> prefix ( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0 AND init='$initial'" );
		$howmany = $xoopsDB -> getRowsNum( $sql );
		$letterlinks['total'] = $howmany;
		$letterlinks['id'] = chr($a);
		$letterlinks['linktext'] = chr($a);

		$alpha['initial'][] = $letterlinks;
	}
	return $alpha;
}

function imglossary_serviceLinks( $variable ) {
    global $xoopsUser, $xoopsDB, $xoopsModule, $xoopsModuleConfig, $xoopsConfig;
	// Functional links
	$srvlinks = "";
	if ( $xoopsUser ) {
		if ( $xoopsUser->isAdmin() ) {
			$srvlinks .= '<a href="admin/index.php" ><img src="images/icon/computer.png" border="0" alt="' . _MD_IMGLOSSARY_ADMININDEX . '" /></a>&nbsp;';
			$srvlinks .= '<a href="admin/entry.php?op=mod&entryID=' . $variable['id'] . '" ><img src="images/icon/edit.png" border="0" alt="' . _MD_IMGLOSSARY_EDITTERM . '" /></a>&nbsp;';
			$srvlinks .= '<a href="admin/entry.php?op=del&entryID=' . $variable['id'] . '" target="_self"><img src="images/icon/delete.png" border="0" alt="' . _MD_IMGLOSSARY_DELTERM . '" /></a>&nbsp;';
		}
	}
	$srvlinks .= '<a href="print.php?entryID=' . $variable['id'] . '" target="_blank"><img src="images/icon/print.png" border="0" alt="' . _MD_IMGLOSSARY_PRINTTERM . '" /></a>&nbsp;';
	$srvlinks .= '<a href="mailto:?subject=' . sprintf(_MD_IMGLOSSARY_INTENTRY,$xoopsConfig["sitename"]) . '&amp;body=' . sprintf(_MD_IMGLOSSARY_INTENTRYFOUND, $xoopsConfig['sitename']) . ':  ' . ICMS_ROOT_PATH . '/modules/' . $xoopsModule -> dirname() . '/entry.php?entryID=' . $variable['id'] . '" target="_blank"><img src="images/icon/email.png" border="0" alt="' . _MD_IMGLOSSARY_SENDTOFRIEND . '" ></a>&nbsp;';
//	$srvlinks .= "<a href='entry.php?entryID=" . $variable['id'] . "'><img src=\"images/icon/comments.png\" border=\"0\" alt=\"" . _COMMENTS . "\" ></a>&nbsp;";
	return $srvlinks;
}

function imglossary_showSearchForm() {
    global $xoopsUser, $xoopsDB, $xoopsModule, $xoopsModuleConfig, $xoopsConfig;
	$searchform = '<table width="100%">';
	$searchform .= '<form name="op" id="op" action="search.php" method="post">';
	$searchform .= '<tr><td style="text-align: right; line-height: 200%" width="150">';
	$searchform .= _MD_IMGLOSSARY_LOOKON . '</td><td width="10">&nbsp;</td><td style="text-align: left;">';
	$searchform .= '<select name="type"><option value="1">' . _MD_IMGLOSSARY_TERMS . '</option><option value="2">' . _MD_IMGLOSSARY_DEFINS . '</option>';
	$searchform .= '<option value="3">' . _MD_IMGLOSSARY_TERMSDEFS . '</option></select></td></tr>';

	if ( $xoopsModuleConfig['multicats'] == 1 ) {
		$searchform .= '<tr><td style="text-align: right; line-height: 200%">' . _MD_IMGLOSSARY_CATEGORY . '</td>';
		$searchform .= '<td>&nbsp;</td><td style="text-align: left;">';
		$resultcat = $xoopsDB -> query( "SELECT categoryID, name FROM " . $xoopsDB -> prefix ( 'imglossary_cats' ) . " ORDER BY categoryID" );
		$searchform .= '<select name="categoryID">';
		$searchform .= '<option value="0">' . _MD_IMGLOSSARY_ALLOFTHEM . '</option>';

		while ( list( $categoryID, $name ) = $xoopsDB -> fetchRow( $resultcat ) ) {
			$searchform .= '<option value="$categoryID">$categoryID : $name</option>';
		}
		$searchform .= '</select></td></tr>';
	}

	$searchform .= '<tr><td style="text-align: right; line-height: 200%">';
	$searchform .= _MD_IMGLOSSARY_TERM . '</td><td>&nbsp;</td><td style="text-align: left;">';
	$searchform .= '<input type="text" name="term" /></td></tr><tr>';
	$searchform .= '<td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" value="' . _MD_IMGLOSSARY_SEARCH . '" />';
	$searchform .= '</td></tr></form></table>';
	return $searchform;
}

function imglossary_getHTMLHighlight( $needle, $haystack, $hlS, $hlE ) {
	$parts = explode( ">", $haystack );
	foreach ( $parts as $key=>$part ) {
		$pL = "";
		$pR = "";

		if( ( $pos = strpos( $part, "<" ) ) === false )
			$pL = $part;
		elseif ( $pos > 0 ) {
			$pL = substr( $part, 0, $pos );
			$pR = substr( $part, $pos, strlen( $part ) );
		}
		if( $pL != "" )
			$parts[$key] = preg_replace( '|(' . quotemeta($needle) . ')|iU', $hlS . '\\1' . $hlE, $pL ) . $pR;
	}
	return ( implode( ">", $parts ) );
}

function imglossary_adminMenu( $currentoption = 0, $breadcrumb = '' ) {
	global $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
	$tblColors = array();
	$tblColors[0]=$tblColors[1]=$tblColors[2]=$tblColors[3]=$tblColors[4]=$tblColors[5]=$tblColors[6]=$tblColors[7]=$tblColors[8]='#F1F4FB';
    $tblColors[$currentoption] = '#FFF';
    if ( file_exists( ICMS_ROOT_PATH . '/modules/' . $xoopsModule -> getVar( 'dirname' ) . '/language/' . $xoopsConfig['language'] . '/modinfo.php' ) ) {
		include_once '../language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once '../language/english/modinfo.php';
	}
	echo '<div style="font-size: 10px; text-align: right; color: #2F5376; margin: 0 0 8px 0; padding: 2px 6px; line-height: 18px; border: 1px solid #e7e7e7; "><b>' . $xoopsModule -> name() . _AM_IMGLOSSARY_MODADMIN . '</b> ' . $breadcrumb . '</div>';	
	echo '<div id="navcontainer"><ul style="padding: 3px 0; margin-left: 0;">';
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="index.php" style="padding: 3px 0.5em; margin-left: 0; border: 1px solid #778; background:' . $tblColors[0] . '; text-decoration: none; white-space: nowrap; ">' . _AM_IMGLOSSARY_INDEX . '</a></li>';
	
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="entry.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[2] . '; text-decoration: none; white-space: nowrap; ">' . _AM_IMGLOSSARY_CREATEENTRY . '</a></li>';
	if ( $xoopsModuleConfig['multicats'] == 1 ) {
		echo '<li style="list-style: none; margin: 0; display: inline; "><a href="category.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[1] . '; text-decoration: none; white-space: nowrap; ">' . _AM_IMGLOSSARY_CREATECAT . '</a></li>';
	}	
//	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="submissions.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[3] . '; text-decoration: none; white-space: nowrap; ">' . _AM_IMGLOSSARY_SUBMITS . '</a></li>';
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="myblocksadmin.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[4] . '; text-decoration: none; white-space: nowrap; ">' . _AM_IMGLOSSARY_BLOCKS . '</a></li>';
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule -> getVar( 'mid' ) . '" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[5] . '; text-decoration: none; white-space: nowrap; ">' . _AM_IMGLOSSARY_OPTS . '</a></li>';
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="../index.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[6] . '; text-decoration: none; white-space: nowrap; ">' . _AM_IMGLOSSARY_GOMOD . '</a></li>';
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="../../system/admin.php?module=' . $xoopsModule -> getVar( 'mid' ) . '&status=0&limit=100&fct=comments&selsubmit=Go" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[6] . '; text-decoration: none; white-space: nowrap; ">' . _AM_IMGLOSSARY_COMMENTS . '</a></li>';

	//Show import from Dictionary module button if installed	
if (imglossary_dictionary_module_included()) {
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="importdictionary.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[6] . '; text-decoration: none; white-space: nowrap; ">' . _AM_IMGLOSSARY_IMPORT . ' Dictionary</a></li>';
}

//Show import from Wordbook module button if installed	
if (imglossary_wordbook_module_included()) {
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="importwordbook.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[6] . '; text-decoration: none; white-space: nowrap; ">' . _AM_IMGLOSSARY_IMPORT . ' Wordbook</a></li>';
}

}
	
function imglossary_linkterms( $definition, $glossaryterm ) {

	global $xoopsModule, $xoopsDB;
	// Code to make links out of glossary terms
		$parts = explode( "¤", $definition );

		// First, retrieve all terms from the glossary...
		$allterms = $xoopsDB -> query( "SELECT entryID, term FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0" );
		while ( list( $entryID, $term ) = $xoopsDB -> fetchrow( $allterms ) ) {
			foreach( $parts as $key => $part ) {
				if ( $term != $glossaryterm ) {
					// singular
					$term_q = preg_quote( $term, '/' );
					$search_term = "/\b$term_q\b/i";
					$replace_term = "<span><b><a href='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/entry.php?entryID=" . intval( $entryID ) . "'>" . $term . "</a></b></span>";
					$parts[$key] = preg_replace( $search_term, $replace_term, $parts[$key] );

					// plural
					$term = $term . "s";
					$term_q = preg_quote( $term, '/' );
					$search_term = "/\b$term_q\b/i";
					$replace_term = "<span><b><a style='color: #2F5376;' href='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/entry.php?entryID=" . intval( $entryID ) . "'>" . $term . "</a></b></span>";
					$parts[$key] = preg_replace( $search_term, $replace_term, $parts[$key] );

					// plural with e
					$term = $term . "es";
					$term_q = preg_quote( $term, '/' );
					$search_term = "/\b$term_q\b/i";
					$replace_term = "<span><b><a style='color: #2F5376;' href='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/entry.php?entryID=" . intval( $entryID ) . "'>" . $term . "</a></b></span>";
					$parts[$key] = preg_replace( $search_term, $replace_term, $parts[$key] );

				}
			}
		}
	$definition = implode( "¤", $parts );
	
	return $definition;
}	

// Check if Dictionary module is installed
function imglossary_dictionary_module_included() {
  static $imglossary_dictionary_module_included;
  if ( !isset( $imglossary_dictionary_module_included ) ) {
    $modules_handler = xoops_gethandler( 'module' );
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
    $modules_handler = xoops_gethandler( 'module' );
    $dict_mod = $modules_handler -> getByDirName( 'wordbook' );
    if ( !$dict_mod ) {
      $dict_mod = false;
    } else {
      $imglossary_wordbook_module_included = $dict_mod -> getVar( 'isactive' ) == 1;
    }
  }
  return $imglossary_wordbook_module_included;
}

?>