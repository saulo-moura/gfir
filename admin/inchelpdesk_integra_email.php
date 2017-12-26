<?php
Require_Once('configuracao.php');
Require_Once('classes/gsw_email_class.php');

set_time_limit(0);
$vetEmail = Array();

echo "GERADO CACHE   - HELPDESK SEBRAE --> HELPDESK CRM<BR />";

/*
  $vetEmail['host'] = 'outlook.office365.com';
  $vetEmail['porta'] = '995';
  $vetEmail['usuario'] = 'suporte.pir@servico.sebraeba.com.br';
  $vetEmail['senha'] = 'Lupe@2016.2';
  $vetEmail['opcao'] = '/pop3/ssl';
 * 
 */

$vetEmail['host'] = $vetConf['helpdesk_host_smtp'];
$vetEmail['porta'] = $vetConf['helpdesk_port_smtp'];
$vetEmail['usuario'] = $vetConf['helpdesk_login_smtp'];
$vetEmail['senha'] = $vetConf['helpdesk_senha_smtp'];
$vetEmail['opcao'] = $vetConf['helpdesk_smtp_secure'];

$vetEmail['box'] = 'INBOX';

$GSWEMAIL = new TGSW_EMAIL($vetEmail);

//$vetEmailLidos = Array();
//$vetEmailLidos     = $GSWEMAIL->LeEmail();

$vetEmailErro = Array();
$vetEmailErro = $GSWEMAIL->GravaEmail();

// Para o sebrae testar 	Depois executar em tempos diferentes
// em outro php que no final tem crm......
echo "GERADO RETORNO - CACHE CRM       --> HELPDESK CRM (USUÁRIO VISUALIZA)<BR /><BR />";

Require_Once('classes/gsw_email_helpdesk_class.php');
$vetEmailHelpdesk = Array();
$vetEmailHelpdesk['usuario'] = 'luizrehmpereira@gmail.com';
$vetEmailHelpdesk['senha'] = '?????';
$vetEmail['opcao'] = '';
$GSWEMAILHELPDESK = new TGSW_EMAILHELPDESK($vetEmailHelpdesk);
$vetEmailErro = Array();
$vetEmailErro = $GSWEMAILHELPDESK->GravaEmailHelpdesk();

set_time_limit(30);

echo "FIM DA SINCRONIZAÇÃO EMAILs INTERAÇÕES - HELPDESK CRM x HELPDESK SEBRAE";