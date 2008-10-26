<?php
// comment callback functions

function imglossary_com_update( $entry_ID, $total_num ) {
	$db =& Database::getInstance();
	$sql = "UPDATE " . $db -> prefix( 'imglossary_entries' ) . " SET comments=" . $total_num . "	WHERE entryID=" . $entry_ID;
	$db -> query( $sql );
}

function imglossary_com_approve( &$comment ) {
	// notification mail here
}
?>