<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: admin/index.php
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		XOOPS_copyrights.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		Wordbook - a multicategory glossary
* @since			1.16
* @author		hsalazar
* ----------------------------------------------------------------------------------------------------------
* 				imGlossary - a multicategory glossary
* @since			1.00
* @author		modified by McDonald
* @version		$Id$
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
		$entryID = '';

		xoops_cp_header();
		global $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule, $entryID;

		$myts =& MyTextSanitizer::getInstance();
		imglossary_adminMenu( 0, _AM_IMGLOSSARY_INDEX );
		
        $result01 = $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " " );
			list( $totalcategories ) = $xoopsDB -> fetchRow( $result01 );
        $result02 = $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0" );
			list( $totalpublished ) = $xoopsDB -> fetchRow( $result02 );
        $result03 = $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=1 AND request=0" );
			list( $totalsubmitted ) = $xoopsDB -> fetchRow( $result03 );
        $result04 = $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=1 AND request=1" );
			list( $totalrequested ) = $xoopsDB -> fetchRow( $result04 );
		
		echo "<div>&nbsp;</div>";
		echo "<fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; color: #292D30;'>" . _AM_IMGLOSSARY_INVENTORY . "</legend>";
        echo "<div style='padding: 12px;'>" . _AM_IMGLOSSARY_TOTALENTRIES . " <b>$totalpublished</b> | ";
		
		if ($xoopsModuleConfig['multicats'] == 1) {
			echo _AM_IMGLOSSARY_TOTALCATS . " <b>$totalcategories</b> | ";
		}
		
        echo _AM_IMGLOSSARY_TOTALSUBM . " <b>$totalsubmitted</b> | ";
		echo _AM_IMGLOSSARY_TOTALREQ . " <b>$totalrequested</b></div>";
		echo "</fieldset><br />";

		/* -- Code to show existing terms -- */
		echo "<fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; color: #292D30;'>" . _AM_IMGLOSSARY_SHOWENTRIES . "</legend><br />";
		echo "<a style='float: left; border: 1px solid #5E5D63; color: #000000; background-color: #EFEFEF; padding: 4px 8px; text-align:center;' href='entry.php'>" . _AM_IMGLOSSARY_CREATEENTRY . "</a><br /><br />";
		// To create existing terms table
		$resultA1 = $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0" );
		list( $numrows ) = $xoopsDB -> fetchRow( $resultA1 );

		$sql = "SELECT entryID, categoryID, term, uid, datesub, offline FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 ORDER BY entryID DESC";
		$resultA2 = $xoopsDB -> query( $sql, $xoopsModuleConfig['perpage'], $startentry );

		echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>";
		echo "<tr>";
		echo "<td width='40' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYID . "</b></td>";
		echo "<td class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYTERM . "</b></td>";
		if ( $xoopsModuleConfig['multicats'] == 1 ) {
			echo "<td width='20%' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCATNAME . "</b></td>";
		}		
		echo "<td width='150' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_SUBMITTER . "</b></td>";
		echo "<td width='90' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCREATED . "</b></td>";
		echo "<td width='30' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_STATUS . "</b></td>";
		echo "<td width='60' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ACTION . "</b></td>";
		echo "</tr>";

		if ( $numrows > 0 ) {
			// That is, if there ARE entries in the system
			while ( list( $entryID, $categoryID, $term, $uid, $created, $offline ) = $xoopsDB -> fetchrow( $resultA2 ) ) {
				$resultA3 = $xoopsDB -> query( "SELECT name FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " WHERE categoryID='$categoryID'" );
				list( $name ) = $xoopsDB -> fetchrow( $resultA3 );

				$sentby = xoops_getLinkedUnameFromId( $uid );

				$catname = "<a href='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/category.php?categoryID=" . $categoryID . "'>" . $myts -> htmlSpecialChars( $name ) . "</a>";
				$term = "<a href='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/entry.php?entryID=" . $entryID . "'>" . $myts -> htmlSpecialChars( $term ) . "</a>";
				$created = formatTimestamp( $created, 's' );
				$modify = "<a href='entry.php?op=mod&entryID=" . $entryID . "'><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/images/icon/edit.png' alt='" . _AM_IMGLOSSARY_EDITENTRY . "' /></a>";
				$delete = "<a href='entry.php?op=del&entryID=" . $entryID . "'><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/images/icon/delete.png' alt='" . _AM_IMGLOSSARY_DELETEENTRY . "' /></a>";

				if ( $offline == 0 ) {
					$status = "<img src='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/images/icon/on.png' alt='" . _AM_IMGLOSSARY_ENTRYISON . "' />";
				} else {
					$status = "<img src='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/images/icon/off.png' alt='" . _AM_IMGLOSSARY_ENTRYISOFF . "' />";
				}

				echo "<tr>";
				echo "<td class='odd' align='center'>" . $entryID . "</td>";
				echo "<td class='even' align='left'>&nbsp;" . $term . "</td>";
				if ( $xoopsModuleConfig['multicats'] == 1 ) {
					if ( $catname == '' ) {
						$catname = '&nbsp;';
					}
					echo "<td class='even' align='left'>&nbsp;" . $catname . "</td>";
				}
				echo "<td class='even' align='center'>" . $sentby . "</td>";
				echo "<td class='even' align='center'>" . $created . "</td>";
				echo "<td class='even' align='center'>" . $status . "</td>";
				echo "<td class='even' align='center'> $modify $delete </td>";
				echo "</tr>";
				} 
			} else {
				// that is, $numrows = 0, there's no entries yet
				echo "<tr>";
				echo "<td class='odd' align='center' colspan= '7'>" . _AM_IMGLOSSARY_NOTERMS . "</td>";
				echo "</tr>";
			} 
		echo "</table>";
		$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startentry, 'startentry', 'entryID=' . $entryID );
		echo "<div style='text-align: right;'>" . $pagenav -> renderNav() . "</div>";
		echo "</fieldset>";
		echo "<br />";

		if ($xoopsModuleConfig['multicats'] == 1) {
			/* -- Code to show existing categories -- */
			echo "<fieldset style='border: #E8E8E8 1px solid;'><legend style='display: inline; font-weight: bold; color: #292D30;'>" . _AM_IMGLOSSARY_SHOWCATS . "</legend><br />";
			echo "<a style='float: left; border: 1px solid #5E5D63; color: #000000; background-color: #EFEFEF; padding: 4px 8px; text-align:center;' href='category.php'>" . _AM_IMGLOSSARY_CREATECAT . "</a><br /><br />";
			// To create existing columns table
			$resultC1 = $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " " );
			list( $numrows ) = $xoopsDB -> fetchRow( $resultC1 );

			$sql = "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " ORDER BY weight";
			$resultC2 = $xoopsDB -> query( $sql, $xoopsModuleConfig['perpage'], $startcat );

			echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
			echo "<tr>";
			echo "<td width='40' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ID . "</b></td>";
			echo "<td width='20%' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_CATNAME . "</b></td>";
			echo "<td class='bg3' align='center'><b>" . _AM_IMGLOSSARY_DESCRIP . "</b></td>";
		//	echo "<td width='80' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_WEIGHT . "</b></td>";
			echo "<td width='60' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ACTION . "</b></td>";
			echo "</tr>";

			if ( $numrows > 0 ) {
				// That is, if there ARE columns in the system
				while ( list( $categoryID, $name, $description, $total ) = $xoopsDB -> fetchrow( $resultC2 ) ) {
					$name = "<a href='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/category.php?categoryID=" . $categoryID . "'>" . $myts -> htmlSpecialChars( $name ) . "</a>";
					$description = $myts -> htmlSpecialChars( $description );
					$modify = "<a href='category.php?op=mod&categoryID=" . $categoryID . "'><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/images/icon/edit.png' alt='" . _AM_IMGLOSSARY_EDITCAT . "'></a>";
					$delete = "<a href='category.php?op=del&categoryID=" . $categoryID . "'><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/images/icon/delete.png' alt='" . _AM_IMGLOSSARY_DELETECAT . "'></a>";

					echo "<tr>";
					echo "<td class='odd' align='center'>" . $categoryID . "</td>";
					echo "<td class='even' align='left'>&nbsp;" . $name . "</td>";
					echo "<td class='even' align='left'>&nbsp;" . $description . "</td>";
				//	echo "<td class='even' align='center'>" . $weight . "</td>";
					echo "<td class='even' align='center'> $modify $delete </td>";
					echo "</tr>";
				} 
			} else {
				// that is, $numrows = 0, there's no columns yet
				echo "<tr>";
				echo "<td class='odd' align='center' colspan= '7'>" . _AM_IMGLOSSARY_NOCATS . "</td>";
				echo "</tr>";
				$categoryID = '0';
			} 
			echo "</table>\n";
			$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startcat, 'startcat', 'categoryID=' . $categoryID );
			echo '<div style="text-align:right;">' . $pagenav -> renderNav() . '</div>';
			echo "</fieldset>";
			echo "<br />\n";
		}

		/* -- Code to show submitted entries -- */
		echo "<fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; color: #292D30;'>" . _AM_IMGLOSSARY_SHOWSUBMISSIONS . "</legend><br /><br />";
		$resultS1 = $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=1 AND request=0" );
		list( $numrows ) = $xoopsDB -> fetchRow( $resultS1 );

		$sql = "SELECT entryID, categoryID, term, uid, datesub FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=1 AND request=0 ORDER BY datesub DESC";
		$resultS2 = $xoopsDB -> query( $sql, $xoopsModuleConfig['perpage'], $startsub );

		echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
		echo "<tr>";
		echo "<td width='40' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYID . "</b></td>";
		if ($xoopsModuleConfig['multicats'] == 1) {
			echo "<td width='20%' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCATNAME . "</b></td>";
		}
		echo "<td class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYTERM . "</b></td>";
		echo "<td width='150' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_SUBMITTER . "</b></td>";
		echo "<td width='90' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCREATED . "</b></td>";
		echo "<td width='60' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ACTION . "</b></td>";
		echo "</tr>";

		if ( $numrows > 0 ) { 
			// That is, if there ARE submitted entries in the system
			while ( list( $entryID, $categoryID, $term, $uid, $created) = $xoopsDB -> fetchrow( $resultS2 ) ) {
				$resultS3 = $xoopsDB -> query( "SELECT name FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " WHERE categoryID='$categoryID'" );
				list( $name ) = $xoopsDB -> fetchrow( $resultS3 );

				$sentby = xoops_getLinkedUnameFromId( $uid );

				$catname = $myts -> htmlSpecialChars( $name );
				$term = $myts -> htmlSpecialChars( $term );
				$created = formatTimestamp( $created, 's' );
				$modify = "<a href='entry.php?op=mod&entryID=" . $entryID . "'><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/images/icon/edit.png' alt='" . _AM_IMGLOSSARY_EDITSUBM . "'></a>";
				$delete = "<a href='entry.php?op=del&entryID=" . $entryID . "'><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/images/icon/delete.png' alt='" . _AM_IMGLOSSARY_DELETESUBM . "'></a>";

				echo "<tr>";
				echo "<td class='odd' align='center'>" . $entryID . "</td>";
				if ( $xoopsModuleConfig['multicats'] == 1 ) {
					if ( $catname == '' ) {
						$catname = '&nbsp;';
					}
					echo "<td class='even' align='left'>&nbsp;" . $catname . "</td>";
				}
				echo "<td class='even' align='left'>&nbsp;" . $term . "</td>";
				echo "<td class='even' align='center'>" . $sentby . "</td>";
				echo "<td class='even' align='center'>" . $created . "</td>";
				echo "<td class='even' align='center'> $modify $delete </td>";
				echo "</tr>";
			} 
		} else {
			// that is, $numrows = 0, there's no columns yet
			echo "<tr>";
			echo "<td class='odd' align='center' colspan= '7'>" . _AM_IMGLOSSARY_NOSUBMISSYET . "</td>";
			echo "</tr>";
		} 
		echo "</table>\n";
		$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startsub, 'startsub', 'entryID=' . $entryID );
		echo '<div style="text-align:right;">' . $pagenav -> renderNav() . '</div>';
		echo "</fieldset>";
		echo "<br />\n";

		/* -- Code to show requested entries -- */
		echo "<fieldset style='border: #e8e8e8 1px solid;'><legend style='display: inline; font-weight: bold; color: #292D30;'>" . _AM_IMGLOSSARY_SHOWREQUESTS . "</legend><br /><br />";
		$resultS2 = $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=1 AND request=1" );
		list( $numrowsX ) = $xoopsDB -> fetchRow( $resultS2 );

		$sql4 = "SELECT entryID, categoryID, term, uid, datesub FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=1 AND request=1 ORDER BY datesub DESC";
		$resultS4 = $xoopsDB -> query( $sql4, $xoopsModuleConfig['perpage'], $startsub );

		echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
		echo "<tr>";
		echo "<td width='40' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYID . "</b></td>";
		// if ( $xoopsModuleConfig['multicats'] == 1 ) {
		//	echo "<td width='20%' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCATNAME . "</b></td>";
		// }
		echo "<td class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYTERM . "</b></td>";
		echo "<td width='150' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_SUBMITTER . "</b></td>";
		echo "<td width='90' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCREATED . "</b></td>";
		echo "<td width='60' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ACTION . "</b></td>";
		echo "</tr>";

		if ( $numrowsX > 0 ) {
			// That is, if there ARE unauthorized articles in the system
			while ( list( $entryID, $categoryID, $term, $uid, $created) = $xoopsDB -> fetchrow( $resultS4 ) )
				{
				$resultS3 = $xoopsDB -> query( "SELECT name FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " WHERE categoryID = '$categoryID'" );
				list( $name ) = $xoopsDB -> fetchrow( $resultS3 );

				$sentby = xoops_getLinkedUnameFromId($uid);

				$catname = $myts -> htmlSpecialChars( $name );
				$term = $myts -> htmlSpecialChars( $term );
				$created = formatTimestamp( $created, 's' );
				$modify = "<a href='entry.php?op=mod&entryID=" . $entryID . "'><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/images/icon/edit.png' alt='" . _AM_IMGLOSSARY_EDITSUBM . "'></a>";
				$delete = "<a href='entry.php?op=del&entryID=" . $entryID . "'><img src='" . ICMS_URL . "/modules/" . $xoopsModule -> dirname() . "/images/icon/delete.png' alt='" . _AM_IMGLOSSARY_DELETESUBM . "'></a>";

				echo "<tr>";
				echo "<td class='odd' align='center'>" . $entryID . "</td>";
				// if ( $xoopsModuleConfig['multicats'] == 1 ) {
				//	echo "<td class='even' align='left'>&nbsp;" . $catname . "</td>";
				// }
				echo "<td class='even' align='left'>&nbsp;" . $term . "</td>";
				echo "<td class='even' align='center'>" . $sentby . "</td>";
				echo "<td class='even' align='center'>" . $created . "</td>";
				echo "<td class='even' align='center'> $modify $delete </td>";
				echo "</tr>";
			} 
		} else {
			// that is, $numrows = 0, there's no columns yet
			echo "<tr>";
			echo "<td class='odd' align='center' colspan= '7'>" . _AM_IMGLOSSARY_NOREQSYET . "</td>";
			echo "</tr>";
		} 
		echo "</table>\n";
		$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startsub, 'startsub', 'entryID=' . $entryID );
		echo "<div style='text-align:right;'>" . $pagenav -> renderNav() . "</div>";
		echo "</fieldset>";
		echo "<br />\n";
		
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
    if ( $xoopsModuleConfig['multicats'] == 1 ) {
        echo "<td width='20%' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCATNAME . "</b></td>";
    }
    echo "<td class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYTERM . "</b></td>";
    echo "<td width='150' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_SUBMITTER . "</b></td>";
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
            echo "<td class='odd' align='center'>" . $entryID . "</td>";
            if ( $xoopsModuleConfig['multicats'] == 1 ) {
				if ( $catname == '' ) {
					$catname = '&nbsp;';
				}
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
        <td class='odd' align='center' colspan= '7'>" . _AM_IMGLOSSARY_NOREQSYET . "</td>
        </tr></div>";
    }
    echo "</table>\n";
    $pagenav = new XoopsPageNav( $numrowsX, $xoopsModuleConfig['perpage'], $startsub, 'startsub', 'entryID=' . $entryID );
    echo '<div style="text-align:right;">' . $pagenav -> renderNav(8) . '</div>';
    echo "</fieldset>\n";
    echo "</div>";
		
		break;
	} 
xoops_cp_footer();
?>