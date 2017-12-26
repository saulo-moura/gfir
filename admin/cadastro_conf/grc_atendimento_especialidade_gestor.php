<style>
    #nm_funcao_desc label{
    }
    #nm_funcao_obj {
    }
    .Tit_Campo {
    }
    .Tit_Campo_Obr {
    }
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        height:30px;
    }
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height:30px;
        padding-top:10px;
    }
    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame_p {
        background:#ABBBBF;
        border:1px solid #FFFFFF;
    }
    div.class_titulo_p {
        background: #ABBBBF;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #2C3E50;
    }
    div.class_titulo {
        background: #C4C9CD;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }
</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
$AliasPai    = "grc_e";
$TabelaPai   = "grc_atendimento_especialidade ";

$EntidadePai = "Cadastro de Serviços";
$idPai       = "idt";
//
$AliasPric    = "grc_aeg";
$TabelaPrinc  = "grc_atendimento_especialidade_gestor";
$Entidade     = "Gestor do Serviços";
$Entidade_p   = "Gestores do Serviço";
$CampoPricPai = "idt_especialidade";
// p($_GET);
// Dados do pai
$sql2 = 'select ';
$sql2 .= "  {$AliasPai}.* ";
$sql2 .= "  from {$TabelaPai} {$AliasPai} ";
$sql2 .= "  where {$AliasPai}.idt = ".null($_GET['idt0']);
$rs_pai  = execsql($sql2);
$row_pai = $rs_pai->data[0];
$nome_servico = $row_pai['plu_usu_nome_completo'];
$tabela = $TabelaPrinc;
$id     = 'idt';
$vetCampo[$CampoPricPai]    = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
//

$sql = "select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
// $sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";
// $sql .= " where grc_pap.idt_ponto_atendimento = ".null($idt_ponto_atendimento);
$sql .= " order by plu_usu.nome_completo";
$vetCampo['idt_gestor'] = objCmbBanco('idt_gestor', 'Gestor', true, $sql, ' ', 'width: 360px;');



$vetFrm = Array();
$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo[$CampoPricPai]),
	Array($vetCampo['idt_gestor']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
</script>