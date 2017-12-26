<style>
.cab_1_1 {
    text-align:center;
    background: #006ca8;
    color:#FFFFFF;
    border-bottom:1px solid #FFFFFF;
    xheight:20px;
    padding:5px;
    font-size:18px;
}
</style>


<?php
$idCampo = 'idt';
$Tela = "as Disponibilidades";

//$vetBtBarra[] = vetBtBarra('grc_atendimento_gera_agenda', 'Gerar Agenda', 'imagens/calendar.gif', 'Gerar_Agenda()', 'inc');
//$vetBtBarra[] = vetBtBarra('grc_atendimento_gera_agenda', 'Gerar Agenda', 'imagens/calendar.gif', '', 'cadastro');

$TabelaPrinc      = "grc_atendimento_usuario_disponibilidade";
$AliasPric        = "grc_aud";
$Entidade         = "Disponibilidade do Usuário";
$Entidade_p       = "Disponibilidades do Usuário";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


$tipoidentificacao = 'N';
$tipofiltro        = 'S';
$comfiltro         = 'A';
$comidentificacao  = 'F';

echo "<div class='cab_1_1' >";
    echo "  DISPONIBILIDADE ";
echo "</div>";


$idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional']; // 09/10/2015


$sql   = 'select ';
$sql  .= '   id_usuario, nome_completo  ';
$sql  .= ' from db_pir_grc.plu_usuario grc_pu ';
$sql  .= ' where id_usuario = '.$_SESSION[CS]['g_id_usuario'];    // 09/10/2015 - tirei as barras
$sql  .= ' order by nome_completo ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'id_usuario';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Consultor';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['usuario'] = $Filtro;


// 09/10/2015 INÍCIO

$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql  .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";
// $sql  .= "   and idt = ".null($idt_ponto_atendimento);
$sql  .= ' order by classificacao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Ponto de Atendimento';
$Filtro['LinhaUm']   = '-- Todos --';

$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;
// 09/10/2015 FIM
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//$comfiltro = 'A';
//$comidentificacao = 'A';

$orderby = "num_dia, hora_inicial";

//$vetCampo['pu_nome_completo']    = CriaVetTabela('Usuário');

$vetCampo['sca_o_descricao']   = CriaVetTabela('PA');
$vetCampo['dia']               = CriaVetTabela('Dia da Semana', 'descDominio', $vetDiaSemana );
//$vetCampo['num_dia']         = CriaVetTabela('Número');
$vetCampo['hora_inicial']      = CriaVetTabela('Hora Inicial');
$vetCampo['hora_final']        = CriaVetTabela('Hora Final');
$vetCampo['duracao']           = CriaVetTabela('Duração (min)');
$vetCampo['ativo']             = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*, pu.nome_completo as pu_nome_completo,  ";
$sql  .= "   sca_o.descricao as sca_o_descricao  ";

$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_usuario ";
$sql  .= " inner join ".db_pir."sca_organizacao_secao sca_o on sca_o.idt = .{$AliasPric}.idt_ponto_atendimento ";

$sql .= ' where ';
$sql .= " {$AliasPric}.idt_usuario =  ".null($vetFiltro['usuario']['valor']);

// $sql .= "  and ";                                                                 
// $sql .= " {$AliasPric}.idt_ponto_atendimento =  ".null($vetFiltro['ponto_atendimento']['valor']);   // 09/10/2015
//
//  p($sql);
//
if ($vetFiltro['ponto_atendimento']['valor']!="" and $vetFiltro['ponto_atendimento']['valor']!="-1")
{
	$sql .= "  and ";                                                                 
	$sql .= " {$AliasPric}.idt_ponto_atendimento =  ".null($vetFiltro['ponto_atendimento']['valor']);   // 09/10/2015
}


$sql_w =  $sql." and {$AliasPric}.ativo = 'S' ";


if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower(dia)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";

?>
<script>

function Gerar_Agenda()
{
  alert('entrei');

   var sessao = $('#grc_atendimento_gera_agenda').data('session_cod');
   btClickCTC('', 'inc', 0, 'cadastro', 'grc_atendimento_gera_agenda', sessao , 'GERAR AGENDA');
}

</script>
