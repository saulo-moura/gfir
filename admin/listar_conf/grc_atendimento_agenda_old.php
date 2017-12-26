<?php
$idCampo = 'idt';
$Tela = "a Agenda";

$TabelaPrinc      = "grc_atendimento_agenda";
$AliasPric        = "grc_aa";
$Entidade         = "Agenda";
$Entidade_p       = "Agendas";


$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';



$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql  .= ' order by classificacao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['LinhaUm']  = '-- Selecione o PA --';
$Filtro['nome']     = 'Pontos de Atendimento';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;

$sql  = "select idt, descricao from grc_atendimento_especialidade ";
$sql .= " order by descricao ";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['LinhaUm']  = '-- Selecione a Especialidade --';
$Filtro['nome']     = 'Especialidade';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['idt_especialidade'] = $Filtro;

$sql  = "select distinct plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
$sql .= " inner join grc_atendimento_usuario_especialidade grc_aue on grc_aue.idt_usuario = plu_usu.id_usuario ";
if ($vetFiltro['idt_especialidade']['valor']>0)
{
    $sql .= " where grc_aue.idt_atendimento_especialidade = ".null($vetFiltro['idt_especialidade']['valor']);
}
$sql .= " order by plu_usu.nome_completo";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'id_usuario';
$Filtro['js_tam']   = '0';
$Filtro['LinhaUm']  = '-- Selecione o Consultor --';
$Filtro['nome']     = 'Consultores';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['idt_consultor'] = $Filtro;


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.data";

$vetCampo["data"]    = CriaVetTabela('Data','data');
$vetCampo['dia_semana'] = CriaVetTabela('Dia');
$vetCampo["hora"] = CriaVetTabela('Hora');
$vetCampo['situacao'] = CriaVetTabela('Situação');

//$vetCampo['ge_descricao'] = CriaVetTabela('Cliente');
//$vetCampo['pu_nome_completo'] = CriaVetTabela('Consultor');
$vetCampo['pu_cliente_consultor'] = CriaVetTabela('Cliente <br />Consultor');

$vetCampo['telefone'] = CriaVetTabela('Telefone');
$vetCampo['hora_confirmacao'] = CriaVetTabela('Hora<br />Conf.');
$vetCampo['hora_chegada'] = CriaVetTabela('Hora<br />Che.');
$vetCampo['hora_liberacao'] = CriaVetTabela('Hora<br />Lib.');
$vetCampo['hora_atendimento'] = CriaVetTabela('Hora<br />Aten.');

//$vetCampo['gae_descricao'] = CriaVetTabela('Especialidade');
//$vetCampo['sos_descricao'] = CriaVetTabela('Ponto Atendimento');

$vetCampo['especialidade_ponto'] = CriaVetTabela('Especialidade <br />Ponto Atendimento');

//$vetCampo['origem'] = CriaVetTabela('Hora Marcada?','descDominio',$vetSimNao);
$vetCampo['origem'] = CriaVetTabela('Origem');

//$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*, gae.descricao as gae_descricao,  ";
$sql  .= "   ge.descricao as ge_descricao,  ";
$sql  .= "   pu.nome_completo as pu_nome_completo,  ";


$sql  .= "  concat_ws('<br />', ge.descricao, pu.nome_completo) as pu_cliente_consultor,  ";

$sql  .= "   sos.descricao as sos_descricao,  ";

$sql  .= "  concat_ws('<br />', gae.descricao, sos.descricao) as especialidade_ponto  ";


// alterado em 23/07/2015 - início

//$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
//$sql  .= " inner join grc_atendimento_especialidade as gae on gae.idt = .{$AliasPric}.idt_especialidade ";
//$sql  .= " left join ".db_pir_gec."gec_entidade as ge on ge.idt = .{$AliasPric}.idt_cliente ";
//$sql  .= " inner join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_consultor ";
//$sql  .= " inner join ".db_pir."sca_organizacao_secao as sos on sos.idt = .{$AliasPric}.idt_ponto_atendimento ";

$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " left  join grc_atendimento_especialidade as gae on gae.idt = .{$AliasPric}.idt_especialidade ";
$sql  .= " left  join ".db_pir_gec."gec_entidade as ge on ge.idt = .{$AliasPric}.idt_cliente ";
$sql  .= " left  join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_consultor ";
$sql  .= " left  join ".db_pir."sca_organizacao_secao as sos on sos.idt = .{$AliasPric}.idt_ponto_atendimento ";

// alterado em 23/07/2015 - fim



$agenda=$_GET['recepcao'];
if ($recepcao==1)
{
  echo "  TO NA RECEPÇÃO";
}

$balcao=$_GET['balcao'];
if ($balcao==1)
{
    echo "  TO NO BALCAO";
}
 $calcenter=$_GET['callcenter'];
if ($callcenter==1)
{
   echo "  TO NO CALL CENTER";
}
$fezwere=0;
if ($vetFiltro['ponto_atendimento']['valor']!='' AND $vetFiltro['ponto_atendimento']['valor']!='-1')
{
    if ($fezwere==0)
    {
        $sql .= ' where ';
        $fezwere=1;
    } 
    else
    {
        $sql .= ' and ';
    }
    $sql .= ' idt_ponto_atendimento= '.null($vetFiltro['ponto_atendimento']['valor']);
  
}

if ($vetFiltro['texto']['valor']!="")
{
    if ($fezwere==0)
    {
        $sql .= ' where ';
        $fezwere=1;
    } 
    else
    {
        $sql .= ' and ';
    }
   // $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.data)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
//    $sql .= ' or lower('.$AliasPric.'.hora)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";


if ($sqlOrderby == '') {
        $sqlOrderby = "data asc, hora asc";
}

?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#id_usuario2").cascade("#idt1", {ajax: {
            url: 'ajax_atendimento.php?tipo=usuario_especialidade&cas=' + conteudo_abrir_sistema,
        }});
    });
</script>
