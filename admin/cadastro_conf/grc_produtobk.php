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
$tabela = 'grc_produto';
$id = 'idt';

////////////////////////////////////////////
$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;
$titulo_cadastro="PRODUTO";
////////////////////////////////////

$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();

$vetParametros = Array(
    'situacao_padrao' => true,
);
$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>1 - IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);


//PRODUTOS ASSOCIADOS
_______________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'produto_associado',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>2 - PRODUTOS ASSOCIADOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
$vetCampo['grc_pp_descricao'] = CriaVetTabela('Produto Associado');


$titulo = 'Produtos Associados';

$TabelaPrinc      = "gec_edital_etapas";
$AliasPric        = "gec_edets";
$Entidade         = "Etapa  do Edital";
$Entidade_p       = "Etapas do Edital";

$TabelaPrinc      = "grc_produto_produto";
$AliasPric        = "grc_atdp";
$Entidade         = "Produto Associado do Produto";
$Entidade_p       = "Produtos Associado do Produto";

$CampoPricPai     = "idt_produto";

$orderby = "{$AliasPric}.codigo";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       gec_pp.descricao as grc_pp_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_produto grc_pp on grc_pp.idt = {$AliasPric}.idt_produto_associado ";
//
$sql .= " where {$AliasPric}".'.idt_produto = $vlID';
$sql .= " order by {$orderby}";


$vetCampo['grc_produto_produto'] = objListarConf('grc_produto_produto', 'idt', $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'codigo_pai' => 'produto_associado',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['grc_produto_produto']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

//CONTEÚDO PROGRAMÁTICO
//_____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'conteudo_programatico',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>3 - CONTEÚDO PROGRAMÁTICO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
// $vetCampo['grc_pp_descricao'] = CriaVetTabela('Produto Associado');


$titulo = 'Conteudo Programático';

$TabelaPrinc      = "grc_produto_conteudo_programatico";
$AliasPric        = "grc_atdp";
$Entidade         = "Conteudo Programático do Produto";
$Entidade_p       = "Conteudos Programático do Produto";

$CampoPricPai     = "idt_produto";

$orderby = "{$AliasPric}.codigo";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       grc_pp.descricao as grc_pp_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_produto grc_pp on grc_pp.idt = {$AliasPric}.idt_produto_associado ";
//
$sql .= " where {$AliasPric}".'.idt_produto = $vlID';
$sql .= " order by {$orderby}";


$vetCampo['grc_produto_produto'] = objListarConf('grc_produto_produto', 'idt', $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'codigo_pai' => 'produto_associado',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['grc_produto_produto']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

///////////////////


$vetCad[] = $vetFrm;
?>