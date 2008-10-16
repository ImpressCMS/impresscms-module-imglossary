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
define("_MI_IMGLOSSARY_MD_NAME", "imGlossary");

// A brief description of this module
define("_MI_IMGLOSSARY_MD_DESC", "A multi-category glossary");

// Sub menus in main menu block
define("_MI_IMGLOSSARY_SUB_SMNAME1", "Submit an entry");
define("_MI_IMGLOSSARY_SUB_SMNAME2", "Request a definition");
define("_MI_IMGLOSSARY_SUB_SMNAME3", "Search for a definition");

define("_MI_IMGLOSSARY_RANDOMTERM", "Random term");

// A brief description of this module
define("_MI_IMGLOSSARY_ALLOWSUBMIT", "Can users submit entries?");
define("_MI_IMGLOSSARY_ALLOWSUBMITDSC", "If set to <em>Yes</em>, users will have access to a submission form");

define("_MI_IMGLOSSARY_ANONSUBMIT", "Can guests submit entries?");
define("_MI_IMGLOSSARY_ANONSUBMITDSC", "If set to <em>Yes</em>, guests will have access to a submission form");

define("_MI_IMGLOSSARY_DATEFORMAT", "In what format should the date appear?");
define("_MI_IMGLOSSARY_DATEFORMATDSC", "Use the part <em>TIME FORMAT SETTINGS</em> of language/english/global.php to select a display style.<br />See <a href='http://jp.php.net/manual/en/function.date.php' target='_blank'>PHP manual</a>");

define("_MI_IMGLOSSARY_PERPAGE", "Number of entries per page (Admin side)?");
define("_MI_IMGLOSSARY_PERPAGEDSC", "Number of entries that will be shown at once in the table that displays active entries in the admin side.");

define("_MI_IMGLOSSARY_PERPAGEINDEX", "Number of entries per page (User side)?");
define("_MI_IMGLOSSARY_PERPAGEINDEXDSC", "Number of entries that will be shown on each page in the user side of the module.");

define("_MI_IMGLOSSARY_AUTOAPPROVE", "Approve entries automatically?");
define("_MI_IMGLOSSARY_AUTOAPPROVEDSC", "If set to <em>Yes</em>, ImpressCMS will publish submitted entries without admin intervention.");

define("_MI_IMGLOSSARY_MULTICATS", "Do you want to have glossary categories?");
define("_MI_IMGLOSSARY_MULTICATSDSC", "If set to <em>Yes</em>, will allow you to have glossary categories. If set to no, will have a single automatic category.");

define("_MI_IMGLOSSARY_CATSINMENU","Should the categories be shown in the menu?"); 
define("_MI_IMGLOSSARY_CATSINMENUDSC","If set to <em>Yes</em> if you want links to categories in the main menu."); 

define("_MI_IMGLOSSARY_CATSPERINDEX","Number of categories per page (User side)?"); 
define("_MI_IMGLOSSARY_CATSPERINDEXDSC","This will define how many categories will be shown in the index page."); 

define("_MI_IMGLOSSARY_ALLOWADMINHITS", "Will the admin hits be included in the counter?");
define("_MI_IMGLOSSARY_ALLOWADMINHITSDSC", "If set to <em>Yes</em>, will increase counter for each entry on admin visits.");

define("_MI_IMGLOSSARY_MAILTOADMIN", "Send mail to admin on each new submission?");  
define("_MI_IMGLOSSARY_MAILTOADMINDSC", "If set to <em>Yes</em>, the manager will receive an e-mail for every submitted entry."); 
 
define("_MI_IMGLOSSARY_RANDOMLENGTH", "Length of string to show in random definitions?");  
define("_MI_IMGLOSSARY_RANDOMLENGTHDSC", "How many characters do you want to show in the random term boxes, both in the main page and in the block? (Default: 500)");

define("_MI_IMGLOSSARY_LINKTERMS", "Show links to other glossary terms in the definitions?");  
define("_MI_IMGLOSSARY_LINKTERMSDSC", "If set to <em>Yes</em>, imGlossary will automatically link in your definitions those terms you already have in your glossaries.");

// Names of admin menu items
define("_MI_IMGLOSSARY_ADMENU1", "Index");
define("_MI_IMGLOSSARY_ADMENU2", "Add category");
define("_MI_IMGLOSSARY_ADMENU3", "Add entry");
define("_MI_IMGLOSSARY_ADMENU4", "Blocks");
define("_MI_IMGLOSSARY_ADMENU5", "Go to module");
//mondarse
define("_MI_IMGLOSSARY_ADMENU6", "Import");

//Names of Blocks and Block information
define("_MI_IMGLOSSARY_ENTRIESNEW", "Newest Terms");
define("_MI_IMGLOSSARY_ENTRIESTOP", "Most Read Terms");

// imGlossary - version 1.00
define("_MI_IMGLOSSARY_SORTCATS", "Sort categories by:");
define("_MI_IMGLOSSARY_SORTCATSDSC", "Select how categories are sorted.");
define("_MI_IMGLOSSARY_TITLE", "Title");
define("_MI_IMGLOSSARY_WEIGHT", "Weight");
define("_MI_IMGLOSSARY_ADMENU7", "Submissions");
define("_MI_IMGLOSSARY_SHOWSUBMITTER", "Show submitter in every entry?");
define("_MI_IMGLOSSARY_SHOWSUBMITTERDSC", "Select <em>Yes</em> to display the submitter of the entry.");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKS","Show Social Bookmarks in every entry?");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKSDSC", "Select <em>Yes</em> to have Social Bookmark icons visible in every entry.");
define("_MI_IMGLOSSARY_SEARCHCOLOR", "Background colour for search terms:");
define("_MI_IMGLOSSARY_SEARCHCOLORDSC", "Enter the colour to use as background for search terms. Default: <span style='background-color: #FFFF00;'>&nbsp;#FFFF00&nbsp;</span>");
?>