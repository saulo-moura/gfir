<style>
   div#grd1 {
       xfloat: left;
       xwidth: 25%;
       xheight:500px;
       xbackground-color: fuchsia;
       xborder-right:2px solid red;
       xbackground-color: #ECF0F1;
       xoverflow:scroll;
       xoverflow-y: scroll;
   }
   
   div#grd2 {
       xfloat: left;
       xwidth: 75%;
       xbackground-color: lime;
   }

   div#grd3 {
       xfloat: left;
       xmargin-top:20px;
   }

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
         xopacity: 0;
         xfilter:alpha(opacity=0);
    }

.TextoFixo {

     font-size:12px;
     height:25px;
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

td#idt_competencia_obj div {
    color:#FF0000;
}

.Tit_Campo {
    font-size:12px;
}


div#topo {
   wwxwidth:900px;
}
div#geral {
   wwxwidth:900px;
}

div#grd0 {
   wwxwidth:700px;
   wwxmargin-left:200px;

}

div#meio_util {
   wwxwidth:700px;
   wwxmargin-left:70px;
}
td.Titulo {
    color:#666666;
}
</style>

<?php

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
$tabela = 'grc_atendimento';
$id     = 'idt';

 // p($_GET);


$corbloq="#FFFFD2";

$corbloq="#F1F1F1";

$corbloq="#ECF0F1";

$mostra_bt_volta = false;

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
//
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'idt', 0);
//p($_GET);
$idt_cliente = 0;
$idt_ponto_atendimento  = 0;
$idt_pessoa = 0;
$idt_projeto  = 0;
$idt_projeto_acao  = 0;
$idt_atendimento       = $_GET['id'];
$inc_cont              = $_GET['cont'];
$idt_ponto_atendimento = $_GET['idt0'];
// p($_GET);
// exit();
$codigo_tema="";
$idt_tema_produto_interesse="";

if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_a.*, gestor, grc_ps.descricao as etapa  ";
     $sql .= " from grc_atendimento grc_a ";
     $sql .= " left join grc_projeto grc_p on grc_p.idt = grc_a.idt_projeto ";
     $sql .= " left join grc_projeto_situacao grc_ps on grc_ps.idt = grc_p.idt_projeto_situacao ";
     $sql .= " where grc_a.idt = {$idt_atendimento} ";
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
         $idt_instrumento        = $row['idt_instrumento'];
         $situacao               = $row['situacao'];
         $gestor_sge             = $row['gestor'];
         $fase_acao_projeto      = $row['etapa'];
         //$instrumento        = $row['idt_instrumento'];
     }
     if ($situacao=='Finalizado' or $situacao=='Cancelado')
     {
         $acao='con';
         $_GET['acao'] = $acao;
     }
}
else
{

     $idt_consultor             = $_SESSION[CS]['g_id_usuario'];
     //  $idt_ponto_atendimento     = $_SESSION[CS]['g_idt_unidade_regional'];
     $idt_projeto               = $_SESSION[CS]['g_idt_projeto'];
     $idt_projeto_acao          = $_SESSION[CS]['g_idt_acao'];
     $idt_instrumento           = $instrumento;
     $gestor_sge                = $_SESSION[CS]['g_projeto_gestor'];
     $fase_acao_projeto         = $_SESSION[CS]['g_projeto_etapa'];

     if ($inc_cont!='s')
     {
         $datadia      = date('d/m/Y H:i:s');
         $vet          = explode(' ',$datadia);
         $data_inicial = trata_data($vet[0]);
         $hora_inicial = substr($vet[1],0,5);
         $idt_atendimentow = 0;
         //echo " t^entramdo <br />";
         // GeraAtendimentoHE($idt_consultor,$idt_ponto_atendimento,$data_inicial,$hora_inicial,$idt_instrumento,$idt_atendimentow);
         $idt_atendimento = $idt_atendimentow;
         // $_GET['id']      = $idt_atendimento;
         // $acao            = "alt";
         // $_GET['acao']    = $acao;
         
     }
}


?>
   <script>
   var acao     = '<?php  echo $acao; ?>';
   var inc_cont = '<?php  echo $inc_cont; ?>';
   </script>
<?php


$class_frame_f   = "class_frame_f";
$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;

$titulo_cadastro="CADASTROS DO ATENDIMENTO";

$vetFrm = Array();
$vetParametros = Array(
    'codigo_frm' => 'grc_atendimento_pessoa_w',
    'controle_fecha' => 'A',
    'barra_inc_ap' => true,
    'barra_alt_ap' => true,
    'barra_con_ap' => false,
    'barra_exc_ap' => true,
);
$vetFrm[] = Frame('<span> CLIENTES</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
//Monta o vetor de Campo

$vetRelacao=Array();
$vetRelacao['L']='Líder';
$vetRelacao['P']='Participante';
$vetCampo['tipo_relacao']     = CriaVetTabela('Tipo Relação','descDominio',$vetRelacao);

$vetCampo['cpf']      = CriaVetTabela('CPF');
$vetCampo['nome']     = CriaVetTabela('Nome');


// Parametros da tela full conforme padrão

$titulo = 'Pessoas';

$TabelaPrinc      = "grc_atendimento_pessoa";
$AliasPric        = "grc_ap";
$Entidade         = "Pessoa do Atendimento";
$Entidade_p       = "Pessoas do Atendimento";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.tipo_relacao, {$AliasPric}.cpf ";

$sql  = "select {$AliasPric}.*  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//
$sql .= " where {$AliasPric}".'.idt_atendimento = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full



$vetCampo['grc_atendimento_pessoa'] = objListarConf('grc_atendimento_pessoa', 'idt', $vetCampo, $sql, $titulo, false,$vetParametros);

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'grc_atendimento_pessoa_w',
    'width' => '100%',
);
$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['grc_atendimento_pessoa']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


//if ($representantes>1)
//{
    $vetCad[] = $vetFrm;
//}


$vetParametros = Array(
    'codigo_frm' => 'grc_representantes_w',
    'controle_fecha' => 'A',
    'barra_inc_ap' => true,
    'barra_alt_ap' => true,
    'barra_con_ap' => false,
    'barra_exc_ap' => true,
);

$vetFrm = Array();
$vetFrm[] = Frame('<span> CADASTRO DO REPRESENTANTE</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'grc_representantes_w_w',
    'width' => '100%',
);


$vetCad[] = $vetFrm;

$idtVinculo = array(
    'idt_atendimento' => 'grc_atendimento',
    " and tipo_relacao = 'L'" => false,
);

MesclarCadastro('grc_atendimento_pessoa', $idtVinculo, $vetCad, $vetParametros);

if  ($_GET['cnpj']!="")
{
    $vetFrm = Array();
    $vetFrm[] = Frame('<span> CADASTRO DO EMPREENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    $vetCad[] = $vetFrm;
    MesclarCadastro('grc_atendimento_organizacao', 'idt_atendimento', $vetCad, $vetParametros);
}
?>
<script>

//var acao     = '<?php  echo $acao; ?>';
//var inc_cont = '<?php  echo $$inc_cont; ?>';


var hora_inicial = "";
var hora_atual   = "";
var timerId      = 0;


$(document).ready(function () {

});

</script>
