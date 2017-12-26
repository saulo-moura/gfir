<?php
if ($acao=='inc')
{
    $datadia = (date('d/m/Y H:i:s'));
    $vetRow['grc_avaliacao']['idt_responsavel_registro']  =  $_SESSION[CS]['g_id_usuario'];
    $vetRow['grc_avaliacao']['data_registro']    =  trata_data($datadia);
	
	$vetRow['grc_avaliacao']['idt_situacao']  =  1;
	
	$tabela = 'grc_avaliacao';
	$Campo  = 'codigo';
	$tam = 7;
	$codigow = numerador_arquivo($tabela, $Campo, $tam);
	$codigo  = 'DS'.$codigow;
	$vetRow['grc_avaliacao']['codigo']   = $codigo;
	
	
	$deondeveio  = $_GET['deondeveio'];
	if ($deondeveio == 'Portal' ) // veio da Url do PA
	{  // assumir variáveis da URL
		$titulo_avaliacao         = $_GET['titulo_avaliacao'];
		$data_avaliacao           = $_GET['data_avaliacao'];
		$protocolo                = $_GET['protocolo'];
		$idt_avaliacao            = $_GET['idt_avaliacao'];
		$cpf                      = $_GET['cpf'];
		$idt_avaliado             = $_GET['idt_avaliado'];
		$cnpj                     = $_GET['cnpj'];
		$idt_organizacao_avaliado = $_GET['idt_organizacao_avaliado'];
		$observacao               = $_GET['observacao'];
		$codigo_formulario        = $_GET['codigo_formulario'];
		$idt_formulario           = $_GET['idt_formulario'];
		$usuario_responsavel      = $_GET['usuario_responsavel'];
	
	
	
	
		if  ($titulo_avaliacao!='')
		{
		    $vetRow['grc_avaliacao']['descricao']         =  $titulo_avaliacao;
		}
        if  ($data_avaliacao!='')
		{
		    $vetRow['grc_avaliacao']['data_avaliacao']    =  trata_data($data_avaliacao);
		}
		
		if  ($idt_avaliado!='')
		{
		    $vetRow['grc_avaliacao']['idt_avaliado']    =  $idt_avaliado;
		}
		if  ($idt_organizacao_avaliado!='')
		{
		    $vetRow['grc_avaliacao']['idt_organizacao_avaliado']    =  $idt_organizacao_avaliado;
		}
		if  ($idt_formulario!='')
		{
		    $vetRow['grc_avaliacao']['idt_formulario']    =  $idt_formulario;
		}


    p($vetRow);



	}

	
	
	
}
?>