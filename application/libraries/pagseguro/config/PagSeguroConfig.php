<?php if (!defined('ALLOW_PAGSEGURO_CONFIG')) { die('No direct script access allowed'); }
/*
************************************************************************
PagSeguro Config File
************************************************************************
*/

$PagSeguroConfig = array();

$PagSeguroConfig['environment'] = array();
$PagSeguroConfig['environment']['environment'] = "production";

$PagSeguroConfig['credentials'] = array();
$PagSeguroConfig['credentials']['email'] = PAGSEGURO_LOGIN;
$PagSeguroConfig['credentials']['token'] = PAGSEGURO_TOKEN;

$PagSeguroConfig['application'] = array();
$PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = array();
$PagSeguroConfig['log']['active'] = FALSE;
$PagSeguroConfig['log']['fileLocation'] = "";

?>