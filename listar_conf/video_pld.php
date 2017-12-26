<?php
        $idCampo = 'idt';
		$bt_mais = True;
        $bt_prefixo = 'det';
        
        $reg_pagina = 20;
        $ver_tabela = true;
        
        //Monta a filtro
        $sql = "select idt_tipo_video, descricao from tipo_video order by descricao";
        $Filtro = Array();
        $Filtro['rs'] = execsql($sql);
        $Filtro['id'] = 'idt';
        $Filtro['nome'] = 'Tipo de Galeria';
        $Filtro['LinhaUm'] = ' ';
        $Filtro['valor'] = trata_id($Filtro);
        $vetFiltro['idt_tipo_video'] = $Filtro;
		
       
        //Monta o vetor de Campo
		$vetCampo['imagem'] = CriaVetLista('Imagem', 'arquivo', '');
        $vetCampo['tv_descricao'] = CriaVetLista('Tipo de Imagem, Vнdeo e Бudio', 'texto', 'tit14b');
        $vetCampo['descricao'] = CriaVetLista('Descriзгo da Imagem, Vнdeo e Бudio', 'texto', 'tit14b');
        
        
        $sql = 'select v.*, tv.descricao as tv_descricao from video v inner join tipo_video tv on v.idt_tipo_video = tv.idt';
   		
        if ($vetFiltro['idt_tipo_video']['valor'] > 0)
             $sql .= ' where v.idt_tipo_video = '.null($vetFiltro['idt_tipo_video']['valor']);
        
        $sql .= ' order by tv.descricao, v.data_publicacao, v.descricao';
?>