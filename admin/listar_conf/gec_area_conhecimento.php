<style>
.topo_full_aciona > div.div_descricao > div {
   xdisplay:none;
}


div.bt_volta_painel {
    Xborder: 1px solid;
    xmargin-left: 38px;
    background:#ECF0F1;
    color:#000000;
    text-align:left;
}

.bt_volta_painel {
    Xborder: 1px solid;
    xmargin-left: 38px;
    background:#ECF0F1;
    color:#000000;
    text-align:left;

}


Input.Botao {

    border: 1px solid transparent;
    padding-left:10px;
    background:#C4C9CD;
    color:#FFFFFF;


}

div#barra_a td {
  font-size: 20px;
  font-weight: bold;
  color:#2A5696;
}

</style>

<?php
$idCampo = 'idt';
$Tela = "a Área de Conhecimento";
//$comidentificacao = 'F';
//$goCad[] = vetCad('idt', 'Cidades', 'gec_sincroniza_sgc');

$vetBtBarra[] = vetBtBarra('gec_sincroniza_area_sgc', 'Sincronizar com SGC', 'imagens/calendar.gif', '', 'inc');


$TabelaPrinc      = "gec_area_conhecimento";
$AliasPric        = "gec_ac";
$Entidade         = "Área de Conhecimento";
$Entidade_p       = "Áreas de Conhecimento";
//
$barra_inc_h = 'Incluir um Novo Registro de Área de Conhecimento';
$contlinfim  = "Existem #qt Áreas de Conhecimento.";

$tipoidentificacao = 'N';


$vetNivelw = Array();
$vetNivelw['T'] = '-- Todos --';
$vetNivelw['1'] = 'Área';
$vetNivelw['2'] = 'Subarea';
$vetNivelw['3'] = 'Especialidade';


$Filtro = Array();
$Filtro['rs'] = $vetNivelw;
$Filtro['id'] = 'nivel';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Nível ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['nivel'] = $Filtro;


$sql  = 'select idt_area, descricao from gec_area_conhecimento ';
$sql .= ' where nivel = 1';
$sql .= ' order by descricao ';
$Filtro = Array();
$Filtro['rs']       = execsql($sql);
$Filtro['id']       = 'idt_area';
$Filtro['nome']     = 'Área';
$Filtro['LinhaUm']     = '-- Todas as Áreas --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_area'] = $Filtro;


//
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');

//
$vetCampo['nivel']     = CriaVetTabela('Nível?', 'descDominio', $vetNivelw );


$vetTpArea = Array();
$vetTpArea['S'] = 'Sintética';
$vetTpArea['A'] = 'Analítica';
//
$vetCampo['tipo']     = CriaVetTabela('Tipo?', 'descDominio', $vetTpArea );
$vetCampo['ativo']    = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
$vetCampo['publica']  = CriaVetTabela('Publica?', 'descDominio', $vetSimNao );
//
$sql  = 'select * from gec_area_conhecimento ';
$sql .= ' where ';
$sql .= ' ( ';
$sql .= ' lower(codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
//echo " ====== ".$vetFiltro['nivel']['valor'];

if ($vetFiltro['nivel']['valor']!="" and $vetFiltro['nivel']['valor']!="T" )
{
    $sql .= ' and nivel <= '.$vetFiltro['nivel']['valor'];
}

//echo " --- ".$vetFiltro['idt_area']['valor'];
if ($vetFiltro['idt_area']['valor']!="" and $vetFiltro['idt_area']['valor']!=-1 and $vetFiltro['idt_area']['valor']!=0)
{
    $sql .= ' and idt_area = '.null($vetFiltro['idt_area']['valor']);
}


$sql .= ' order by codigo';
//p($sql);
?>
<script type="text/javascript">
</script>