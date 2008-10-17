<?php
include 'admin_header.php';
$op = '';

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];
/****
 * Available operations
 ****/
switch ( $op ) {
case "default":
    default:
    xoops_cp_header();
    global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule;
    $myts =& MyTextSanitizer::getInstance();
    imglossary_adminMenu( _AM_IMGLOSSARY_IMPORT );
}

/****
 * Start Import
 ****/

function import2db( $text ) {
    return preg_replace( array( "/'/i" ), array( "\'" ), $text );
}

function DefinitionImport( $delete ) {
    global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule, $myts;
    $myts =& MyTextSanitizer::getInstance();

    $sqlquery = $xoopsDB -> query( "SELECT COUNT(id) AS count FROM " . $xoopsDB -> prefix( 'wiwimod' ) );
    list( $count ) = $xoopsDB -> fetchRow( $sqlquery ) ;
    if ( $count < 1 ) {
        redirect_header( "index.php", 1, _AM_IMGLOSSARY_MODULEIMPORTEMPTY10 );
        exit();
    }

    $delete = 0 ;
    $glocounter = 0;
    $errorcounter = 0;

    if ( isset( $delete ) ) {
        $delete = intval( $_POST['delete'] );
    } else {
        if ( isset( $delete ) ) {
            $delete = intval( $_POST['delete'] );
        }
    }

    /****
     * delete all entries and categories + comments
     ****/

    if ( $delete )	{
        //get all entries
        $result3 = $xoopsDB -> query( "SELECT entryID FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "" );
        //delete comments for each entry
        while ( list( $entryID ) = $xoopsDB -> fetchRow( $result3 ) ) {
            xoops_comment_delete( $xoopsModule -> getVar( 'mid' ), $entryID );
        }
        // delete everything
        $sqlquery1 = $xoopsDB -> queryF( "TRUNCATE TABLE " . $xoopsDB -> prefix( 'imglossary_entries' ));
        $sqlquery2 = $xoopsDB -> queryF( "TRUNCATE TABLE " . $xoopsDB -> prefix( 'imglossary_cats' ) );
    }

    /****
     * Import ENTRIES
     ****/

    $sqlquery = $xoopsDB -> query( "SELECT id, title, body, u_id, lastmodified datetime, visible FROM " . $xoopsDB -> prefix( 'wiwimod' ) );

    $fecha = time()-1;
    while ( $sqlfetch = $xoopsDB -> fetchArray( $sqlquery ) ) {
        $glo = array();
        $glo['id'] = $sqlfetch["id"];
        $glo['title'] = $sqlfetch["title"];
        #$glo['body'] = import2db($sqlfetch["body"]);
        $glo['body'] = $myts -> addSlashes( import2db( $sqlfetch["body"] ) );
        $glo['u_id'] = import2db( $sqlfetch["u_id"] );
        #$glo['lastmodified'] = $sqlfetch["lastmodified datetime"];
        $glo['lastmodified'] = $fecha++;
        $glo['visible'] = $sqlfetch["visible"];
        $glocounter = $glocounter + 1;

        if ( $delete ) {
            $insert = $xoopsDB -> queryF( "INSERT INTO " . $xoopsDB -> prefix( 'imglossary_entries' ) . " (entryID, term, definition, uid, datesub, offline, html) VALUES ('" . $glo['id'] . "','" . $glo['title'] . "','" . $glo['body'] . "','" . $glo['u_id'] . "','" . $glo['lastmodified'] . "','" . $glo['visible'] . "','1')" );
        } else {
            $insert = $xoopsDB -> queryF( "INSERT INTO " . $xoopsDB -> prefix( 'imglossary_entries' ) . " (entryID, term, definition, uid, datesub, offline, html) VALUES ('','" . $glo['title'] . "','" . $glo['body'] . "','" . $glo['u_id'] . "','" . $glo['lastmodified'] . "','" . $glo['visible'] . "','1')" );
        }
        if ( !$insert ) {
            $errorcounter = $errorcounter + 1;
            echo "<font color='red'>Error: #" . $glo['id'] . "</font><br />" . $glo['title'] . "<br />";
            #echo $glo['body']."<br><br>";
            echo "<font size='1'>" . substr( $glo['body'], 0, 25) . "...</font><br ><br />";
        }
		if ( $ret1 ) {
			if ( $uid ) {
				$member_handler = &xoops_gethandler( 'member' );
				$submitter =& $member_handler -> getUser( $uid );
				if ( is_object( $submitter ) ) {
					$submitter -> setVar( 'posts', $submitter -> getVar( 'posts' ) + 1 );
					$res = $member_handler -> insertUser( $submitter, true );
					unset( $submitter );
				}
			}
		}
    }

    $sqlquery = $xoopsDB -> query( "SELECT mid FROM " . $xoopsDB -> prefix( 'modules' ) . " WHERE dirname='wiwimod'" );
    list( $wiwiID ) = $xoopsDB -> fetchRow( $sqlquery ) ;
    echo "<p>Wiwi Module ID: " . $wiwiID . "</p>";
    echo "<p>Encyclopedia Module ID: " . $xoopsModule -> getVar( 'mid' ) . "</p>";
    //echo "<p>delete is on/off: ".$delete."</p>";
    echo "<p><font color='red'>Incorrectly: " . $errorcounter . "</font></p>";
    echo "<p>Processed: " . $glocounter . "</p>";
    echo "<br /><b><a href='index.php'>" . _AM_IMGLOSSARY_IMPDICT_11 . "</a></b>";
    CloseTable();
    xoops_cp_footer();
}
/****
 * IMPORT FORM PLAIN HTML
 ****/

function FormImport() {
    global $xoopsConfig, $xoopsDB, $xoopsModule;
    $module_handler = xoops_gethandler( 'module' );
    $wiwimodModule = $module_handler -> getByDirname( "wiwimod" );
    $got_options = false;
    if ( is_object( $wiwimodModule ) ) {
		echo "<br /><br /><br />";
        echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
        echo "<tr>";
        echo "<td colspan='2' class='bg3' align='left'><font size='2'><b>" . _AM_IMGLOSSARY_MODULEHEADIMPORTWW . "</b></font></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td class='odd' align='center'><img src='" . ICMS_URL . "/modules/wiwimod/images/wiwilogo.gif' alt='' title='' /></td>";
        echo "<td class='even' style='text-align: center; background-color: #FBE3E4; color: red; font-weight: bold;'><br /><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> getVar( 'dirname' ) . "/images/icon/warning.png' alt='' title='' /><h3>" . _AM_IMGLOSSARY_IMPORTWARN . "</h3></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='odd' width = '200' align='left'><font size=2>" . _AM_IMGLOSSARY_IMPORTDELWB . "</font></td>";
        echo "<td class='even' align='center'><form action='importwiwimod.php?op=import' method=post>
        <input type='radio' name='delete' value='1'>&nbsp;" . _YES . "&nbsp;&nbsp;
        <input type='radio' name='delete' value='0' checked='checked'>&nbsp;" . _NO . "<br />
        </td>";
        echo "</tr><tr><td width = '200' class='odd' align='center'>&nbsp;</td>";
        echo "<td class='even' align='center'>
        <input type='submit' name='button' id='import' value='" . _AM_IMGLOSSARY_IMPORT . "'>&nbsp;
        <input type='button' name='cancel' value='" . _CANCEL . "' onclick='javascript:history.go(-1);'></td>";
        echo "</tr></table><br />\n";
    } else {
        echo "<br /><b><font color='red'>Module Wiwimod not found on this site.</font></b><br '><a href='index.php'>Back</a>";
    }
    xoops_cp_footer();

}

if ( !isset( $HTTP_POST_VARS['op'] ) ) {
    $op = isset( $HTTP_GET_VARS['op'] ) ? $HTTP_GET_VARS['op'] : 'main';
} else {
    $op = $HTTP_POST_VARS['op'];
}

if ( !isset( $HTTP_POST_VARS['delete'] ) ) {
    $delete = isset( $HTTP_GET_VARS['delete'] ) ? $HTTP_GET_VARS['delete'] : 'main';
} else {
    $delete = $HTTP_POST_VARS['delete'];
}

switch ( $op ) {
case "import":
    DefinitionImport( $delete );
    break;
case 'main':
default:
    FormImport();
    break;
}
?>

