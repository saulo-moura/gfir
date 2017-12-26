<?php
$tabela = 'grc_pergunta_frequente';
$id = 'idt';





$idt_projeto_acao  = 0;
$pergunta_frequente = $_GET['id'];


if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_pf.*  ";
     $sql .= " from grc_pergunta_frequente grc_pf ";
     $sql .= " where idt = {$pergunta_frequente} ";
     $rs = execsql($sql);
     $wcodigo = '';
     ForEach($rs->data as $row)
     {
         $idt_unidade_responsavel= $row['idt_ponto_atendimento'];
         $idt_consultor          = $row['idt_consultor'];
     }
}
else
{

     $idt_consultor             = $_SESSION[CS]['g_id_usuario'];
     $idt_unidade_responsavel   = $_SESSION[CS]['g_idt_unidade_regional'];
}

$vetCampo['pergunta'] = objTextArea('pergunta', 'Pergunta', false, 800,' height: 60px;  width: 650px;');
$vetCampo['resposta'] = objTextArea('resposta', 'Resposta', false, 800,' height: 180px; width: 650px;');


$js_hm   = " readonly='true' style='background:#FFFF80; font-size:14px;' ";

$vetCampo['data']     = objDatahora('data', 'Data Publicaчуo', False,$js_hm);
$vetCampo['ativo']    = CriaVetTabela('Ativo?', 'descDominio', $vetNaoSim,'' );
$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql  .= ' order by classificacao ';
$js = " ";
$vetCampo['idt_unidade_responsavel'] = objCmbBanco('idt_unidade_responsavel', 'Unidade Responsсvel', true, $sql,' ','width:250px;',$js);

$sql  = "select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
$sql .= " where plu_usu.id_usuario = ".null($idt_consultor);
$js_hm    = " disabled style='background:#FFFF80; font-size:14px;' ";
$vetCampo['idt_consultor'] = objCmbBanco('idt_consultor', 'Consultor', false, $sql,' ',$style, $js_hm);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_unidade_responsavel'],'',$vetCampo['idt_consultor']),
    Array($vetCampo['data'],'',$vetCampo['ativo']),

));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['pergunta']),
    Array($vetCampo['resposta']),
));
$vetCad[] = $vetFrm;
?>