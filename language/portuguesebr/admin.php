<?php
/**
 * $Id: admin.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
 
define("_AM_IMGLOSSARY_ACTION", "Ação");
define("_AM_IMGLOSSARY_ADMINCATMNGMT", "Editar Categoria");
define("_AM_IMGLOSSARY_ADMINENTRYMNGMT", "Editar Entrada");
define("_AM_IMGLOSSARY_ALLOWCOMMENTS", "Pode comentar o Termo?");
define("_AM_IMGLOSSARY_ANON", "Anônimos");
define("_AM_IMGLOSSARY_AUTHENTRY", "Autorizado envio");
define("_AM_IMGLOSSARY_AUTHOR", "Autor");
define("_AM_IMGLOSSARY_AUTHORIZE", "Autorizar");
define("_AM_IMGLOSSARY_BACK2IDX", "Cancelado. Levando você de volta para o índice");
define("_AM_IMGLOSSARY_BLOCK", " Incluir este termo no bloco?");
define("_AM_IMGLOSSARY_BLOCKS", "Blocos");
define("_AM_IMGLOSSARY_BREAKS", " Usar conversão linebreak?");
define("_AM_IMGLOSSARY_CANCEL", "Cancelar");
define("_AM_IMGLOSSARY_CATCREATED", "Nova categoria foi criada e salva!");
define("_AM_IMGLOSSARY_CATDESCRIPT", "Descrição da Categoria");
define("_AM_IMGLOSSARY_CATIMAGE", "Imagem da Categoria");
define("_AM_IMGLOSSARY_CATIMAGEUPLOAD", " Enviar imagem da categoria");
define("_AM_IMGLOSSARY_CATISDELETED", "Categoria %s foi apagada");
define("_AM_IMGLOSSARY_CATMODIFIED", "A Categoria escolhida foi modificada e salva!");
define("_AM_IMGLOSSARY_CATNAME", "Nome da Categoria");
define("_AM_IMGLOSSARY_CATPOSIT", "Posição da Categoria");
define("_AM_IMGLOSSARY_CATS", "Categorias");
define("_AM_IMGLOSSARY_CATSHEADER", "Edição da Categoria");
define("_AM_IMGLOSSARY_CLEAR", "Limpar");
define("_AM_IMGLOSSARY_CREATE", "Criar");
define("_AM_IMGLOSSARY_CREATECAT", "Incluir categoria");
define("_AM_IMGLOSSARY_CREATEENTRY", "Incluir Termo");
define("_AM_IMGLOSSARY_CREATEIN", "Criar na categoria:");
define("_AM_IMGLOSSARY_DELETE", "Apagar");
define("_AM_IMGLOSSARY_DELETECAT", "Apagar categoria");
define("_AM_IMGLOSSARY_DELETEENTRY", "Apagar Termo");
define("_AM_IMGLOSSARY_DELETESUBM", "Apagar Termo enviado");
define("_AM_IMGLOSSARY_DELETETHISCAT", "Tem certeza de que deseja apagar esta categoria?");
define("_AM_IMGLOSSARY_DELETETHISENTRY", "Apagar este Termo?");
define("_AM_IMGLOSSARY_DESCRIP", "Descrição da Categoria");
define("_AM_IMGLOSSARY_DOHTML", " Habilitar Tags HTML");
define("_AM_IMGLOSSARY_DOSMILEY", " Habilitar emotions");
define("_AM_IMGLOSSARY_DOXCODE", " Habilitar xCode");
define("_AM_IMGLOSSARY_EDITCAT", "Editar categoria");
define("_AM_IMGLOSSARY_EDITENTRY", "Editar termo");
define("_AM_IMGLOSSARY_EDITSUBM", "Editar novo envio");
define("_AM_IMGLOSSARY_ENTRIES", "Termos");
define("_AM_IMGLOSSARY_ENTRYAUTHORIZED", "O termo foi autorizado.");
define("_AM_IMGLOSSARY_ENTRYCATNAME", "Nome da Categoria");
define("_AM_IMGLOSSARY_ENTRYCREATED", "Criado");
define("_AM_IMGLOSSARY_ENTRYCREATEDOK", "O termo foi criado corretamente!");
define("_AM_IMGLOSSARY_ENTRYDEF", "Definição");
define("_AM_IMGLOSSARY_ENTRYID", "Id");
define("_AM_IMGLOSSARY_ENTRYISDELETED", "O termo %s foi apagado.");
define("_AM_IMGLOSSARY_ENTRYISOFF", "Termo está offline");
define("_AM_IMGLOSSARY_ENTRYISON", "Termo está online");
define("_AM_IMGLOSSARY_ENTRYMODIFIED", "O artigo foi modificado corretamente!");
define("_AM_IMGLOSSARY_ENTRYNOTCREATED", "Não foi possível criar este termo!");
define("_AM_IMGLOSSARY_ENTRYNOTUPDATED", "Não foi possível atualizar este termo!");
define("_AM_IMGLOSSARY_ENTRYREFERENCE", "Referência<span style='font-size: xx-small; font-weight: normal; display: block;'>(Informe aqui as fontes desta sua<br />definição, tais como um livro, um site, uma empresa, <br />artigo, ou até mesmo uma pessoa.)</span>");
define("_AM_IMGLOSSARY_ENTRYTERM", "Termo");
define("_AM_IMGLOSSARY_ENTRYURL", "Site Relacionado<span style='font-size: xx-small; font-weight: normal; display: block;'>(Digite um URL válido com<br />ou sem o prefixo HTTP.)</span>");
define("_AM_IMGLOSSARY_FILEEXISTS", "Um arquivo com esse nome já existe no servidor. Por favor escolha outro!");
define("_AM_IMGLOSSARY_GOMOD", "Ir ao módulo");
define("_AM_IMGLOSSARY_HELP", "Ajuda");
define("_AM_IMGLOSSARY_ID", "Id");
define("_AM_IMGLOSSARY_INDEX", "Principal");
define("_AM_IMGLOSSARY_INVENTORY", "Sumário dos Items");
define("_AM_IMGLOSSARY_MODCAT", "Modificar a categoria existente");
define("_AM_IMGLOSSARY_MODADMIN", " Admin do Módulo: ");
define("_AM_IMGLOSSARY_MODENTRY", "Modificar um termo");
define("_AM_IMGLOSSARY_MODIFY", "Modificar");
define("_AM_IMGLOSSARY_MODIFYCAT", "Modificar categoria");
define("_AM_IMGLOSSARY_MODIFYTHISCAT", "Modificar esta categoria?");
define("_AM_IMGLOSSARY_MODULEHEADMULTI", "Termos | Categorias | Envios | Solicitações");
define("_AM_IMGLOSSARY_MODULEHEADSINGLE", "Termos | Envios | Solicitações");
define("_AM_IMGLOSSARY_NEEDONECOLUMN", "Para introduzir um novo termo, você precisa ter pelo menos uma categoria.");
define("_AM_IMGLOSSARY_NEWCAT", "Criar categoria");
define("_AM_IMGLOSSARY_NEWENTRY", "Criar termo");
define("_AM_IMGLOSSARY_NO", "Não");
define("_AM_IMGLOSSARY_NOCATS", "Nenhuma categoria para mostrar");
define("_AM_IMGLOSSARY_NOCOLTOEDIT", "Não existem colunas para editar!");
define("_AM_IMGLOSSARY_NOPERMSSET", "Não é possível definir permissões: Não há colunas criadas ainda!");
define("_AM_IMGLOSSARY_NOREQSYET", "Não existe atualmente qualquer termo indefinido ou solicitado.");
define("_AM_IMGLOSSARY_NOSUBMISSYET", "Não existe atualmente qualquer termo aguardando por aprovação.");
define("_AM_IMGLOSSARY_NOTERMS", "Nenhum termo para mostrar");
define("_AM_IMGLOSSARY_NOTUPDATED", "Houve um erro ao atualizar o banco de dados!");
define("_AM_IMGLOSSARY_OPTIONS", "Opções");
define("_AM_IMGLOSSARY_OPTS", "Preferências");
define("_AM_IMGLOSSARY_SHOWCATS", "Categorias");
define("_AM_IMGLOSSARY_SHOWENTRIES", "Termos");
define("_AM_IMGLOSSARY_SHOWREQUESTS", "Solicitações");
define("_AM_IMGLOSSARY_SHOWSUBMISSIONS", "Submissões");
define("_AM_IMGLOSSARY_SINGLECAT", "The module is defined to have a single category. You have no reason to be here.");
define("_AM_IMGLOSSARY_STATUS", "Status");
define("_AM_IMGLOSSARY_SUBMITS", "Envios");
define("_AM_IMGLOSSARY_SUBMITTER", "Enviado por");
define("_AM_IMGLOSSARY_SWITCHOFFLINE", " Deixar offline?");
define("_AM_IMGLOSSARY_TOTALCATS", "Categorias disponíveis: ");
define("_AM_IMGLOSSARY_TOTALENTRIES", "Termos Publicados: ");
define("_AM_IMGLOSSARY_TOTALREQ", "Termos Solicitados: ");
define("_AM_IMGLOSSARY_TOTALSUBM", "Termos Apresentados: ");
define("_AM_IMGLOSSARY_UNIQUE", "Categoria Única");
define("_AM_IMGLOSSARY_WEIGHT", "Peso");
define("_AM_IMGLOSSARY_WRITEHERE", "Por favor escreva aqui a definição.");
define("_AM_IMGLOSSARY_YES", "Sim");
//mondarse
define("_AM_IMGLOSSARY_IMPORT", "Importar");
define("_AM_IMGLOSSARY_IMPORTWARN", "Aviso!!:<br />Faça um Backup do seu banco de dados antes de continuar. O script de Importação é uma versão alfa, e pode causar corrupção/perda de dados.");

// Taken from importdictionary091.php (McDonald)
define("_AM_IMGLOSSARY_IMPDICT_01","Base de dados para importação não existe ou está vazio!");
define("_AM_IMGLOSSARY_IMPDICT_02","imGlossary script para Importar termos");
define("_AM_IMGLOSSARY_IMPDICT_03","Importar de um Dicionário Versão 0.92");
define("_AM_IMGLOSSARY_IMPDICT_04","Erro: #");
define("_AM_IMGLOSSARY_IMPDICT_05","ID do Módulo de Dicionário: ");
define("_AM_IMGLOSSARY_IMPDICT_06","ID do módulo imGlossary: ");
define("_AM_IMGLOSSARY_IMPDICT_07","Erro ao transferir Comentários ao Dicionário do módulo imGlossary.");
define("_AM_IMGLOSSARY_IMPDICT_08","Comentários foram movidos com sucesso a partir do Dicionário do imGlossary");
define("_AM_IMGLOSSARY_IMPDICT_09","Incorretamente: ");
define("_AM_IMGLOSSARY_IMPDICT_10","Transformados: ");
define("_AM_IMGLOSSARY_IMPDICT_11","Voltar ao Admin");

define("_AM_IMGLOSSARY_NOCOLEXISTS", "Infelizmente, não há categorias definidas ainda. <br /> Entre em contato com o administrador do site e comunique sobre este problema."); // This was originally in the main.php file

// imGlossary v1.00
define("_AM_IMGLOSSARY_SHOWOFFLINE", "Offline");
define("_AM_IMGLOSSARY_COMMENTS", "Comentários");
define("_AM_IMGLOSSARY_ABOUT", "About");
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