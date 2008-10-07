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
define("_MI_WB_MD_DESC", "Un glosario multicategor�a");

// Sub menus in main menu block
define("_MI_WB_SUB_SMNAME1", "Enviar definici�n");
define("_MI_WB_SUB_SMNAME2", "Pedir definici�n");
define("_MI_WB_SUB_SMNAME3", "Buscar definici�n");

define("_MI_WB_RANDOMTERM", "T�rmino al azar");

// A brief description of this module
define("_MI_WB_ALLOWSUBMIT", "�Pueden los usuarios enviar definiciones?");
define("_MI_WB_ALLOWSUBMITDSC", "Si selecciona 'S�', los usuarios tendr�n acceso al formulario de env�o");

define("_MI_WB_ANONSUBMIT", "Pueden los invitados enviar definiciones?");
define("_MI_WB_ANONSUBMITDSC", "Si selecciona 'S�', los invitados tendr�n acceso al formulario de env�o");

define("_MI_WB_DATEFORMAT", "�En qu� formato debe verse la fecha?");
define("_MI_WB_DATEFORMATDSC", "Use la parte final de language/english/global.php para elegir un estilo. Ejemplo: 'd-M-Y H:i' significa '23-Mar-2004 22:35'");

define("_MI_WB_PERPAGE", "�N�mero de definiciones por p�gina (Administrador)?");
define("_MI_WB_PERPAGEDSC", "N�mero de definiciones que se ver�n a la vez en la tabla que muestra definiciones en la secci�n de administraci�n.");

define("_MI_WB_PERPAGEINDEX", "�N�mero de definiciones por p�gina (Usuario)?");
define("_MI_WB_PERPAGEINDEXDSC", "N�mero de definiciones que se mostrar�n en cada p�gina del m�dulo a los usuarios de la p�gina.");

define("_MI_WB_AUTOAPPROVE", "�Aprobar definiciones autom�ticamente?");
define("_MI_WB_AUTOAPPROVEDSC", "Si selecciona 'S�', ImpressCMS publicar� las definiciones enviadas sin intervenci�n del administrador.");

define("_MI_WB_MULTICATS", "�Quiere tener categor�as?");
define("_MI_WB_MULTICATSDSC", "Si selecciona 'S�', podr� tener categor�as en su glosario o bien varios glosarios distintos. Si se define como 'No', tendr� una sola categor�a autom�tica.");

define("_MI_WB_CATSINMENU","�Deben mostrarse las categor�as en el men�?"); 
define("_MI_WB_CATSINMENUDSC","Si selecciona 'S�', habr� enlaces a las categor�as en el men� principal."); 

define("_MI_WB_CATSPERINDEX","�Categor�as por p�gina (Usuarios)?"); 
define("_MI_WB_CATSPERINDEXDSC","Esto definir� cu�ntas categor�as mostrar en la p�gina �ndice de categor�as."); 

define("_MI_WB_ALLOWADMINHITS", "�Se contar�n tambi�n las visitas del administrador?");
define("_MI_WB_ALLOWADMINHITSDSC", "Si selecciona 'S�', el contador se incrementar� para cada definici�n cuando la visite el administrador.");

define("_MI_WB_MAILTOADMIN", "�Enviar correo al administrador en cada nuevo env�o?");  
define("_MI_WB_MAILTOADMINDSC", "Si selecciona 'S�', el administrador recibir� un e-mail para cada definici�n que se env�e al sitio.");  

define("_MI_WB_RANDOMLENGTH", "�Cu�ntos caracteres mostrar en t�rminos al azar?");  
define("_MI_WB_RANDOMLENGTHDSC", "�Cu�ntos caracteres quiere mostrar en los bloques de t�rminos al azar, tanto en la p�gina inicial del m�dulo como en el bloque? (Por defecto: 150)");

define("_MI_WB_LINKTERMS", "�Mostrar enlaces a otras definiciones del glosario en cada definici�n?");  
define("_MI_WB_LINKTERMSDSC", "Si selecciona 'S�', autom�ticamente crear� enlaces en sus definiciones para aquellos t�rminos que ya tenga definidos en sus glosarios.");

// Names of admin menu items
define("_MI_WB_ADMENU1", "�ndice");
define("_MI_WB_ADMENU2", "Categor�as");
define("_MI_WB_ADMENU3", "Definiciones");
define("_MI_WB_ADMENU4", "Bloques");
define("_MI_WB_ADMENU5", "Ir al m�dulo");
//mondarse
define("_MI_WB_ADMENU6", "Importar");

//Names of Blocks and Block information
define("_MI_WB_ENTRIESNEW", "T�rminos m�s nuevos");
define("_MI_WB_ENTRIESTOP", "T�rminos m�s le�dos");

?>