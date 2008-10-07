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
function wb_getLinkedUnameFromId( $userid = 0, $name= 0 ) {
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
					$linkeduser = "<a href='" . ICMS_ROOT_PATH . "/userinfo.php?uid=" . $userid . "'>" . ucfirst( $ts -> htmlSpecialChars($username) ) ."</a>";
				}
				return $linkeduser;
            }
        }
        return $GLOBALS['xoopsConfig']['anonymous'];
}

function getuserForm( $user ) {
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

function calculateTotals() {
	global $xoopsUser, $xoopsDB, $xoopsModule;
	$result01 = $xoopsDB -> query( "SELECT categoryID, total FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " " );
	list( $totalcategories ) = $xoopsDB -> getRowsNum( $result01 );
	while (list ( $categoryID, $total ) = $xoopsDB -> fetchRow ( $result01 ) ) {
		$newcount = countByCategory ( $categoryID );
		$xoopsDB -> queryF( "UPDATE " . $xoopsDB -> prefix( 'imglossary_cats' ) . " SET total='$newcount' WHERE categoryID='$categoryID'" );
	}
}

function countByCategory( $c ) {
    global $xoopsUser, $xoopsDB, $xoopsModule;
    $count = 0;
    $sql = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 and offline=0 AND categoryID='$c'" );
    while ( $myrow = $xoopsDB -> fetchArray( $sql ) ) {
		$count++;
	} 
	return $count;
} 

function countCats() {
    global $xoopsUser, $xoopsDB, $xoopsModule;
	$cats = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( "imglossary_cats" ) . "" );
	$totalcats = $xoopsDB -> getRowsNum( $cats );
	return $totalcats;
}

function countWords() {
    global $xoopsUser, $xoopsDB, $xoopsModule;
	$pubwords = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0 AND request=0" );
	$publishedwords = $xoopsDB -> getRowsNum ( $pubwords );
	return $publishedwords;
}

function alphaArray() {
    global $xoopsUser, $xoopsDB, $xoopsModule;
	$alpha = array();
	for ($a = 65; $a < (65+26); $a++ ) {
		$letterlinks = array();
		$initial = chr($a);
		$sql = $xoopsDB -> query ( "SELECT * FROM " . $xoopsDB -> prefix ( 'imglossary_entries' ) . " WHERE init='$initial'" );
		$howmany = $xoopsDB -> getRowsNum( $sql );
		$letterlinks['total'] = $howmany;
		$letterlinks['id'] = chr($a);
		$letterlinks['linktext'] = chr($a);

		$alpha['initial'][] = $letterlinks;
	}
	return $alpha;
}

function serviceLinks( $variable ) {
    global $xoopsUser, $xoopsDB, $xoopsModule, $xoopsModuleConfig, $xoopsConfig;
	// Functional links
	$srvlinks = "";
	if ( $xoopsUser ) {
		if ( $xoopsUser->isAdmin() ) {
			$srvlinks .= "<a href=\"admin/entry.php?op=mod&entryID=" . $variable['id'] . "\" ><img src=\"images/edit.gif\" border=\"0\" alt=\"" . _MD_WB_EDITTERM . "\" ></a>&nbsp;<a href=\"admin/entry.php?op=del&entryID=" . $variable['id'] . "\" target=\"_self\"><img src=\"images/delete.gif\" border=\"0\" alt=\"" . _MD_WB_DELTERM . "\" ></a>&nbsp;";
		}
	}
	$srvlinks .= "<a href=\"print.php?entryID=" . $variable['id'] . "\" target=\"_blank\"><img src=\"images/print.gif\" border=\"0\" alt=\"" . _MD_WB_PRINTTERM . "\" ></a>&nbsp;<a href=\"mailto:?subject=" . sprintf(_MD_WB_INTENTRY,$xoopsConfig["sitename"]) . "&amp;body=" . sprintf(_MD_WB_INTENTRYFOUND, $xoopsConfig['sitename']) . ":  " . ICMS_ROOT_PATH . "/modules/" . $xoopsModule -> dirname() . "/entry.php?entryID=" . $variable['id'] . " \" target=\"_blank\"><img src=\"images/email.gif\" border=\"0\" alt=\"" . _MD_WB_SENDTOFRIEND . "\" ></a>&nbsp;";
	return $srvlinks;
}

function showSearchForm() {
    global $xoopsUser, $xoopsDB, $xoopsModule, $xoopsModuleConfig, $xoopsConfig;
	$searchform = "<table width=\"100%\">";
	$searchform .= "<form name=\"op\" id=\"op\" action=\"search.php\" method=\"post\">";
	$searchform .= "<tr><td style=\"text-align: right; line-height: 200%\" width=\"150\">";
	$searchform .= _MD_WB_LOOKON . "</td><td width=\"10\">&nbsp;</td><td style=\"text-align: left;\">";
	$searchform .= "<select name=\"type\"><option value=\"1\">" . _MD_WB_TERMS . "</option><option value=\"2\">" . _MD_WB_DEFINS . "</option>";
	$searchform .= "<option value=\"3\">" . _MD_WB_TERMSDEFS . "</option></select></td></tr>";

	if ( $xoopsModuleConfig['multicats'] == 1 ) {
		$searchform .= "<tr><td style=\"text-align: right; line-height: 200%\">" . _MD_WB_CATEGORY . "</td>";
		$searchform .= "<td>&nbsp;</td><td style=\"text-align: left;\">";
		$resultcat = $xoopsDB -> query( "SELECT categoryID, name FROM " . $xoopsDB -> prefix ( 'imglossary_cats' ) . " ORDER BY categoryID" );
		$searchform .= "<select name=\"categoryID\">";
		$searchform .= "<option value=\"0\">" . _MD_WB_ALLOFTHEM . "</option>";

		while ( list( $categoryID, $name ) = $xoopsDB -> fetchRow( $resultcat ) ) {
			$searchform .= "<option value=\"$categoryID\">$categoryID : $name</option>";
		}
		$searchform .= "</select></td></tr>";
	}

	$searchform .= "<tr><td style=\"text-align: right; line-height: 200%\">";
	$searchform .= _MD_WB_TERM . "</td><td>&nbsp;</td><td style=\"text-align: left;\">";
	$searchform .= "<input type=\"text\" name=\"term\" /></td></tr><tr>";
	$searchform .= "<td>&nbsp;</td><td>&nbsp;</td><td><input type=\"submit\" value=\"" . _MD_WB_SEARCH . "\" />";
	$searchform .= "</td></tr></form></table>";
	return $searchform;
}

function getHTMLHighlight( $needle, $haystack, $hlS, $hlE ) {
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

function adminMenu( $currentoption = 0, $breadcrumb = '' ) {
	global $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
	$tblColors = array();
	$tblColors[0]=$tblColors[1]=$tblColors[2]=$tblColors[3]=$tblColors[4]=$tblColors[5]=$tblColors[6]=$tblColors[7]=$tblColors[8]='#DDE';
    $tblColors[$currentoption] = '#FFF';
    if ( file_exists( ICMS_ROOT_PATH . '/modules/' . $xoopsModule -> getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/modinfo.php' ) ) {
		include_once '../language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once '../language/english/modinfo.php';
	}
	echo '<div style="font-size: 10px; text-align: right; color: #2F5376; margin: 0 0 8px 0; padding: 2px 6px; line-height: 18px; border: 1px solid #e7e7e7; "><b>' . $xoopsModule -> name() . _AM_WB_MODADMIN . '</b> ' . $breadcrumb . '</div>';	
	echo '<div id="navcontainer"><ul style="padding: 3px 0; margin-left: 0;">';
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="index.php" style="padding: 3px 0.5em; margin-left: 0; border: 1px solid #778; background:' . $tblColors[0] . '; text-decoration: none; white-space: nowrap; ">' . _AM_WB_INDEX . '</a></li>';

	if ( $xoopsModuleConfig['multicats'] == 1 ) {
		echo '<li style="list-style: none; margin: 0; display: inline; "><a href="category.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[1] . '; text-decoration: none; white-space: nowrap; ">' . _AM_WB_CATS . '</a></li>';
	}
	
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="entry.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[2] . '; text-decoration: none; white-space: nowrap; ">' . _AM_WB_ENTRIES . '</a></li>';
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="submissions.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[3] . '; text-decoration: none; white-space: nowrap; ">' . _AM_WB_SUBMITS . '</a></li>';
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="myblocksadmin.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[4] . '; text-decoration: none; white-space: nowrap; ">' . _AM_WB_BLOCKS . '</a></li>';
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule -> getVar( 'mid' ) . '" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[5] . '; text-decoration: none; white-space: nowrap; ">' . _AM_WB_OPTS . '</a></li>';
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="../index.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[6] . '; text-decoration: none; white-space: nowrap; ">' . _AM_WB_GOMOD . '</a></li>';
	//mondarse
	echo '<li style="list-style: none; margin: 0; display: inline; "><a href="importdictionary091.php" style="padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: ' . $tblColors[6] . '; text-decoration: none; white-space: nowrap; ">' . _AM_WB_IMPORT . '</a></li>';
	//mondarse
//	echo "<li style=\"list-style: none; margin: 0; display: inline; \"><a href=\"../help/index.html\" target=\"_blank\" style=\"padding: 3px 0.5em; margin-left: 3px; border: 1px solid #778; background: " . $tblColors[7] . "; text-decoration: none; white-space: nowrap; \">" . _AM_WB_HELP . "</a></li></ul></div>";
	}
	
function imgloss_substr( $str, $start, $length, $trimmarker = '...' ) {
	$config_handler =& xoops_gethandler( 'config' );
	$im_multilanguageConfig =& $config_handler -> getConfigsByCat( IM_CONF_MULILANGUAGE );
    
	if ( $im_multilanguageConfig['ml_enable'] ) {
		$tags = explode( ',', $im_multilanguageConfig['ml_tags'] );
		$strs = array();
		$hasML = false;
		foreach ( $tags as $tag ) {
			if ( preg_match( "/\[" . $tag . "](.*)\[\/" . $tag . "\]/sU", $str, $matches ) ) {
				if ( count( $matches ) > 0 ) {
					$hasML = true;
					$strs[] = $matches[1];
				}
			}
		}
	} else {
		$hasML = false;
	}
	
	if ( !$hasML ) {
        $strs = array( $str );
	}
	
	for ( $i = 0; $i <= count( $strs ) - 1; $i++ ) {
		if ( !XOOPS_USE_MULTIBYTES ) {
			$strs[$i] = ( strlen( $strs[$i] ) - $start <= $length ) ? substr( $strs[$i], $start, $length ) : substr( $strs[$i], $start, $length - strlen( $trimmarker) ) . $trimmarker;
		}

		if ( function_exists( 'mb_internal_encoding' ) && @mb_internal_encoding( _CHARSET ) ) {
			$str2 = mb_strcut( $strs[$i], $start, $length - strlen( $trimmarker ) );
			$strs[$i] = $str2 . ( mb_strlen( $strs[$i] ) != mb_strlen( $str2 ) ? $trimmarker : '' );
		}

		// phppp patch
		$DEP_CHAR = 127;
		$pos_st = 0;
		$action = false;
		for ( $pos_i = 0; $pos_i < strlen( $strs[$i] ); $pos_i++ ) {
			if ( ord( substr( $strs[$i], $pos_i, 1 ) ) > 127 ) {
				$pos_i++;
			}
			if ( $pos_i <= $start ) {
				$pos_st=$pos_i;
			}
			if ( $pos_i >= $pos_st + $length ) {
				$action = true;
				break;
			}
		}
		$strs[$i] = ($action) ? substr( $strs[$i], $pos_st, $pos_i - $pos_st - strlen($trimmarker) ) . $trimmarker : $strs[$i];

		$strs[$i] = ($hasML)?'[' . $tags[$i] . ']' . $strs[$i] . '[/' . $tags[$i] . ']':$strs[$i];
	}
	$str = implode( '', $strs );

	return $str;
}
?>