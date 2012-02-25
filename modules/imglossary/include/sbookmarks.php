<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: include/sbookmarks.php
*
* @copyright	http://www.xoops.org/ The XOOPS Project
* @copyright	XOOPS_copyrights.txt
* @copyright	http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		imGlossary - a multicategory glossary
* @since		1.00
* @author		modified by McDonald
* @version		$Id$
*/

function imglossary_sbmarks( $entryid, $term ) { 
	$sbmark_arr = array();
	$sbmark_arr['term'] = $term;
	$sbmark_arr['link'] = ICMS_URL . '/modules/' . icms::$module -> getvar( 'dirname' ) . '/entry.php?entryid=' . intval( $entryid );

//Definitions for social bookmarks

//Backflip
$sbmarks['blackflip'] = '<a href="http://www.backflip.com/add_page_pop.ihtml?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/backflip.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'BackFlip" alt="" /></a>';

//Bibsonomy
$sbmark['bibsonomy'] = '<a href="http://www.bibsonomy.org/ShowBookmarkEntry?c=b&jump=yes&url=' . $sbmark_arr['link'] . '&description=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/bibsonomy.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Bibsonomy alt="" /></a>';

//BlinkList
$sbmarks['blinklist'] = '<a href="http://www.blinklist.com/index.php?Action=Blink/addblink.php&Quick=true&Url=' . $sbmark_arr['link'] . '&Title=' . $sbmark_arr['term'] . '&Pop=yes" target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/blinklist.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'BlinkList" alt="" /></a>';

//Blogmark
$sbmark['blogmark'] = '<a href="http://blogmarks.net/my/new.php?title=' . $sbmark_arr['term'] . '&url=' . $sbmark_arr['link'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/blogmarks.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'BlogMarks" alt="" /></a>';

//CiteUlike
$sbmark['citeulike'] = '<a href="http://www.citeulike.org/posturl?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/citeulike.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'CiteUlike" alt="" /></a>';

//Connotea
$sbmarks['connotea'] = '<a href="http://www.connotea.org/add?continue=return&uri=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/connotea.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Connotea" alt="" /></a>';

//del.icio.us
$sbmarks['delicio'] = '<a href="http://del.icio.us/post?v=4&noui&jump=close&url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/del.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'del.icio.us" alt="" /></a>';

//Digg
$sbmarks['digg'] = '<a href="http://digg.com/submit?phase=2&url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/digg.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Digg" alt="" /></a>';

//Diigo
$sbmarks['diigo'] = '<a href="http://www.diigo.com/post?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/diigo.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Diigo" alt="" /></a>';

//DZone
$sbmarks['dzone'] = '<a href="http://www.dzone.com/links/add.html?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/dzone.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'DZone" alt="" /></a>';

//Earthlink
$sbmarks['earthlink'] = '<a href="http://myfavorites.earthlink.net/my/add_favorite?v=1&url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/earthlink.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'EarthLink MyFavorites" alt="" /></a>';

//EatMyHamster
$sbmarks['eatmyhamster'] = '<a href="http://www.eatmyhamster.com/post?u=' . $sbmark_arr['link'] . '&h=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/eatmyhamster.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'EatMyHamster" alt="" /></a>';

//FaceBook
$sbmarks['facebook'] ='<a href="http://www.facebook.com/sharer.php?u=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"> <img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/facebook.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Facebook" alt="" /></a>';

//Fantacular
$sbmarks['fantacular'] = '<a href="http://fantacular.com/add.asp?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/fantacular.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Fantacular" alt="" /></a>';

//Fark
$sbmarks['fark'] = '<a href="http://cgi.fark.com/cgi/fark/edit.pl?new_url=' . $sbmark_arr['link'] . '&new_comment=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/fark.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Fark" alt="" /></a>';

//FeedMarker
$sbmarks['feedmarker'] = '<a href="http://www.feedmarker.com/admin.php?do=bookmarklet_mark&url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/feedmarker.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'FeedMarker" alt="" /></a>';

//FeedMeLinks
$sbmarks['feedmelinks'] = '<a href="http://feedmelinks.com/categorize?from=toolbar&op=submit&name=' . $sbmark_arr['term'] . '&url=' . $sbmark_arr['link'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/feedmelinks.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'FeedMeLinks" alt="" /></a>';

//Furl
$sbmarks['furl'] = '<a href="http://www.furl.net/storeIt.jsp?t=' . $sbmark_arr['term'] . '&u=' . $sbmark_arr['link'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/furl.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Furl" alt="" /></a>';

//Google
$sbmarks['google'] = '<a href="http://www.google.com/bookmarks/mark?op=edit&output=popup&bkmk=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/google.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Google" alt="" /></a>';

//Gravee
$sbmarks['gravee'] = '<a href="http://www.gravee.com/account/bookmarkpop?u=' . $sbmark_arr['link'] . '&t=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/gravee.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Gravee" alt="" /></a>';

//igooi
$sbmarks['igooi'] = '<a href="http://www.igooi.com/addnewitem.aspx?self=1&noui=yes&jump=close&url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/igooi.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'igooi" alt="" /></a>';

//iTalkNews
$sbmarks['italknews'] = '<a href="http://italknews.com/member/write_link.php?content=' . $sbmark_arr['link'] . '&headline=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/italknews.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'iTalkNews" alt="" /></a>';

//Jookster
$sbmarks['jookster'] = '<a href="http://www.jookster.com/JookThis.aspx?url=' . $sbmark_arr['link'] . '"' . 'target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/jookster.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Jookster" alt="" /></a>';

//Kinja
$sbmarks['kinja'] = '<a href="http://kinja.com/id.knj?url=' . $sbmark_arr['link'] . '"' . 'target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/kinja.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Kinja" alt="" /></a>';

//Linkagogo
$sbmarks['linkagogo'] = '<a href="http://www.linkagogo.com/go/AddNoPopup?title=' . $sbmark_arr['term'] . '&url=' . $sbmark_arr['link'] . '"' . 'target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/linkagogo.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Linkagogo" alt="" /></a>';

//LinkRoll
$sbmarks['linkroll'] = '<a href="http://linkroll.com/insert.php?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/linkroll.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'LinkRoll" alt="" /></a>';

//linuxquestions.org
$sbmarks['linuxquestions'] = '<a href="http://bookmarks.linuxquestions.org/linux/post?uri=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '&when_done=go_back"' . 'target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/linuxquestions.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'linuxquestions.org" alt="" /></a>';

//LookMarks
$sbmarks['lookmarks'] = '<a href="http://www.lookmarks.com/AddLinkFrame.aspx?Url=' . $sbmark_arr['link'] . '&Title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/lookmarks.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'LookMarks" alt="" /></a>';

//Lycos
$sbmarks['lycos'] = '<a href="http://iq.lycos.co.uk/lili/my/add?url=' . $sbmark_arr['link'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/lycos.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Lycos" alt="" /></a>';

//Windows Live
$sbmarks['live'] = '<a href="https://favorites.live.com/quickadd.aspx?marklet=1&mkt=en-us&title=' . $sbmark_arr['term'] . '&url=' . $sbmark_arr['link'] . '&top=1' . '"' . 'target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/windows_live.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Windows Live" alt="" /></a>';

//Magnolia
$sbmarks['magnolia'] = '<a href="http://ma.gnolia.com/bookmarklet/add?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/magnolia.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Ma.gnolia" alt="" /></a>';

//Markabboo
$sbmarks['markabboo'] = '<a href="http://www.markaboo.com/resources/new?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/markabboo.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Markabboo" alt="" /></a>';

//Netscape
$sbmarks['netscape'] = '<a href="http://www.netscape.com/submit/?U=' . $sbmark_arr['link'] . '&T=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/netscape.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Netscape" alt="" /></a>';

//Netvouz
$sbmarks['netvouz'] = '<a href="http://www.netvouz.com/action/submitBookmark?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '&popup=no"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/netvouz.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Netvouz" alt="" /></a>';

//Newsvine
$sbmarks['newsvine'] = '<a href="http://www.newsvine.com/_tools/seed&save?u=' . $sbmark_arr['link'] . '&h=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/newsvine.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Newsvine" alt="" /></a>';

//Ning
$sbmarks['ning'] = '<a href="http://bookmarks.ning.com/addItem.php?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/ning.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Ning" alt="" /></a>';

//NowPublic
$sbmarks['nowpublic'] = '<a href="http://view.nowpublic.com/?src=' . $sbmark_arr['link'] . '&t=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/nowpublic.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'NowPublic" alt="" /></a>';

//RawSugar
$sbmarks['rawsugar'] = '<a href="http://www.rawsugar.com/pages/tagger.faces?turl=' . $sbmark_arr['link'] . '&tttl=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/rawsugar.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'RawSugar" alt="" /></a>';

//Reddit
$sbmarks['reddit'] = '<a href="http://reddit.com/submit?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/reddit.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'reddit" alt="" /></a>';

//Riffs
$sbmarks['riffs'] = '<a href="http://www.riffs.com/item.cgi?section=init_url&url=' . $sbmark_arr['link'] . '&name=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/riffs.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Riffs" alt="" /></a>';

//Rojo
$sbmarks['rojo'] = '<a href="http://www.rojo.com/submit/?title=' . $sbmark_arr['term'] . '&url=' . $sbmark_arr['link'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/rojo.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Rojo" alt="" /></a>';

//Shadows
$sbmarks['shadow'] = '<a href="http://www.shadows.com/features/tcr.htm?title=' . $sbmark_arr['term'] . '&url=' . $sbmark_arr['link'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/shadows.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Shadows" alt="" /></a>';

//Squidoo
$sbmarks['squidoo'] = '<a href="http://www.squidoo.com/lensmaster/bookmark?' . $sbmark_arr['link'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/squidoo.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Squidoo" alt="" /></a>';

//StumbleUpon
$sbmarks['stumble'] = '<a href="http://www.stumbleupon.com/submit?url=' . $sbmark_arr['link'] . '&title=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/stumbleupon.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'StumbleUpon" alt="" /></a>';

//tagtooga
$sbmarks['tagtooga'] = '<a href="http://www.tagtooga.com/tapp/db.exe?c=jsEntryForm&b=fx&title=' . $sbmark_arr['term'] . '&url=' . $sbmark_arr['link'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/tagtooga.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'tagtooga" alt="" /></a>';

//Technorati
$sbmarks['techno'] = '<a="http://www.technorati.com/faves?add=' . $sbmark_arr['link'] . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/technorati.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Technorati" alt="" /></a>';

//Wink
$sbmarks['wink'] = '<a href="http://www.wink.com/_/tag?url=' . $sbmark_arr['link'] . '&doctitle=' . $sbmark_arr['term'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/wink.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Wink" alt="" /></a>';

// Yahoo
$sbmarks['yahoo'] = '<a href="http://myweb2.search.yahoo.com/myresults/bookmarklet?t=' . $sbmark_arr['term'] . '&u=' . $sbmark_arr['link'] . '"' . ' target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/yahoo.png" align="middle" title="'._MD_IMGLOSSARY_ADDTO.'Yahoo MyWeb" alt="" /></a>';

//Information
$sbmarks['info'] = '<a href="http://en.wikipedia.org/wiki/Social_bookmarking" target="_blank"><img border="0" src="' . ICMS_URL . '/modules/' . icms::$module -> getVar( 'dirname' ) . '/images/sbookmarks/what.png" align="middle" title="Information" alt="" /></a>';

// Make list of selected social bookmarks
// Comment out thosr social bookmarks which should not be visible

$sbmarks['sbmarks'] =	//$sbmarks['blackflip'] . " " .
						//$sbmark['bibsonomy'] . " " .
						$sbmarks['blinklist'] . " " .
						//$sbmark['blogmark'] . " " .
						//$sbmark['citeulike'] . " " .
						//$sbmarks['connotea'] . " " .
						$sbmarks['delicio'] . " " .
						$sbmarks['digg'] . " " .
						//$sbmarks['diigo'] . " " .
						//$sbmarks['dzone'] . " " .
						//$sbmarks['earthlink'] . " " .
						//$sbmarks['eatmyhamster'] . " " .
						$sbmarks['facebook'] . " " .
						//$sbmarks['fantacular'] . " " .
						//$sbmarks['fark'] . " " .
						//$sbmarks['feedmarker'] . " " .
						//$sbmarks['feedmelinks'] . " " .
						$sbmarks['furl'] . " " .
						$sbmarks['google'] . " " .
						//$sbmarks['gravee'] . " " .
						//$sbmarks['igooi'] . " " .
						//$sbmarks['italknews'] . " " .
						//$sbmarks['jookster'] . " " .
						//$sbmarks['kinja'] . " " .
						//$sbmarks['linkagogo'] . " " .
						//$sbmarks['linkroll'] . " " .
						//$sbmarks['linuxquestions'] . " " .
						//$sbmarks['live'] . " " .			<==== Don't use doesn't work properly
						//$sbmarks['lookmarks'] . " " .
						//$sbmarks['lycos'] . " " .
						//$sbmarks['magnolia'] . " " .
						//$sbmarks['markabboo'] . " " .
						//$sbmarks['netscape'] . " " .
						//$sbmarks['netvouz'] . " " .
						//$sbmarks['newsvine'] . " " .
						//$sbmarks['ning'] . " " .
						//$sbmarks['nowpublic'] . " " .
						//$sbmarks['rawsugar'] . " " .
						$sbmarks['reddit'] . " " .
						//$sbmarks['riffs'] . " " .
						//$sbmarks['rojo'] . " " .
						//$sbmarks['shadow'] . " " .
						//$sbmarks['squidoo'] . " " .
						$sbmarks['stumble'] . " " .
						//$sbmarks['tagtooga'] . " " .
						//$sbmarks['techno'] . " " .
						$sbmarks['wink'] . " " .
						$sbmarks['yahoo'] . " " .
						$sbmarks['info'];

return $sbmarks['sbmarks'];
}
?>