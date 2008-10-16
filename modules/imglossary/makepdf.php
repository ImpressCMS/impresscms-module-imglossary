<?php
/**
 * $Id: makepdf.php
 * Module: imGlossary - a multicategory glossary 
 * Author: McDonald
 * Licence: GNU
 */

include_once 'header.php';

if ( !defined( 'ICMS_ROOT_PATH' ) ) {
	die( "ICMS root path not defined" );
}

$glossdirname = basename( dirname( __FILE__ ) );

function strip_p_tag($text) {
    $search = array(
         "'<p>'si",
         "'</p>'si",
	);

	$replace = array(
         "",
         "<br /><br />",
	);

	$text = preg_replace($search, $replace, $text);
    return $text;
}

global $xoopsDB, $xoopsConfig, $xoopsModuleConfig, $xoopsUser;

$entryID = isset( $_GET['entryID'] ) ? intval( $_GET['entryID'] ) : 0;
$entryID = intval( $entryID );

$result = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix('imglossary_entries') . " WHERE entryID=" . $entryID );
$myrow = $xoopsDB -> fetchArray( $result );

$result2 = $xoopsDB -> query( "SELECT name FROM " . $xoopsDB -> prefix('imglossary_cats') . " WHERE categoryID=" . $myrow['categoryID'] );
$mycat = $xoopsDB -> fetchArray( $result2 );

$date = formatTimestamp( $myrow['datesub'], $xoopsModuleConfig['dateformat'] );

$myts =& MyTextSanitizer::getInstance();
$title = $myts -> makeTboxData4Show($myrow['term']);
$submitter = strip_tags( xoops_getLinkedUnameFromId( $myrow['uid'] ) );
$category = $mycat['name'];
$whowhen = sprintf( '', $submitter, $date );
$content = $title . '<br /><br />' . strip_p_tag($myrow['definition']);

$slogan = $xoopsConfig['sitename'] . ' - ' . $xoopsConfig['slogan'];
$keywords = $title . ' ' . $category . ' ' . $submitter . ' ' . $slogan;
$description = '';

$htmltitle = '<font color=#3399CC><h1>' . $title . '</h1><h4>' . $category . '</font></h4><br>' . $description . '<br />' . $submitter;

require_once ICMS_PDF_LIB_PATH.'/tcpdf.php';

$filename = ICMS_ROOT_PATH.'/modules/' . $glossdirname . '/' . $xoopsConfig['language'] . '/main.php';
if ( file_exists( $filename ) ) {
  include_once $filename;
} else {
  include_once ICMS_ROOT_PATH . '/modules/' . $glossdirname . '/language/english/main.php';
}

$filename = ICMS_PDF_LIB_PATH . '/config/lang/' . _LANGCODE . '.php';
if( file_exists( $filename ) ) {
  include_once $filename;
} else {
  include_once ICMS_PDF_LIB_PATH . '/config/lang/en.php';
}

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true);

// set document information
$pdf -> SetCreator(PDF_CREATOR);
$pdf -> SetAuthor($submitter);
$pdf -> SetTitle($title);
$pdf -> SetSubject($category);
$pdf -> SetKeywords($keywords);

$firstLine = $slogan;
$secondLine =  $whowhen;

$pdf -> SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $firstLine, $secondLine);

//set margins
$pdf -> SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf -> SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf -> SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf -> SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor

$pdf -> setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf -> setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf -> setLanguageArray($l); //set language items

// set font
$pdf -> SetFont("dejavusans", "BI", 10);

//initialize document
$pdf -> AliasNbPages();
$pdf -> AddPage();
$pdf -> writeHTML($content, true, 0);
$pdf -> Output();

?>