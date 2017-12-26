<?php
$tabela = 'grc_atendimento_agenda_painel';
$id = 'idt';

$idt_atendimento_agenda_painel = $_GET['id'];


if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_aap.*  ";
     $sql .= " from grc_atendimento_agenda_painel grc_aap ";
     $sql .= " where idt = {$idt_atendimento_agenda_painel} ";
     $rs = execsql($sql);
     $wcodigo = '';
     ForEach($rs->data as $row)
     {
         $situacao  = $row['situacao'];
     }
     if ($situacao=='Cancelado' or $situacao=='Bloqueado')
     {
         $acao='con';
     }
}
else
{

}

$vetCampo['data']   = objData('data', 'Data Agenda', True);
$vetCampo['hora'] = objTexto('hora', 'Hora', True, 5, 5);

$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";

$vetCampo['observacao_chegada'] = objTexto('observacao_chegada', 'Observação Chegada', false, 30, 120,$js);
$vetCampo['observacao_atendimento'] = objTexto('observacao_atendimento', 'Observação Atendimento', false, 30, 120,$js);

$vetCampo['cliente_texto'] = objTexto('cliente_texto', 'Cliente', false, 40, 120);

$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data_confirmacao']   = objData('data_confirmacao', 'Data Confirmação', False, $js);

$vetCampo['hora_confirmacao'] = objTexto('hora_confirmacao', 'Hora Confirmação', False, 5, 5, $js);
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['hora_chegada'] = objTexto('hora_chegada', 'Hora Chegada', False, 5, 5,$js);
$vetCampo['hora_atendimento'] = objTexto('hora_atendimento', 'Hora Atendimento', False, 5, 5,$js);
$vetCampo['hora_liberacao'] = objTexto('hora_liberacao', 'Hora Liberação', False, 5, 5,$js);

$vetCampo['dia_semana'] = objTexto('dia_semana', 'Dia Semana', True, 3, 3);
$vetCampo['telefone'] = objTexto('telefone', 'Telefone', False, 15, 15);
$vetCampo['celular'] = objTexto('celular', 'Celular', False, 15, 15);
$vetCampo['origem'] = objTexto('origem', 'Origem', False,10,15,$js);

$vetCampo['status_painel'] = objTexto('status_painel', 'Status', False,2,2,$js);
$vetCampo['protocolo'] = objTexto('protocolo', 'Protocolo', False,20,45,$js);


//$sql  = "select idt, descricao from grc_atendimento_situacao_agenda ";
//$sql .= " order by descricao";
//$vetCampo['idt_situacao'] = objCmbBanco('idt_situacao', 'Situação', false, $sql,' ','width:100px;');

$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['situacao'] = objTexto('situacao', 'Situação', false, 10, 20,$js);

$sql  = "select idt, descricao from grc_atendimento_especialidade ";
$sql .= " order by descricao";
$vetCampo['idt_especialidade'] = objCmbBanco('idt_especialidade', 'Especialidade', false, $sql,' ','width:400px;');

//$sql  = "select idt, descricao from ".db_pir_gec."gec_entidade ";
//$sql .= " order by descricao";
//$vetCampo['idt_cliente'] = objCmbBanco('idt_cliente', 'Cliente', false, $sql,' ','width:400px;');

$vetCampo['idt_cliente'] = objListarCmb('idt_cliente', 'gec_entidade_cmb', 'Cliente', false);

$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_consultor'] = objCmbBanco('idt_consultor', 'Consultor', true, $sql,' ','width:400px;');

$sql  = "select idt, descricao from ".db_pir."sca_organizacao_secao ";
$sql .= " order by descricao";
$vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto Atendimento', false, $sql,' ','width:200px;');


$sql  = "select idt, data, hora from grc_atendimento_agenda ";
$sql .= " order by data, hora";
$vetCampo['idt_atendimento_agenda'] = objCmbBanco('idt_atendimento_agenda', 'Agenda', false, $sql,' ','width:400px;');

$sql  = "select idt, descricao from grc_atendimento_box ";
$sql .= " order by descricao";
$vetCampo['idt_atendimento_box'] = objCmbBanco('idt_atendimento_box', 'Box Atendimento', false, $sql,' ','width:200px;');

$sql  = "select idt, descricao from grc_atendimento_painel ";
$sql .= " order by descricao";
$vetCampo['idt_atendimento_painel'] = objCmbBanco('idt_atendimento_painel', 'Painel', false, $sql,' ','width:200px;');



$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observações', false, $maxlength, $style, $js);


//$vetCampo['confirmacao_agendamento'] = objInclude('confirmacao_agendamento', 'cadastro_conf/confirmacao_agendamento.php');

//$vetCampo['confirmacao_chegada'] = objInclude('confirmacao_chegada', 'cadastro_conf/confirmacao_chegada.php');
//$vetCampo['confirmacao_liberacao'] = objInclude('confirmacao_liberacao', 'cadastro_conf/confirmacao_liberacao.php');

//$vetCampo['confirmacao_atendimento'] = objInclude('confirmacao_atendimento', 'cadastro_conf/confirmacao_atendimento.php');

//$vetCampo['chama_atendimento'] = objInclude('chama_atendimento', 'cadastro_conf/chama_atendimento.php');


//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');


$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['data'],'',$vetCampo['hora'],' ',$vetCampo['cliente_texto'],' ',$vetCampo['situacao']),
    Array($vetCampo['dia_semana'],'','','',$vetCampo['telefone'],'',$vetCampo['celular'],'',$vetCampo['origem']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Confirmação do Agendamento</span>', Array(
    Array($vetCampo['data_confirmacao'],'',$vetCampo['hora_confirmacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Registro da Chegada</span>', Array(
    Array($vetCampo['hora_chegada'],' ',$vetCampo['observacao_chegada'],'',$vetCampo['hora_liberacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Registro do Atendimento</span>', Array(
    Array($vetCampo['hora_atendimento'],'',$vetCampo['observacao_atendimento']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Especialidade</span>', Array(
    Array($vetCampo['idt_cliente']),
    Array($vetCampo['idt_consultor'],'',$vetCampo['idt_especialidade']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Painel</span>', Array(
    Array($vetCampo['idt_atendimento_agenda']),
    Array($vetCampo['idt_ponto_atendimento'],'',$vetCampo['idt_atendimento_box'],'',$vetCampo['idt_atendimento_painel']),
    Array($vetCampo['status_painel'],'',$vetCampo['protocolo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observações Gerais</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
