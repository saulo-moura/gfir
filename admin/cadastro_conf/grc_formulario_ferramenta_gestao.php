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

if ($_SESSION[CS]['g_id_usuario']!=1)
{
    if ($acao=='inc' or $acao=='exc')
	{
        $acao='con';
	}	
}

$tabela = 'grc_formulario_ferramenta_gestao';
$id = 'idt';
$vetCampo['codigo']    = objInteiro('codigo', 'Número', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Título', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
//
$vetNivel=Array();
$vetNivel[1]='BÁSICO';
$vetNivel[2]='INTERMEDIÁRIO';
$vetNivel[3]='AVANÇADO';
$vetCampo['nivel'] = objCmbVetor('nivel', 'Nível', True, $vetNivel);
$vetCampo['numero_pagina'] = objInteiro('numero_pagina', 'Página', false, 10, 120);
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";


$altura  = '250';
$largura = '800';
$js      = '';
$barra_aberto  = false;
$barra_simples = false;
$campo_fixo    = false;

$vetCampo['detalhe'] = objHtml('detalhe', '', false, $altura, $largura);
//
$sql = "select idt, descricao from grc_formulario_area   order by codigo";
$vetCampo['idt_area'] = objCmbBanco('idt_area', 'Área', true, $sql,'','width:100%;');
//


/*
$sql_lst_1 = 'select idt as idt_produto, descricao from grc_produto  order by codigo';


$sql_lst_2 = 'select ds.idt as idt_produto,  ds.descricao from grc_produto ds inner join
			   grc_nan_ferramenta_x_produto dr on ds.idt = dr.idt_produto
			   where dr.idt = '.null($_GET['id']).' order by ds.codigo';

$vetCampo['idt_produto'] = objLista('idt_produto', false, 'Produto', 'idt_produto1', $sql_lst_1, 'grc_nan_ferramenta_x_produto', 200, 'Produtos Selecionados', 'idt_produto2', $sql_lst_2);
*/




/////////////////////////////////////////

$vetFrm = Array();

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$titulo_cadastro = 'FERRAMENTAS DE GESTÃO';

$vetParametros = Array(
    'situacao_padrao' => true,
);
$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'relato01a',
    'controle_fecha' => 'A',
);


$vetFrm[] = Frame('<span>FERRAMENTA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'relato01a',
);



MesclarCol($vetCampo['idt_area'], 9);
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['idt_area']),
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['nivel'],'',$vetCampo['numero_pagina'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);




$vetFrm[] = Frame('O que é:', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

/*
$vetFrm[] = Frame('<span>Produtos Associados</span>', Array(
    Array($vetCampo['idt_produto']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/












//////////////////////////////////////

//
// ----------------------- PRODUTOS
//
$vetParametros = Array(
    'codigo_frm' => 'produto',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>PRODUTOS ASSOCIADOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();



$vetCampo['grc_ai_descricao'] = CriaVetTabela('Instrumento');
$vetCampo['grc_p_descricao']  = CriaVetTabela('Produto');


if ($sistema_origem=='GEC')
{
  //$vetCampo['qtd_pontos'] = CriaVetTabela('Qtd. Pontos');
}
$titulo = 'Produtos associadas à Ferramenta';

$TabelaPrinc  = "grc_nan_ferramenta_x_produto";
$AliasPric    = "grc_nfp";
$Entidade     = "Ferramenta x Produtos";
$Entidade_p   = "Ferramenta x Produtos";
$CampoPricPai = "idt_ferramenta";

//$orderby = " {$AliasPric}.valido, {$AliasPric}.codigo ";
$orderby = " grc_ai.descricao, grc_p.descricao ";

$sql  = "select {$AliasPric}.*, ";
$sql .= " grc_ai.descricao as grc_ai_descricao, ";
$sql .= " grc_p.descricao as grc_p_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left join grc_formulario_ferramenta_gestao grc_fg on grc_fg.idt = grc_nfp.idt ";
$sql .= " left join grc_produto grc_p on grc_p.idt                        = grc_nfp.idt_produto ";
$sql .= " left join grc_atendimento_instrumento grc_ai on grc_ai.idt      = grc_p.idt_instrumento ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".'$vlID';
$sql .= " order by {$orderby}";

$vetParametros = Array(
    'func_trata_row' => bloqueia_row_formulario,
);
$vetCampo[$TabelaPrinc] = objListarConf($TabelaPrinc, 'idt', $vetCampo, $sql, $titulo, true, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'produto',
    'width' => '100%',
);


$vetFrm[] = Frame('<span>'.$Entidade_p.$html.'</span>', Array(
    Array($vetCampo[$TabelaPrinc]),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);










$vetCad[] = $vetFrm;
?>