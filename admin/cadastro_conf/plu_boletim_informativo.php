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
    
    
    
    fieldset.class_frame_fe {
        background:#ecf0f1;
        border:1px solid #FFFFFF;
        height:50px;
    }
    
    div.class_titulo_fe {
        background: #ecf0f1;
        border    : 1px solid #2C3E50;
        text-align: left;
        height:50px;
        padding-top:10px;
        font-size:16px;
        text-align:center;
        color: #2A5696;
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
$tabela = db_pir.'plu_boletim_informativo';
$id = 'idt';
$idt_boletim = $_GET['id'];
if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " plu_bi.*  ";
     $sql .= " from ".db_pir."plu_boletim_informativo plu_bi ";
     $sql .= " where idt = {$idt_boletim} ";
     $rs = execsql($sql);
     $wcodigo = '';
     ForEach($rs->data as $row)
     {
         $publicado = $row['publicado'];
     }
    
}
else
{




}
//$onSubmitCon = ' gec_edital_con() ';
$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:".$corbloq."' ";
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45,$jst);
$jst = " style='width:100%;";
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 50, 120,$jst);

$maxlength  = 255;
$style      = "width:100%; height:60px; ";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição Detalhada', true, $maxlength, $style, $js);
$vetCampo['arquivo'] = objFile('arquivo', 'Arquivo com Boletim', false, 40, 'todos', '', '', 0, '', 'Clique aqui para fazer o Download do Edital', 'class_file');

$vetCampo['ativo']        = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
$vetCampo['publica']      = objCmbVetor('publica', 'Publica?', True, $vetSimNao,'');
$vetCampo['data_inicial'] = objData('data_inicial', 'Inicio Publicação', true,'','','S');
$vetCampo['data_final']   = objData('data_final', 'Final Publicação', false,'','','S');



$sql  = "select id_usuario, nome_completo from ".db_pir."plu_usuario ";
$sql .= " order by nome_completo";
$js_hm = " disabled  ";
$style = " width:70%; background:#FFFFE1;  ";
$vetCampo['idt_usuario']     = objCmbBanco('idt_usuario', 'Responsável', false, $sql, '', $style, $js_hm);
$js = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['data_registro']   = objDatahora('data_registro', 'Data Registro', false,$js);



$class_frame_f   = "class_frame_f";
$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;
$titulo_cadastro="BOLETIM INFORMATIVO";




$vetFrm = Array();
$vetParametros = Array(
    'situacao_padrao' => true,
);
$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);



$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


$vetParametros = Array(
    'codigo_pai' => 'parte01',
);

MesclarCol($vetCampo['arquivo'], 3);
MesclarCol($vetCampo['descricao'], 5);
MesclarCol($vetCampo['detalhe'], 5);
MesclarCol($vetCampo['arquivo'], 5);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'],'',$vetCampo['ativo']),
    Array($vetCampo['publica'],'',$vetCampo['data_inicial'],'',$vetCampo['data_final']),
    Array($vetCampo['descricao']),
    Array($vetCampo['detalhe']),
	Array($vetCampo['arquivo']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_usuario'],'',$vetCampo['data_registro']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);



$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
</script>