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

//p($_GET);

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);


if ($acao!="inc")
{
        $sql = 'select ';
        $sql .= '  *  ';
        $sql .= '  from grc_evento_produto ';
        $sql .= '  where  ';
        $sql .= '         idt  = '.$_GET['id'];
        $rs = execsql($sql);
        if ($rs->rows == 0)
        {   // incluir
        }
         else
         {
            ForEach ($rs->data as $row) {
                $idt_produto = $row['idt_produto'];
            }
            $_GET['idCad']=$idt_produto;

         }
         echo " idt_produto == $idt_produto";

}


$TabelaPai   = "grc_evento";
$AliasPai    = "grc_eve";
$EntidadePai = "Evento";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_evento_produto";
$AliasPric        = "grc_evepro";
$Entidade         = "Produto Associado a Evento";
$Entidade_p       = "Produtos Associado a Evento";
$CampoPricPai     = "idt_evento";

$tabela = $TabelaPrinc;


$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;


$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);


//$sql  = "select idt, codigo, copia , descricao from grc_produto ";
//$sql .= " order by codigo";
//$vetCampo['idt_produto'] = objCmbBanco('idt_produto', 'Produto Associado', true, $sql,' ','width:500px;');



$vetCampo['idt_produto'] = objListarCmb('idt_produto', 'grc_produto_evento_cmb', 'Produto Associado', true);


//
$vetFrm = Array();


   $vetParametros = Array(
        'codigo_frm' => 'parte01',
        'controle_fecha' => 'A',
    );
    $vetFrm[] = Frame('<span>1 - DADOS DA ASSOCIAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    //$vetCad[] = $vetFrm;

    $vetParametros = Array(
        'codigo_pai' => 'parte01',
    );


$vetFrm[] = Frame('<span>Produto</span>', Array(
    Array($vetCampo[$CampoPricPai],'',$vetCampo['idt_produto']),
),$class_frame,$class_titulo,$titulo_na_linha, $vetParametros);


/*
//MesclarCol($vetCampo['idt_situacao'], 3);
$vetFrm[] = Frame('<span>Produto Associado</span>', Array(
    Array($vetCampo['idt_produto']),
),$class_frame,$class_titulo,$titulo_na_linha, $vetParametros);
*/

/*
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha, $vetParametros);
*/

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha, $vetParametros);



//
// Grudar o produto
//


// mesclar o produto associado

if ($acao!="inc")
{


   $vetParametros = Array(
        'codigo_frm' => 'parte02',
        'controle_fecha' => 'A',
    );
    $vetFrm[] = Frame('<span>2 - DADOS DO PRODUTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetCad[] = $vetFrm;

    $vetParametros = Array(
        'codigo_pai' => 'parte02',
        'id' => $idt_produto,

    );



    MesclarCadastro('grc_produto', 'idt_evento_produto', $vetCad, $vetParametros);
}
else
{
    $vetCad[] = $vetFrm;

}




//$vetCad[] = $vetFrm;
?>