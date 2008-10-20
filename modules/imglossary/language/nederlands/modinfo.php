<?php
/**
 * $Id: modinfo.php 
 * Module: imGlossary - a multicategory glossary
 * Author: McDonald
 * Language: Dutch (Nederlands)
 * Licence: GNU
 */
 
global $xoopsModule;

// Module Info
// The name of this module

define("_MI_IMGLOSSARY_MD_NAME", "imGlossary");

// A brief description of this module
define("_MI_IMGLOSSARY_MD_DESC", "Een multi-categorie verklarende woordenlijst");

// Sub menus in main menu block
define("_MI_IMGLOSSARY_SUB_SMNAME1", "Inzenden term");
define("_MI_IMGLOSSARY_SUB_SMNAME2", "Aanvragen term");
define("_MI_IMGLOSSARY_SUB_SMNAME3", "Zoek een definitie");

define("_MI_IMGLOSSARY_RANDOMTERM", "Willekeurige term");

// A brief description of this module
define("_MI_IMGLOSSARY_ALLOWSUBMIT", "Kunnen bezoekers termen inzenden?");
define("_MI_IMGLOSSARY_ALLOWSUBMITDSC", "Indien <em>Ja</em>, dan hebben bezoekers toegang tot het inzendformulier");

define("_MI_IMGLOSSARY_ANONSUBMIT", "Kunnen gasten termen inzenden?");
define("_MI_IMGLOSSARY_ANONSUBMITDSC", "Indien <em>Ja</em>, dan hebben gasten toegang tot het inzendformulier");

define("_MI_IMGLOSSARY_DATEFORMAT", "Weergave formaat voor de datum?");
define("_MI_IMGLOSSARY_DATEFORMATDSC", "Voor informatie <a href='http://jp.php.net/manual/en/function.date.php' target='_blank'>PHP handleiding</a>");
//define("_MI_IMGLOSSARY_DATEFORMATDSC", "Gebruik het deel <em>TIME FORMAT SETTINGS</em> van language/nederlands/global.php om een weergave stijl in te stellen.<br />Voor meer informatie <a href='http://jp.php.net/manual/en/function.date.php' target='_blank'>PHP handleiding</a>");

define("_MI_IMGLOSSARY_PERPAGE", "Aantal termen per pagina (Admin zijde)?");
define("_MI_IMGLOSSARY_PERPAGEDSC", "Aantal termen die per pagina worden getoond in de administratie van de module.<br />Standaard: <em>5</em>");

define("_MI_IMGLOSSARY_PERPAGEINDEX", "Aantal termen per pagina (Gebruikers zijde)?");
define("_MI_IMGLOSSARY_PERPAGEINDEXDSC", "Aantal termen die per pagina worden getoond aan de gebruikers kant van de module.<br />Standaard: <em>5</em>");

define("_MI_IMGLOSSARY_AUTOAPPROVE", "Termen automatisch goedkeuren?");
define("_MI_IMGLOSSARY_AUTOAPPROVEDSC", "Indien <em>Ja</em>, dan publiceerd ImpressCMS ingezonden termen automatisch zonder tussenkomst van de websitebeheerder.");

define("_MI_IMGLOSSARY_MULTICATS", "Wilt u categorieën toepassen?");
define("_MI_IMGLOSSARY_MULTICATSDSC", "Indien <em>Ja</em>, dan kunt u categorieën aanmaken. Indien <em>Nee</em> zal één automatische categorie toegepast worden.");

define("_MI_IMGLOSSARY_CATSINMENU", "Categorieën in het hoofdmenu weergegeven?"); 
define("_MI_IMGLOSSARY_CATSINMENUDSC", "Indien <em>Ja</em>, dan worden de categorieën in het hoofdmenu weergegeven."); 

define("_MI_IMGLOSSARY_CATSPERINDEX", "Aantal categorieën per pagina (Gebruikers zijde)?"); 
define("_MI_IMGLOSSARY_CATSPERINDEXDSC", "Dit geeft aan hoeveel categorieën per pagina worden weergegeven.<br />Standaard: <em>5</em>"); 

define("_MI_IMGLOSSARY_ALLOWADMINHITS", "Dienen de admin hits meegetelt te worden?");
define("_MI_IMGLOSSARY_ALLOWADMINHITSDSC", "Indien <em>Ja</em>, dan zal de teller verhoogd worden iedere keer als de admin de tterm bekijkt.");

define("_MI_IMGLOSSARY_MAILTOADMIN", "Stuur een email naar de admin bij iedere nieuwe inzending?");  
define("_MI_IMGLOSSARY_MAILTOADMINDSC", "Indien <em>Ja</em>, dan zal de admin een email ontvangen voor iedere ingezonden term."); 
 
define("_MI_IMGLOSSARY_RANDOMLENGTH", "Lengte van de tekst voor <em>willekeurige definities</em>?");  
define("_MI_IMGLOSSARY_RANDOMLENGTHDSC", "Vul hier het aantal karakters in voor de willekeurige term blokken?<br />Standaard: 500");

define("_MI_IMGLOSSARY_LINKTERMS", "Laat linken naar andere termen zien in de definities?");  
define("_MI_IMGLOSSARY_LINKTERMSDSC", "Indien <em>Ja</em>, zal imGlossary automatisch linken in uw definities naar andere termen in de woordenlijsten.");

// Names of admin menu items
define("_MI_IMGLOSSARY_ADMENU1", "Index");
define("_MI_IMGLOSSARY_ADMENU2", "Nieuwe categorie");
define("_MI_IMGLOSSARY_ADMENU3", "Nieuwe term");
define("_MI_IMGLOSSARY_ADMENU4", "Blokken");
define("_MI_IMGLOSSARY_ADMENU5", "Naar module");
//mondarse
define("_MI_IMGLOSSARY_ADMENU6", "Importeer");

//Names of Blocks and Block information
define("_MI_IMGLOSSARY_ENTRIESNEW", "Nieuwste termen");
define("_MI_IMGLOSSARY_ENTRIESTOP", "Meest gelezen termen");

// imGlossary - version 1.00
define("_MI_IMGLOSSARY_SORTCATS", "Sorteer categorieën op:");
define("_MI_IMGLOSSARY_SORTCATSDSC", "Selekteer hoe categorieën gesorteerd worden.");
define("_MI_IMGLOSSARY_TITLE", "Titel");
define("_MI_IMGLOSSARY_WEIGHT", "Gewicht");
define("_MI_IMGLOSSARY_ADMENU7", "Inzendingen");
define("_MI_IMGLOSSARY_SHOWSUBMITTER", "Laat inzender voor iedere term zien?");
define("_MI_IMGLOSSARY_SHOWSUBMITTERDSC", "Kies <em>Ja</em> om de inzender van de term weer te geven.");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKS","Laat Social Bookmarks zien bij iedere term?");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKSDSC", "Kies <em>Ja</em> om de Social Bookmark iconen weer te geven bij iedere term.");
define("_MI_IMGLOSSARY_SEARCHCOLOR", "Achtergrond kleur voor zoektermen:");
define("_MI_IMGLOSSARY_SEARCHCOLORDSC", "Voer de kleur in die als achtergroind dient voor zoektermen.<br />Standaard: <span style='background-color: #FFFF00; font-style: italic;'>&nbsp;#FFFF00&nbsp;</span>");
define("_MI_IMGLOSSARY_CAPTCHA", "Gebruik captcha in inzend- en aanvraagformulier?");
define("_MI_IMGLOSSARY_CAPTCHADSC", "Kies <em>Ja</em> om captcha te gebruiken in het inzend- en aanvraagformulier.<br />Standaard: <em>Ja</em>");
define("_MI_IMGLOSSARY_SHOWCENTER", "Laat center blokken zien?");
define("_MI_IMGLOSSARY_SHOWCENTERDSC", "Kies <em>Ja</em> om de drie blokken Recente termen, Populaire termen en Zoek in de index pagina te laten zien.<br />Kies <em>Nee</em> om in plaats van de drie blokken alleen een Zoek blok te laten zien.");
define("_MI_IMGLOSSARY_SHOWRANDOM", "Laat Willekeurige term blok zien?");
define("_MI_IMGLOSSARY_SHOWRANDOMDSC", "Kies <em>Ja</em> om het Willekeurige blok in de index pagina te laten zien.");
?>