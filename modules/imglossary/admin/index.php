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

$op = '';

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];

/* -- Available operations -- */
switch ( $op ) {
	case 'default':
	default:

		$startentry = isset( $_GET['startentry'] ) ? intval( $_GET['startentry'] ) : 0;
		$startcat = isset( $_GET['startcat'] ) ? intval( $_GET['startcat'] ) : 0;
		$startsub = isset( $_GET['startsub'] ) ? intval( $_GET['startsub'] ) : 0;
		$datesub = isset( $_GET['datesub'] ) ? intval( $_GET['datesub'] ) : 0;
		$entryID = '';

		icms_cp_header();
		global $icmsConfig, $entryID;

		imglossary_adminMenu( 0, _AM_IMGLOSSARY_INDEX );
		
        $result01 = icms::$xoopsDB -> query( "SELECT COUNT(*) FROM " . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . " " );
			list( $totalcategories ) = icms::$xoopsDB -> fetchRow( $result01 );
        $result02 = icms::$xoopsDB -> query( "SELECT COUNT(*) FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0" );
			list( $totalpublished ) = icms::$xoopsDB -> fetchRow( $result02 );
        $result03 = icms::$xoopsDB -> query( "SELECT COUNT(*) FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=1 AND request=0" );
			list( $totalsubmitted ) = icms::$xoopsDB -> fetchRow( $result03 );
        $result04 = icms::$xoopsDB -> query( "SELECT COUNT(*) FROM " . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=1 AND request=1" );
			list( $totalrequested ) = icms::$xoopsDB -> fetchRow( $result04 );
		
		echo '<div>&nbsp;</div>';
		echo '<fieldset style="border: #E8E8E8 1px solid;"><legend style="display: inline; font-weight: bold; color: #292D30;">' . _AM_IMGLOSSARY_INVENTORY . '</legend>';
        echo '<div style="padding: 12px;">' . _AM_IMGLOSSARY_TOTALENTRIES . ' <b>' . $totalpublished . '</b> | ';
		
		if (icms::$module -> config['multicats'] == 1) {
			echo _AM_IMGLOSSARY_TOTALCATS . ' <b>' . $totalcategories . '</b> | ';
		}
		
        echo _AM_IMGLOSSARY_TOTALSUBM . ' <b>' . $totalsubmitted . '</b> | ';
		echo _AM_IMGLOSSARY_TOTALREQ . ' <b>' . $totalrequested . '</b></div>';
		echo '</fieldset>';

		/* -- Code to show existing terms -- */
		echo '<fieldset style="border: #E8E8E8 1px solid; padding: 16px;"><legend style="display: inline; font-weight: bold; color: #292D30;">' . _AM_IMGLOSSARY_SHOWENTRIES . '</legend><br /><br />';
		echo '<a style="float: ' . _GLOBAL_LEFT . '; border: 1px solid #5E5D63; color: #000000; background-color: #EFEFEF; padding: 4px 8px; text-align:center;" href="entry.php">' . _AM_IMGLOSSARY_CREATEENTRY . '</a><br /><br />';
		// To create existing terms table
		$resultA1 = icms::$xoopsDB -> query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0' );
		list( $numrows ) = icms::$xoopsDB -> fetchRow( $resultA1 );

		$sql = 'SELECT entryID, categoryID, term, uid, datesub, offline FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=0 AND block=1 ORDER BY entryID DESC';
		$resultA2 = icms::$xoopsDB -> query( $sql, icms::$module -> config['perpage'], $startentry );

		echo '<table width="100%" cellspacing="1" cellpadding="3" border="0" class="outer">';
		echo '<tr>';
		echo '<td width="40" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYID . '</b></td>';
		echo '<td class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYTERM . '</b></td>';
		if ( icms::$module -> config['multicats'] == 1 ) {
			echo '<td width="20%" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYCATNAME . '</b></td>';
		}		
		echo '<td width="150" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_SUBMITTER . '</b></td>';
		echo '<td width="90" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYCREATED . '</b></td>';
		echo '<td width="55" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_STATUS . '</b></td>';
		echo '<td width="55" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ACTION . '</b></td>';
		echo '</tr>';

		if ( $numrows > 0 ) {
			// That is, if there ARE entries in the system
			while ( list( $entryID, $categoryID, $term, $uid, $created, $offline ) = icms::$xoopsDB -> fetchrow( $resultA2 ) ) {
				$resultA3 = icms::$xoopsDB -> query( 'SELECT name FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' WHERE categoryID=' . $categoryID );
				list( $name ) = icms::$xoopsDB -> fetchrow( $resultA3 );

				$sentby = icms_member_user_Handler::getUserLink( $uid );

				$catname = '<a href="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/category.php?categoryID=' . $categoryID . '">' . icms_core_DataFilter::htmlSpecialchars( $name ) . '</a>';
				$term = '<a href="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/entry.php?entryID=' . $entryID . '">' . icms_core_DataFilter::htmlSpecialchars( $term ) . '</a>';
				$created = formatTimestamp( $created, 's' );
				$modify = '<a href="entry.php?op=mod&entryID=' . $entryID . '"><img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/images/icon/edit.png" alt="' . _AM_IMGLOSSARY_EDITENTRY . '" title="' . _AM_IMGLOSSARY_EDITENTRY . '" /></a>';
				$delete = '<a href="entry.php?op=del&entryID=' . $entryID . '"><img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/images/icon/delete.png" alt="' . _AM_IMGLOSSARY_DELETEENTRY . '" title="' . _AM_IMGLOSSARY_DELETEENTRY . '" /></a>';

				if ( $offline == 0 ) {
					$status = '<img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/images/icon/on.png" alt="' . _AM_IMGLOSSARY_ENTRYISON . '" title="' . _AM_IMGLOSSARY_ENTRYISON . '" />';
				} else {
					$status = '<img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/images/icon/off.png" alt="' . _AM_IMGLOSSARY_ENTRYISOFF . '" title="' . _AM_IMGLOSSARY_ENTRYISOFF . '" />';
				}

				echo '<tr>';
				echo '<td class="odd" align="center">' . $entryID . '</td>';
				echo '<td class="even" align="' . _GLOBAL_LEFT . '">&nbsp;' . $term . '</td>';
				if ( icms::$module -> config['multicats'] == 1 ) {
					if ( $catname == '' ) {
						$catname = '&nbsp;';
					}
					echo '<td class="even" align="' . _GLOBAL_LEFT . '">&nbsp;' . $catname . '</td>';
				}
				echo '<td class="even" align="center">' . $sentby . '</td>';
				echo '<td class="even" align="center">' . $created . '</td>';
				echo '<td class="even" align="center">' . $status . '</td>';
				echo '<td class="even" align="center">' . $modify . '&nbsp;' . $delete . '</td>';
				echo '</tr>';
				} 
			} else {
				// that is, $numrows = 0, there's no entries yet
				echo '<tr>';
				echo '<td class="odd" align="center" colspan="7">' . _AM_IMGLOSSARY_NOTERMS . '</td>';
				echo '</tr>';
			} 
		echo '</table>';
		$pagenav = new icms_view_PageNav( $numrows, icms::$module -> config['perpage'], $startentry, 'startentry', 'entryID=' . $entryID );
		echo '<div style="text-align: ' . _GLOBAL_RIGHT . ';">' . $pagenav -> renderNav() . '</div>';
		echo '</fieldset>';
		echo '<br />';

		if (icms::$module -> config['multicats'] == 1) {
			/* -- Code to show existing categories -- */
			echo '<fieldset style="border: #E8E8E8 1px solid; padding: 16px;"><legend style="display: inline; font-weight: bold; color: #292D30;">' . _AM_IMGLOSSARY_SHOWCATS . '</legend><br /><br />';
			echo '<a style="float: ' . _GLOBAL_LEFT . '; border: 1px solid #5E5D63; color: #000000; background-color: #EFEFEF; padding: 4px 8px; text-align:center;" href="category.php">' . _AM_IMGLOSSARY_CREATECAT . '</a><br /><br />';
			// To create existing columns table
			$resultC1 = icms::$xoopsDB -> query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) );
			list( $numrows ) = icms::$xoopsDB -> fetchRow( $resultC1 );

			$sql = 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' ORDER BY weight';
			$resultC2 = icms::$xoopsDB -> query( $sql, icms::$module -> config['perpage'], $startcat );

			echo '<table width="100%" cellspacing=1 cellpadding=3 border=0 class=outer>';
			echo '<tr>';
			echo '<td width="40" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ID . '</b></td>';
			echo '<td width="20%" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_CATNAME . '</b></td>';
			echo '<td class="bg3" align="center"><b>' . _AM_IMGLOSSARY_DESCRIP . '</b></td>';
		//	echo '<td width="80" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_WEIGHT . '</b></td>';
			echo '<td width="60" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ACTION . '</b></td>';
			echo '</tr>';

			if ( $numrows > 0 ) {
				// That is, if there ARE columns in the system
				while ( list( $categoryID, $name, $description, $total ) = icms::$xoopsDB -> fetchrow( $resultC2 ) ) {
					$name = '<a href="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/category.php?categoryID=' . $categoryID . '">' . icms_core_DataFilter::htmlSpecialchars( $name ) . '</a>';
					$description = icms_core_DataFilter::htmlSpecialchars( $description );
					$modify = '<a href="category.php?op=mod&categoryID=' . $categoryID . '"><img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/images/icon/edit.png" alt="' . _AM_IMGLOSSARY_EDITCAT . '" title="' . _AM_IMGLOSSARY_EDITCAT . '" /></a>';
					$delete = '<a href="category.php?op=del&categoryID=' . $categoryID . '"><img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/images/icon/delete.png" alt="' . _AM_IMGLOSSARY_DELETECAT . '" title="' . _AM_IMGLOSSARY_DELETECAT . '" /></a>';

					echo '<tr>';
					echo '<td class="odd" align="center">' . $categoryID . '</td>';
					echo '<td class="even" align="' . _GLOBAL_LEFT . '">&nbsp;' . $name . '</td>';
					echo '<td class="even" align="' . _GLOBAL_LEFT . '">&nbsp;' . $description . '</td>';
				//	echo '<td class="even" align="center">' . $weight . '</td>';
					echo '<td class="even" align="center">' . $modify . '&nbsp;' .$delete . '</td>';
					echo '</tr>';
				} 
			} else {
				// that is, $numrows = 0, there's no columns yet
				echo '<tr>';
				echo '<td class="odd" align="center" colspan="7">' . _AM_IMGLOSSARY_NOCATS . '</td>';
				echo '</tr>';
				$categoryID = '0';
			} 
			echo '</table>';
			$pagenav = new icms_view_PageNav( $numrows, icms::$module -> config['perpage'], $startcat, 'startcat', 'categoryID=' . $categoryID );
			echo '<div style="text-align:' . _GLOBAL_RIGHT . ';">' . $pagenav -> renderNav() . '</div>';
			echo '</fieldset>';
			echo '<br />';
		}

		/* -- Code to show submitted entries -- */
		echo '<fieldset style="border: #E8E8E8 1px solid;"><legend style="display: inline; font-weight: bold; color: #292D30;">' . _AM_IMGLOSSARY_SHOWSUBMISSIONS . '</legend><br /><br />';
		$resultS1 = icms::$xoopsDB -> query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=1 AND request=0' );
		list( $numrows ) = icms::$xoopsDB -> fetchRow( $resultS1 );

		$sql = 'SELECT entryID, categoryID, term, uid, datesub FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=1 AND request=0 ORDER BY datesub DESC';
		$resultS2 = icms::$xoopsDB -> query( $sql, icms::$module -> config['perpage'], $startsub );

		echo '<table width="100%" cellspacing=1 cellpadding=3 border=0 class=outer>';
		echo '<tr>';
		echo '<td width="40" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYID . '</b></td>';
		echo '<td class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYTERM . '</b></td>';
		if ( icms::$module -> config['multicats'] == 1 ) {
			echo '<td width="20%" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYCATNAME . '</b></td>';
		}
		echo '<td width="150" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_SUBMITTER . '</b></td>';
		echo '<td width="90" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYCREATED . '</b></td>';
		echo '<td width="60" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ACTION . '</b></td>';
		echo '</tr>';

		if ( $numrows > 0 ) { 
			// That is, if there ARE submitted entries in the system
			while ( list( $entryID, $categoryID, $term, $uid, $created) = icms::$xoopsDB -> fetchrow( $resultS2 ) ) {
				$resultS3 = icms::$xoopsDB -> query( 'SELECT name FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' WHERE categoryID=' . $categoryID );
				list( $name ) = icms::$xoopsDB -> fetchrow( $resultS3 );

				$sentby = icms_member_user_Handler::getUserLink( $uid );
				$catname = icms_core_DataFilter::htmlSpecialchars( $name );
				$term = icms_core_DataFilter::htmlSpecialchars( $term );
				$created = formatTimestamp( $created, 's' );
				$modify = '<a href="entry.php?op=mod&entryID=' . $entryID . '"><img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/images/icon/edit.png" alt="' . _AM_IMGLOSSARY_EDITSUBM . '" title="' . _AM_IMGLOSSARY_EDITSUBM . '" /></a>';
				$delete = '<a href="entry.php?op=del&entryID=' . $entryID . '"><img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/images/icon/delete.png" alt="' . _AM_IMGLOSSARY_DELETESUBM . '" title="' . _AM_IMGLOSSARY_DELETESUBM . '" /></a>';

				echo '<tr>';
				echo '<td class="odd" align="center">' . $entryID . '</td>';
				echo '<td class="even" align="' . _GLOBAL_LEFT . '">&nbsp;' . $term . '</td>';
				if ( icms::$module -> config['multicats'] == 1 ) {
					if ( $catname == '' ) {
						$catname = '&nbsp;';
					}
					echo '<td class="even" align="' . _GLOBAL_LEFT . '">&nbsp;' . $catname . '</td>';
				}
				echo '<td class="even" align="center">' . $sentby . '</td>';
				echo '<td class="even" align="center">' . $created . '</td>';
				echo '<td class="even" align="center">' . $modify . '&nbsp;' . $delete  . '</td>';
				echo '</tr>';
			} 
		} else {
			// that is, $numrows = 0, there's no columns yet
			echo '<tr>';
			echo '<td class="odd" align="center" colspan="7">' . _AM_IMGLOSSARY_NOSUBMISSYET . '</td>';
			echo '</tr>';
		} 
		echo '</table>';
		$pagenav = new icms_view_PageNav( $numrows, icms::$module -> config['perpage'], $startsub, 'startsub', 'entryID=' . $entryID );
		echo '<div style="text-align:' . _GLOBAL_RIGHT . ';">' . $pagenav -> renderNav() . '</div>';
		echo '</fieldset>';
		echo '<br />';

		/* -- Code to show requested entries -- */
		echo '<fieldset style="border: #E8E8E8 1px solid;"><legend style="display: inline; font-weight: bold; color: #292D30;">' . _AM_IMGLOSSARY_SHOWREQUESTS . '</legend><br /><br />';
		$resultS2 = icms::$xoopsDB -> query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=1 AND request=1' );
		list( $numrowsX ) = icms::$xoopsDB -> fetchRow( $resultS2 );

		$sql4 = 'SELECT entryID, categoryID, term, uid, datesub FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=1 AND request=1 ORDER BY datesub DESC';
		$resultS4 = icms::$xoopsDB -> query( $sql4, icms::$module -> config['perpage'], $startsub );

		echo '<table width="100%" cellspacing=1 cellpadding=3 border=0 class=outer>';
		echo '<tr>';
		echo '<td width="40" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYID . '</b></td>';
		// if ( icms::$module -> config['multicats'] == 1 ) {
		//	echo "<td width='20%' class='bg3' align='center'><b>" . _AM_IMGLOSSARY_ENTRYCATNAME . "</b></td>";
		// }
		echo '<td class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYTERM . '</b></td>';
		echo '<td width="150" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_SUBMITTER . '</b></td>';
		echo '<td width="90" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYCREATED . '</b></td>';
		echo '<td width="60" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ACTION . '</b></td>';
		echo '</tr>';

		if ( $numrowsX > 0 ) {
			// That is, if there ARE unauthorized articles in the system
			while ( list( $entryID, $categoryID, $term, $uid, $created) = icms::$xoopsDB -> fetchrow( $resultS4 ) ) {
				$resultS3 = icms::$xoopsDB -> query( 'SELECT name FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' WHERE categoryID=' . $categoryID );
				list( $name ) = icms::$xoopsDB -> fetchrow( $resultS3 );

				$sentby = icms_member_user_Handler::getUserLink($uid);
				$catname = icms_core_DataFilter::htmlSpecialchars( $name );
				$term = icms_core_DataFilter::htmlSpecialchars( $term );
				$created = formatTimestamp( $created, 's' );
				$modify = '<a href="entry.php?op=mod&entryID=' . $entryID . '"><img src="' . ICMS_URL . '/modules/"' . icms::$module -> getVar('dirname') . '/images/icon/edit.png" alt="' . _AM_IMGLOSSARY_EDITSUBM . '" title="' . _AM_IMGLOSSARY_EDITSUBM . '" /></a>';
				$delete = '<a href="entry.php?op=del&entryID=' . $entryID . '"><img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar('dirname') . '/images/icon/delete.png" alt="' . _AM_IMGLOSSARY_DELETESUBM . '" title="' . _AM_IMGLOSSARY_DELETESUBM . '" /></a>';

				echo '<tr>';
				echo '<td class="odd" align="center">' . $entryID . '</td>';
				// if ( icms::$module -> config['multicats'] == 1 ) {
				//	echo "<td class='even' align='"._GLOBAL_LEFT."'>&nbsp;" . $catname . "</td>";
				// }
				echo '<td class="even" align="' . _GLOBAL_LEFT . '">&nbsp;' . $term . '</td>';
				echo '<td class="even" align="center">' . $sentby . '</td>';
				echo '<td class="even" align="center">' . $created . '</td>';
				echo '<td class="even" align="center">' . $modify . '&nbsp;' . $delete . '</td>';
				echo "</tr>";
			} 
		} else {
			// that is, $numrows = 0, there's no columns yet
			echo '<tr>';
			echo '<td class="odd" align="center" colspan="7">' . _AM_IMGLOSSARY_NOREQSYET . '</td>';
			echo '</tr>';
		} 
		echo '</table>';
		$pagenav = new icms_view_PageNav( $numrows, icms::$module -> config['perpage'], $startsub, 'startsub', 'entryID=' . $entryID );
		echo '<div style="text-align: ' . _GLOBAL_RIGHT . ';">' . $pagenav -> renderNav() . '</div>';
		echo '</fieldset>';
		echo '<br />';
		
	/**
       * Code to show offline entries
     **/
    echo '<fieldset style="border: #E8E8E8 1px solid;"><legend style="display: inline; font-weight: bold; color: #292D30;">' . _AM_IMGLOSSARY_SHOWOFFLINE . '</legend>';
	echo "<div>&nbsp;</div>";
    echo '<div style="float: ' . _GLOBAL_LEFT . '; width: 100%;"><table class="outer" cellspacing=1 cellpadding=3 width="100%" border="0">';

    $resultS2 = icms::$xoopsDB -> query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE offline=1' );
    list( $numrowsX ) = icms::$xoopsDB -> fetchRow( $resultS2 );

    $sql4 = 'SELECT entryID, categoryID, term, uid, datesub FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE offline=1 ORDER BY datesub DESC';
    $resultS4 = icms::$xoopsDB -> query( $sql4, icms::$module -> config['perpage'], $startsub );

    echo '<td width="40" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYID . '</b></td>';
    echo '<td class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYTERM . '</b></td>';
    if ( icms::$module -> config['multicats'] == 1 ) {
        echo '<td width="20%" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYCATNAME . '</b></td>';
    }
    echo '<td width="150" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_SUBMITTER . '</b></td>';
    echo '<td width="90" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ENTRYCREATED . '</b></td>';
    echo '<td width="60" class="bg3" align="center"><b>' . _AM_IMGLOSSARY_ACTION . '</b></td>';
    echo '</tr>';

    if ( $numrowsX > 0 ) {  // That is, if there ARE unauthorized articles in the system
        while ( list( $entryID, $categoryID, $term, $uid, $created ) = icms::$xoopsDB -> fetchrow( $resultS4 ) ) {
            $resultS3 = icms::$xoopsDB -> query( 'SELECT name FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' WHERE categoryID=' . $categoryID );
            list( $name ) = icms::$xoopsDB -> fetchrow( $resultS3 );

            $sentby = icms_member_user_Handler::getUserLink( $uid );
            $catname = icms_core_DataFilter::htmlSpecialchars( $name );
            $term = icms_core_DataFilter::htmlSpecialchars( $term );
            $created = formatTimestamp( $created, 's' );
            $modify = '<a href="entry.php?op=mod&entryID=' . $entryID . '"><img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/icon/edit.png" alt="' . _AM_IMGLOSSARY_EDITSUBM . '" title="' . _AM_IMGLOSSARY_EDITSUBM . '" /></a>';
            $delete = '<a href="entry.php?op=del&entryID=' . $entryID . '"><img src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/icon/delete.png" alt="' . _AM_IMGLOSSARY_DELETESUBM . '" title="' . _AM_IMGLOSSARY_DELETESUBM . '" /></a>';

            echo '<tr>';
            echo '<td class="odd" align="center">' . $entryID . '</td>';
            echo '<td class="even" align="' . _GLOBAL_LEFT . '">' . $term . '</td>';
            if ( icms::$module -> config['multicats'] == 1 ) {
				if ( $catname == '' ) {
					$catname = '&nbsp;';
				}
                echo '<td class="even" align="' . _GLOBAL_LEFT . '">' . $catname . '</td>';
            }
            echo '<td class="even" align="center">' . $sentby . '</td>';
            echo '<td class="even" align="center">' . $created . '</td>';
            echo '<td class="even" align="center">' . $modify . '&nbsp;' . $delete . '</td>';
            echo '</tr></div>';
        }
    }
    else {  // that is, $numrows = 0, there's no columns yet
        echo '<tr>
        <td class="odd" align="center" colspan="7">' . _AM_IMGLOSSARY_NOREQSYET . '</td>
        </tr></div>';
    }
    echo '</table>';
    $pagenav = new icms_view_PageNav( $numrowsX, icms::$module -> config['perpage'], $startsub, 'startsub', 'entryID=' . $entryID );
    echo '<div style="text-align: ' . _GLOBAL_RIGHT . ';">' . $pagenav -> renderNav(8) . '</div>';
    echo '</fieldset>';
    echo '</div>';
		
		break;
	} 
icms_cp_footer();
?>