
<style>
 #nm_funcao_desc label{
    }
    #nm_funcao_obj {
    }
    .Tit_Campo {
    }
    .Tit_Campo_Obr {
    }
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #14ADCC;
    }
    div.class_titulo {
        background: #ABBBBF;
        border    : 1px solid #14ADCC;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }


    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        guyheight:30px;
    }
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        guyheight:30px;
        padding-top:10px;
    }
    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        xbackground:#ABBBBF;
        xborder:1px solid #FFFFFF;

        background:#FFFFFF;
        border:0px solid #FFFFFF;



    }
    div.class_titulo_p {
        xbackground: #ABBBBF;
        xborder    : 1px solid #2C3E50;
        xcolor     : #FFFFFF;
        text-align: left;
        xbackground: #F1F1F1;

        background: #ECF0F1;

        background: #C4C9CD;


        border    : 0px solid #2C3E50;
        color     : #FFFFFF;

    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }
	
	div.class_titulo_semcliente {
        text-align: left;
        background: #F1F1F1;
        border    : 1px solid #2C3E50;
        color     : #FF0000;
		text-align:center;
		font-size:16px;
    }
    div.class_titulo_p span {
        Xpadding-left:20px;
        Xtext-align: left;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #C4C9CD;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 10px;
    }


    fieldset.class_frame {
        xbackground:#ECF0F1;
        xborder:1px solid #2C3E50;
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }
    div.class_titulo {
        xbackground: #C4C9CD;
        xborder    : 1px solid #2C3E50;
        xcolor     : #FFFFFF;
        text-align: left;

        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;


    }
    div.class_titulo span {
        padding-left:10px;
    }

    Select {
        border:0px;
        min-height: 25px;
        padding-left: 3px;
        padding-right: 3px;
        padding-top: 5px;
    }

    .TextoFixo {

        font-size:12px;
        guyheight:25px;
        text-align:left;
        border:0px;
        xbackground:#F1F1F1;
        background:#ECF0F1;


        font-weight:normal;

        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        color:#5C6D7E;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;



    }
    .Texto {

        font-size:12px;
        guyheight:25px;
        text-align:left;
        border:0px;
        xbackground:#F1F1F1;
        background:#ECF0F1;


        font-weight:normal;

        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        color:#5C6D7E;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;

    }

    td.Titulo {
        color:#666666;
    }


.botao_ag {
    text-align:center;
    width:180px;
    height:35px;
    color:#FFFFFF;
    Xbackground:#0000FF;
    background:#2F65BB;
    font-size:14px;
    cursor:pointer;
    float:left;
    margin-top:10px;
    margin-right:10px;
    xpadding-top:20px;
    xpadding-right:20px;
    font-weight:bold; 

} 
.botao_ag:hover {
    background:#0000FF;
     

}
.botao_ag_bl {
    text-align:center;
    width:200px;
    height:35px;
    color:#FFFFFF;
    //background:#0000FF;
    background:#2F65BB;
    font-size:14px;
    cursor:pointer;
    float:left;
    margin-top:10px;
    margin-right:10px;
    xpadding-top:20px;
    xpadding-right:20px;
    font-weight:bold; 

} 
.botao_ag_bl:hover {
    background:#0000FF;
     

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

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

//
$AliasPric    = "grc_aea";
$TabelaPrinc  = "grc_atendimento_especialidade_acao";
$Entidade     = "Ação para o Serviços";
$Entidade_p   = "Ações para o Serviços";
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
$vetCampo['codigo']    = objTexto('codigo', 'Código da Ação', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');


$vetCampo['tipo_acao']     = objCmbVetor('tipo_acao', 'Tipo da Ação?', True, $vetTPAC,'');

$vetCampo['cor'] = objTexto('cor', 'Cor', false, 60, 120);

$vetCampo['largura'] = objInteiro('largura', 'Largura', false, 10);


$altura ="150";
$largura="700";
$js="";
$vetCampo['introducao_texto'] = objHTML('introducao_texto', 'Introdução', false, $altura, $largura, $js);
$vetCampo['observacao_texto'] = objHTML('observacao_texto', 'Observação', false, $altura, $largura, $js);

$vetCampo['arquivo_cab']    = objFile('arquivo_cab', 'Arquivo para Cabeçalho', false, 120, 'todos');
$vetCampo['arquivo_rod']    = objFile('arquivo_rod', 'Arquivo para Rodapé', false, 120, 'todos');

//
$maxlength  = 750;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição Detalhada da Ação', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
MesclarCol($vetCampo[$CampoPricPai], 7);
MesclarCol($vetCampo['detalhe'], 7);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['tipo_acao'],'',$vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
	Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);


MesclarCol($vetCampo['arquivo_cab'], 3);
MesclarCol($vetCampo['introducao_texto'], 3);
MesclarCol($vetCampo['observacao_texto'], 3);
MesclarCol($vetCampo['arquivo_rod'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['largura'],'',$vetCampo['cor']),
    Array($vetCampo['arquivo_cab']),
	Array($vetCampo['introducao_texto']),
	Array($vetCampo['observacao_texto']),
	Array($vetCampo['arquivo_rod']),
),$class_frame,$class_titulo,$titulo_na_linha);


// Anexo da Ação para o Serviços
$vetParametros = Array(
		'codigo_frm' => 'grc_atendimento_especialidade_acao_anexo_w',
		'controle_fecha' => 'A',
	//	'barra_inc_ap' => false,
	//	'barra_alt_ap' => false,
	//	'barra_con_ap' => false,
	//	'barra_exc_ap' => false,

);
$vetFrm[] = Frame('<span>ANEXOS DA AÇÃO DO SERVIÇO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
// Definição de campos formato full que serão editados na tela full
$vetCampo = Array();
//$vetCampo['tipo_acao'] = CriaVetTabela('Tipo Ação','descDominio',$vetTPAC);
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['ativo']     = CriaVetTabela('Ativo?','descDominio',$vetSimNao);

$titulo           = 'Anexo da Ação do Serviço';
$TabelaPrinc      = "grc_atendimento_especialidade_acao_anexo";
$AliasPric        = "grc_aeaa";
$Entidade         = "Anexo da Ação do Serviço";
$Entidade_p       = "Anexo da Ação do Serviço";
// Select para obter campos da tabela que serão utilizados no full
$orderby = "grc_aeaa.codigo  ";
$sql  = "select {$AliasPric}.* ";
//$sql .= "       grc_ae.descricao as servico ";
//$sql .= "       sca_os.descricao as ponto_atendimento ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//$sql .= " inner join grc_atendimento_especialidade grc_ae on  grc_ae.idt = {$AliasPric}.idt_servico ";
//$sql .= " inner join ".db_pir."sca_organizacao_secao sca_os on  sca_os.idt = {$AliasPric}.idt_ponto_atendimento";
//
$sql .= " where {$AliasPric}".'.idt_especialidade_acao = $vlID';
$sql .= " order by {$orderby}";
$vetCampo['grc_atendimento_especialidade_acao_anexo'] = objListarConf('grc_atendimento_especialidade_acao_anexo', 'idt', $vetCampo, $sql, $titulo, false,$vetParametros);
$vetParametros = Array(
	'codigo_pai' => 'grc_atendimento_especialidade_acao_anexo_w',
	'width' => '100%',
);
$vetFrm[] = Frame('', Array(
	Array($vetCampo['grc_atendimento_especialidade_acao_anexo']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);




$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
</script>