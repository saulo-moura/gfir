<?php



function TransformarTabelaTexto($TabelaTexto,&$sql_t,&$menu_t,&$status,&$erros)
{
    //
	// Transformar texto em  SQL
	//
	/*
	#campos
idt;integer; ; ;an
codigo;varchar;45
descricao;varchar;120
ativo;char;1;S
detalhe;texto
#indices
codigo
*/
    $vetSecao=explode('#',$TabelaTexto);
	foreach ($vetSecao as $Secao) {
	   $Secaow = explode('#', $Secao);
	   
	}
      
    $sql_t = $TabelaTexto;


}