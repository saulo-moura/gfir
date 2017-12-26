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
        background: #FFFFFF;
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

    .Texto {
        border:0;
        background:#ECF0F1;
    }
    
    Select {
        border:0;
        background:#ECF0F1;
    }

    TextArea {
        border:0;
        background:#ECF0F1;
    }
    
    .TextArea {
        border:0;
        background:#ECF0F1;
    }

    div#xEditingArea {
        border:0;
        background:#ECF0F1;
    }

    .TextoFixo {
        background:#ECF0F1;
    }


    fieldset.class_frame {
        border:0;
    }

    .campo_disabled {
        background-color: #ffffd7;
    }    

    #parterepasse_tit {
        padding-left:0px;
    }
</style>




<?php
$tabela = 'grc_politica_parametro_tabelas';
$id = 'idt';

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;
$titulo_cadastro = "POLÍTICA DE VENDAS - PARÂMETRO TABELAS";

if ($acao=='inc')
{
    // Gerar Politica de Vendas em cadastramento
	$idt_politica_parametro_tabelas = GerarPoliticaVendasParametroInc();
    // trocar para alteração 
	$href = "conteudo.php?prefixo=cadastro&menu=grc_politica_parametro_tabelas&acao=alt" . "&id=" . $idt_politica_parametro_tabelas;
    $botao_acao = '<script type="text/javascript">self.location = "' . $href . '";</script>';
    echo $botao_acao;
}
if ($acao=='alt')
{
    // Gerar Politica de Vendas em cadastramento
	$idt_politica_parametro_tabelas = GerarPoliticaVendasParametroInc();
}


$js=" readonly='true' style='background:#ffff70;' ";
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45,$js);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120,$js);
$js=" disabled style='background:#ffff70;' ";
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'',$js);
//



$maxlength  = 4000;
$style      = "width:100%;";
$js=" readonly='true' style='background:#ffff70;' ";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição Detalhada da Tabela', false, $maxlength, $style, $js);



// $sql = "select idt, codigo, descricao from plu_estado order by descricao";
// $vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');

$vetFrm = Array();
MesclarCol($vetCampo['detalhe'], 5);

MesclarCol($vetCampo['data_responsavel'], 3);
//MesclarCol($vetCampo['data_fim'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);




//
// CAMPOS
//

$vetParametros = Array(
    'codigo_frm' => 'campos',
    'controle_fecha' => 'A',
	'barra_inc_ap' => false,
	'barra_alt_ap' => true,
	'barra_con_ap' => true,
	'barra_exc_ap' => false,
);
$vetFrm[] = Frame('CAMPOS', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['codigo']    = CriaVetTabela('Expressão/Código');
$vetCampo['alias']     = CriaVetTabela('Nome Visão Usuário');
$vetCampo['selecao']   = CriaVetTabela('Seleção', 'descDominio', $vetSimNao );
$vetCampo['tipo']      = CriaVetTabela('Tipo');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$titulo = 'Campos';

$TabelaPrinc = "grc_politica_parametro_campos";
$AliasPric   = "grc_ppc";
$Entidade    = "Campo Parâmetro da Política de Vendas";
$Entidade_p  = "Campos Parâmetro  da Política de Vendas";

$CampoPricPai = "idt_politica_vendas";

$orderby = "{$AliasPric}.alias";

$sql = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " where {$AliasPric}" . '.idt_politica_parametro_tabelas = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_politica_parametro_campos'] = objListarConf('grc_politica_parametro_campos', 'idt', $vetCampo, $sql, $titulo, false, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'campos',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_politica_parametro_campos']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


$vetCad[] = $vetFrm;


//~ /////////////// condicao

$vetFrm = Array();







?>