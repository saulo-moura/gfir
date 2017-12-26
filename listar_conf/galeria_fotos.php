<?php
        $idCampo = 'idt';
		$bt_mais = True;
        $bt_prefixo = 'det';
        
        $reg_pagina = 50;
        $ver_tabela = true;
        
        $sen_linha = true;
        
        $bot_pesq = false;
        $par_auto=" onChange = 'document.frm.submit();' ";
        
        
        //Monta a filtro
        $sql = "select idt, descricao from tipo_video order by descricao";
        $Filtro = Array();
        $Filtro['rs'] = execsql($sql);
        $Filtro['id'] = 'idt';
        $Filtro['nome'] = 'Tipo de Galeria';
        $Filtro['LinhaUm'] = 'Todos os Tipos ';
        $Filtro['js'] = $par_auto;
        $Filtro['valor'] = trata_id($Filtro);
        $vetFiltro['idt_tipo_video'] = $Filtro;
		
       
        //Monta o vetor de Campo
	//	$vetCampo['imagem'] = CriaVetLista('Imagem', 'arquivo', '');
	    $vetCampo['data_publicacao'] = CriaVetLista('PUBLICAวรO', 'data', 'tit14b');
		$vetCampo['tv_imagem']    = CriaVetTabela('TIPO GALERIA', 'arquivo',' ' , 'tipo_video');
        //$vetCampo['tv_descricao'] = CriaVetLista('Tipo da Galeria', 'texto', 'tit14b');
        $vetCampo['descricao']    = CriaVetLista('DESCRIวรO DA GALERIA', 'texto', 'tit14b');

        
        $sql = 'select v.*, tv.descricao as tv_descricao,  tv.imagem as tv_imagem from video v inner join tipo_video tv on v.idt_tipo_video = tv.idt';
   		
   		
   		$sql .= ' where v.idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);
   		
        if ($vetFiltro['idt_tipo_video']['valor'] > 0)
             $sql .= ' and v.idt_tipo_video = '.null($vetFiltro['idt_tipo_video']['valor']);
        
        $sql .= ' order by  v.data_publicacao';
?>