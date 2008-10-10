<?php
/*  Sitemap plugin for module imGlossary
 *	Author: McDonald
*/

function b_sitemap_imglossary() {
	
	$db =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();
	
	$result = $db -> query( "SELECT categoryID, name FROM " . $db -> prefix( 'imglossary_cats' ) . " ORDER BY name" );
	
	$ret = array() ;
	while( list( $id, $name ) = $db -> fetchRow( $result ) ) {
		$ret["parent"][] = array(
			"id" => $id,
			"title" => $myts -> makeTboxData4Show( $name ),
			"url" => "category.php?categoryID=$id"
		);
	}
	
	return $ret;
}
?>