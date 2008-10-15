<?php
/**
 * $Id: admin.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
 
define("_AM_IMGLOSSARY_ACTION", "Aktion");
define("_AM_IMGLOSSARY_ADMINCATMNGMT", "Kategoriemanagement");
define("_AM_IMGLOSSARY_ADMINENTRYMNGMT", "Eintragmanagement");
define("_AM_IMGLOSSARY_ALLOWCOMMENTS", "Dürfen Einträge kommentiert werden?");
define("_AM_IMGLOSSARY_ANON", "Gäste");
define("_AM_IMGLOSSARY_AUTHENTRY", "Einsendung autorisieren");
define("_AM_IMGLOSSARY_AUTHOR", "Autor");
define("_AM_IMGLOSSARY_AUTHORIZE", "Autorisieren");
define("_AM_IMGLOSSARY_BACK2IDX", "Abgebrochen. Zurück zum Index");
define("_AM_IMGLOSSARY_BLOCK", " Dem Eintrag-Block hinzufügen?");
define("_AM_IMGLOSSARY_BLOCKS", "Blöcke");
define("_AM_IMGLOSSARY_BREAKS", " Zeilenumbruchkonvertierung benutzen?");
define("_AM_IMGLOSSARY_CANCEL", "Abbrechen");
define("_AM_IMGLOSSARY_CATCREATED", "Neue Kategorie wurde erstellt und gespeichert!");
define("_AM_IMGLOSSARY_CATDESCRIPT", "Kategoriebeschreibung");
define("_AM_IMGLOSSARY_CATIMAGE", "Kategoriebild");
define("_AM_IMGLOSSARY_CATIMAGEUPLOAD", " Kategoriebild hochladen");
define("_AM_IMGLOSSARY_CATISDELETED", "Kategorie %s wurde gelöscht");
define("_AM_IMGLOSSARY_CATMODIFIED", "Gewählte Kategorie wurde verändert und gespeichert!");
define("_AM_IMGLOSSARY_CATNAME", "Kategoriename");
define("_AM_IMGLOSSARY_CATPOSIT", "Kategorieposition");
define("_AM_IMGLOSSARY_CATS", "Kategorien");
define("_AM_IMGLOSSARY_CATSHEADER", "Kategoriekopfzeile");
define("_AM_IMGLOSSARY_CLEAR", "Zurücksetzen");
define("_AM_IMGLOSSARY_CREATE", "Erstellen");
define("_AM_IMGLOSSARY_CREATECAT", "Kategorie erstellen");
define("_AM_IMGLOSSARY_CREATEENTRY", "Eintrag erstellen");
define("_AM_IMGLOSSARY_CREATEIN", "Erstellen in Kategorie:");
define("_AM_IMGLOSSARY_DELETE", "Löschen");
define("_AM_IMGLOSSARY_DELETECAT", "Kategorie löschen");
define("_AM_IMGLOSSARY_DELETEENTRY", "Eintrag löschen");
define("_AM_IMGLOSSARY_DELETESUBM", "Einsendung löschen");
define("_AM_IMGLOSSARY_DELETETHISCAT", "Sind Sie sicher Sie wollen diese Kategorie löschen?");
define("_AM_IMGLOSSARY_DELETETHISENTRY", "Diesen Eintrag löschen?");
define("_AM_IMGLOSSARY_DESCRIP", "Kategoriebeschreibung");
define("_AM_IMGLOSSARY_DOHTML", " HTML-Tags erlauben");
define("_AM_IMGLOSSARY_DOSMILEY", " Smilies erlauben");
define("_AM_IMGLOSSARY_DOXCODE", " XOOPS-Codes erlauben");
define("_AM_IMGLOSSARY_EDITCAT", "Kategorie bearbeiten");
define("_AM_IMGLOSSARY_EDITENTRY", "Eintrag bearbeiten");
define("_AM_IMGLOSSARY_EDITSUBM", "Einsendung bearbeiten");
define("_AM_IMGLOSSARY_ENTRIES", "Einträge");
define("_AM_IMGLOSSARY_ENTRYAUTHORIZED", "Der Eintrag wurde autorisiert.");
define("_AM_IMGLOSSARY_ENTRYCATNAME", "Kategoriename");
define("_AM_IMGLOSSARY_ENTRYCREATED", "Erstellt");
define("_AM_IMGLOSSARY_ENTRYCREATEDOK", "Der Eintrag wurde erfolgreich erstellt!");
define("_AM_IMGLOSSARY_ENTRYDEF", "Definition");
define("_AM_IMGLOSSARY_ENTRYID", "ID");
define("_AM_IMGLOSSARY_ENTRYISDELETED", "Der Eintrag %s wurde gelöscht.");
define("_AM_IMGLOSSARY_ENTRYISOFF", "Eintrag ist offline");
define("_AM_IMGLOSSARY_ENTRYISON", "Eintrag ist online");
define("_AM_IMGLOSSARY_ENTRYMODIFIED", "Der Eintrag wurde erfolgreich verändert!");
define("_AM_IMGLOSSARY_ENTRYNOTCREATED", "Verzeihung, es war nicht möglich, diesen Eintrag zu erstellen!");
define("_AM_IMGLOSSARY_ENTRYNOTUPDATED", "Verzeihung, es war nicht möglich, diesen Eintrag zu aktualisieren!");
define("_AM_IMGLOSSARY_ENTRYREFERENCE", "Referenz<span style='font-size: xx-small; font-weight: normal; display: block;'>(Schreiben Sie die Quelle Ihrer<br />Definition, wie Buch,<br />Artikel oder Person.)</span>");
define("_AM_IMGLOSSARY_ENTRYTERM", "Begriff");
define("_AM_IMGLOSSARY_ENTRYURL", "Verknüpfte Site<span style='font-size: xx-small; font-weight: normal; display: block;'>(Bitte geben sie eine gültige URL<br />mit oder ohne HTTP-Präfix an)</span>");
define("_AM_IMGLOSSARY_FILEEXISTS", "Eine Datei mit diesem Namen existiert bereits auf dem Server. Bitte wählen Sie eine andere Datei!");
define("_AM_IMGLOSSARY_GOMOD", "Zum Modul");
define("_AM_IMGLOSSARY_HELP", "Hilfe");
define("_AM_IMGLOSSARY_ID", "ID");
define("_AM_IMGLOSSARY_INDEX", "Index");
define("_AM_IMGLOSSARY_INVENTORY", "Eintragzusammenfassung");
define("_AM_IMGLOSSARY_MODCAT", "Vorhandene Kategorie verändern");
define("_AM_IMGLOSSARY_MODADMIN", " Modul-Admin: ");
define("_AM_IMGLOSSARY_MODENTRY", "Eintrag verändern");
define("_AM_IMGLOSSARY_MODIFY", "Verändern");
define("_AM_IMGLOSSARY_MODIFYCAT", "Kategorie verändern");
define("_AM_IMGLOSSARY_MODIFYTHISCAT", "Diese Kategorie verändern?");
define("_AM_IMGLOSSARY_MODULEHEADMULTI", "Einträge | Kategorien | Einsendungen | Anfragen");
define("_AM_IMGLOSSARY_MODULEHEADSINGLE", "Einträge | Einsendungen | Anfragen");
define("_AM_IMGLOSSARY_NEEDONECOLUMN", "Um einen Eintrag zu erstellen, wird wenigstens eine Kategorie benötigt.");
define("_AM_IMGLOSSARY_NEWCAT", "Kategorie erstellen");
define("_AM_IMGLOSSARY_NEWENTRY", "Eintrag erstelen");
define("_AM_IMGLOSSARY_NO", "Nein");
define("_AM_IMGLOSSARY_NOCATS", "Es gibt keine anzuzeigenden Kategorien");
define("_AM_IMGLOSSARY_NOCOLTOEDIT", "Es gibt keine zu bearbeitenden Spalten!");
define("_AM_IMGLOSSARY_NOPERMSSET", "Berechtigungen können nicht gesetzt werden: Keine Spalten bis jetzt erstellt!");
define("_AM_IMGLOSSARY_NOREQSYET", "Es gibt momentan keine nicht definierten angefragten Begriffe.");
define("_AM_IMGLOSSARY_NOSUBMISSYET", "Es gibt momentan keine Einsendungen die auf Freigabe warten.");
define("_AM_IMGLOSSARY_NOTERMS", "Keine anzuzeigenden Begriffe");
define("_AM_IMGLOSSARY_NOTUPDATED", "Beim Aktualisieren der Datenbank ist ein Fehler aufgetreten!");
define("_AM_IMGLOSSARY_OPTIONS", "Optionen");
define("_AM_IMGLOSSARY_OPTS", "Moduleinstellungen");
define("_AM_IMGLOSSARY_SHOWCATS", "Kategorien");
define("_AM_IMGLOSSARY_SHOWENTRIES", "Einträge");
define("_AM_IMGLOSSARY_SHOWREQUESTS", "Anfragen");
define("_AM_IMGLOSSARY_SHOWSUBMISSIONS", "Einsendungen");
define("_AM_IMGLOSSARY_SINGLECAT", "The module is defined to have a single category. You have no reason to be here.");
define("_AM_IMGLOSSARY_STATUS", "Status");
define("_AM_IMGLOSSARY_SUBMITS", "Einsendungen");
define("_AM_IMGLOSSARY_SUBMITTER", "Absender");
define("_AM_IMGLOSSARY_SWITCHOFFLINE", " Eintrag offline setzen?");
define("_AM_IMGLOSSARY_TOTALCATS", "Verfügbare Kategorien: ");
define("_AM_IMGLOSSARY_TOTALENTRIES", "Veröffentlichte Einträge: ");
define("_AM_IMGLOSSARY_TOTALREQ", "Angefragte Einträge: ");
define("_AM_IMGLOSSARY_TOTALSUBM", "Eingeschickte Einträge: ");
define("_AM_IMGLOSSARY_UNIQUE", "Einmalige Kategorie");
define("_AM_IMGLOSSARY_WEIGHT", "Position");
define("_AM_IMGLOSSARY_WRITEHERE", "Schreiben Sie hier die Definition.");
define("_AM_IMGLOSSARY_YES", "Ja");
//mondarse
define("_AM_IMGLOSSARY_IMPORT", "Import");
define("_AM_IMGLOSSARY_IMPORTWARN", "Warnung!! Zuerst Datenbank-Backup durchführen.<br />Das Importscript ist noch in der Testphase und kann zu Datenverlust führen.");

// Taken from importdictionary091.php (McDonald)
define("_AM_IMGLOSSARY_IMPDICT_01","Datenbank für Import fehlt oder ist leer!");
define("_AM_IMGLOSSARY_IMPDICT_02","Glossar Einträge Import Script");
define("_AM_IMGLOSSARY_IMPDICT_03","Import von Dictionary Version 0.92");
define("_AM_IMGLOSSARY_IMPDICT_04","Fehler: #");
define("_AM_IMGLOSSARY_IMPDICT_05","Dictionary Module ID: ");
define("_AM_IMGLOSSARY_IMPDICT_06","Glossar-Module ID: ");
define("_AM_IMGLOSSARY_IMPDICT_07","Fehler wärend des transverierens der Kommentare von Dictionary nach imGlossary.");
define("_AM_IMGLOSSARY_IMPDICT_08","Kommentare erfolgreich von Dictionary nach Glossar transveriert");
define("_AM_IMGLOSSARY_IMPDICT_09","Fehlerhaft: ");
define("_AM_IMGLOSSARY_IMPDICT_10","Erfolgreich: ");
define("_AM_IMGLOSSARY_IMPDICT_11","Zurück zur Administration");
define("_AM_IMGLOSSARY_IMPDICT_12","Module Dictionary not found on this site.");

define("_AM_IMGLOSSARY_NOCOLEXISTS", "Es sind noch keine Kategorien angelegt.<br />Bitte kontaktieren Sie den Administrator und teilen Sie ihm diese Nachricht mit."); // This was originally in the main.php file

// imGlossary v1.00
define("_AM_IMGLOSSARY_SHOWOFFLINE", "Offline");
define("_AM_IMGLOSSARY_COMMENTS", "Kommentare");
define("_AM_IMGLOSSARY_UPDATEMOD", "Update module");

// Import 
define("_AM_IMGLOSSARY_MODULEHEADIMPORTWB", "Wordbook &mdash;&gt; imGlossary import script");
define("_AM_IMGLOSSARY_MODULEHEADIMPORT", "Dictionary 0.91 &mdash;&gt; imGlossary import script");
define("_AM_IMGLOSSARY_MODULEHEADIMPORTGLO", "Glossaire &mdash;&gt; imGlossary import script");
define("_AM_IMGLOSSARY_MODULEHEADIMPORTXWO", "XWords &mdash;&gt; imGlossary import script");
define("_AM_IMGLOSSARY_MODULEHEADIMPORTWW", "Wiwimod &mdash;&gt; imGlossary import script");
define("_AM_IMGLOSSARY_MODULEIMPORTEMPTY10", "Database missing or empty!");
define("_AM_IMGLOSSARY_MODULEIMPORTERCOM", "Comments successfully moved to imGlossary");
define("_AM_IMGLOSSARY_MODULEIMPORTERNOCOM", "Error while moving Comments to imGlossary");
define("_AM_IMGLOSSARY_IMPORTDELWB","Delete entries before import? ");
define("_AM_IMGLOSSARY_NOOTHERMODS", "No corresponding modules could be located!");
?>