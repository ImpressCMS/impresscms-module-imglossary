<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* File: makepdf.php
*
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* ----------------------------------------------------------------------------------------------------------
* @package		imGlossary - a multicategory glossary
* @since		1.00
* @author		McDonald
* @version		$Id$
*/

include_once 'header.php';

if ( !defined( 'ICMS_ROOT_PATH' ) ) { die( 'ICMS root path not defined' ); }

$glossdirname = basename( dirname( __FILE__ ) );

global $icmsConfig;

$entryID = isset( $_GET['entryID'] ) ? intval( $_GET['entryID'] ) : 0;
$entryID = intval( $entryID );

$result = icms::$xoopsDB -> query( 'SELECT * FROM ' . icms::$xoopsDB -> prefix( 'imglossary_entries' ) . ' WHERE entryID=' . $entryID );
$myrow = icms::$xoopsDB -> fetchArray( $result );

$result2 = icms::$xoopsDB -> query( 'SELECT name FROM ' . icms::$xoopsDB -> prefix( 'imglossary_cats' ) . ' WHERE categoryID=' . $myrow['categoryID'] );
$mycat = icms::$xoopsDB -> fetchArray( $result2 );

$date = formatTimestamp( $myrow['datesub'], icms::$module -> config['dateformat'] );

$title = icms_core_DataFilter::htmlSpecialchars( $myrow['term'] );
$submitter = strip_tags( icms_member_user_Handler::getUserLink( $myrow['uid'] ) );
$category = $mycat['name'];
$whowhen = sprintf( '', $submitter, $date );

$content = '<h2>' . $title . '</h2><br /><br />' . icms_core_DataFilter::checkVar( $myrow['definition'], 'html', 'output' );

$slogan = $icmsConfig['sitename'] . ' - ' . $icmsConfig['slogan'];
$keywords = $title . ' ' . $category . ' ' . $submitter . ' ' . $slogan;
$description = '';

$htmltitle = '<font color=#3399CC><h1>' . $title . '</h1><h4>' . $category . '</font></h4><br>' . $description . '<br />' . $submitter;

require_once ICMS_PDF_LIB_PATH . '/tcpdf.php';

$filename = ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/language/' . $icmsConfig['language'] . '/main.php';
if ( file_exists( $filename ) ) {
	include_once $filename;
} else {
	include_once ICMS_ROOT_PATH . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/language/english/main.php';
}

$filename = ICMS_ROOT_PATH . '/language/' . $icmsConfig['language'] . '/pdf.php';
if ( file_exists( $filename ) ) {
	include_once $filename;
} else {
	include_once ICMS_PDF_LIB_PATH . '/config/lang/eng.php';
}

$pdf = new TCPDF( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true );

// set document information
$pdf -> SetCreator( PDF_CREATOR );
$pdf -> SetAuthor( $submitter );
$pdf -> SetTitle( $title );
$pdf -> SetSubject( $category );
$pdf -> SetKeywords( $keywords );

$firstLine = $slogan;
$secondLine = $whowhen;

$pdf -> SetHeaderData( PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $firstLine, $secondLine );

//set margins
$pdf -> SetMargins( PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT );

//set auto page breaks
$pdf -> SetAutoPageBreak( true, PDF_MARGIN_BOTTOM );
$pdf -> SetHeaderMargin( PDF_MARGIN_HEADER );
$pdf -> SetFooterMargin( PDF_MARGIN_FOOTER );
$pdf -> setImageScale( PDF_IMAGE_SCALE_RATIO ); //set image scale factor

$pdf -> setHeaderFont( array( PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN ) );
$pdf -> setFooterFont( array( PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA ) );

$pdf -> setLanguageArray( $l ); //set language items

// Set font
$pdf -> SetFont( 'helvetica', '', 10 );

//initialize document
$pdf -> AddPage();
$pdf -> writeHTML( $content, true, false, false, 0 );
$pdf -> Output();
?>