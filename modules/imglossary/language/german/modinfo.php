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
define("_MD_WB_NOCATSINSYSTEM","Keine Kategorien gefunden");

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
define("_MI_IMGLOSSARY_SEARCHCOLORDSC", "Enter the colour to use as background for search terms. Default: <span style='background-color: #FFFF00;'>&nbsp;#FFFF00&nbsp;</span>");
define("_MI_IMGLOSSARY_CAPTCHA", "Use captcha in submit and request forms?");
define("_MI_IMGLOSSARY_CAPTCHADSC", "Select <em>Yes</em> to use captcha in the submit and request form.<br />Default: <em>Yes</em>");
define("_MI_IMGLOSSARY_SHOWCENTER", "Display center blocks?");
define("_MI_IMGLOSSARY_SHOWCENTERDSC", "Select <em>Yes</em> to display the three center blocks Recent entries, Popular entries and Search on the index page.");
define("_MI_IMGLOSSARY_SHOWRANDOM", "Display Random term block?");
define("_MI_IMGLOSSARY_SHOWRANDOMDSC", "Select <em>Yes</em> to display the Random term block on the index page.");
?>