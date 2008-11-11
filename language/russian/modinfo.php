<?php
/**
* imGlossary - a multicategory glossary for ImpressCMS
*
* Based upon Wordbook 1.16
*
* File: language/russian/modinfo.php
*
* @copyright		http://www.xoops.org/ The XOOPS Project
* @copyright		XOOPS_copyrights.txt
* @copyright		http://www.impresscms.org/ The ImpressCMS Project
* @license		GNU General Public License (GPL)
*				a copy of the GNU license is enclosed.
* ----------------------------------------------------------------------------------------------------------
* @package		Wordbook - a multicategory glossary
* @since			1.16
* @author		hsalazar
* ----------------------------------------------------------------------------------------------------------
* 				imGlossary - a multicategory glossary
* @since			1.00
* @author		modified by McDonald
* @version		$Id$ Russian translation. Charset: utf-8 (without BOM)
*/

// The name of this module
global $xoopsModule;
define("_MI_IMGLOSSARY_MD_NAME", "imGlossary");

// A brief description of this module
define("_MI_IMGLOSSARY_MD_DESC", "Многокатегорийный глоссарий (словарь)");

// Sub menus in main menu block
define("_MI_IMGLOSSARY_SUB_SMNAME1", "Размещение записи");
define("_MI_IMGLOSSARY_SUB_SMNAME2", "Запрос определения");
define("_MI_IMGLOSSARY_SUB_SMNAME3", "Поиск определения");

define("_MI_IMGLOSSARY_RANDOMTERM", "Случайный термин");

// A brief description of this module
define("_MI_IMGLOSSARY_ALLOWSUBMIT", "Пользователи могут размещать записи?");
define("_MI_IMGLOSSARY_ALLOWSUBMITDSC", "Если установлено <em>Да</em>, то пользователи будут иметь доступ к заполнению формы размещения");

define("_MI_IMGLOSSARY_ANONSUBMIT", "Гости могут размещать записи?");
define("_MI_IMGLOSSARY_ANONSUBMITDSC", "Если установлено <em>Да</em>, то гости будут иметь доступ к заполнению формы размещения");

define("_MI_IMGLOSSARY_DATEFORMAT", "В каком формате должна быть представлена дата?");
define("_MI_IMGLOSSARY_DATEFORMATDSC", "Use the part <em>TIME FORMAT SETTINGS</em> of language/english/global.php to select a display style.<br />See <a href='http://jp.php.net/manual/en/function.date.php' target='_blank'>PHP manual</a>");

define("_MI_IMGLOSSARY_PERPAGE", "Кол-во записей на странице (для администратора)?");
define("_MI_IMGLOSSARY_PERPAGEDSC", "Number of entries that will be shown at once in the table that displays active entries in the admin side.");

define("_MI_IMGLOSSARY_PERPAGEINDEX", "Кол-во записей на странице (для пользователя)?");
define("_MI_IMGLOSSARY_PERPAGEINDEXDSC", "Number of entries that will be shown on each page in the user side of the module.");

define("_MI_IMGLOSSARY_AUTOAPPROVE", "Утверждать записи автоматически?");
define("_MI_IMGLOSSARY_AUTOAPPROVEDSC", "Если установлено <em>Да</em>, ImpressCMS will publish submitted entries without admin intervention.");

define("_MI_IMGLOSSARY_MULTICATS", "Do you want to have glossary categories?");
define("_MI_IMGLOSSARY_MULTICATSDSC", "Если установлено <em>Да</em>, will allow you to have glossary categories. Если установлено <em>Нет</em>, will have a single automatic category.");

define("_MI_IMGLOSSARY_CATSINMENU","Should the categories be shown in the menu?"); 
define("_MI_IMGLOSSARY_CATSINMENUDSC","Если установлено <em>Да</em> if you want links to categories in the main menu."); 

define("_MI_IMGLOSSARY_CATSPERINDEX","Кол-во категорий на странице (для пользователя)?"); 
define("_MI_IMGLOSSARY_CATSPERINDEXDSC","This will define how many categories will be shown in the index page."); 

define("_MI_IMGLOSSARY_ALLOWADMINHITS", "Will the admin hits be included in the counter?");
define("_MI_IMGLOSSARY_ALLOWADMINHITSDSC", "Если установлено <em>Да</em>, will increase counter for each entry on admin visits.");

define("_MI_IMGLOSSARY_MAILTOADMIN", "Отсылать email администратору о каждом новом размещении?");  
define("_MI_IMGLOSSARY_MAILTOADMINDSC", "Если установлено <em>Да</em>, the manager will receive an e-mail for every submitted entry."); 
 
define("_MI_IMGLOSSARY_RANDOMLENGTH", "Длина строки для показа в произвольных определениях?");  
define("_MI_IMGLOSSARY_RANDOMLENGTHDSC", "Какое кол-во символов Вы желаете показывать в боксах случайных терминов, both in the main page and in the block? (По умолчанию: 500)");

define("_MI_IMGLOSSARY_LINKTERMS", "Показывать ссылки на другие термины из глоссария в определениях?");  
define("_MI_IMGLOSSARY_LINKTERMSDSC", "Если установлено <em>Да</em>, imGlossary будет автоматически ссылаться в Вашем определении на термины, которые уже имеются в глоссариях.");

// Names of admin menu items
define("_MI_IMGLOSSARY_ADMENU1", "Индекс");
define("_MI_IMGLOSSARY_ADMENU2", "Добавить категорию");
define("_MI_IMGLOSSARY_ADMENU3", "Добавить запись");
define("_MI_IMGLOSSARY_ADMENU4", "Блоки");
define("_MI_IMGLOSSARY_ADMENU5", "В модуль");
//mondarse
define("_MI_IMGLOSSARY_ADMENU6", "Импорт");

//Names of Blocks and Block information
define("_MI_IMGLOSSARY_ENTRIESNEW", "Новейшие термины");
define("_MI_IMGLOSSARY_ENTRIESTOP", "Часто читаемые термины");

// imGlossary - version 1.00
define("_MI_IMGLOSSARY_SORTCATS", "Сортировать категории по:");
define("_MI_IMGLOSSARY_SORTCATSDSC", "Select how categories are sorted.");
define("_MI_IMGLOSSARY_TITLE", "Заголовок");
define("_MI_IMGLOSSARY_WEIGHT", "Вес");
define("_MI_IMGLOSSARY_ADMENU7", "Размещения");
define("_MI_IMGLOSSARY_SHOWSUBMITTER", "Показывать разместившего в каждой записи?");
define("_MI_IMGLOSSARY_SHOWSUBMITTERDSC", "Select <em>Yes</em> to display the submitter of the entry.");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKS","Show Social Bookmarks in every entry?");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKSDSC", "Select <em>Yes</em> to have Social Bookmark icons visible in every entry.");
define("_MI_IMGLOSSARY_SEARCHCOLOR", "Цвет фона терминов при поиске:");
define("_MI_IMGLOSSARY_SEARCHCOLORDSC", "Enter the colour to use as background for search terms. Default: <span style='background-color: #FFFF00;'>&nbsp;#FFFF00&nbsp;</span>");
define("_MI_IMGLOSSARY_CAPTCHA", "Использовать captcha в формах размщения и запроса?");
define("_MI_IMGLOSSARY_CAPTCHADSC", "Select <em>Yes</em> to use captcha in the submit and request form.<br />Default: <em>Yes</em>");
define("_MI_IMGLOSSARY_SHOWCENTER", "Показать центральные блоки?");
define("_MI_IMGLOSSARY_SHOWCENTERDSC", "Select <em>Yes</em> to display the three center blocks Recent entries, Popular entries and Search on the index page.<br />Select <em>No</em> to replace these 3 blocks by a Search block.");
define("_MI_IMGLOSSARY_SHOWRANDOM", "Показать блок случайных терминов?");
define("_MI_IMGLOSSARY_SHOWRANDOMDSC", "Select <em>Yes</em> to display the Random term block on the index page.");
define('_MI_IMGLOSSARY_EDITORADMIN', "Использовать редактор (для администратора):");
define('_MI_IMGLOSSARY_EDITORADMINDSC', "Select the editor to use for admin side.<br />In Preferences -> General Settings set 'Default Editor' to <em>dhtmltextarea</em>.");
define('_MI_IMGLOSSARY_EDITORUSER', "Использовать редактор (для пользователя):");
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

// version 1.01
define( '_MI_IMGLOSSARY_SELECTFEED', 'Использовать RSS канал?' );
define( '_MI_IMGLOSSARY_SELECTFEED_DSC', 'По умолчанию: <em>Да</em>'  );
define( '_MI_IMGLOSSARY_FEEDSTOTAL', 'Сколько терминов отображать в RSS канале?' );
define( '_MI_IMGLOSSARY_FEEDSTOTALDSC', 'По умолчанию: <em>15</em>' );
?>