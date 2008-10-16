<?php
/**
 * $Id: about.php
 * Module: imGlossary - a multicategory glossary 
 * Author: McDonald
 * Licence: GNU
 */

include_once 'admin_header.php';

include_once ICMS_ROOT_PATH . '/kernel/icmsmoduleabout.php';

$aboutObj = new IcmsModuleAbout();
$aboutObj -> render();

?>