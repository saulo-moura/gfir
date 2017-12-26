
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
#frm0 table {
    width:90%;
}

#frm1 table {
    width:90%;
}
#frm2 table {
    width:90%;
}
#frm3 table {
    width:90%;
}

</style> 

<?php


//Require_Once('incdistancia_devolutiva.php');
/*
$codigo='061846425-53';
$vetRetorno=Array();
$ret = OpcaoCanalContato($codigo,$vetRetorno);
p($vetRetorno);
die();
*/

/*
$vetParametro['sumario']   = utf8_encode("Teste de sumário. Grande decisão no endereço de cas e tem que ser em uma única linha");
$vetParametro['descricao'] = utf8_encode('Teste de comissão e ático de teste dois ');
$vetParametro['data_agenda']='30/07/2017';
$vetParametro['hora_evento']='12:00';
    
$textoics = ArquivoICS($vetParametro);
p($textoics);
*/



$tabela = 'grc_atendimento_especialidade';
$id = 'idt';

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Título', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');


$vetCampo['tipo_atendimento']     = objCmbVetor('tipo_atendimento', 'Tipo Atendimento?', True, $vetTPAT,'');



//
$maxlength  = 700;
$style      = "width:100%;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição do Serviço', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');


$js         = " onblur = CalculaOpcoes(this); ";
$vetCampo['periodo'] = objInteiro('periodo', 'Duração do Atendimento (Minutos)', true, 10,'','','',$js);



$vetCampo['quantidade_periodo'] = objInteiro('quantidade_periodo', 'Quantidade de Períodos (Minutos)', false, 10,'','','',$js);
$vetCampo['opcoes_escolher']    = objHidden('opcoes_escolher');



$sql  = "select idt, descricao from grc_atendimento_especialidade_acao";
$sql .= " where idt_especialidade = ".null($_GET['id']);
$sql .= " order by descricao";
$vetCampo['idt_acao'] = objCmbBanco('idt_acao', 'Relatório Devolutiva', false, $sql,' ','width:180px;');


$sql  = "select idt, descricao from grc_agenda_emailsms";
///             $sql .= " where idt_especialidade = ".null($_GET['id']);
$sql .= " order by codigo";
$vetCampo['idt_email_confirmacao'] = objCmbBanco('idt_email_confirmacao', 'Email de Confirmação', false, $sql,' ','width:180px;');



$sql  = "select idt, descricao from grc_agenda_maturidade";
$sql .= " order by descricao";
$vetCampo['idt_maturidade'] = objCmbBanco('idt_maturidade', 'Maturidade', false, $sql,' ','width:180px;');


$sql = "select idt,  descricao from grc_tema_subtema ";
$sql .= " order by codigo";
$vetCampo['idt_tema_subtema'] = objCmbBanco('idt_tema_subtema', 'Tema/Subtemas', true, $sql, ' ', 'width:180px;');


$sql_lst_1 = 'select idt as idt_porte, descricao from '.db_pir_gec.'gec_organizacao_porte order by descricao';

$sql_lst_2 = 'select ds.idt as idt_porte, ds.descricao from '.db_pir_gec.'gec_organizacao_porte ds inner join
               grc_atendimento_especialidade_porte dr on ds.idt = dr.idt_porte
               where dr.idt = $vlID order by ds.descricao';

$vetCampo['idt_porte'] = objLista('idt_porte', false, 'Porte', 'idt_porte1', $sql_lst_1, 'grc_atendimento_especialidade_porte', 180, 'Portes Selecionados', 'idt_porte2', $sql_lst_2);





$sql = "select idt,  descricao from grc_publico_alvo ";
$sql .= " order by codigo";
$vetCampo['idt_publico_alvo'] = objCmbBanco('idt_publico_alvo', 'Público Alvo Prioritário', true, $sql, ' ', 'width:180px;');


$sql_lst_1x = 'select idt as idt_publico_alvo_outro, descricao from grc_publico_alvo order by codigo';

$sql_lst_2x = 'select d.idt as idt_publico_alvo_outro, d.descricao from grc_publico_alvo d inner join
               grc_atendimento_especialidade_publico_alvo df on d.idt = df.idt_publico_alvo_outro
               where df.idt = $vlID order by d.codigo';
			   
			   
$vetCampo['idt_publico_alvo_outro'] = objLista('idt_publico_alvo_outro', false, 'Públicos Alvos do Sistema', 'idt_publico_alvo_outro1', $sql_lst_1x, 'grc_atendimento_especialidade_publico_alvo', 180, 'Outros Público Alvo do Produto', 'idt_publico_alvo_outro2', $sql_lst_2x);



$vetCampo['despublica'] = objCmbVetor('despublica', 'Despublicação Automática?', True, $vetNaoSim,'');



$vetCampo['data_despublicar'] = objData('data_despublicar', 'Data para Despublicação', false, '', '', 'S');
$vetCampo['hora_despublicar'] = objHora('hora_despublicar', 'Hora para Despublicação', false);


$par = 'data_despublicar';
$vetDesativa['despublica'][0]   = vetDesativa($par);
$vetAtivadoObr['despublica'][0] = vetAtivadoObr($par, 'S', true, '_lst_2');

$par = 'hora_despublicar';
$vetDesativa['despublica'][1]   = vetDesativa($par);
$vetAtivadoObr['despublica'][1] = vetAtivadoObr($par, 'S', true, '_lst_3');



$maxlength  = 4000;
$style      = "";
$js         = " style=' width:100%; ' ";
$vetCampo['palavras_chave'] = objTextArea('palavras_chave', 'Palavras Chaves', false, $maxlength, $style, $js);


$arquivo_html ="";
$arquivo_html.="<div id='id_opcoes_escolha' style='font-size:14px; color:red; padding-top:15px;'>";
$arquivo_html.="Opções []";
$arquivo_html.="</div>";
$vetCampo['opcoes_escolha'] = objInclude('opcoes_escolha', $arquivo_html);


//MesclarCol($vetCampo['idt_maturidade'], 7);
MesclarCol($vetCampo['opcoes_escolher'], 7);
MesclarCol($vetCampo['detalhe'], 7);

//MesclarCol($vetCampo['idt_publico_alvo'], 5);
//MesclarCol($vetCampo['idt_porte'], 3);
//MesclarCol($vetCampo['idt_publico_alvo_outro'], 3);

MesclarCol($vetCampo['palavras_chave'], 7);
MesclarCol($vetCampo['hora_despublicar'], 3);


//MesclarCol($vetCampo['idt_publico_alvo'], 3);
//MesclarCol($vetCampo['idt_porte'], 3);
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['tipo_atendimento'],'',$vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
	Array($vetCampo['palavras_chave']),
    Array($vetCampo['idt_email_confirmacao'],'',$vetCampo['periodo'],'',$vetCampo['quantidade_periodo'],'',$vetCampo['opcoes_escolha']),
	Array($vetCampo['opcoes_escolher']),
    Array($vetCampo['despublica'],'', $vetCampo['data_despublicar'] ,'', $vetCampo['hora_despublicar'] ),  
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_publico_alvo'],'',$vetCampo['idt_maturidade'],'',$vetCampo['idt_tema_subtema']),  
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('', Array(
	Array($vetCampo['idt_publico_alvo_outro'],'',$vetCampo['idt_porte']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);





//  PRODUTOS DO SERVIÇO
$vetParametros = Array(
    'codigo_frm' => 'parte21',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>PRODUTOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo_p = Array();


$vetCampo_p = Array();
$vetCampo_p['grc_ep_descricao'] = CriaVetTabela('Produto', 'limite_txt', 35);
$vetCampo_p['observacao'] = CriaVetTabela('Observação', 'limite_txt', 35);
//$vetCampo['plu_usu_nome_completo']  = CriaVetTabela('Responsável');
//$vetCampo['data_registro']          = CriaVetTabela('Data Registro','data');

$TabelaPrinc  = "grc_atendimento_especialidade_produto";
$AliasPric    = "grc_aep";
$Entidade     = "Produto do Serviço";
$Entidade_p   = "Produtos do Serviço";
$CampoPricPai = "idt_atendimento_especialidade";

$titulo = $Entidade_p;


// $orderby = "{$AliasPric}.data_registro, gec_ec.descricao, gec_eo.descricao ";

$orderby = "grc_ep.descricao ";

$sql = "select {$AliasPric}.*, ";
$sql .= "        plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql .= "        grc_ep.descricao      as grc_ep_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left  join plu_usuario plu_usu on  plu_usu.id_usuario = {$AliasPric}.idt_responsavel";
$sql .= " left  join ".db_pir_grc."grc_produto grc_ep  on  grc_ep.idt = {$AliasPric}.idt_produto";
$sql .= " where {$AliasPric}".'.idt_atendimento_especialidade = $vlID';
$sql .= " order by {$orderby}";


$vetCampo['grc_atendimento_especialidade_produto'] = objListarConf('grc_atendimento_especialidade_produto', 'idt', $vetCampo_p, $sql, $titulo, false, $vetParametros);
$vetParametros = Array(
    'codigo_pai' => 'parte21',
    'width' => '100%',
);



$vetFrm[] = Frame('', Array(
	Array($vetCampo['grc_atendimento_especialidade_produto']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);









// Gestores do Serviço

$vetParametros = Array(
		'codigo_frm' => 'grc_atendimento_especialidade_gestor_w',
		'controle_fecha' => 'A',
		//'barra_inc_ap' => false,
		//'barra_alt_ap' => false,
		//'barra_con_ap' => false,
		//'barra_exc_ap' => false,

);
$vetFrm[] = Frame('<span>GESTORES DO SERVIÇO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
// Definição de campos formato full que serão editados na tela full
$vetCampo = Array();
$vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Gestor');
$titulo           = 'Gestores do Serviço';
$TabelaPrinc      = "grc_atendimento_especialidade_gestor";
$AliasPric        = "grc_aeg";
$Entidade         = "Gestor do Serviço";
$Entidade_p       = "Gestores dos Serviços";
// Select para obter campos da tabela que serão utilizados no full
$orderby = "plu_usu.nome_completo  ";
$sql  = "select {$AliasPric}.*, ";
$sql .= "       plu_usu.nome_completo as plu_usu_nome_completo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join plu_usuario plu_usu on  plu_usu.id_usuario = {$AliasPric}.idt_gestor ";
//
$sql .= " where {$AliasPric}".'.idt_especialidade = $vlID';
$sql .= " order by {$orderby}";
$vetCampo['grc_atendimento_especialidade_gestor'] = objListarConf('grc_atendimento_especialidade_gestor', 'idt', $vetCampo, $sql, $titulo, false,$vetParametros);
$vetParametros = Array(
	'codigo_pai' => 'grc_atendimento_especialidade_gestor_w',
	'width' => '100%',
);
$vetFrm[] = Frame('', Array(
	Array($vetCampo['grc_atendimento_especialidade_gestor']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);



// Ações para o Serviços
$vetParametros = Array(
		'codigo_frm' => 'grc_atendimento_especialidade_acao_w',
		'controle_fecha' => 'A',
	//	'barra_inc_ap' => false,
	//	'barra_alt_ap' => false,
	//	'barra_con_ap' => false,
	//	'barra_exc_ap' => false,

);
$vetFrm[] = Frame('<span>AÇÕES DO SERVIÇO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
// Definição de campos formato full que serão editados na tela full
$vetCampo = Array();
$vetCampo['tipo_acao'] = CriaVetTabela('Tipo Ação','descDominio',$vetTPAC);
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['ativo']     = CriaVetTabela('Ativo?','descDominio',$vetSimNao);

$titulo           = 'Ações do Serviço';
$TabelaPrinc      = "grc_atendimento_especialidade_acao";
$AliasPric        = "grc_aea";
$Entidade         = "Ação do Serviço";
$Entidade_p       = "Ações do Serviço";
// Select para obter campos da tabela que serão utilizados no full
$orderby = "grc_aea.tipo_acao, grc_aea.codigo  ";
$sql  = "select {$AliasPric}.* ";
//$sql .= "       grc_ae.descricao as servico ";
//$sql .= "       sca_os.descricao as ponto_atendimento ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//$sql .= " inner join grc_atendimento_especialidade grc_ae on  grc_ae.idt = {$AliasPric}.idt_servico ";
//$sql .= " inner join ".db_pir."sca_organizacao_secao sca_os on  sca_os.idt = {$AliasPric}.idt_ponto_atendimento";
//
$sql .= " where {$AliasPric}".'.idt_especialidade = $vlID';
$sql .= " order by {$orderby}";
$vetCampo['grc_atendimento_especialidade_acao'] = objListarConf('grc_atendimento_especialidade_acao', 'idt', $vetCampo, $sql, $titulo, false,$vetParametros);
$vetParametros = Array(
	'codigo_pai' => 'grc_atendimento_especialidade_acao_w',
	'width' => '100%',
);
$vetFrm[] = Frame('', Array(
	Array($vetCampo['grc_atendimento_especialidade_acao']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// Duração Serviços
$vetParametros = Array(
		'codigo_frm' => 'grc_atendimento_especialidade_duracao_w',
		'controle_fecha' => 'A',
		'barra_inc_ap' => false,
		'barra_alt_ap' => false,
		'barra_con_ap' => false,
		'barra_exc_ap' => false,

);
$vetFrm[] = Frame('<span>DURAÇÕES DO SERVIÇO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
// Definição de campos formato full que serão editados na tela full
$vetCampo = Array();
$vetCampo['duracao'] = CriaVetTabela('Duração do Atendimento<br />(Minutos)');
$titulo           = 'Durações do Serviço';
$TabelaPrinc      = "grc_atendimento_especialidade_duracao";
$AliasPric        = "grc_aed";
$Entidade         = "Duração do Serviço";
$Entidade_p       = "Duração dos Serviços";
// Select para obter campos da tabela que serão utilizados no full
$orderby = "grc_aed.duracao  ";
$sql  = "select {$AliasPric}.* ";
//$sql .= "       grc_ae.descricao as servico ";
//$sql .= "       sca_os.descricao as ponto_atendimento ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//$sql .= " inner join grc_atendimento_especialidade grc_ae on  grc_ae.idt = {$AliasPric}.idt_servico ";
//$sql .= " inner join ".db_pir."sca_organizacao_secao sca_os on  sca_os.idt = {$AliasPric}.idt_ponto_atendimento";
//
$sql .= " where {$AliasPric}".'.idt_especialidade = $vlID';
$sql .= " order by {$orderby}";
$vetCampo['grc_atendimento_especialidade_duracao'] = objListarConf('grc_atendimento_especialidade_duracao', 'idt', $vetCampo, $sql, $titulo, false,$vetParametros);
$vetParametros = Array(
	'codigo_pai' => 'grc_atendimento_especialidade_duracao_w',
	'width' => '100%',
);
$vetFrm[] = Frame('', Array(
	Array($vetCampo['grc_atendimento_especialidade_duracao']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
$vetCad[] = $vetFrm;
?>
<script>
$(document).ready(function () {
   CalculaOpcoes('');
});

function CalculaOpcoes(thisw)
{
   if (thisw!='')
   {
       enumero(thisw);
   }
   //var periodo            = $('#periodo').val;
   //var quantidade_periodo = $('#quantidade_periodo').val;   
   
   
   var periodo            = 0;
   var quantidade_periodo = 0;   
   
   var id='periodo';
   objtp           = document.getElementById(id);
   if (objtp != null) {
       periodo = objtp.value;
   }
   var id='quantidade_periodo';
   objtp           = document.getElementById(id);
   if (objtp != null) {
       quantidade_periodo = objtp.value;
   }
    //alert ('calcula opções '+periodo+'---- '+quantidade_periodo); 
   
   
   var opcoes_trab = "Opções [ " + periodo;
   if (quantidade_periodo=='')
   {
       opcoes_trab = opcoes_trab +" ]";
   }
   else
   {
	   if (quantidade_periodo==1)
	   {
		   opcoes_trab = opcoes_trab +" ]";
	   }
	   else
	   {
		  var x      = '';
		  for (c = 2; c <= quantidade_periodo; c++) {
			  x      = periodo*c;  
			  opcoes_trab = opcoes_trab +"; "+x;
					
          }
		  
		  opcoes_trab = opcoes_trab +" ]";
	   }
    }   
    objd=document.getElementById('id_opcoes_escolha');
    if (objd != null)
    {
	   objd.innerHTML=opcoes_trab;
    }
    objd=document.getElementById('opcoes_escolher');
    if (objd != null)
    {
	   var opcoes_trab2 = opcoes_trab.substr(7);
	   objd.value=opcoes_trab2;
    }

  

}


</script>