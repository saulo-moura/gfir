<style>
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }

    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        background:#FFFFFF;
        border:0px solid #FFFFFF;
    }

    div.class_titulo_p {
        background: #2F66B8;
        text-align: left;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        xheight    : 20px;
        font-size : 16px;
        padding:10px;
    }

    div.class_titulo_p span {
        padding:10px;
        font-size:18px;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #c4c9cd;
        border    : none;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 20px;
    }

    fieldset.class_frame {
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }

    div.class_titulo {
        text-align: left;
        background: #FFFFFF;
        color     : #000000;
        border    : 0px solid #2C3E50;
		margin-top: 20px;
        text-align:center;		
    }

    div.class_titulo span {
        padding-left:10px;
    }

    div.class_titulo_c {
        text-align: center;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo_c span {
        padding-left:10px;
    }


/*
    Select {
        border:0px;
        height:28px;
    }
*/
    .TextoFixo {
        font-size:12px;
        text-align:left;
        border:0px;
        background:#ECF0F1;
        font-weight:normal;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;
    }
    td {
        padding-top:0px;
    }
</style>



<?php




$botao_volta = " self.location = 'conteudo.php?prefixo=inc&menu=grc_nan_parametros_projeto'; ";
$botao_acao = '<script type="text/javascript">self.location = '.'"'.'conteudo.php?prefixo=inc&menu=grc_nan_parametros_projeto'.'";'.'</script>';


$class_frame_f   = "class_frame_f";
$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;

/*
echo "<div id='titulo_tela'>";
echo " ";
echo "</div>'>";
*/



$_GET['id']=1;

//
$TabelaPrinc      = "grc_nan_parametros_projetos";
$AliasPric        = "grc_npp";
$Entidade         = "Parametros do NAN";
$Entidade_p       = "Parametros do NAN";
$CampoPricPai     = "idt";

$tabela = $TabelaPrinc;
$id = 'idt';
//
$class_frame_f   = "class_frame_f";
$class_titulo_f  = "class_titulo_f";

$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";


$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;

$titulo_cadastro = "PARÂMETROS ADMINISTRATIVOS";
$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame("<span><span>{$titulo_cadastro}</span></span>", '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


$vetParametros = Array(
    'codigo_pai' => 'parte01',
	'width' => '60%',
);



//$vetCampo['data_validade']        = objData('data_validade', 'Validade', False,'','','S');
$vetCampo['numero_max_visita']      = objInteiro('numero_max_visita', 'Número máximo<br />de Visitas<br />(por Dia)', true);
$vetCampo['numero_adicinal_visita'] = objInteiro('numero_adicinal_visita', 'Número adicional<br /> de Visitas<br />(por Dia)', False);
$vetCampo['prazo_max_1_2']          = objInteiro('prazo_max_1_2', 'Prazo Máximo<br /> entre Visitas 1 e 2<br />(Dias corridos)', true);
$vetCampo['prazo_max_2_3']          = objInteiro('prazo_max_2_3', 'Prazo Máximo<br /> entre Visitas 2 e 3<br />(Dias corridos)', False);
$vetCampo['prazo_tutor']            = objInteiro('prazo_tutor', 'Prazo Máximo<br /> de Apuração do Tutor<br />(Dias corridos)', False);

$vetCampo['valor_visita1']          = objDecimal('valor_visita1', 'Valor R$ Visita 1', False);
$vetCampo['valor_visita2']          = objDecimal('valor_visita2', 'Valor R$ Visita 2', False);


$sql_lst_1 = 'select idt as idt_publico_alvo, descricao from grc_publico_alvo  order by codigo';

$sql_lst_2 = 'select ds.idt as idt_publico_alvo,  ds.descricao from grc_publico_alvo ds inner join
			   grc_nan_parametros_projetos_publico_alvo dr on ds.idt = dr.idt_publico_alvo
			   where dr.idt = '.null($_GET['id']).' order by ds.codigo';

$vetCampo['idt_publico_alvo'] = objLista('idt_publico_alvo', true, 'Público Alvo', 'idt_publico_alvo1', $sql_lst_1, 'grc_nan_parametros_projetos_publico_alvo', 250, 'Publico Alvo Selecionados', 'idt_publico_alvo2', $sql_lst_2);





MesclarCol($vetCampo['numero_adicinal_visita'], 3);
MesclarCol($vetCampo['valor_visita2'], 3);
//MesclarCol($vetCampo['idt_publico_alvo'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['numero_max_visita'],'',$vetCampo['numero_adicinal_visita']),
	Array($vetCampo['prazo_max_1_2'],'',$vetCampo['prazo_max_2_3'],'',$vetCampo['prazo_tutor']),
	
	Array($vetCampo['valor_visita1'],'',$vetCampo['valor_visita2']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

$vetFrm[] = Frame('<span>Restrição de Atendimento por Público Alvo:</span>', Array(
	Array($vetCampo['idt_publico_alvo']),
	
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


////////////////////////////// projetos
$vetParametros = Array(
    'codigo_frm' => 'acao_produto',
    'controle_fecha' => 'A',
	'barra_inc_ap' => false,
	'barra_alt_ap' => true,
	'barra_con_ap' => true,
	'barra_exc_ap' => false,
	
);
$vetFrm[] = Frame('<span>PROJETOS E AÇÔES DO NAN</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
//Monta o vetor de Campo


$vetCampo['grc_p_descricao']         = CriaVetTabela('Projeto');
$vetCampo['descricao']               = CriaVetTabela('Ação');
$vetCampo['numero_max_visita']       = CriaVetTabela('Número máximo<br />de Visitas<br />(por Dia)');

$vetCampo['adicional']               = CriaVetTabela('Visitas Adicionais?','descDominio',$vetSimNao);

$vetCampo['numero_adicinal_visita'] = CriaVetTabela('Número adicional<br /> de Visitas<br />(por Dia)');
$vetCampo['data_validade']           = CriaVetTabela('Data Validade','data');

$vetCampo['prazo_max_1_2']           = CriaVetTabela('Prazo Máximo<br /> entre Visitas 1 e 2<br />(Dias corridos)');
$vetCampo['prazo_max_2_3']           = CriaVetTabela('Prazo Máximo<br /> entre Visitas 2 e 3<br />(Dias corridos)');
$vetCampo['prazo_tutor']             = CriaVetTabela('Prazo Máximo<br /> de Apuração do Tutor<br />(Dias corridos)');



// Parametros da tela full conforme padrão

$titulo = 'Ações do Projeto';

$TabelaPrinc      = "grc_projeto_acao";
$AliasPric        = "grc_ppp";
$Entidade         = "Ação de Projetos";
$Entidade_p       = "Ações de Projetos";

$CampoPricPai     = "idt_projeto";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "grc_p.descricao, {$AliasPric}.descricao";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "  grc_ps.descricao as grc_ps_descricao, ";
$sql  .= "  grc_p.descricao as grc_p_descricao, ";
$sql  .= "  plu_usu.nome_completo as plu_usu_nome_completo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left join grc_projeto grc_p on grc_p.idt = {$AliasPric}.idt_projeto ";
$sql .= " left join grc_projeto_acao_n grc_ps on grc_ps.idt = {$AliasPric}.idt_projeto_acao_n ";
$sql .= " left join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario_criador ";
// $sql .= " where {$AliasPric}".'.idt_projeto = $vlID';
//$sql .= " and {$AliasPric}".'.nan = '.aspa('S');
$sql .= " where {$AliasPric}".'.nan = '.aspa('S');
$sql .= " order by {$orderby}";
$vetCampo['grc_projeto_acao_nan'] = objListarConf('grc_projeto_acao_nan', 'idt', $vetCampo, $sql, $titulo, false,$vetParametros);

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'acao_produto',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_projeto_acao_nan']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


/////////////////

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
    });
</script>	