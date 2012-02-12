<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: class/Entries.php
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

defined( 'ICMS_ROOT_PATH' ) or die ( 'ICMS root path not defined' );

class mod_imglossary_Entries extends icms_ipf_seo_Object {

	public function __construct( &$handler ) {
		icms_ipf_object::__construct( $handler );

		$this -> quickInitVar( 'entryID', XOBJ_DTYPE_INT, true );
		$this -> quickInitVar( 'categoryID', XOBJ_DTYPE_INT, false, '', '', 0 );
		$this -> quickInitVar( 'term', XOBJ_DTYPE_TXTBOX, true );
		$this -> quickInitVar( 'init', XOBJ_DTYPE_TXTBOX, false );
		$this -> quickInitVar( 'definition', XOBJ_DTYPE_TXTAREA, false );
		$this -> quickInitVar( 'ref', XOBJ_DTYPE_TXTBOX, false );
		$this -> quickInitVar( 'url', XOBJ_DTYPE_TXTBOX, false );
		$this -> quickInitVar( 'uid', XOBJ_DTYPE_INT, false, '', '', 1 );
		$this -> quickInitVar( 'submit', XOBJ_DTYPE_INT, false, '', '', 0 );
		$this -> quickInitVar( 'datesub', XOBJ_DTYPE_LTIME, false, '', '', 1033141070 );
		$this -> quickInitVar( 'counter', XOBJ_DTYPE_INT, false, '', '', 0 );
		$this -> quickInitVar( 'html', XOBJ_DTYPE_INT, false, '', '', 0 );
		$this -> quickInitVar( 'smiley', XOBJ_DTYPE_INT, false, '', '', 0 );
		$this -> quickInitVar( 'xcodes', XOBJ_DTYPE_INT, false, '', '', 0 );
		$this -> quickInitVar( 'breaks', XOBJ_DTYPE_INT, false, '', '', 1 );
		$this -> quickInitVar( 'block', XOBJ_DTYPE_INT, false, '', '', 0 );
		$this -> quickInitVar( 'offline', XOBJ_DTYPE_INT, true, false, false, true );
		$this -> quickInitVar( 'notifypub', XOBJ_DTYPE_INT, false, '', '', 0 );
		$this -> quickInitVar( 'request', XOBJ_DTYPE_INT, false, '', '', 0 );
		$this -> quickInitVar( 'comments', XOBJ_DTYPE_INT, false, '', '', 0 );

		$this -> initCommonVar( 'entryID' );

		$this -> setControl( 'offline', 'yesno' );

	}

	public function getVar( $key, $format = 's' ) {
		if ( $format == 's' && in_array( $key, array( 'uid', 'offline' ) ) ) {
			return call_user_func( array( $this, $key ) );
		}
		return parent::getVar( $key, $format );
	}

	function uid() {
		return icms_member_user_Handler::getUserLink( $this -> getVar( 'uid', 'e' ) );
	}

	function offline() {
		$status = $button = '';
		$status = $this -> getVar( 'offline', 'e' );
		$button = '<a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/admin/entries.php?entryID=' . $this -> getVar( 'entryID' ) . '&amp;op=changeStatus">';
		if ( $status == false ) {
			$button .= '<img src="' . ICMS_URL . '/images/crystal/actions/1.png" alt="' . _AM_IMGLOSSARY_TERM_ISON  . '" title="' . _AM_IMGLOSSARY_TERM_ISON . '" /></a>';
		} else {
			$button .= '<img src="' . ICMS_URL . '/images/crystal/actions/0.png" alt="' . _AM_IMGLOSSARY_TERM_ISOFF . '" title="' . _AM_IMGLOSSARY_TERM_ISOFF . '" /></a>';
		}
		return $button;
	}

	function ViewEntryLink() {
		$ret = '<a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/entry.php?entryID=' . $this -> getVar( 'entryID', 'e' ) . '">' . $this -> getVar( 'term' ) . '</a>';
		return $ret;
	}

}