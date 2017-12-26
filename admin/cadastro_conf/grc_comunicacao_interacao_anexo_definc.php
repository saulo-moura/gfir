<?php
if ($acao=='inc' or $acao=='alt' )
{
       $datadia = trata_data(date('d/m/Y H:i:s'));
	   if ($vetRow['plu_helpdesk_interacao_anexo']['data_responsavel']=="")
	   {
		   $vetRow['plu_helpdesk_interacao_anexo']['data_responsavel'] = $datadia;
		   $vetRow['plu_helpdesk_interacao_anexo']['idt_responsavel']  = $_SESSION[CS]['g_id_usuario'];
		   //$vetRow['plu_helpdesk_anexo']['data_envio_email_helpdesk'] = $datadia;
	   }
}
?>