<?php
if ($acao=='inc')
{
       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow['grc_agenda_emailsms']['data_responsavel'] = $datadia;
       $vetRow['grc_agenda_emailsms']['idt_responsavel']  = $_SESSION[CS]['g_id_usuario'];
	   IF ($peca=='G')
	   {
	       $vetRow['grc_agenda_emailsms']['proprietario']     = "GESTOR";
	   }
	   else
	   {
	       $vetRow['grc_agenda_emailsms']['proprietario']     = "UAIN";
	   }   
}
?>