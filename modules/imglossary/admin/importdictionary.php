$_POST<?php
//////////////////////////////////////////////////////////////////////////////
// $Id: importdictionary.php,v 1.1 18/03/2007 17:21:00 Yerres Exp $         //
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
// coded bits stolen from Aiba                                              //
// ------------------------------------------------------------------------ //
// import script dictionary  -> Encyclopedia 1.00                           //
// ------------------------------------------------------------------------ //
// modified by McDonald                                                     //
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
    global $xoopsConfig, $xoopsDB, $xoopsModule, $myts;
    $sqlquery = $xoopsDB -> query( "SELECT COUNT(id) AS count FROM " . $xoopsDB -> prefix( 'dictionary' ) );
    list( $count ) = $xoopsDB -> fetchRow( $sqlquery ) ;
    if ( $count < 1 ) {
        redirect_header( "index.php", 1, _AM_IMGLOSSARY_IMPDICT_01 );
        exit();
    }

    $delete = 0 ;
    $glocounter = 0;
    $errorcounter = 0;

    if ( isset( $delete ) ) {
        $delete = intval( $_POST['delete'] );
    } else {
        if ( isset( $delete ) ) {
            #$delete=1;
            $delete = intval( $_POST['delete'] );
        }
    }

    /****
     * delete all entries and categories
     ****/
    if ( $delete ) {
        //get all entries
        $result3 = $xoopsDB -> query( "SELECT entryID FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "" );
        //now for each entry, delete the coments
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

    $sql1 = $xoopsDB -> query( " SELECT * FROM " . $xoopsDB -> prefix( 'dictionary' ) . " " );

    $result1 = $xoopsDB -> getRowsNum( $sql1 );
    if ( $result1 ) {
        $fecha = time()-1;
        while ( $row2 = $xoopsDB -> fetchArray( $sql1 ) ) {
            $entryID     = intval( $row2['id'] );
            $init        = $myts -> addSlashes( $row2['letter'] );
            $term        = $myts -> addSlashes( import2db( $row2['name'] ) );
            $definition  = $myts -> addSlashes( import2db( $row2['definition'] ) );
            #$request    = intval($row2['request']);
            $datesub     = $fecha++;
            #$estado     = intval($row2['state']);
            $estado      = import2db( $row2['state'] );
            if ( $estado  == 'O' ) {
                $row2['state']  = 0;
            } else {
                $row2['state'] = 1;
            }
            if ( $estado  == 'D' ) {
                $row2['submit'] = 1 && $row2['state'] = 1;
            } else {
                $row2['submit'] = 0;
            }
            $comments    = intval( $row2['comments'] );
            $glocounter  = $glocounter + 1;

            if ( $delete ) {

                $ret1 = $xoopsDB -> queryF( "INSERT INTO " . $xoopsDB -> prefix( 'imglossary_entries' ) . " (entryID, init, term, definition, url,  submit, datesub, offline, comments) VALUES ('$entryID', '$init', '$term', '$definition', '', '" . $row2['submit'] . "', '$datesub', '" . $row2['state'] . "', '$comments' )" );
            } else {
                $ret1 = $xoopsDB -> queryF( "INSERT INTO " . $xoopsDB -> prefix( 'imglossary_entries' ) . " (entryID, init, term, definition, url, submit, datesub, offline, comments) VALUES ('', '$init', '$term', '$definition', '', '" . $row2['submit'] . "', '$datesub', '" . $row2['state'] . "',  '$comments' )" );
            }
            if ( !$ret1 ) {
                $errorcounter = $errorcounter + 1;
                echo "<font color='red'>Error: entryID: " . $entryID . "</font><br />$term<br />";
                echo "<font size='1'>" . xoops_substr( $definition, 0, 25 ) . "</font><br/><br />";
            }
            // update user posts count
            if ( $ret1 ) {
                if ( $uid ) {
                    $member_handler = &xoops_gethandler( 'member' );
                    $submitter =& $member_handler -> getUser( $uid );
                    if ( is_object( $submitter ) ) {
                        $submitter -> setVar( 'posts', $submitter -> getVar('posts') + 1 );
                        $res = $member_handler -> insertUser( $submitter, true );
                        unset( $submitter );
                    }
                }
            }
        }
    }
    /****
     * FINISH
     ****/

    $sqlquery = $xoopsDB -> query( "SELECT mid FROM " . $xoopsDB -> prefix ( 'modules' ) . " WHERE dirname='dictionary'" );
    list( $dicID ) = $xoopsDB -> fetchRow( $sqlquery ) ;
    echo "<p>Dictionary Module ID: " . $dicID . "</p>";
    echo "<p>Encyclopedia Module ID: " . $xoopsModule -> getVar( 'mid' ) . "</p>";
    //echo "<p>delete is on/off: ".$delete."</p>";

    $commentaire = $xoopsDB -> queryF( "UPDATE " . $xoopsDB -> prefix( 'xoopscomments' ) . " SET com_modid = '" . $xoopsModule -> getVar( 'mid' ) . "' WHERE com_modid='" . $dicID . "'" );
    if ( !$commentaire ) {
        echo "<font color='red'>" . _AM_IMGLOSSARY_IMPDICT_07 . "<br /><br />";
    } else {
        echo "<p>" . _AM_IMGLOSSARY_IMPDICT_08 . "</p>";
    }

    echo "<p><font color='red'>" . _AM_IMGLOSSARY_IMPDICT_09 . $errorcounter . "</font></p>";
    echo "<p>" . _AM_IMGLOSSARY_IMPDICT_10 . $glocounter . "</p>";
    echo "<br /><b><a href='importwordbook.php'>" . _AM_IMGLOSSARY_IMPDICT_11 . "</a></b><p>";
    CloseTable();
    xoops_cp_footer();
}

/****
 * IMPORT FORM PLAIN HTML
 ****/

function FormImport() {
    global $xoopsConfig, $xoopsDB, $xoopsModule;

    $module_handler = xoops_gethandler( 'module' );
    $dictionaryModule = $module_handler -> getByDirname( 'dictionary' );
    $got_options = false;
    if ( is_object( $dictionaryModule ) ) {
		echo "<br /><br /><br />";
        echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
        echo "<tr>";
        echo "<td colspan='2' class='bg3' align='left'><b>" . _AM_IMGLOSSARY_MODULEHEADIMPORT . "</b></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td class='odd' align='center'><img src='" . ICMS_URL . "/modules/dictionary/images/dictionary_logo.png' alt='' title='' /></td>";
        echo "<td class='even'  style='text-align: center; background-color: #FBE3E4; color: red; font-weight: bold;'><br /><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> getVar( 'dirname' ) . "/images/icon/warning.png' alt='' title='' /><h3>" . _AM_IMGLOSSARY_IMPORTWARN . "</h3></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td class='odd' style='text-align: center; font-weight: bold;'>" . _AM_IMGLOSSARY_IMPORTDELWB . "</td>";
        echo "<td class='even' align='center'><form action='importdictionary.php?op=import' method=post>
        <input type='radio' name='delete' value='1'>&nbsp;" . _YES . "&nbsp;&nbsp;
        <input type='radio' name='delete' value='0' checked='checked'>&nbsp;"._NO."<br />
        </td>";
        echo "</tr><tr><td width = '200' class='odd' align='center'>&nbsp;</td>";
        echo "<td class='even' align='center'>
        <input type='submit' name='button' id='import' value='" . _AM_IMGLOSSARY_IMPORT . "'>&nbsp;
        <input type='button' name='cancel' value='" . _CANCEL . "' onclick='javascript:history.go(-1);'></td>";
        echo "</tr></table>\n";
    } else {
        echo "<br><b><font color='red'>" . _AM_IMGLOSSARY_IMPDICT_12 . "</font></b><br /><a href='index.php'>" . _AM_IMGLOSSARY_IMPDICT_11 . "</a>";
    }
    CloseTable();
    xoops_cp_footer();
}

if (!isset($HTTP_POST_VARS['op'])) {
    $op = isset($HTTP_GET_VARS['op']) ? $_GET['op'] : 'main';
} else {
    $op = ['op'];
}

if (!isset($_POST['delete'])) {
    $delete = isset($HTTP_GET_VARS['delete']) ? $_GET['delete'] : 'main';
} else {
    $delete = $_POST['delete'];
}

switch ($op) {
case "import":
    $delete = ( isset( $_GET['delete'] ) ) ? intval($_GET['delete']) : intval($_POST['delete']);
    DefinitionImport($delete);
    break;
case 'main':
default:
    FormImport();
    break;
}
?>