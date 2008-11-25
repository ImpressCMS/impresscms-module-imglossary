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

define("_MI_IMGLOSSARY_DATEFORMAT", "Формат даты:");
define("_MI_IMGLOSSARY_DATEFORMATDSC", "Используйте фрагмент <em>TIME FORMAT SETTINGS</em> файла language/russian/global.php для выбора стиля отображения.<br />Смотрите <a href='http://jp.php.net/manual/en/function.date.php' target='_blank'>PHP руководство</a>");

define("_MI_IMGLOSSARY_PERPAGE", "Кол-во записей на странице (для администратора):");
define("_MI_IMGLOSSARY_PERPAGEDSC", "Количество записей, которое будет показываться за один разадминистратору при отображении таблицы активных записей.");

define("_MI_IMGLOSSARY_PERPAGEINDEX", "Кол-во записей на странице (для пользователя):");
define("_MI_IMGLOSSARY_PERPAGEINDEXDSC", "Количество записей, которое будет показываться пользователям на каждой странице модуля.");

define("_MI_IMGLOSSARY_AUTOAPPROVE", "Утверждать записи автоматически?");
define("_MI_IMGLOSSARY_AUTOAPPROVEDSC", "Если установлено <em>Да</em>, то размещенные записи будут автоматически публиковаться без вмешательства администратора.");

define("_MI_IMGLOSSARY_MULTICATS", "Имеются ли категории?");
define("_MI_IMGLOSSARY_MULTICATSDSC", "Если установлено <em>Да</em>, Вы получите возможность иметь категории в Вашем глоссарии. Если установлено <em>Нет</em>, Вы автоматически будете иметь одну категорию.");

define("_MI_IMGLOSSARY_CATSINMENU","Показывать категории в меню?"); 
define("_MI_IMGLOSSARY_CATSINMENUDSC","Если установлено <em>Да</em>, то ссылки на категории появятся в главном меню."); 

define("_MI_IMGLOSSARY_CATSPERINDEX","Кол-во категорий на странице (для пользователя):"); 
define("_MI_IMGLOSSARY_CATSPERINDEXDSC","Определяется какое количество категорий будет показываться на индексной странице."); 

define("_MI_IMGLOSSARY_ALLOWADMINHITS", "Включать посещения администратора в счетчик?");
define("_MI_IMGLOSSARY_ALLOWADMINHITSDSC", "Если установлено <em>Да</em>, счетчик посещаемости записи будет увеличиваться при каждом визите администратора.");

define("_MI_IMGLOSSARY_MAILTOADMIN", "Отсылать email администратору о каждом новом размещении?");  
define("_MI_IMGLOSSARY_MAILTOADMINDSC", "Если установлено <em>Да</em>, менеджер будет получать email с оповещением о каждой размещенной записи."); 
 
define("_MI_IMGLOSSARY_RANDOMLENGTH", "Длина строки в произвольных определениях:");  
define("_MI_IMGLOSSARY_RANDOMLENGTHDSC", "Какое количество символов Вы желаете показывать в боксах случайных терминов, на индексной странице и в блоке? (По умолчанию: 500)");

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
define("_MI_IMGLOSSARY_ENTRIESTOP", "Популярные термины");

// imGlossary - version 1.00
define("_MI_IMGLOSSARY_SORTCATS", "Сортировать категории по:");
define("_MI_IMGLOSSARY_SORTCATSDSC", "Выбор порядка сортировки категорий.");
define("_MI_IMGLOSSARY_TITLE", "Заголовок");
define("_MI_IMGLOSSARY_WEIGHT", "Вес");
define("_MI_IMGLOSSARY_ADMENU7", "Размещения");
define("_MI_IMGLOSSARY_SHOWSUBMITTER", "Показывать разместившего в каждой записи?");
define("_MI_IMGLOSSARY_SHOWSUBMITTERDSC", "Выберите <em>Да</em> для показа разместившего запись.");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKS","Показывать социальные закладки в каждой записи?");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKSDSC", "Выберите <em>Да</em>, чтобы сдклать видимыми иконки социальных закладок в каждой записи .");
define("_MI_IMGLOSSARY_SEARCHCOLOR", "Цвет фона терминов при поиске:");
define("_MI_IMGLOSSARY_SEARCHCOLORDSC", "Выберите цвет фона, для выделения искомого термина. По умолчанию: <span style='background-color: #FFFF00;'>&nbsp;#FFFF00&nbsp;</span>");
define("_MI_IMGLOSSARY_CAPTCHA", "Использовать captcha в формах?");
define("_MI_IMGLOSSARY_CAPTCHADSC", "Выберите <em>Да</em> для использования captcha в формах запросов.<br />По умолчанию: <em>Да</em>");
define("_MI_IMGLOSSARY_SHOWCENTER", "Показать центральные блоки?");
define("_MI_IMGLOSSARY_SHOWCENTERDSC", "Выберите <em>Да</em> для отображния тройки центральных блоков: Новейшие, Популярные, Поиск на индексной странице.<br />Выберите <em>Нет</em> для замещения этих трех блоков блоком поиска.");
define("_MI_IMGLOSSARY_SHOWRANDOM", "Показать блок случайных терминов?");
define("_MI_IMGLOSSARY_SHOWRANDOMDSC", "Выберите <em>Да</em> для отображения блока произвольных терминов на индексной странице.");
define('_MI_IMGLOSSARY_EDITORADMIN', "Редактор для администратора:");
define('_MI_IMGLOSSARY_EDITORADMINDSC', "Выберите редактор, используемый администратором.<br />В меню Установки -> Установки основные выберите 'Редактор по умолчанию' <em>dhtmltextarea</em>.");
define('_MI_IMGLOSSARY_EDITORUSER', "Редактор для пользователя:");
define('_MI_IMGLOSSARY_EDITORUSERDSC', "Выберите редактор, коотрый будет доступен пользователям.<br />В меню Установки -> Установки основные выберите 'Редактор по умолчанию' <em>dhtmltextarea</em>.");
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
define( '_MI_IMGLOSSARY_FEEDSTOTAL', 'Количество терминов RSS канале:' );
define( '_MI_IMGLOSSARY_FEEDSTOTALDSC', 'По умолчанию: <em>15</em>' );
?>