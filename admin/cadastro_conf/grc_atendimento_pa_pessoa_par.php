<?php
$tabela = 'grc_atendimento_pa_pessoa';
$id = 'idt';

$botao_volta = "self.location = '".trata_aspa($_SESSION[CS]['painel_url_volta'][$_GET['cod_volta']])."'";
$botao_acao = "<script type='text/javascript'>self.location = '".trata_aspa($_SESSION[CS]['painel_url_volta'][$_GET['cod_volta']])."';</script>";

if ($_SESSION[CS]['g_idt_unidade_regional'] == '') {
    echo "
        <script type='text/javascript'>
            alert('Usuário não tem Ponto de Atendimento informado! Favor informar para continuar com a operação.')
        </script>
    ";
    echo $botao_acao;
    exit();
}

$TabelaPai = "".db_pir."sca_organizacao_secao";
$AliasPai = "grc_os";
$EntidadePai = "PA´s";
$idPai = "idt";

$CampoPricPai = "idt_ponto_atendimento";


$sql = 'select ';
$sql .= '  grc_app.*  ';
$sql .= '  from  grc_atendimento_pa_pessoa grc_app';
$sql .= '  where grc_app.idt_usuario = '.null($_SESSION[CS]['g_id_usuario']);
$sql .= '    and grc_app.idt_ponto_atendimento = '.null($_SESSION[CS]['g_idt_unidade_regional']);
$rs = execsql($sql);
if ($rs->rows == 0) {
} else {
    ForEach ($rs->data as $row) {
        $_GET['id'] = $row['idt'];
    }
}


$_GET['idt0'] = $_SESSION[CS]['g_idt_unidade_regional'];



$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, $idPai, 'descricao', 0);


$sql = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " where id_usuario = ".null($_SESSION[CS]['g_id_usuario']);
$sql .= " order by nome_completo";
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Pessoa', true, $sql, '', 'width:300px;');



$sql = "select idt, descricao from grc_atendimento_box ";
$sql .= " where idt_organizacao_secao =  ".null($_GET['idt0']);
$sql .= " order by codigo";
$vetCampo['idt_box'] = objCmbBanco('idt_box', 'Guichê padrão', false, $sql, '', 'width:150px;');



$vetRel = Array();
$vetRel['A'] = 'Atendente';
$vetRel['R'] = 'Recepcionista';
$vetRel['C'] = 'Consultor';
$vetRel['G'] = 'Gestor do PA';

$vetCampo['relacao'] = objCmbVetor('relacao', 'Função de atendimento', True, $vetRel, '');
$vetCampo['letra_painel'] = objCmbVetor('letra_painel', 'Letra para senha do painel', True, $vetLetra);
$vetCampo['duracao'] = objInteiro('duracao', 'Duração média de atendimento (min)', False, 5, 5);



/*
  $sql  = "select idt, descricao from grc_projeto grc_p ";
  $sql .= " order by descricao";
  $vetCampo['idt_projeto'] = objCmbBanco('idt_projeto', 'Projeto SGE', false, $sql,' ','width:410px;');

  $sql  = "select idt, descricao from grc_projeto_acao grc_pa ";
  $sql .= " order by descricao";
  $vetCampo['idt_acao'] = objCmbBanco('idt_acao', 'Ação SGE', false, $sql,' ','width:410px;');
 */

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo[$CampoPricPai]),
        ), $class_frame, $class_titulo, $titulo_na_linha);



$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['idt_usuario'], '', $vetCampo['idt_box'], '', $vetCampo['letra_painel'], '', $vetCampo['relacao'], '', $vetCampo['duracao']),
        ), $class_frame, $class_titulo, $titulo_na_linha);



/*
  $vetFrm[] = Frame('<span></span>', Array(
  Array($vetCampo['idt_projeto']),
  Array($vetCampo['idt_acao']),
  ),$class_frame,$class_titulo,$titulo_na_linha);
 */


$vetCad[] = $vetFrm;
?>
