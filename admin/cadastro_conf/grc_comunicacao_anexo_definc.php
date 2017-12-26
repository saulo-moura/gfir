<?php
if ($acao=='inc' or $acao=='alt' )
{
       $datadia = trata_data(date('d/m/Y H:i:s'));
	   if ($vetRow['grc_comunicacao_anexo']['data_responsavel']=="")
	   {
		   $vetRow['grc_comunicacao_anexo']['data_responsavel'] = $datadia;
		   $vetRow['grc_comunicacao_anexo']['idt_responsavel']  = $_SESSION[CS]['g_id_usuario'];
		   //$vetRow['grc_comunicacao_anexo']['data_envio_email_helpdesk'] = $datadia;
	   }
}
?>