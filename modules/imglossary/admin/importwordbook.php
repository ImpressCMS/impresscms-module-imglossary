<?php
//////////////////////////////////////////////////////////////////////////////
// $Id: importWordbook.php,v 1.1 18/03/2007 17:21:00 Yerres Exp $           //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
//                                                                          //
// This program is distributed in the hope that it will be useful, but      //
// WITHOUT ANY WARRANTY; without even the implied warranty of               //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU         //
// General Public License for more details.                                 //
//                                                                          //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the                            //
// Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,      //
// MA 02111-1307 USA                                                        //
// ------------------------------------------------------------------------ //
// code bits stolen from Aiba                                               //
// ------------------------------------------------------------------------ //
// import script Wordbook -> imGlossary 1.0                                 //
// ------------------------------------------------------------------------ //
// modified by McDonald
//////////////////////////////////////////////////////////////////////////////

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
    global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModule, $entryID, $myts;
    $sqlquery = $xoopsDB -> query( "SELECT COUNT(entryID) AS count FROM " . $xoopsDB -> prefix( 'wbentries' ) );
    list( $count ) = $xoopsDB -> fetchRow( $sqlquery ) ;
    if ( $count < 1 ) {
        redirect_header( "index.php", 1, _AM_IMGLOSSARY_MODULEIMPORTEMPTY10 );
        exit();
    }
    $delete = 0 ;
    $wbkcounter = 0;
    $errorcounter = 0;
    $wbkcounter1 = 0;
    $errorcounter1 = 0;

    if (isset( $delete ) ) {
        $delete=intval( $_POST['delete'] );
    } else {
        if ( isset( $delete ) ) {
            $delete = 1;
            $delete = intval( $_POST['delete'] );
        }
    }

    /****
     * delete all entries and categories without comments
     ****/
    if ( $delete )	{
        //get all entries
        $result3 = $xoopsDB -> query( "SELECT entryID FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "");
        //delete comments for each entry
        while ( list( $entryID ) = $xoopsDB -> fetchRow( $result3 ) ) {
            xoops_comment_delete( $xoopsModule -> getVar( 'mid' ), $entryID );
        }
        // delete everything
        $sqlquery1 = $xoopsDB -> queryF( "TRUNCATE TABLE " . $xoopsDB -> prefix( 'imglossary_entries' ) );
        $sqlquery2 = $xoopsDB -> queryF( "TRUNCATE TABLE " . $xoopsDB -> prefix( 'imglossary_cats' ) );
    }

    /****
     * Import ENTRIES
     ****/

    $sql1 = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'wbentries' ) . " " );

    $result1 = $xoopsDB -> getRowsNum( $sql1 );
    if ( $result1 ) {
        while ( $row2 = $xoopsDB -> fetchArray( $sql1 ) ) {
            $entryID     = intval( $row2['entryID'] );
            $categoryID  = intval( $row2['categoryID'] );
            $term        = $myts -> addSlashes( import2db( $row2['term'] ) );
            $init        = $myts -> addSlashes( $row2['init'] );
            $definition  = $myts -> addSlashes( import2db( $row2['definition'] ) );
            $ref         = $myts -> addSlashes( $row2['ref'] );
            $url         = $myts -> addSlashes( $row2['url'] );
            $uid         = intval( $row2['uid'] );
            $submit      = intval( $row2['submit'] );
            $datesub     = intval( $row2['datesub'] );
            $counter     = intval( $row2['counter'] );
            $html        = intval( $row2['html'] );
            $smiley      = intval( $row2['smiley'] );
            $xcodes      = intval( $row2['xcodes'] );
            $breaks      = intval( $row2['breaks'] );
            $block       = intval( $row2['block'] );
            $offline     = intval( $row2['offline'] );
            $notifypub   = intval( $row2['notifypub'] );
            $request     = intval( $row2['request'] );
            $comments     = intval( $row2['comments'] );
            $wbkcounter = $wbkcounter + 1;

            // just adding the entries to existing database or setting it up anew ?
            if ( $delete ) {
                $ret1 = $xoopsDB -> queryF( "INSERT INTO " . $xoopsDB -> prefix( 'imglossary_entries' ) . " (entryID, categoryID, term, init, definition, ref, url, uid, submit, datesub, counter, html, smiley, xcodes, breaks, block, offline, notifypub, request, comments) VALUES ('$entryID', '$categoryID', '$term', '$init', '$definition', '$ref', '$url', '$uid', '$submit', '$datesub', '$counter', '$html', '$smiley', '$xcodes', '$breaks', '$block', '$offline', '$notifypub', '$request', '$comments' )" );
            } else {
                $ret1 = $xoopsDB -> queryF("INSERT INTO " . $xoopsDB -> prefix( 'imglossary_entries' ) . " (entryID, categoryID, term, init, definition, ref, url, uid, submit, datesub, counter, html, smiley, xcodes, breaks, block, offline, notifypub, request, comments) VALUES ('', '$categoryID', '$term', '$init', '$definition', '$ref', '$url', '$uid', '$submit', '$datesub', '$counter', '$html', '$smiley', '$xcodes', '$breaks', '$block', '$offline', '$notifypub', '$request', '$comments')" );
            }
            if ( !$ret1 ) {
                $errorcounter = $errorcounter + 1;
                echo "<font color='red'>Error: entryID: " . $entryID . "</font><br />$term<br />";
                #echo $definition ."<br><br>";
                echo "<font size='1'>" . substr($definition,0,25) . "...</font><br /><br />";
            }
            // update user posts count
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
    }

    /****
     * Import CATEGORIES
     ****/

    $sql2 = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'wbcategories' ) . " ORDER BY categoryID" );

    $result2 = $xoopsDB -> getRowsNum( $sql2 );
    if ( $result2 ) {
        while ( $row1 = $xoopsDB -> fetchArray( $sql2 ) ) {
            $categoryID  = intval( $row1['categoryID'] );
            $name        = $myts -> addSlashes( $row1['name'] );
            $description = $myts -> addSlashes( import2db( $row1['description'] ) );
            $total       = intval( $row1['total'] );
            $weight      = intval( $row1['weight'] );
            $wbkcounter1 = $wbkcounter1 + 1;

            // insert new field `` as well 1.1
            if ( $delete ) {
                $ret2 = $xoopsDB -> queryF( "INSERT INTO " . $xoopsDB -> prefix( 'imglossary_cats' ) . " (categoryID, name, description, total, weight) VALUES ('$categoryID','$name', '$description', '$total', '$weight')" );
            } else {
                $ret2 = $xoopsDB -> queryF( "INSERT INTO " . $xoopsDB -> prefix( 'imglossary_cats' ) . " (categoryID, name, description, total, weight) VALUES ('', '$name', '$description', '$total', '$weight')" );
            }
            if ( !$ret2 ) {
                $errorcounter = $errorcounter + 1;
                echo "<font color='red'>Error: categoryID: " . $categoryID . "</font><br />$name<br />";
                echo "<font size='1'>" . substr( $description, 0, 25) . "...</font><br /><br />";
            }
        }
    }

    /****
     * FINISH
     ****/

    $sqlquery3 = $xoopsDB -> query( "SELECT mid FROM " . $xoopsDB -> prefix( 'modules' ) . " WHERE dirname='wordbook'" );
    list( $wbkID ) = $xoopsDB -> fetchRow( $sqlquery3 );

    echo "<p>Wordbook Module ID: " . $wbkID . "</p>";
    echo "<p>imGlossary Module ID: " . $xoopsModule -> getVar( 'mid' ) . "</p>";
    //echo "<p>delete is on/off: ".$delete."</p>";

    $commentaire = $xoopsDB -> queryF( "UPDATE " . $xoopsDB -> prefix( 'xoopscomments' ) . " SET com_modid = '" . $xoopsModule -> getVar( 'mid' ) . "' WHERE com_modid='" . $wbkID . "'" );

    if ( !$commentaire ) {
        echo "<font color='red'>" . _AM_IMGLOSSARY_MODULEIMPORTERNOCOM . "<br /><br />";
    } else {
        echo "<p>" . _AM_IMGLOSSARY_MODULEIMPORTERNOCOM . "</p>";
    }

    echo "<p><font color='red'>Incorrectly: " . $errorcounter . "</font></p>";
    echo "<p>Processed Entries: " . $wbkcounter . "</p>";
    echo "<p>Processed Categories: " . $wbkcounter1 . "</p>";
    echo "<br /><b><a href='index.php'>Back to Admin</a></b><p>";
    CloseTable();
    xoops_cp_footer();
}

/****
 * IMPORT FORM PLAIN HTML
 ****/

function FormImport() {
    global $xoopsConfig, $xoopsDB, $xoopsModule;

    $module_handler = xoops_gethandler( 'module' );
    $wordbookModule = $module_handler -> getByDirname( 'wordbook' );
    $got_options = false;
    if ( is_object( $wordbookModule ) ) {
		echo "<br /><br /><br />";
        echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
        echo "<tr>";
        echo "<td colspan='2' class='bg3' align='"._GLOBAL_LEFT."'><b>" . _AM_IMGLOSSARY_MODULEHEADIMPORTWB . "</b></td>";
        echo "</tr>";

        echo "<tr>";
 //       echo "<td class='head' width = '200' align='center'><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> getVar('dirname') . "/images/icon/exclamation.png"."' alt='' hspace='0' vspace='0' align='middle' style='margin-right: 10px; '></td>";
		echo "<td class='odd' align='center'><img src='" . ICMS_URL . "/modules/wordbook/images/wb_slogo.png' alt='' title='' /></td>";
        echo "<td class='even' style='text-align: center; background-color: #FBE3E4; color: red; font-weight: bold;'><br /><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> getVar( 'dirname' ) . "/images/icon/warning.png' alt='' title='' /><h3>" . _AM_IMGLOSSARY_IMPORTWARN . "</h3></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='odd' style='text-align: center; font-weight: bold;'>" . _AM_IMGLOSSARY_IMPORTDELWB . "</td>";
        echo "<td class='even' align='center'><form action='importwordbook.php?op=import' method=post>
        <input type='radio' name='delete' value='1'>&nbsp;" . _YES . "&nbsp;&nbsp;
        <input type='radio' name='delete' value='0' checked='checked'>&nbsp;" . _NO . "<br />
        </td>";
        echo "</tr><tr><td width = '200' class='odd' align='center'>&nbsp;</td>";
        echo "<td class='even' align='center'>
        <input type='submit' name='button' id='import' value='" . _AM_IMGLOSSARY_IMPORT . "'>&nbsp;
        <input type='button' name='cancel' value='" . _CANCEL . "' onclick='javascript:history.go(-1);'></td>";
        echo "</tr></table>\n";
    } else {
        echo "<br /><b><font color='red'>Module Wordbook not found on this site.</font></b><br /><a href='index.php'>Back</a>";
    }
    xoops_cp_footer();

}

global $op;

switch ( $op ) {
case "import":
    $delete = ( isset( $_GET['delete'] ) ) ? intval($_GET['delete']) : intval($_POST['delete']);
    DefinitionImport( $delete );
    break;


default:
    FormImport();
    break;
}
?>