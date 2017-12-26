<?php
//*************************************************************************
//*** Configuração do Banco de Dados                                    ***
//*************************************************************************
require_once 'configuracao_banco.php';

define('servidor', 'producao');

$dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$dir = mb_strtolower($dir);

define('url', 'http://' . mb_strtolower($_SERVER['HTTP_HOST']) . '/' . $dir);
define('url_pai', 'http://' . mb_strtolower($_SERVER['HTTP_HOST']));
define('path_fisico', mb_strtolower($_SERVER['DOCUMENT_ROOT']) . $dir);

/**
 * IP ou nome DNS do servidor LDAP.
 *
 * @access public
 * @var const
 */
define('ldap_host', '10.6.14.2');

/**
 * Precisa do @, mas nem sempre o mesmo domínio do servidor LDAP
 *
 * @access public
 * @var const
 */
define('ldap_usuario_dominio', '@sebraeba');

define('googleapis_key', '');

$vetSistemaUtiliza['GEC'] = Array(
    'nome' => 'GEC',
    'url' => 'http://localhost/sebrae_gec/admin/',
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/sebrae_gec/',
    'path_file' => $_SERVER['DOCUMENT_ROOT'] . '/sebrae_gec/admin/obj_file',
);

$vetSistemaUtiliza['BIA'] = Array(
    'nome' => 'BIA',
    'url' => 'http://localhost/sebrae_bia/admin/',
);

$vetSistemaUtiliza['PFO'] = Array(
    'nome' => 'PFO',
    'url' => 'http://localhost/sebrae_pfo/admin/',
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/sebrae_pfo/',
);
