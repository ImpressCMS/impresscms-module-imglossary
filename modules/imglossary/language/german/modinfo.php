<?php
/**
 * $Id: main.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

// Module Info
// The name of this module
global $xoopsModule;
define("_MI_WB_MD_NAME", "imGlossary");

// A brief description of this module
define("_MI_WB_MD_DESC", "Ein Multikategorie-Glossar");

// Sub menus in main menu block
define("_MI_WB_SUB_SMNAME1", "Eintrag einschicken");
define("_MI_WB_SUB_SMNAME2", "Definition anfordern");
define("_MI_WB_SUB_SMNAME3", "Definition suchen");

define("_MI_WB_RANDOMTERM", "Zuf&auml;lliger Begriff");

// A brief description of this module
define("_MI_WB_ALLOWSUBMIT", "D&uuml;rfen User Eintr&auml;ge einschicken?");
define("_MI_WB_ALLOWSUBMITDSC", "Falls 'Ja', haben die User Zugriff auf das Absendeformular");

define("_MI_WB_ANONSUBMIT", "D&uuml;rfen G&auml;ste Eintr&auml;ge einschicken?");
define("_MI_WB_ANONSUBMITDSC", "Falls 'Ja', haben G&auml;ste Zugriff auf das Absendeformular");

define("_MI_WB_DATEFORMAT", "Welches Format soll das Datum haben?");
define("_MI_WB_DATEFORMATDSC", "Benutzt den letzten Teil von language/english/global.php um die Datumsanzeige zu bestimmen. Beispiel: 'd-M-Y H:i' wird zu '23-Mar-2004 22:35'");

define("_MI_WB_PERPAGE", "Anzahl der Eintr&auml;ge pro Seite (Admin-Seite)?");
define("_MI_WB_PERPAGEDSC", "Anzahl der Eintr&auml;ge die auf einmal auf der Admin-Seite angezeigt werden.");

define("_MI_WB_PERPAGEINDEX", "Anzahl der Eintr&auml;ge pro Seite (User-Seite)?");
define("_MI_WB_PERPAGEINDEXDSC", "Anzahl der Eintr&auml;ge die auf jeder Seite der User-Seite angezeigt werden.");

define("_MI_WB_AUTOAPPROVE", "Eintr&auml;ge automatisch freigeben?");
define("_MI_WB_AUTOAPPROVEDSC", "Falls 'Ja' werden die Eintr&auml;ge automatisch freigegeben.");

define("_MI_WB_MULTICATS", "Ben&ouml;tigen Sie Glossar-Kategorien?");
define("_MI_WB_MULTICATSDSC", "Falls 'Ja' k&ouml;nnen diverse Kategorien benutzt werden, ansonsten gibt es nur eine automatische Kategorie.");

define("_MI_WB_CATSINMENU","Sollen die Kategorien im Men&uuml; angezeigt werden?"); 
define("_MI_WB_CATSINMENUDSC","W&auml;hlen Sie 'Ja', falls Sie Link zu Kategorien im Hauptmen&uuml; haben wollen."); 

define("_MI_WB_CATSPERINDEX","Anzahl der Kategorien pro Seite (User-Seite)?"); 
define("_MI_WB_CATSPERINDEXDSC","Definiert die Anzahl der angezeigten Kategorien auf der Index-Seite."); 

define("_MI_WB_ALLOWADMINHITS", "Sollen Admin-Aufrufe mitgez&auml;hlt werden?");
define("_MI_WB_ALLOWADMINHITSDSC", "Falls 'Ja', wird sich der Z&auml;hler auch bei Admin-Aufrufen erh&ouml;hen.");

define("_MI_WB_MAILTOADMIN", "E-Mail an Admin bei jeder neuen Einsendung?");  
define("_MI_WB_MAILTOADMINDSC", "Falls 'Ja', wird der Admin bei jeder neuen Einsendung eine E-Mail erhalten.");  

define("_MI_WB_RANDOMLENGTH", "L&auml;nge der anzuzeigenden Zeile bei zuf&auml;lligen Definitionen?");  
define("_MI_WB_RANDOMLENGTHDSC", "Wieviele Zeichen sollen bei den zuf&auml;lligen Definitionen angezeigt werden? Gilt f&uuml;r die Index-Seite und f&uuml;r den Block (Vorgabe: 150 Zeichen)");

define("_MI_WB_LINKTERMS", "Links anzeigen zu anderen Begriffen in den Definitionen?");  
define("_MI_WB_LINKTERMSDSC", "Falls 'Ja' wird in den Definitionen automatisch zu anderen Eintr&auml;gen im Glossar verlinkt.");

// Names of admin menu items
define("_MI_WB_ADMENU1", "Index");
define("_MI_WB_ADMENU2", "Kategorien");
define("_MI_WB_ADMENU3", "Eintr&auml;ge");
define("_MI_WB_ADMENU4", "Bl&ouml;cke");
define("_MI_WB_ADMENU5", "Zum Modul");
//mondarse
define("_MI_WB_ADMENU6", "Import");

//Names of Blocks and Block information
define("_MI_WB_ENTRIESNEW", "Neueste Begriffe");
define("_MI_WB_ENTRIESTOP", "Meistgelesene Begriffe");
define("_MD_WB_NOCATSINSYSTEM","No categories in system");

// imGlossary - version 1.00
define("_MI_IMGLOSSARY_SORTCATS", "Sort categories by:");
define("_MI_IMGLOSSARY_SORTCATSDSC", "Select how categories are sorted.");
define("_MI_IMGLOSSARY_TITLE", "Title");
define("_MI_IMGLOSSARY_WEIGHT", "Weight");

?>