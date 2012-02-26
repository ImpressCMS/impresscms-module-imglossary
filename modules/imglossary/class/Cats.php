<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: class/Cats.php
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
* @since		1.03
* @author		modified by McDonald
* @version		$Id$
*/

defined( 'ICMS_ROOT_PATH' ) or die ( 'ICMS root path not defined' );

class mod_imglossary_Cats extends icms_ipf_seo_Object {

	public function __construct( &$handler ) {
		icms_ipf_object::__construct( $handler );

		$this -> quickInitVar( 'categoryid', XOBJ_DTYPE_INT, true );
		$this -> quickInitVar( 'name', XOBJ_DTYPE_TXTBOX, false );
		$this -> quickInitVar( 'description', XOBJ_DTYPE_TXTAREA, false );
		$this -> quickInitVar( 'total', XOBJ_DTYPE_INT, false, '', '', 0 );
		$this -> quickInitVar( 'weight', XOBJ_DTYPE_INT, true, false, false, 0 );
	}

	public function getWeightControl() {
		$control = new icms_form_elements_Text( '','weight[]', 5, 7, $this -> getVar( 'weight', 'e' ) );
		$control -> setExtra( 'style="text-align:center;"' );
		return $control -> render();
	}

	public function getDescriptionTeaser() {
		$ret = $this -> getVar( 'description', 's' );
		$ret = icms_core_DataFilter::icms_substr( icms_cleanTags( $ret, array() ), 0, 128 );
		return $ret;
	}

	function ViewCategoryLink() {
		$ret = '<a href="' . ICMS_URL . '/modules/' . basename( dirname( dirname( __FILE__ ) ) ) . '/category.php?categoryid=' . $this -> getVar( 'categoryid', 'e' ) . '">' . $this -> getVar( 'name' ) . '</a>';
		return $ret;
	}

}