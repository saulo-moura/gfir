<?

$idCampo = 'idt';
$Tela    = "o desvio do orçamento";

$bt_mais = True;

$sql     = 'select  idt, estado, descricao from empreendimento ';
$sql    .= '    order by estado, descricao ';
$Filtro  = Array();
$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Empreendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['empreendimento'] = $Filtro;


$sql     = 'select  idt, descricao from periodo ';
$sql    .= '    order by descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Período';
$Filtro['LinhaUm'] = 'Todos os períodos';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['periodo'] = $Filtro;


//  Monta o vetor de Campo

if ($vetFiltro['periodo']['valor']==-1)
{
    $vetCampo['pe_descricao']   = CriaVetTabela('Periodo');


}


$vetCampo['descricao'] = CriaVetTabela('Orçamento', 'descDominio', $vetOrcamento);


$vetCampo['valor_previsto']   = CriaVetTabela('Previsto R$', 'decimal');
$vetCampo['valor_projetado']  = CriaVetTabela('Projetado R$', 'decimal');
$vetCampo['diferenca']  = CriaVetTabela('Diferença R$', 'decimal');
$vetCampo['desvio']  = CriaVetTabela('Desvio %', 'decimal');

$sql  = 'select ';
$sql .= ' deo.*, ';
$sql .= ' pe.descricao as pe_descricao,  ';
$sql .= ' em.descricao as em_descricao   ';
$sql .= ' from   ';
$sql .= ' desvio_orcamento deo   ';
$sql .= ' inner join periodo pe        on pe.idt = deo.idt_periodo ';
$sql .= ' inner join empreendimento em on em.idt = deo.idt_empreendimento ';
$sql .= 'where ';
$sql .= '     deo.idt_empreendimento = '.null($vetFiltro['empreendimento']['valor']);

if ($vetFiltro['periodo']['valor']!=-1)
{
    $sql .= ' and  deo.idt_periodo = '.null($vetFiltro['periodo']['valor']);
}

$sql .= ' order by pe.descricao, em.descricao, deo.descricao';

        
        
        
        
?>        
    