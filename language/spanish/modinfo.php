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
define("_MI_IMGLOSSARY_MD_DESC", "Un glosario multicategoría");

// Sub menus in main menu block
define("_MI_IMGLOSSARY_SUB_SMNAME1", "Enviar definición");
define("_MI_IMGLOSSARY_SUB_SMNAME2", "Pedir definición");
define("_MI_IMGLOSSARY_SUB_SMNAME3", "Buscar definición");

define("_MI_IMGLOSSARY_RANDOMTERM", "Término al azar");

// A brief description of this module
define("_MI_IMGLOSSARY_ALLOWSUBMIT", "¿Pueden los usuarios enviar definiciones?");
define("_MI_IMGLOSSARY_ALLOWSUBMITDSC", "Si selecciona 'Sí', los usuarios tendrán acceso al formulario de envío");

define("_MI_IMGLOSSARY_ANONSUBMIT", "Pueden los invitados enviar definiciones?");
define("_MI_IMGLOSSARY_ANONSUBMITDSC", "Si selecciona 'Sí', los invitados tendrán acceso al formulario de envío");

define("_MI_IMGLOSSARY_DATEFORMAT", "¿En qué formato debe verse la fecha?");
define("_MI_IMGLOSSARY_DATEFORMATDSC", "Use la parte final de language/english/global.php para elegir un estilo. Ejemplo: 'd-M-Y H:i' significa '23-Mar-2004 22:35'");

define("_MI_IMGLOSSARY_PERPAGE", "¿Número de definiciones por página (Administrador)?");
define("_MI_IMGLOSSARY_PERPAGEDSC", "Número de definiciones que se verán a la vez en la tabla que muestra definiciones en la sección de administración.");

define("_MI_IMGLOSSARY_PERPAGEINDEX", "¿Número de definiciones por página (Usuario)?");
define("_MI_IMGLOSSARY_PERPAGEINDEXDSC", "Número de definiciones que se mostrarán en cada página del módulo a los usuarios de la página.");

define("_MI_IMGLOSSARY_AUTOAPPROVE", "¿Aprobar definiciones automáticamente?");
define("_MI_IMGLOSSARY_AUTOAPPROVEDSC", "Si selecciona 'Sí', ImpressCMS publicará las definiciones enviadas sin intervención del administrador.");

define("_MI_IMGLOSSARY_MULTICATS", "¿Quiere tener categorías?");
define("_MI_IMGLOSSARY_MULTICATSDSC", "Si selecciona 'Sí', podrá tener categorías en su glosario o bien varios glosarios distintos. Si se define como 'No', tendrá una sola categoría automática.");

define("_MI_IMGLOSSARY_CATSINMENU","¿Deben mostrarse las categorías en el menú?"); 
define("_MI_IMGLOSSARY_CATSINMENUDSC","Si selecciona 'Sí', habrá enlaces a las categorías en el menú principal."); 

define("_MI_IMGLOSSARY_CATSPERINDEX","¿Categorías por página (Usuarios)?"); 
define("_MI_IMGLOSSARY_CATSPERINDEXDSC","Esto definirá cuántas categorías mostrar en la página índice de categorías."); 

define("_MI_IMGLOSSARY_ALLOWADMINHITS", "¿Se contarán también las visitas del administrador?");
define("_MI_IMGLOSSARY_ALLOWADMINHITSDSC", "Si selecciona 'Sí', el contador se incrementará para cada definición cuando la visite el administrador.");

define("_MI_IMGLOSSARY_MAILTOADMIN", "¿Enviar correo al administrador en cada nuevo envío?");  
define("_MI_IMGLOSSARY_MAILTOADMINDSC", "Si selecciona 'Sí', el administrador recibirá un e-mail para cada definición que se envíe al sitio.");  

define("_MI_IMGLOSSARY_RANDOMLENGTH", "¿Cuántos caracteres mostrar en términos al azar?");  
define("_MI_IMGLOSSARY_RANDOMLENGTHDSC", "¿Cuántos caracteres quiere mostrar en los bloques de términos al azar, tanto en la página inicial del módulo como en el bloque? (Por defecto: 150)");

define("_MI_IMGLOSSARY_LINKTERMS", "¿Mostrar enlaces a otras definiciones del glosario en cada definición?");  
define("_MI_IMGLOSSARY_LINKTERMSDSC", "Si selecciona 'Sí', automáticamente creará enlaces en sus definiciones para aquellos términos que ya tenga definidos en sus glosarios.");

// Names of admin menu items
define("_MI_IMGLOSSARY_ADMENU1", "Índice");
define("_MI_IMGLOSSARY_ADMENU2", "Categorías");
define("_MI_IMGLOSSARY_ADMENU3", "Definiciones");
define("_MI_IMGLOSSARY_ADMENU4", "Bloques");
define("_MI_IMGLOSSARY_ADMENU5", "Ir al módulo");
//mondarse
define("_MI_IMGLOSSARY_ADMENU6", "Importar");

//Names of Blocks and Block information
define("_MI_IMGLOSSARY_ENTRIESNEW", "Términos más nuevos");
define("_MI_IMGLOSSARY_ENTRIESTOP", "Términos más leídos");

// imGlossary - version 1.00
define("_MI_IMGLOSSARY_SORTCATS", "Ordenar categorías por:");
define("_MI_IMGLOSSARY_SORTCATSDSC", "Seleccione la forma en la que las categorías son ordenadas.");
define("_MI_IMGLOSSARY_TITLE", "Título");
define("_MI_IMGLOSSARY_WEIGHT", "Importancia");
define("_MI_IMGLOSSARY_ADMENU7", "Envíos");
define("_MI_IMGLOSSARY_SHOWSUBMITTER", "¿Mostrar quién envió en cada definición o término?");
define("_MI_IMGLOSSARY_SHOWSUBMITTERDSC", "Seleccione <em>Sí</em> para mostrar el nombre de la persona que envió la definición o término.");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKS","¿Mostrar Marcadores Sociales en cada elemento?");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKSDSC", "Seleccione <em>Sí</em> para mostrar los iconos de los Marcadores sociales en cada uno de los elementos.");
define("_MI_IMGLOSSARY_SEARCHCOLORDSC", "Enter the colour to use as background for search terms. Default: <span style='background-color: #FFFF00;'>&nbsp;#FFFF00&nbsp;</span>");
define("_MI_IMGLOSSARY_CAPTCHA", "Use captcha in submit and request forms?");
define("_MI_IMGLOSSARY_CAPTCHADSC", "Select <em>Yes</em> to use captcha in the submit and request form.<br />Default: <em>Yes</em>");
define("_MI_IMGLOSSARY_SHOWCENTER", "Display center blocks?");
define("_MI_IMGLOSSARY_SHOWCENTERDSC", "Select <em>Yes</em> to display the three center blocks Recent entries, Popular entries and Search on the index page.<br />Select <em>No</em> to replace these 3 blocks by a Search block.");
define("_MI_IMGLOSSARY_SHOWRANDOM", "Display Random term block?");
define("_MI_IMGLOSSARY_SHOWRANDOMDSC", "Select <em>Yes</em> to display the Random term block on the index page.");
?>