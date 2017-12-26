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
    width:180px;
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



$tabela = 'grc_atendimento_agenda_log';
$id     = 'idt';
$idt_atendimento_agenda_log=$_GET['id'];
$acao = 'con';
$sql  = "select  ";
$sql .= " grc_aal.*  ";
$sql .= " from grc_atendimento_agenda_log grc_aal ";
$sql .= " where idt = {$idt_atendimento_agenda_log} ";
$rs = execsql($sql);
$wcodigo = '';
ForEach($rs->data as $row)
{
	$situacao    = $row['situacao'];
	$origem      = $row['origem'];
	$idt_cliente = $row['idt_cliente'];
	$cpf_cliente = $row['cpf'];
	$idt_ponto_atendimento  = $row['idt_ponto_atendimento'];
	$idt_consultor = $row['idt_consultor'];                      // incluído 07/08/2015 - gilmar
	$servicos      = $row['servicos'];
	//echo " {$situacao} cli= {$idt_cliente} pa =  {$idt_ponto_atendimento} Con =  {$idt_consultor}<br />";
	if ($idt_cliente=="")
	{
		$idt_cliente=0;
	}
}
//////////////
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['observacao_chegada']     = objTexto('observacao_chegada', 'Observação Chegada', false, 30, 255,$js);
$vetCampo['observacao_atendimento'] = objTexto('observacao_atendimento', 'Observação Atendimento', false, 30, 255,$js);


$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data_confirmacao']   = objData('data_confirmacao', 'Data Confirmação', False, $js);

$vetCampo['hora_confirmacao'] = objTexto('hora_confirmacao', 'Hora Confirmação', False, 5, 5, $js);
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['hora_chegada'] = objTexto('hora_chegada', 'Hora Chegada', False, 5, 5,$js);
$vetCampo['hora_atendimento'] = objTexto('hora_atendimento', 'Hora Inicial Atendimento', False, 5, 5,$js);
$vetCampo['hora_final_atendimento'] = objTexto('hora_final_atendimento', 'Hora Final Atendimento', False, 5, 5,$js);
$vetCampo['hora_liberacao'] = objTexto('hora_liberacao', 'Hora Liberação', False, 5, 5,$js);

$js    = "   readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['dia_semana'] = objTexto('dia_semana', 'Dia Semana', false, 3, 3,$js);
//$vetCampo['telefone'] = objTexto('telefone', 'Telefone', False, 15, 15);
//$vetCampo['celular'] = objTexto('celular', 'Celular', False, 15, 15);
$vetCampo['origem'] = objTexto('origem', 'Origem', False,15,15,$js);



//$js=" style='width:140px; ' ";
//$js="  ";
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";

$vetCampo['telefone']         = objTelefone('telefone', 'Telefone de Contato', false, $js);
$vetCampo['celular']          = objTelefone('celular', 'Celular de Contato', false, $js);
$vetCampo['email']            = objEmail('email', 'Email de Contato', false, 35, 120,'S', $js);


//$sql  = "select idt, descricao from grc_atendimento_situacao_agenda ";
//$sql .= " order by descricao";
//$vetCampo['idt_situacao'] = objCmbBanco('idt_situacao', 'Situação', false, $sql,' ','width:100px;');

$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['situacao'] = objTexto('situacao', 'Situação', false, 10, 20,$js);



if ($origem=="Hora Marcada")
{
    $js_hm   = " disabled  ";
    $style   = 'background:#FFFF80; font-size:14px; width:200px;';
    
}
else
{
    $js_hm   = "";
    $style   = ' width:700px;';
}

    $js_hm   = "";
    $style   = ' width:300px;';

$sql  = "select idt, descricao from grc_atendimento_especialidade ";
$sql .= " order by descricao";
    $js_hm   = " disabled  ";
    $style   = 'background:#FFFF80; font-size:14px; width:400px;';

$vetCampo['idt_especialidade'] = objCmbBanco('idt_especialidade', 'Serviço', false, $sql,' ',$style,$js_hm);




$fixaunidade=0;
$sql  = "select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
$sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";
if ($idt_ponto_atendimento>0)
{
    $fixaunidade=1;
    $sql .= " where grc_pap.idt_ponto_atendimento = ".null($idt_ponto_atendimento);
}


if ($idt_consultor > 0)
{
    if ($fixaunidade == 1)
    {
       $sql .= " and plu_usu.id_usuario = ".null($idt_consultor);     // gilmar - 07/08/2015
    }
    else
    {
       $sql .= " where plu_usu.id_usuario = ".null($idt_consultor);     // gilmar - 07/08/2015
    }
}

$sql .= " order by plu_usu.nome_completo";
$vetCampo['idt_consultor'] = objCmbBanco('idt_consultor', 'Consultor/Atendente', false, $sql,'',$style,$js_hm);

$maxlength  = 2000;
// $style      = "width:700px; ";
$js         = " disabled ";
// $style      = " background:#FFFF80; ";
$style      = "";
//$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";

$vetCampo['assunto'] = objTextArea('assunto', 'Resumo do Assunto', true, $maxlength, $style, $js);


//$sql  = "select idt, descricao from ".db_pir_gec."gec_entidade ";
//$sql .= " order by descricao";
//$vetCampo['idt_cliente'] = objCmbBanco('idt_cliente', 'Cliente', false, $sql,' ','width:400px;');

if ($idt_cliente>0)
{
    $jst    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";

}
else
{
    $jst="  ChamaCPFEspecial(this)  ";
}
if ($deondeveio=="Distancia")
{
     $jst="  ChamaCPFEspecial(this)  ";
}
$vetCampo['cpf']              = objCPF('cpf', 'CPF do Cliente', true,true,'',$jst);

$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['cliente_texto']    = objTexto('cliente_texto', 'Cliente', false, 40, 120,$js);

if ($origem=="Hora Marcada")
{
    $vetCampo['idt_cliente']      = objListarCmb('idt_cliente', 'gec_entidade_agenda_cmb', 'Cliente', false,'450px');
}
else
{
    $vetCampo['idt_cliente']      = objListarCmb('idt_cliente', 'gec_entidade_agenda_cmb', 'Cliente', false,'450px');
}

$vetCampo['idt_cliente'] = objHidden('idt_cliente', '');


$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['cnpj']             = objCNPJ('cnpj', 'CNPJ da Empresa', false, true, 15,$js);
$vetCampo['nome_empresa']     = objTexto('nome_empresa', 'Nome completo da Empresa', false, 40, 120,$js);




//$sql  = "select idt, descricao from ".db_pir."sca_organizacao_secao ";
//$sql .= " order by descricao";

if ($fixaunidade==0)
{   // Todos
    $sql   = 'select ';
    $sql  .= '   idt, descricao  ';
    $sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
    $sql  .= ' order by classificacao ';
    $js = " ";
    $vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto Atendimento', true, $sql,' ','width:250px;',$js);

}
else
{
    $sql   = 'select ';
    $sql  .= '   idt, descricao  ';
    $sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql  .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";
    $sql  .= "   and idt = ".null($idt_ponto_atendimento);
    $sql  .= ' order by classificacao ';
    //$js = " disabled ";
    $vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto Atendimento', true, $sql,'','background:#FFFF80; width:250px;',$js);

}





$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observações para Recepção', false, $maxlength, $style, $js);
$vetCampo['confirmacao_chegada'] = objInclude('confirmacao_chegada', 'cadastro_conf/confirmacao_chegada.php');
$vetCampo['confirmacao_liberacao'] = objInclude('confirmacao_liberacao', 'cadastro_conf/confirmacao_liberacao.php');
$vetCampo['chama_atendimento'] = objInclude('chama_atendimento', 'cadastro_conf/chama_atendimento.php');
$vetCampo['confirmacao_atendimento'] = objInclude('confirmacao_atendimento', 'cadastro_conf/confirmacao_atendimento.php');
//$vetCampo['confirmacao_agendamento'] = objInclude('confirmacao_agendamento', 'cadastro_conf/confirmacao_agendamento.php');
$vetCampo['confirmacao_agendamento_desconfirma']  = objInclude('confirmacao_agendamento_desconfirma', 'cadastro_conf/confirmacao_agendamento_desconfirma.php');
$vetCampo['confirmacao_agendamento_bloqueio']     = objInclude('confirmacao_agendamento_bloqueio', 'cadastro_conf/confirmacao_agendamento_bloqueio.php');
$vetCampo['confirmacao_agendamento_cancelamento'] = objInclude('confirmacao_agendamento_cancelamento', 'cadastro_conf/confirmacao_agendamento_cancelamento.php');
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$js         = " visibility='hidden' ";
$js         = "";
$vetCampo['tipo_pessoa']      = objCmbVetor('tipo_pessoa', 'Prioridade?', false, $vetNaoSim,'',$js);
$maxlength  = 2000;
$style      = "width:600px;  background:#FFFF80; font-size:14px;";
$js         = " readonly='true' ";
$vetCampo['mensagem'] = objTextArea('mensagem', 'Forma de atendimento na Fila', false, $maxlength, $style, $js);
$vetCampo['botao_atendimento_agenda_prioridade_sim'] = objInclude('botao_atendimento_agenda_prioridade_sim', 'cadastro_conf/botao_atendimento_agenda_prioridade_sim.php');
$vetCampo['botao_atendimento_agenda_prioridade_nao'] = objInclude('botao_atendimento_agenda_prioridade_nao', 'cadastro_conf/botao_atendimento_agenda_prioridade_nao.php');
$vetCampo['botao_hora_marcada_agenda'] = objInclude('botao_hora_marcada_agenda', 'cadastro_conf/botao_hora_marcada_agenda.php');
$vetCampo['botao_hora_extra_agenda']   = objInclude('botao_hora_extra_agenda', 'cadastro_conf/botao_hora_extra_agenda.php');
$js         = " visibility='hidden' ";

$vetCampo['hora_marcada_extra']      = objCmbVetor('hora_marcada_extra', 'Hora Marcada?', false, $vetSimNao,' ',$js);




$vetCampo_w['botao_inicia_atendimento_agenda'] = objInclude('botao_inicia_atendimento_agenda', 'cadastro_conf/botao_inicia_atendimento_agenda.php');


$vetCampo['botao_atendimento_agenda_cadastro_pessoa'] = objInclude('botao_atendimento_agenda_cadastro_pessoa', 'cadastro_conf/botao_atendimento_agenda_cadastro_pessoa.php');

$js    = "";
$vetCampo['tipo']        = objTexto('tipo', 'Tipo de Movimentação',false,45,45,$js);
$vetCampo['dataregistro'] = objDatahora('dataregistro', 'Data do registro', False,$js);




//$vetCampo['protocolo']        = objAutonum('protocolo', 'Senha',15,true);
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";

$vetCampo['protocolo']        = objTexto('protocolo', 'Protocolo de Marcação',false,15,45,$js);
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data_hora_marcacao'] = objDatahora('data_hora_marcacao', 'Data Marcação', False,$js);



$vetCampo['necessidade_especial'] = objCmbVetor('necessidade_especial', 'Portador de Necessidades Especiais?', false, $vetNaoSim, '', $js2);
$sql_lst_1 = 'select idt as idt_tipo_deficiencia, descricao from '.db_pir_gec.'gec_entidade_tipo_deficiencia order by descricao';

$sql_lst_2 = 'select ds.idt as idt_tipo_deficiencia, ds.descricao from '.db_pir_gec.'gec_entidade_tipo_deficiencia ds inner join
               grc_atendimento_pessoa_tipo_deficiencia dr on ds.idt = dr.idt_tipo_deficiencia
               where dr.idt = $vlID order by ds.descricao';
$vetCampo['idt_tipo_deficiencia'] = objLista('idt_tipo_deficiencia', false, 'Deficiência do Sistema', 'idt_tipo_deficiencia1', $sql_lst_1, 'grc_atendimento_pessoa_tipo_deficiencia', 200, 'Deficiência Selecionadas', 'idt_tipo_deficiencia2', $sql_lst_2);
$par = 'idt_tipo_deficiencia';
$vetDesativa['necessidade_especial'][0] = vetDesativa($par);
$vetAtivadoObr['necessidade_especial'][0] = vetAtivadoObr($par, 'S', true, '_lst_2');



$titulo_cadastro="LOG DO AGENDAMENTO";

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

 
$maxlength  = 2000;
//$style    = "width:700px;";
$style      = "";
$js         = "";
$vetCampo['observacao_desmarcacao'] = objTextArea('observacao_desmarcacao', 'Observações ', false, $maxlength, $style, $js);
$idt_ponto_atendimento  =$_GET['idt_ponto_atendimento'];
$vetFrm = Array();
MesclarCol($vetCampo['protocolo'], 5);
MesclarCol($vetCampo['idt_cliente'], 5);
//MesclarCol($vetCampo['dataregistro'], 3);
MesclarCol($vetCampo['idt_consultor'], 3);
MesclarCol($vetCampo['hora'], 3);
MesclarCol($vetCampo['cliente_texto'], 3);
MesclarCol($vetCampo['nome_empresa'], 3);
MesclarCol($vetCampo['idt_especialidade'], 5);
MesclarCol($vetCampo['assunto'], 5);
MesclarCol($vetCampo['observacao_desmarcacao'], 5);

$vetFrm[] = Frame('', Array(
	Array($vetCampo['idt_cliente']),

    Array($vetCampo['tipo'],'',$vetCampo['dataregistro'],'',$vetCampo['protocolo']),
	Array($vetCampo['situacao'] ,'', $vetCampo['idt_consultor']),
	Array($vetCampo['data'],'',$vetCampo['hora']),
	Array($vetCampo['cpf'],'', $vetCampo['cliente_texto']),
	Array($vetCampo['cnpj'],'', $vetCampo['nome_empresa']),
	Array($vetCampo['telefone'],'',$vetCampo['celular'],'',$vetCampo['email']),
	Array($vetCampo['idt_especialidade']),
	Array($vetCampo['assunto']),
	Array($vetCampo['observacao_desmarcacao']),
	
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
$vetCad[] = $vetFrm;

?>
<script>

var idt_atendimento_agenda_log  =  '<?php echo  $idt_atendimento_agenda_log; ?>' ;
</script>
