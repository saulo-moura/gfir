<?php
if (PHP_SAPI == 'cli') {
    $tmp = $argv[1];
} else {
    $SCRIPT_NAME = str_replace('//', '/', $_SERVER['SCRIPT_NAME']);
    $SCRIPT_NAME = str_replace('\\\\', '\\', $SCRIPT_NAME);
    $SCRIPT_NAME = mb_strtolower($SCRIPT_NAME);

    $SCRIPT_FILENAME = str_replace('//', '/', $_SERVER['SCRIPT_FILENAME']);
    $SCRIPT_FILENAME = str_replace('\\\\', '\\', $SCRIPT_FILENAME);
    $SCRIPT_FILENAME = mb_strtolower($SCRIPT_FILENAME);
    
    $tmp = str_replace($SCRIPT_NAME, '', $SCRIPT_FILENAME);
    $tmp = mb_strtolower($tmp);
}

/**
 * Path para a pasta de biblioteca
 *
 * @access public
 * @var string
 */
define('lib_path', $tmp.'/sebrae_lib/');

/**
 * Path para a biblioteca MPDF versуo 6.1.2
 *
 * @access public
 * @var string
 */
define('lib_mpdf', lib_path.'mpdf_6.1.2/');

/**
 * Path para a biblioteca PHPMailer versуo 5.2.10
 *
 * @access public
 * @var string
 */
define('lib_phpmailer', lib_path.'PHPMailer-5.2.10/');

/**
 * Path para o arquivo de funчуo de todos os sistemas
 *
 * @access public
 * @var string
 */
define('lib_funcao', lib_path . 'funcao/funcao.php');

/**
 * Path para o arquivo de funчуo basicas de todos os sistemas
 *
 * @access public
 * @var string
 */
define('lib_funcao_basicas', lib_path.'funcao/funcao_basicas.php');

/**
 * Path para a biblioteca SMS Zenvia
 *
 * @access public
 * @var string
 */
define('lib_sms', lib_path . 'zenvia-api/');
