<?php
/**
 * $Id: submissions.php v 1.0 18 May 2006 hsalazar Exp $
 * Module: encyclopedia - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

include 'admin_header.php';
$myts =& MyTextSanitizer::getInstance();
$op = '';

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];

/* -- Available operations -- */
switch ( $op ) {
case "default":
    default:
    include_once ICMS_ROOT_PATH . '/class/xoopslists.php';
    include_once ICMS_ROOT_PATH . '/class/pagenav.php';

    $startentry = isset( $_GET['startentry'] ) ? intval( $_GET['startentry'] ) : 0;
    $startcat = isset( $_GET['startcat'] ) ? intval( $_GET['startcat'] ) : 0;
    $startsub = isset( $_GET['startsub'] ) ? intval( $_GET['startsub'] ) : 0;
    $datesub = isset( $_GET['datesub'] ) ? intval( $_GET['datesub'] ) : 0;
    #$entryID =

    xoops_cp_header();
    global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule, $entryID;

    $myts =& MyTextSanitizer::getInstance();

    //v.1.17 completely rewritten had no content
    imglossary_adminMenu( 3, _AM_IMGLOSSARY_SUBMITS );
    $result01 = $xoopsDB -> query( "SELECT COUNT(*)
                                   FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " " );
    list( $totalcategories ) = $xoopsDB -> fetchRow( $result01 );

    $result02 = $xoopsDB -> query( "SELECT COUNT(*)
                                   FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "
                                   WHERE submit=0" );
    list( $totalpublished ) = $xoopsDB -> fetchRow( $result02 );

    $result03 = $xoopsDB -> query( "SELECT COUNT(*)
                                   FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "
                                   WHERE submit=1 AND request=0" );
    list( $totalsubmitted ) = $xoopsDB -> fetchRow( $result03 );

    $result04 = $xoopsDB -> query( "SELECT COUNT(*)
                                   FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "
                                   WHERE submit=1 AND request=1" );
    list( $totalrequested ) = $xoopsDB -> fetchRow( $result04 );

    $result05 = $xoopsDB -> query( "SELECT COUNT(*)
                                   FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "
                                   WHERE offline=1" );
    list( $totaloffline ) = $xoopsDB -> fetchRow( $result05 );

    echo "<div>&nbsp;</div>";
	echo "<fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; color: #292D30;'>" . _AM_IMGLOSSARY_INVENTORY . "</legend>";
	echo "<div style='padding: 12px;'>" . _AM_IMGLOSSARY_TOTALENTRIES . " <b>$totalpublished</b> | ";
		
	if ($xoopsModuleConfig['multicats'] == 1) {
		echo _AM_IMGLOSSARY_TOTALCATS . " <b>$totalcategories</b> | ";
	}
		
	echo _AM_IMGLOSSARY_TOTALSUBM . " <b>$totalsubmitted</b> | ";
	echo _AM_IMGLOSSARY_TOTALREQ . " <b>$totalrequested</b></div>";
	echo "</fieldset><br />";

    /**
     * Code to show submitted entries
     **/

    echo "<fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; color: #292D30;'>" . _AM_IMGLOSSARY_SHOWSUBMISSIONS . "</legend>";
	echo "<div>&nbsp;</div>";
    echo "<table class='outer' cellspacing=1 cellpadding=3 width='100%' border='0'>";

    $resultS1 = $xoopsDB -> query( "SELECT COUNT(*)
                                   FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "
                                   WHERE submit=1 AND request=0" );
    list( $numrows ) = $xoopsDB -> fetchRow( $resultS1 );

    $sql = "SELECT entryID, categoryID, term, uid, datesub
           FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "
           WHERE submit=1 AND request=0
           ORDER BY datesub DESC";
    $resultS2 = $xoopsDB -> query( $sql, $xoopsModuleConfig['perpage'], $startsub );

    echo " <td width='40' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYID . "</b></td>";
    if ( $xoopsModuleConfig['multicats'] == 1 ) {
        echo "<td width='20%' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCATNAME . "</b></td>";
    }
    echo "<td class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYTERM . "</b></td>
    <td width='90' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_SUBMITTER . "</b></td>
    <td width='90' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCREATED . "</b></td>
    <td width='60' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ACTION . "</b></td>
    </tr>";

    if ( $numrows > 0 ) // That is, if there ARE submitted entries in the system
    {
        while ( list( $entryID, $categoryID, $term, $uid, $created) = $xoopsDB -> fetchrow( $resultS2 ) ) {
            $resultS3 = $xoopsDB -> query( "SELECT name
                                           FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . "
                                           WHERE categoryID = '$categoryID'" );
            list( $name ) = $xoopsDB -> fetchrow( $resultS3 );

            $sentby = xoops_getLinkedUnameFromId( $uid );

            $catname = $myts -> htmlSpecialChars( $name );
            $term = $myts -> htmlSpecialChars( $term );
            $created = formatTimestamp( $created, 's' );
            $modify = "<a href='entry.php?op=mod&entryID=" . $entryID . "'><img src=" . ICMS_URL . "/modules/" . $glossdirname . "/images/icon/edit.png alt='" . _AM_IMGLOSSARY_EDITSUBM . "'></a>";
            $delete = "<a href='entry.php?op=del&entryID=" . $entryID . "'><img src=" . ICMS_URL . "/modules/" . $glossdirname . "/images/icon/delete.png alt='" . _AM_IMGLOSSARY_DELETESUBM . "'></a>";
            //$approve = "<a href='entry.php?op=add&entryID=" . $entryID . "'><img src=" . ICMS_URL . "/modules/" . $glossdirname . "/images/icon/approve.png alt='"._AM_IMGLOSSARY_APPROVESUBM."'></a>";

            echo "<tr>
            <td class='even' align='center'>" . $entryID . "</td>";
            if ( $xoopsModuleConfig['multicats'] == 1 ) {
                echo "<td class='even' align='left'>" . $catname . "</td>";
            }
            echo "<td class='even' align='left'>" . $term . "</td>
            <td class='even' align='center'>" . $sentby . "</td>
            <td class='even' align='center'>" . $created . "</td>
            <td class='even' align='center'> $modify $delete </td>
            </tr></div>";
        }
    }
    else // that is, $numrows = 0, there's no columns yet
    {
        echo "<tr>
        <td class='head' align='center' colspan= '7'>" . _AM_IMGLOSSARY_NOSUBMISSYET . "</td>
        </tr></div>";
    }
    echo "</table>\n";
    $pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startsub, 'startsub', 'entryID=' . $entryID );
    echo '<div style="text-align:right;">' . $pagenav -> renderNav(8) . '</div>';
    echo" <br /></fieldset>\n";
 //   echo "</div>";

    /**
     * Code to show requested entries
     **/

    echo "<fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; color: #292D30;'>" . _AM_IMGLOSSARY_SHOWREQUESTS . "</legend>";
	echo "<div>&nbsp;</div>";
    echo "<div style='float:left; width:100%;'><table class='outer' cellspacing=1 cellpadding=3 width='100%' border='0'>";
    /*		<tr>
    		<td colspan='7' class='odd'>
    		<strong>". _AM_IMGLOSSARY_SHOWREQUESTS . ' (' . $totalrequested . ')'. "</strong></td></TR>";
    		echo "<tr>";
    */
    $resultS2 = $xoopsDB -> query( "SELECT COUNT(*)
                                   FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "
                                   WHERE submit=1 AND request=1" );
    list( $numrowsX ) = $xoopsDB -> fetchRow( $resultS2 );

    $sql4 = "SELECT entryID, categoryID, term, uid, datesub
            FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "
            WHERE submit=1 AND request=1
            ORDER BY datesub DESC";
    $resultS4 = $xoopsDB -> query( $sql4, $xoopsModuleConfig['perpage'], $startsub );

    echo "<td width='40' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYID . "</b></td>";
    if ( $xoopsModuleConfig['multicats'] == 1 ) {
        echo "<td width='20%' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCATNAME . "</b></td>";
    }
    echo "<td class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYTERM . "</b></td>";
    echo "<td width='90' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_SUBMITTER . "</b></td>";
    echo "<td width='90' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCREATED . "</b></td>";
    echo "<td width='60' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ACTION . "</b></td>";
    echo "</tr>";

    if ( $numrowsX > 0 ) // That is, if there ARE unauthorized articles in the system
    {
        while ( list( $entryID, $categoryID, $term, $uid, $created ) = $xoopsDB -> fetchrow( $resultS4 ) ) {
            $resultS3 = $xoopsDB -> query( "SELECT name
                                           FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . "
                                           WHERE categoryID='$categoryID'" );
            list( $name ) = $xoopsDB -> fetchrow( $resultS3 );

            $sentby = xoops_getLinkedUnameFromId( $uid );

            $catname = $myts -> htmlSpecialChars( $name );
            $term = $myts -> htmlSpecialChars( $term );
            $created = formatTimestamp( $created, 's' );
            $modify = "<a href='entry.php?op=mod&entryID=" . $entryID . "'><img src=" . ICMS_URL . "/modules/" . $glossdirname . "/images/icon/edit.png alt='" . _AM_IMGLOSSARY_EDITSUBM . "'></a>";
            $delete = "<a href='entry.php?op=del&entryID=" . $entryID . "'><img src=" . ICMS_URL . "/modules/" . $glossdirname . "/images/icon/delete.png alt='" . _AM_IMGLOSSARY_DELETESUBM . "'></a>";

            echo "<tr>";
            echo "<td class='even' align='center'>" . $entryID . "</td>";
            if ($xoopsModuleConfig['multicats'] == 1) {
                echo "<td class='even' align='left'>" . $catname . "</td>";
            }
            echo "<td class='even' align='left'>" . $term . "</td>";
            echo "<td class='even' align='center'>" . $sentby . "</td>";
            echo "<td class='even' align='center'>" . $created . "</td>";
            echo "<td class='even' align='center'> $modify $delete </td>";
            echo "</tr></div>";
        }
    }
    else // that is, $numrows = 0, there's no columns yet
    {
        echo "<tr>
        <td class='head' align='center' colspan= '7'>" . _AM_IMGLOSSARY_NOREQSYET . "</td>
        </tr></div>";
    }
    echo "</table>\n";
    $pagenav = new XoopsPageNav( $numrowsX, $xoopsModuleConfig['perpage'], $startsub, 'startsub', 'entryID=' . $entryID );
    echo '<div style="text-align:right;">' . $pagenav -> renderNav(8) . '</div>';
    echo "<br /></fieldset>\n";
    echo "</div>";

    /**
     * Code to show offline entries
     **/
    echo "<fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; color: #292D30;'>" . _AM_IMGLOSSARY_SHOWOFFLINE . "</legend>";
	echo "<div>&nbsp;</div>";
    echo "	<div style='float:left; width:100%;'><table class='outer' cellspacing=1 cellpadding=3 width='100%' border='0'>";

    $resultS2 = $xoopsDB -> query( "SELECT COUNT(*)
                                   FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "
                                   WHERE offline=1" );
    list( $numrowsX ) = $xoopsDB -> fetchRow( $resultS2 );

    $sql4 = "SELECT entryID, categoryID, term, uid, datesub
            FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "
            WHERE offline=1
            ORDER BY datesub DESC";
    $resultS4 = $xoopsDB -> query( $sql4, $xoopsModuleConfig['perpage'], $startsub );

    echo "<td width='40' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYID . "</b></td>";
    if ($xoopsModuleConfig['multicats'] == 1) {
        echo "<td width='20%' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCATNAME . "</b></td>";
    }
    echo "<td class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYTERM . "</b></td>";
    echo "<td width='90' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_SUBMITTER . "</b></td>";
    echo "<td width='90' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCREATED . "</b></td>";
    echo "<td width='60' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ACTION . "</b></td>";
    echo "</tr>";

    if ( $numrowsX > 0 ) // That is, if there ARE unauthorized articles in the system
    {
        while ( list( $entryID, $categoryID, $term, $uid, $created ) = $xoopsDB -> fetchrow( $resultS4 ) ) {
            $resultS3 = $xoopsDB -> query( "SELECT name
                                           FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . "
                                           WHERE categoryID='$categoryID'" );
            list( $name ) = $xoopsDB -> fetchrow( $resultS3 );

            $sentby = xoops_getLinkedUnameFromId( $uid );

            $catname = $myts -> htmlSpecialChars( $name );
            $term = $myts -> htmlSpecialChars( $term );
            $created = formatTimestamp( $created, 's' );
            $modify = "<a href='entry.php?op=mod&entryID=" . $entryID . "'><img src=" . ICMS_URL . "/modules/" . $glossdirname . "/images/icon/edit.png ALT='" . _AM_IMGLOSSARY_EDITSUBM . "'></a>";
            $delete = "<a href='entry.php?op=del&entryID=" . $entryID . "'><img src=" . ICMS_URL . "/modules/" . $glossdirname . "/images/icon/delete.png ALT='" . _AM_IMGLOSSARY_DELETESUBM . "'></a>";

            echo "<tr>";
            echo "<td class='even' align='center'>" . $entryID . "</td>";
            if ( $xoopsModuleConfig['multicats'] == 1 ) {
                echo "<td class='even' align='left'>" . $catname . "</td>";
            }
            echo "<td class='even' align='left'>" . $term . "</td>";
            echo "<td class='even' align='center'>" . $sentby . "</td>";
            echo "<td class='even' align='center'>" . $created . "</td>";
            echo "<td class='even' align='center'> $modify $delete </td>";
            echo "</tr></div>";
        }
    }
    else // that is, $numrows = 0, there's no columns yet
    {
        echo "<tr>
        <td class='head' align='center' colspan= '7'>" . _AM_IMGLOSSARY_NOREQSYET . "</td>
        </tr></div>";
    }
    echo "</table>\n";
    $pagenav = new XoopsPageNav( $numrowsX, $xoopsModuleConfig['perpage'], $startsub, 'startsub', 'entryID=' . $entryID );
    echo '<div style="text-align:right;">' . $pagenav -> renderNav(8) . '</div>';
    echo "<br /></fieldset>\n";
    echo "</div>";
}
xoops_cp_footer();
?>