<style>
</style>
<?php
    
    Require_Once('configuracao.php');
	 set_time_limit(0);
   
	echo "GERADO RETORNO - CACHE CRM       --> HELPDESK CRM (USUÁRIO VISUALIZA)<BR /><BR />";
	Require_Once('classes/gsw_email_helpdesk_class.php');
    $vetEmailHelpdesk=Array();
	$vetEmailHelpdesk['usuario'] = 'luizrehmpereira@gmail.com';
	$vetEmailHelpdesk['senha']   = 'guybete52';
	$vetEmail['opcao']           = '';
	$GSWEMAILHELPDESK = new TGSW_EMAILHELPDESK($vetEmailHelpdesk);
	$vetEmailErro        = Array();
	$vetEmailErro        = $GSWEMAILHELPDESK->GravaEmailHelpdesk();
    //
    set_time_limit(30);
	echo "FIM DA SINCRONIZAÇÃO EMAILs INTERAÇÕES - HELPDESK CRM x HELPDESK SEBRAE";
?>
