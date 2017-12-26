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
$tabela = 'grc_atendimento_pa_pessoa';
$id = 'idt';

$TabelaPai   = "".db_pir."sca_organizacao_secao";
$AliasPai    = "grc_os";
$EntidadePai = "Ponto de Atendimento (PA)";
$idPai       = "idt";
$CampoPricPai  = "idt_ponto_atendimento";
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, $idPai, 'descricao', 0);


$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;



$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Pessoa', true, $sql,' ','width:300px;');



$sql  = "select idt, descricao from grc_atendimento_box ";
$sql .= " where idt_organizacao_secao =  ".null($_GET['idt0']);
$sql .= " order by codigo";
$vetCampo['idt_box'] = objCmbBanco('idt_box', 'Guichê padrão', false, $sql,' ','width:150px;');



$vetRel = Array();
$vetRel['A'] = 'Atendente';
$vetRel['R'] = 'Recepcionista';
$vetRel['C'] = 'Consultor';
$vetRel['G'] = 'Gestor do PA';

$vetCampo['relacao']       = objCmbVetor('relacao', 'Função de atendimento', True, $vetRel);
$vetCampo['letra_painel']  = objCmbVetor('letra_painel', 'Letra para senha do painel', True, $vetLetra);

$vetCampo['pode_feriado']  = objCmbVetor('pode_feriado', 'Considerar Agenda para feriado?', false, $vetNaoSim);

$js = " readonly='true' style='background:#FFFFD7; '";
$vetCampo['duracao']       = objInteiro('duracao', 'Duração mínima de atendimento (min)', False, 5, 5,'',$js);


$vetCampo['ativo_pa']  = objCmbVetor('ativo_pa', 'Ativo no PA?', false, $vetNaoSim);



/*
$sql  = "select idt, descricao from grc_projeto grc_p ";
$sql .= " order by descricao";
$vetCampo['idt_projeto'] = objCmbBanco('idt_projeto', 'Projeto SGE', false, $sql,' ','width:410px;');

$sql  = "select idt, descricao from grc_projeto_acao grc_pa ";
$sql .= " order by descricao";
$vetCampo['idt_acao'] = objCmbBanco('idt_acao', 'Ação SGE', false, $sql,' ','width:410px;');
*/



/*
$sql_lst_1 = 'select idt as idt_servico, descricao from grc_atendimento_especialidade order by descricao';

$sql_lst_2 = 'select ds.idt as idt_servico, ds.descricao from grc_atendimento_especialidade ds inner join
               grc_atendimento_pa_pessoa_servico dr on ds.idt = dr.idt_servico
               where dr.idt = '.null($_GET['id']).' order by ds.descricao';
$vetCampo['idt_servico'] = objLista('idt_servico', True, 'Serviços SEBRAE', 'idt_servico1', $sql_lst_1, 'grc_atendimento_pa_pessoa_servico', 200, 'Serviços Selecionados', 'idt_servico2', $sql_lst_2);
*/











$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['idt_usuario'],'',$vetCampo['idt_box'],'',$vetCampo['letra_painel'],'',$vetCampo['relacao'],'',$vetCampo['duracao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Para Agendamento</span>', Array(
    Array($vetCampo['pode_feriado'],'',$vetCampo['ativo_pa']),
),$class_frame,$class_titulo,$titulo_na_linha);



//$vetFrm[] = Frame('<span></span>', Array(
//    Array($vetCampo['idt_servico']),
//),$class_frame,$class_titulo,$titulo_na_linha);

/*
$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['idt_projeto']),
    Array($vetCampo['idt_acao']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/


// Serviços
$vetParametros = Array(
		'codigo_frm' => 'grc_atendimento_pa_pessoa_servico_w',
		'controle_fecha' => 'A',
		

	
);
$vetFrm[] = Frame('<span>CADASTRO DE SERVIÇOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
// $vetCampo['ponto_atendimento'] = CriaVetTabela('Ponto Atendimento');
$vetCampo['servico']           = CriaVetTabela('Serviço');
$vetCampo['periodo'] = CriaVetTabela('Duração do Atendimento<br />(Minutos)');
//$vetCampo['quantidade_periodo'] = CriaVetTabela('Quantidade de Períodos<br /> (Minutos)');

$titulo = 'Cadastro de Serviços';
$TabelaPrinc      = "grc_atendimento_pa_pessoa_servico";
$AliasPric        = "grc_apps";
$Entidade         = "Serviço  do Atendente/Consultor";
$Entidade_p       = "Serviços do Atendente/Consultor ";
// Select para obter campos da tabela que serão utilizados no full
$orderby = "grc_ae.descricao  ";
$sql  = "select {$AliasPric}.*, ";
$sql .= "       grc_ae.descricao as servico ";
//$sql .= "       sca_os.descricao as ponto_atendimento ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_atendimento_especialidade grc_ae on  grc_ae.idt = {$AliasPric}.idt_servico ";
//$sql .= " inner join ".db_pir."sca_organizacao_secao sca_os on  sca_os.idt = {$AliasPric}.idt_ponto_atendimento";
//
$sql .= " where {$AliasPric}".'.idt_pa_pessoa = $vlID';
$sql .= " order by {$orderby}";
$vetCampo['grc_atendimento_pa_pessoa_servico'] = objListarConf('grc_atendimento_pa_pessoa_servico', 'idt', $vetCampo, $sql, $titulo, false,$vetParametros);
$vetParametros = Array(
	'codigo_pai' => 'grc_atendimento_pa_pessoa_servico_w',
	'width' => '100%',
);
$vetFrm[] = Frame('', Array(
	Array($vetCampo['grc_atendimento_pa_pessoa_servico']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);











$vetCad[] = $vetFrm;
?>
<script>
function grc_atendimento_pa_pessoa_servico(returnVal) {
	var duracao = returnVal.duracao;
	objd=document.getElementById('duracao');
    if (objd != null)
    {
	   objd.value=duracao;
    }
	
	
}
</script>