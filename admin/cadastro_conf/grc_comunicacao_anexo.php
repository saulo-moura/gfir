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
.Texto {

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

td.Titulo {
    color:#666666;
}


#idt_helpdesk_obj {
   xwidth:100%;
}

#idt_helpdesk_tf {
   font-size:16px;
   font-weight:normal;
   padding:3px;
   background:#FFFFCA;
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


$TabelaPai   = "grc_comunicacao";
$AliasPai    = "grc_c";
$EntidadePai = "Comunicação";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_comunicacao_anexo";
$AliasPric        = "grc_ca";
$Entidade         = "Anexo da Comunicação";
$Entidade_p       = "Anexos da Comunicação";
$CampoPricPai     = "idt_comunicacao";

$tabela = $TabelaPrinc;


$idt_comunicacao_anexo = $_GET['id'];

if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_ca.*  ";
     $sql .= " from grc_comunicacao_anexo grc_ca  ";
     $sql .= " where idt = {$idt_comunicacao_anexo} ";
     $rs = execsql($sql);
     ForEach($rs->data as $row)
     {
        $idt_usuario     = $row['idt_usuario'];
        $idt_responsavel = $row['idt_responsavel'];
     }
}
else
{
     $idt_responsavel = $_SESSION[CS]['g_id_usuario'];
}
$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'protocolo', 0);
$jst="";
$vetCampo['descricao']  = objTexto('descricao', 'Título', true, 30, 120);
$vetCampo['arquivo']    = objFile('arquivo', 'Arquivo Anexado', true, 120, 'todos');
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);
$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " where id_usuario = ".null($idt_responsavel);
$sql .= " order by nome_completo";
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsavel', true, $sql,' ','width:180px;');
$vetCampo['data_responsavel']  = objTexto('data_responsavel', 'Data Registro', true, 30, 120);
$vetFrm = Array();
MesclarCol($vetCampo['observacao'], 5);
MesclarCol($vetCampo['arquivo'], 5);
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai],'',$vetCampo['idt_responsavel'],'',$vetCampo['data_responsavel']),
    Array($vetCampo['descricao'],'',$vetCampo['arquivo']),
    Array($vetCampo['observacao']),
), $class_frame, $class_titulo, $titulo_na_linha);
$vetCad[] = $vetFrm;
?>
<script>
$(document).ready(function () {
   objd=document.getElementById('idt_responsavel');
   if (objd != null)
   {
       $(objd).css('fontSize','12px');
       $(objd).css('background','#FFFFCA');
       $(objd).css('color','#000000');
       $(objd).attr('disabled','disabled');
   }
   objd=document.getElementById('data_responsavel');
   if (objd != null)
   {
       $(objd).css('fontSize','12px');
       $(objd).css('background','#FFFFCA');
       $(objd).css('color','#000000');
       $(objd).attr('readonly','true');
   }

});
   
   
</script>