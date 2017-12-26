<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';

$reg_pagina = 20;
$ver_tabela = true;

/*
$sql     = 'select  idt, estado, descricao from empreendimento ';
$sql    .= '    order by estado, descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Empreendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['empreendimento'] = $Filtro;
*/

//p($_SESSION[CS]['g_periodo_obra']);
$f=count($_SESSION[CS]['g_periodo_obra']);
$ano_ini=$_SESSION[CS]['g_periodo_obra'][1]['ano'];
$ano_fim=$_SESSION[CS]['g_periodo_obra'][$f]['ano'];
$mes_ini=$_SESSION[CS]['g_periodo_obra'][1]['mes'];
$mes_fim=$_SESSION[CS]['g_periodo_obra'][$f]['mes'];

$sql     = 'select  idt, descricao from periodo ';

$sql    .= '    where ( concat(ano,mes) >= '.aspa($ano_ini.$mes_ini).' ) ' ;
$sql    .= '      and ( concat(ano,mes) <= '.aspa($ano_fim.$mes_fim).' ) ' ;
$sql    .= '    order by ano desc, mes desc';
//p($sql);
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Período';
//$Filtro['LinhaUm'] = 'Todos os períodos';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['periodo'] = $Filtro;




//  Monta o vetor de Campo
$vetCampo['pc_descricao'] = CriaVetLista('CONTA', 'texto', 'tit14b');
$vetCampo['valor_real']   = CriaVetLista('VALOR EM R$', 'texto', 'tit14b_right', false,'','','',"Titulo_right");
$vetCampo['valor_incc']   = CriaVetLista('VALOR EM INCC', 'texto', 'tit14b_right', false,'','','',"Titulo_right");
$vetCampo['percentual']   = CriaVetLista('%', 'texto', 'tit14b_right', false,'','','',"Titulo_right");


$sql  = 'select ';
$sql .= '  de.*, ';
$sql .= '  pc.tipo_conta as pc_tipo_conta,  ';
$sql .= '  pc.descricao  as pc_descricao  ';
$sql .= 'from demonstrativo de ';
$sql .= 'inner join periodo peri on peri.idt  = de.idt_periodo ';
$sql .= 'inner join plano_contas pc on pc.idt = de.idt_conta ';
$sql .= 'where ';
$sql .= '    de.idt_empreendimento = '.null($_SESSION[CS]['g_idt_obra']);

if ($vetFiltro['periodo']['valor']!=-1)
{
    $sql .= ' and  de.idt_periodo = '.null($vetFiltro['periodo']['valor']);
}
$sql .= ' order by pc.classificacao';

if (tem_direito($menu, "'INC'"))
{
    if ($vetFiltro['periodo']['valor']!=-1)
    {
        $rs = execsql($sql);
        if ($rs->rows == 0)
        {
            copia_plano_contas(null ($_SESSION[CS]['g_idt_obra']) , null($vetFiltro['periodo']['valor']) );
        }
    }
}





?>