<?php
/**
 * $Id: main.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 * Translation: Language portuguesebr - GibaPhp - http://br.impresscms.org
 */

// Module Info
// The name of this module
global $xoopsModule;
define("_MI_IMGLOSSARY_MD_NAME", "imGlossary");

// A brief description of this module
define("_MI_IMGLOSSARY_MD_DESC", "Um Glossário com Multiplas Categorias");

// Sub menus in main menu block
define("_MI_IMGLOSSARY_SUB_SMNAME1", "Enviar uma Definição");
define("_MI_IMGLOSSARY_SUB_SMNAME2", "Solicitar uma definição");
define("_MI_IMGLOSSARY_SUB_SMNAME3", "Procurar uma definição");

define("_MI_IMGLOSSARY_RANDOMTERM", "Termo Randômico");

// A brief description of this module
define("_MI_IMGLOSSARY_ALLOWSUBMIT", "Usuários podem enviar termos?");
define("_MI_IMGLOSSARY_ALLOWSUBMITDSC", "Se escolher <em><b>Sim</b></em>, os usuários terão acesso a um formulário para apresentar novos termos no glossário");

define("_MI_IMGLOSSARY_ANONSUBMIT", "Visitantes/Anônimos podem apresentar novos termos?");
define("_MI_IMGLOSSARY_ANONSUBMITDSC", "Se escolher <em><b>Sim</b></em>, visitantes/anônimos irão ter acesso a um formulário para o envio de novos termos no glossário");

define("_MI_IMGLOSSARY_DATEFORMAT", "Em que formato deverá mostrar a data?");
define("_MI_IMGLOSSARY_DATEFORMATDSC", "Use a parte final da language/english/global.php para selecionar um tipo de estilo de data.<br />Veja no <a href='http://jp.php.net/manual/pt_BR/function.date.php' target='_blank'>Manual do PHP</a>");

define("_MI_IMGLOSSARY_PERPAGE", "Qual o Número de termos por página (no lado do Admin)?");
define("_MI_IMGLOSSARY_PERPAGEDSC", "Número de <b>termos</b> que será mostrado de uma vez na tabela que exibe as entradas ativas no lado do admin.");

define("_MI_IMGLOSSARY_PERPAGEINDEX", "Qual o Número de <b>termos</b> por página (No lado do Usuário)?");
define("_MI_IMGLOSSARY_PERPAGEINDEXDSC", "Informe o Número de termos que será mostrado em cada página no lado do usuário na parte lateral do módulo.");

define("_MI_IMGLOSSARY_AUTOAPPROVE", "Aprovar automaticamente termos?");
define("_MI_IMGLOSSARY_AUTOAPPROVEDSC", "Se responder com <em><b>Sim</b></em>, Será atualizada e publicada a nova informação dentro do ImpressCMS sem a intervenção do admin deste módulo.");

define("_MI_IMGLOSSARY_MULTICATS", "Você quer ter categorias neste glossário?");
define("_MI_IMGLOSSARY_MULTICATSDSC", "Se escolheu a opção <em><b>Sim</b></em>, permitirá que seja montado categorias no seu glossário.  Se ficar definido como não, vai ter uma única categoria automáticamente para todos os seus termos.");

define("_MI_IMGLOSSARY_CATSINMENU","As categorias devem ser mostradas no menu?"); 
define("_MI_IMGLOSSARY_CATSINMENUDSC","Se informar <em><b>Sim</b></em> irá receber em seu menu principal todas as categorias que existirem dentro de seu módulo de glossário."); 

define("_MI_IMGLOSSARY_CATSPERINDEX","Número de categorias por página (Lado do Usuário)?"); 
define("_MI_IMGLOSSARY_CATSPERINDEXDSC","Isto irá definir quantas categorias vão ser mostradas na página principal."); 

define("_MI_IMGLOSSARY_ALLOWADMINHITS", "Irá incluir o admin na contagem de acessos?");
define("_MI_IMGLOSSARY_ALLOWADMINHITSDSC", "Se escolher esta opção com <em><b>Sim</b></em>, aumentará o contador para cada novo acesso do admin ao fazer visitas. Normalmente o Admin deve ser deixado como não.");

define("_MI_IMGLOSSARY_MAILTOADMIN", "Enviar e-mail para o admin a cada novo termo enviado?");  
define("_MI_IMGLOSSARY_MAILTOADMINDSC", "Se marcar esta opção com <em><b>Sim</b></em>, o gestor deste módulo irá receber um e-mail a cada novo termo que for apresentado."); 
 
define("_MI_IMGLOSSARY_RANDOMLENGTH", "Qual o Comprimento de caracteres mostrar no bloco de definições aleatórias?");  
define("_MI_IMGLOSSARY_RANDOMLENGTHDSC", "Qual a quantidade de caracteres que você deseja mostrar no bloco de termos aleatórios, tanto na página principal e no bloco? (O Padrão é: 500)");

define("_MI_IMGLOSSARY_LINKTERMS", "Mostrar link de outros termos nas definições do glossário?");  
define("_MI_IMGLOSSARY_LINKTERMSDSC", "Se responder <em><b>Sim</b></em>, imGlossary irá vincular automaticamente estas definições em seus termos caso estes já existam em seu glossário.");

// Names of admin menu items
define("_MI_IMGLOSSARY_ADMENU1", "Principal");
define("_MI_IMGLOSSARY_ADMENU2", "Incluir Categoria");
define("_MI_IMGLOSSARY_ADMENU3", "Incluir Termo");
define("_MI_IMGLOSSARY_ADMENU4", "Blocos");
define("_MI_IMGLOSSARY_ADMENU5", "Ir ao Módulo");
//mondarse
define("_MI_IMGLOSSARY_ADMENU6", "Importar");

//Names of Blocks and Block information
define("_MI_IMGLOSSARY_ENTRIESNEW", "Últimos Termos");
define("_MI_IMGLOSSARY_ENTRIESTOP", "Termos mais visitados");

// imGlossary - version 1.00
define("_MI_IMGLOSSARY_SORTCATS", "Ordenar categorias por:");
define("_MI_IMGLOSSARY_SORTCATSDSC", "Escolha a forma como as categorias devem ser ordenadas.");
define("_MI_IMGLOSSARY_TITLE", "Título");
define("_MI_IMGLOSSARY_WEIGHT", "Peso");
define("_MI_IMGLOSSARY_ADMENU7", "Participações");
define("_MI_IMGLOSSARY_SHOWSUBMITTER", "Mostrar quem enviou o Termo?");
define("_MI_IMGLOSSARY_SHOWSUBMITTERDSC", "Escolha <em><b>Sim</b></em> para mostrar quem foi o responsável por cada novo termo enviado.");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKS","Mostrar um BookMark Social em cada termo?");
define("_MI_IMGLOSSARY_SHOWSBOOKMARKSDSC", "Escolha <em><b>Sim</b></em> para ter um ícone de BookMark Social visível em cada termo.");
define("_MI_IMGLOSSARY_SEARCHCOLOR", "Cor de fundo para os termos da pesquisa:");
define("_MI_IMGLOSSARY_SEARCHCOLORDSC", "Introduza a cor de fundo para usar como termos de pesquisa. Padrão: <span style='background-color: #FFFF00;'>&nbsp;#FFFF00&nbsp;</span>");
define("_MI_IMGLOSSARY_CAPTCHA", "Usar captcha no formulário de envio de novos termos?");
define("_MI_IMGLOSSARY_CAPTCHADSC", "Escolha <em><b>Sim</b></em> para usar o captcha no momento em que está digitando o novo termo no formulário de solicitação.<br /><b>Padrão:</b> <em>Sim</em>");
define("_MI_IMGLOSSARY_SHOWCENTER", "Mostrar nos Blocos do Centro?");
define("_MI_IMGLOSSARY_SHOWCENTERDSC", "Escolha <em><b>Sim</b></em> para apresentar os três blocos no centro dos termos recentes, e as mais Populares definições no bloco de  Pesquisa na página principal. <br />Escolha <em><b>Não</b></em> para substituir esses 3 blocos por um bloco de Pesquisa apenas.");
define("_MI_IMGLOSSARY_SHOWRANDOM", "Mostrar o bloco de termos aleatório ?");
define("_MI_IMGLOSSARY_SHOWRANDOMDSC", "Escolha <em><b>Sim</b></em> para mostrar os termos de forma aleatória no bloco de apresentação na página principal deste módulo.");
define('_MI_IMGLOSSARY_EDITORADMIN', "Editor para uso (No Admin):");
define('_MI_IMGLOSSARY_EDITORADMINDSC', "Selecione o editor que será utilizado na sua administração do módulo. <br /> Em Preferências -> Configurações Gerais escolha 'Editor Padrão' para <em><b>dhtmltextarea</b></em>.");
define('_MI_IMGLOSSARY_EDITORUSER', "Editor para uso (Lado do usuário):");
define('_MI_IMGLOSSARY_EDITORUSERDSC', "Selecione o editor que será utilizado na sua administração do módulo. <br /> Em Preferências -> Configurações Gerais escolha 'Editor Padrão' para <em><b>dhtmltextarea</b></em>.");
define("_MI_IMGLOSSARY_FORM_DHTML", "DHTML");
define("_MI_IMGLOSSARY_FORM_COMPACT", "Compacto");
define("_MI_IMGLOSSARY_FORM_HTMLAREA", "Editor HtmlArea");
define("_MI_IMGLOSSARY_FORM_FCK", "Editor FCK");
define("_MI_IMGLOSSARY_FORM_KOIVI", "Editor Koivi");
define("_MI_IMGLOSSARY_FORM_INBETWEEN", "Inbetween");
define("_MI_IMGLOSSARY_FORM_TINYEDITOR", "TinyEditor");
define("_MI_IMGLOSSARY_FORM_TINYMCE", "TinyMCE");
define("_MI_IMGLOSSARY_FORM_DHTMLEXT", "DHTML Extendido");
?>