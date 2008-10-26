<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: language/english/modinfo.php
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		XOOPS_copyrights.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* ----------------------------------------------------------------------------------------------------------
* @package		Wordbook - a multicategory glossary
* @since			1.16
* @author		hsalazar
* ----------------------------------------------------------------------------------------------------------
* @package		imGlossary - a multicategory glossary
* @since			1.00
* @author		modified by McDonald
* @version		$Id$
*/

// The name of this module
global $xoopsModule;
define("_MI_IMGLOSSARY_MD_NAME", "Glossar");

// A brief description of this module
define("_MI_IMGLOSSARY_MD_DESC", "Ein Multikategorie-Glossar");

// Sub menus in main menu block
define("_MI_IMGLOSSARY_SUB_SMNAME1", "Eintrag einschicken");
define("_MI_IMGLOSSARY_SUB_SMNAME2", "Definition anfordern");
define("_MI_IMGLOSSARY_SUB_SMNAME3", "Definition suchen");

define("_MI_IMGLOSSARY_RANDOMTERM", "Zufälliger Begriff");

// A brief description of this module
define("_MI_IMGLOSSARY_ALLOWSUBMIT", "Dürfen Mitglieder Einträge einschicken?");
define("_MI_IMGLOSSARY_ALLOWSUBMITDSC", "Falls 'Ja', haben die Mitglieder Zugriff auf das Absendeformular");

define("_MI_IMGLOSSARY_ANONSUBMIT", "Dürfen Gäste Einträge einschicken?");
define("_MI_IMGLOSSARY_ANONSUBMITDSC", "Falls 'Ja', haben Gäste Zugriff auf das Absendeformular");

define("_MI_IMGLOSSARY_DATEFORMAT", "Welches Format soll das Datum haben?");
define("_MI_IMGLOSSARY_DATEFORMATDSC", "Benutzt den letzten Teil von language/german/global.php um die Datumsanzeige zu bestimmen. Beispiel: 'd-M-Y H:i' wird zu '23-Mar-2004 22:35'");

define("_MI_IMGLOSSARY_PERPAGE", "Anzahl der Einträge pro Seite (Admin-Seite)?");
define("_MI_IMGLOSSARY_PERPAGEDSC", "Anzahl der Einträge die auf einmal auf der Admin-Seite angezeigt werden.");

define("_MI_IMGLOSSARY_PERPAGEINDEX", "Anzahl der Einträge pro Seite (User-Seite)?");
define("_MI_IMGLOSSARY_PERPAGEINDEXDSC", "Anzahl der Einträge die auf jeder Seite der User-Seite angezeigt werden.");

define("_MI_IMGLOSSARY_AUTOAPPROVE", "Einträge automatisch freigeben?");
define("_MI_IMGLOSSARY_AUTOAPPROVEDSC", "Falls 'Ja' werden die Einträge automatisch freigegeben.");

define("_MI_IMGLOSSARY_MULTICATS", "Benötigen Sie Glossar-Kategorien?");
define("_MI_IMGLOSSARY_MULTICATSDSC", "Falls 'Ja' können diverse Kategorien benutzt werden, ansonsten gibt es nur eine automatische Kategorie.");

define("_MI_IMGLOSSARY_CATSINMENU","Sollen die Kategorien im Menü angezeigt werden?"); 
define("_MI_IMGLOSSARY_CATSINMENUDSC","Wählen Sie 'Ja', falls Sie Link zu Kategorien im Hauptmenü haben wollen."); 

define("_MI_IMGLOSSARY_CATSPERINDEX","Anzahl der Kategorien pro Seite (User-Seite)?"); 
define("_MI_IMGLOSSARY_CATSPERINDEXDSC","Definiert die Anzahl der angezeigten Kategorien auf der Index-Seite."); 

define("_MI_IMGLOSSARY_ALLOWADMINHITS", "Sollen Admin-Aufrufe mitgezählt werden?");
define("_MI_IMGLOSSARY_ALLOWADMINHITSDSC", "Falls 'Ja', wird sich der Zähler auch bei Admin-Aufrufen erhöhen.");

define("_MI_IMGLOSSARY_MAILTOADMIN", "E-Mail an Admin bei jeder neuen Einsendung?");  
define("_MI_IMGLOSSARY_MAILTOADMINDSC", "Falls 'Ja', wird der Admin bei jeder neuen Einsendung eine E-Mail erhalten.");  

define("_MI_IMGLOSSARY_RANDOMLENGTH", "Länge der anzuzeigenden Zeile bei zufälligen Definitionen?");  
define("_MI_IMGLOSSARY_RANDOMLENGTHDSC", "Wieviele Zeichen sollen bei den zufälligen Definitionen angezeigt werden? Gilt für die Index-Seite und für den Block (Vorgabe: 150 Zeichen)");

define("_MI_IMGLOSSARY_LINKTERMS", "Links anzeigen zu anderen Begriffen in den Definitionen?");  
define("_MI_IMGLOSSARY_LINKTERMSDSC", "Falls 'Ja' wird in den Definitionen automatisch zu anderen Einträgen im Glossar verlinkt.");

// Names of admin menu items
define("_MI_IMGLOSSARY_ADMENU1", "Index");
define("_MI_IMGLOSSARY_ADMENU2", "Kategorien");
define("_MI_IMGLOSSARY_ADMENU3", "Einträge");
define("_MI_IMGLOSSARY_ADMENU4", "Blöcke");
define("_MI_IMGLOSSARY_ADMENU5", "Zum Modul");
//mondarse
define("_MI_IMGLOSSARY_ADMENU6", "Importieren");

//Names of Blocks and Block information
define("_MI_IMGLOSSARY_ENTRIESNEW", "Neueste Begriffe");
define("_MI_IMGLOSSARY_ENTRIESTOP", "Meistgelesene Begriffe");

// imGlossary - version 1.00
define("_MI_IMGLOSSARY_SORTCATS", "Sortiert Kategorien nach:");
define("_MI_IMGLOSSARY_SORTCATSDSC", "Wähle wie die Kategorien sortiert werden sollen.");
define("_MI_IMGLOSSARY_TITLE", "Titel");
define("_MI_IMGLOSSARY_WEIGHT", "Gewichtung");
define("_MI_IMGLOSSARY_ADMENU7", "Datum");
define("_MI_IMGLOSSARY_SHOWSUBMITTER", "Zeige Übermittler bei jedem Eintrag?");
define("_MI_IMGLOSSARY_SHOWSUBMITTERDSC", "Bei <em>Ja</em> wird der Übermittler in jedem Eintrag angezeigt.");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKS","Zeige Social Bookmarks bei jedem Eintrag?");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKSDSC", "Bei <em>Ja</em> werden die Social Bookmark Icons in jedem Eintrag angezeigt.");
define("_MI_IMGLOSSARY_SEARCHCOLOR", "Hintergrundfarbe für ein Suchergebnis:");
define("_MI_IMGLOSSARY_SEARCHCOLORDSC", "Eintragen einer Farbe welche als Hintegrundfarbe für die Suchergebnisse genutzt werden soll. Stnadard ist: <span style='background-color: #FFFF00;'>&nbsp;#FFFF00&nbsp;</span>");
define("_MI_IMGLOSSARY_CAPTCHA", "Visuelle Verifizierung beim Hinzufügen benutzen?");
define("_MI_IMGLOSSARY_CAPTCHADSC", "<em>Ja</em> es wird ein Captcha beim Hinzufügen eines Artikels verwendet.<br />Standard ist: <em>Ja</em>");
define("_MI_IMGLOSSARY_SHOWCENTER", "Display center blocks?");
define("_MI_IMGLOSSARY_SHOWCENTERDSC", "Select <em>Yes</em> to display the three center blocks Recent entries, Popular entries and Search on the index page.<br />Select <em>No</em> to replace these 3 blocks by a Search block.");
define("_MI_IMGLOSSARY_SHOWRANDOM", "Display Random term block?");
define("_MI_IMGLOSSARY_SHOWRANDOMDSC", "Select <em>Yes</em> to display the Random term block on the index page.");
define('_MI_IMGLOSSARY_EDITORADMIN', "Editor to use (Admin side):");
define('_MI_IMGLOSSARY_EDITORADMINDSC', "Select the editor to use for admin side.<br />In Preferences -> General Settings set 'Default Editor' to <em>dhtmltextarea</em>.");
define('_MI_IMGLOSSARY_EDITORUSER', "Editor to use (User side):");
define('_MI_IMGLOSSARY_EDITORUSERDSC', "Select the editor to use for user side.<br />In Preferences -> General Settings set 'Default Editor' to <em>dhtmltextarea</em>.");
define("_MI_IMGLOSSARY_FORM_DHTML", "DHTML");
define("_MI_IMGLOSSARY_FORM_COMPACT", "Compact");
define("_MI_IMGLOSSARY_FORM_HTMLAREA", "HtmlArea Editor");
define("_MI_IMGLOSSARY_FORM_FCK", "FCK Editor");
define("_MI_IMGLOSSARY_FORM_KOIVI", "Koivi Editor");
define("_MI_IMGLOSSARY_FORM_INBETWEEN", "Inbetween");
define("_MI_IMGLOSSARY_FORM_TINYEDITOR", "TinyEditor");
define("_MI_IMGLOSSARY_FORM_TINYMCE", "TinyMCE");
define("_MI_IMGLOSSARY_FORM_DHTMLEXT", "DHTML Extended");
?>