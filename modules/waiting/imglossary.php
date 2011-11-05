<?php

function b_waiting_imglossary() {
//	$xoopsDB =& Database::getInstance();
	$ret = array();

	// Waiting
	$block = array();
	$result = icms::$xoopsDB -> query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=1 AND categoryID>0' );
	if ( $result ) {
		$block['adminlink'] = ICMS_URL . '/modules/imglossary/admin/index.php';
		list( $block['pendingnum'] ) = icms::$xoopsDB -> fetchRow( $result );
		$block['lang_linkname'] = _PI_WAITING_WAITINGS;
	}
	$ret[] = $block ;

	// Request
	$result = icms::$xoopsDB->query( 'SELECT COUNT(*) FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE submit=1 AND categoryID=0' );
	if ( $result ) {
		$block['adminlink'] = ICMS_URL . '/modules/imglossary/admin/index.php';
		list($block['pendingnum']) = icms::$xoopsDB -> fetchRow( $result );
		$block['lang_linkname'] = _PI_WAITING_REQUESTS;
	}
	$ret[] = $block ;

	return $ret ;
}
?>