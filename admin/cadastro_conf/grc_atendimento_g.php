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
$tabela = 'grc_atendimento';
$id = 'idt';



if ($_GET['cont']!='s')
{
    if ($_GET['balcao']==2)
    {
        $instrumento=$_GET['instrumento'];
        if ($instrumento==1)
        {
            $acao='inc';
            $_GET['id']=0;
        }
        $html = ChamaInstrumentoContabiliza($instrumento);
        echo $html;
    }
}

$TabelaPai   = "grc_atendimento_agenda";
$AliasPai    = "grc_aa";
$EntidadePai = "Agenda";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_atendimento";
$AliasPric        = "grc_a";
$Entidade         = "Atendimento da Agenda";
$Entidade_p       = "Atendimentos da Agenda";
$CampoPricPai     = "idt_atendimento_agenda";

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'assunto', 0);




$idt_cliente = 0;
$idt_ponto_atendimento  = 0;
$idt_pessoa = 0;
$idt_projeto  = 0;
$idt_projeto_acao  = 0;
$idt_atendimento = $_GET['id'];
if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_a.*  ";
     $sql .= " from grc_atendimento grc_a ";
     $sql .= " where idt = {$idt_atendimento} ";
     $rs = execsql($sql);
     $wcodigo = '';
     ForEach($rs->data as $row)
     {
         $idt_cliente = $row['idt_cliente'];
         $idt_ponto_atendimento  = $row['idt_ponto_atendimento'];
         $idt_pessoa             = $row['idt_pessoa'];
         $idt_projeto            = $row['idt_projeto'];
         $idt_projeto_acao       = $row['idt_projeto_acao'];
         $idt_consultor          = $row['idt_consultor'];
     }
     if ($situacao=='Cancelado' or $situacao=='Bloqueado')
     {
     //    $acao='con';
     }
}
else
{

     $idt_consultor             = $_SESSION[CS]['g_id_usuario'];
     $idt_ponto_atendimento     = $_SESSION[CS]['g_idt_unidade_regional'];
     $idt_projeto               = $_SESSION[CS]['g_idt_projeto'];
     $idt_projeto_acao          = $_SESSION[CS]['g_idt_acao'];

}

$jst    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['protocolo']  = objTexto('protocolo', 'Protocolo', false, 15, 45, $jst);

$fixaunidade=1;
if ($fixaunidade==0)
{   // Todos
    $sql   = 'select ';
    $sql  .= '   sac_os.idt, sac_os.descricao  ';
    $sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql  .= " where sac_os.posto_atendimento = 'UR' or sac_os.posto_atendimento = 'S' ";
    $sql  .= ' order by sac_os.classificacao ';
    $js = " ";
    $vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto Atendimento', true, $sql,' ','width:250px;',$js);

}
else
{
    $sql   = 'select ';
    $sql  .= '   sac_os.idt, sac_os.descricao  ';
    $sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql  .= " where (sac_os.posto_atendimento = 'UR' or sac_os.posto_atendimento = 'S' ) ";
    $sql  .= "   and sac_os.idt = ".null($idt_ponto_atendimento);
    $sql  .= ' order by sac_os.classificacao ';
    $js = " disabled ";
    $vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto Atendimento', true, $sql,'','background:#FFFF80; width:250px;',$js);
}


$vetCampo['idt_pessoa']   = objListarCmb('idt_pessoa', 'gec_entidade_agenda_cmb', 'Pessoa', false,'450px');



$vetCampo['idt_cliente']  = objListarCmb('idt_cliente', 'gec_entidade_agenda_o_cmb', 'Cliente', false,'450px');

$fixaunidade=0;
$sql  = "select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
// $sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";
//if ($idt_ponto_atendimento>0)
//{
//    $fixaunidade=1;
//    $sql .= " where grc_pap.idt_ponto_atendimento = ".null($idt_ponto_atendimento);
//}
//$sql .= " order by plu_usu.nome_completo";
$sql .= " where plu_usu.id_usuario = ".null($idt_consultor);

$js_hm    = " disabled style='background:#FFFF80; font-size:14px;' ";
$vetCampo['idt_consultor'] = objCmbBanco('idt_consultor', 'Consultor/Atendente', false, $sql,' ',$style, $js_hm);

$maxlength  = 2000;
$style      = "width:830px; ";
$js         = "";
$vetCampo['assunto'] = objTextArea('assunto', 'Resumo do Assunto', false, $maxlength, $style, $js);

if ($idt_pessoa>0)
{
    $jst    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";

}
else
{
    $jst="  ChamaCPFEspecial(this)  ";
}
$vetCampo['cpf']              = objCPF('cpf', 'CPF da Pessoa', false,true,'',$jst);
$vetCampo['nome_pessoa']     = objTexto('nome_pessoa', 'Nome completo da pessoa', false, 60, 120);


if ($idt_cliente>0)
{
    $jst    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";

}
else
{
    $jst="  ChamaCNPJEspecial(this)  ";
}

$vetCampo['cnpj']             = objCNPJ('cnpj', 'CNPJ da Empresa', false, true, 15);
$vetCampo['nome_empresa']     = objTexto('nome_empresa', 'Nome completo da empresa', false, 60, 120);

$sql  = "select grc_p.idt, grc_p.descricao from grc_projeto grc_p ";
$sql .= " where  grc_p.idt = ".null($idt_projeto);
$sql .= " order by grc_p.descricao";
$vetCampo['idt_projeto']               = objCmbBanco('idt_projeto', 'Projeto', false, $sql,' ','width:500px;',$js_hm);


$sql  = "select grc_pa.idt,  grc_pa.descricao from grc_projeto_acao grc_pa ";
$sql .= " inner join grc_projeto grc_p on grc_p.idt =  grc_pa.idt_projeto ";
$sql .= " where grc_pa.idt =  ".null($idt_projeto_acao);
$sql .= " order by  grc_pa.descricao";


$js_hm    = " disabled style='background:#FFFF80; font-size:14px;' ";
$vetCampo['idt_projeto_acao']               = objCmbBanco('idt_projeto_acao', 'Ação do Projeto', false, $sql,' ','width:500px;',$js_hm);


$jst    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data']   = objData('data', 'Data', False,$jst);

$vetCampo['data_inicio_atendimento']   = objDatahora('data_inicio_atendimento', 'Data Inicio Atendimento', False);
$vetCampo['data_termino_atendimento']  = objDatahora('data_termino_atendimento', 'Data Termino Atendimento', False);


$vetCampo['primeiro']     = objTexto('primeiro', 'Primeiro?', false, 3, 3);





$js_hm   = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['hora_inicio_atendimento'] = objHora('hora_inicio_atendimento', 'Hora Inicial', True,$js_hm);
$js_hm   = "";
$vetCampo['hora_termino_atendimento'] = objHora('hora_termino_atendimento', 'Hora Final', True,$js_hm);
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['horas_atendimento']         = objDecimal('horas_atendimento','Duração (m.)',false,5,'',2,$js);


$vetCampo['botao_concluir_atendimento'] = objInclude('botao_concluir_atendimento', 'cadastro_conf/botao_concluir_atendimento.php');
$vetCampo['botao_barra_tarefa_atendimento'] = objInclude('botao_barra_tarefa_atendimento', 'cadastro_conf/botao_barra_tarefa_atendimento.php');



$vetCampow=$vetCampo;

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$titulo_cadastro="REGISTRO DO ATENDIMENTO";

$vetFrm = Array();
$vetParametros = Array(
    'situacao_padrao' => true,
);
$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

// Definição de um frame ou seja de um quadro da tela para agrupar campos

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>01 - IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parte01',
);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['protocolo'],'',$vetCampo['idt_ponto_atendimento'],'',$vetCampo['idt_projeto']),
    Array('','',$vetCampo['idt_consultor'],'',$vetCampo['idt_projeto_acao']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


$vetFrm[] = Frame('<span>Barra de Tarefas </span>', Array(
    Array($vetCampo['botao_barra_tarefa_atendimento']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


$vetFrm[] = Frame('<span>Registro do Tempo de atendimento</span>', Array(
   // Array($vetCampo['protocolo'],'',$vetCampo['data_inicio_atendimento'],'',$vetCampo['data_termino_atendimento'],'',$vetCampo['horas_atendimento']),
   // Array($vetCampo['protocolo']),

    Array($vetCampo['data'],'',$vetCampo['hora_inicio_atendimento'],'',$vetCampo['hora_termino_atendimento'],'',$vetCampo['horas_atendimento'],'',$vetCampo['botao_concluir_atendimento']),
    

),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

MesclarCol($vetCampo['assunto'], 3);
$vetFrm[] = Frame('<span>Cliente</span>', Array(
    Array($vetCampo['cpf'],'',$vetCampo['idt_pessoa']),
    Array('','',$vetCampo['nome_pessoa']),
    Array($vetCampo['cnpj'],'',$vetCampo['idt_cliente']),
    Array('','',$vetCampo['nome_empresa']),
    Array($vetCampo['assunto']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);




// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// DIAGNOSTICOS DE ATENDIMENTO
//____________________________________________________________________________

// Definição do frame DIAGNOSTICO ASSOCIADO
// NOME DO FRAME = diagnostico_associado
// controle_fecha = A(o full entra aberto) F(O full entra fechado)

$vetParametros = Array(
    'codigo_frm' => 'atendimento_diagnostico',
    'controle_fecha' => 'F',
);
$vetFrm[] = Frame('<span>2 - DIAGNÓSTICOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
//Monta o vetor de Campo
$vetCampo['codigo']           = CriaVetTabela('Código');
$vetCampo['grc_ps_descricao'] = CriaVetTabela('Diagnostico Associado');
$vetCampo['descricao']        = CriaVetTabela('Descrição');
$vetCampo['ativo']            = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

// Parametros da tela full conforme padrão

$titulo = 'Diagnósticos do Atendimento';

$TabelaPrinc      = "grc_atendimento_diagnostico";
$AliasPric        = "grc_atd";
$Entidade         = "Diagnóstico de Atendimento";
$Entidade_p       = "Diagnósticos de Atendimento";

$CampoPricPai     = "idt_diagnostico";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.codigo";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "  grc_ps.descricao as grc_ps_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";

$sql .= " inner join grc_diagnostico grc_ps on grc_ps.idt = {$AliasPric}.idt_diagnostico ";
//
$sql .= " where {$AliasPric}".'.idt_atendimento = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full

$vetCampo['grc_atendimento_diagnostico'] = objListarConf('grc_atendimento_diagnostico', 'idt', $vetCampo, $sql, $titulo, false);

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'atendimento_diagnostico',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['grc_atendimento_diagnostico']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________


$barra_inc_ap = true;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = true;
$barra_fec_ap = true;


$vetParametros = Array(
    'codigo_frm' => 'atendimento_produto',
    'controle_fecha' => 'F',
    'barra_inc_ap' => true,
    'barra_alt_ap' => false,
    'barra_con_ap' => true,
    'barra_exc_ap' => false,
);
$vetFrm[] = Frame('<span>3 - PRODUTOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
//Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
$vetCampo['grc_pp_descricao'] = CriaVetTabela('Produto');

// Parametros da tela full conforme padrão

$titulo = 'Produtos';

$TabelaPrinc      = "grc_atendimento_produto";
$AliasPric        = "grc_apr";
$Entidade         = "Produto";
$Entidade_p       = "Produtos";

$CampoPricPai     = "idt_produto";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.codigo";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "  grc_pp.descricao as grc_pp_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";

$sql .= " inner join grc_produto grc_pp on grc_pp.idt = {$AliasPric}.idt_produto ";
//
$sql .= " where {$AliasPric}".'.idt_atendimento = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full

$vetCampo['grc_atendimento_produto'] = objListarConf('grc_atendimento_produto', 'idt', $vetCampo, $sql, $titulo, false);

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'atendimento_produto',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['grc_atendimento_produto']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);





$vetCad[] = $vetFrm;
?>
<script>
function ChamaCPFEspecial(thisw)
{
    var ret = Valida_CPF(thisw);
    //alert('xxx acessar pessoa '+thisw.value+ ' == '+ ret );
    //var cpf = thisw.value;
    if (ret && thisw.value!='')
    {
//        ChamaPessoa();
    }
    return ret;
}
function ChamaCNPJespecial(thisw)
{
    var ret = Valida_CNPJ(thisw);
    //alert('xxx acessar pessoa '+thisw.value+ ' == '+ ret );
    //var cpf = thisw.value;
    if (ret && thisw.value!='')
    {
//        ChamaPessoa();
    }
    return ret;
}

</script>
