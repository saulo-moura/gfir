<script type="text/javascript">


function  gerar_assinaturas()
{
//    alert(' gerar relatório ');
    // controle de assinatura
    var indice                   = 0;
    var idt_assinatura_controle  = 0;
    var idt_ggc                  = 0;
    var es_estado                = '';

    objs=document.getElementById('idt_assinatura_controle');
    if (objs != null)
    {
        indice                   = objs.selectedIndex;
        idt_assinatura_controle  = objs.options[indice].value;
    }
    objs=document.getElementById('es_estado');
    if (objs != null)
    {
        indice                   = objs.selectedIndex;
        es_estado  = objs.options[indice].value;
    }
    objs=document.getElementById('ggc_idt');
    if (objs != null)
    {
        indice                   = objs.selectedIndex;
        idt_ggc  = objs.options[indice].value;
    }
    
    objs=document.getElementById('assinatura_msg');
    if (objs != null)
    {
        //var msg="<a><img  src='imagens/carregando_1.gif'  />Aguarde...<br> Gerando Relatório.</a>";
        //var msg="<img  src='imagens/carregando_1.gif'  />";
        //        msg='guy';
        //objs.innerHTML=msg;
        objs.style.display='block';
    }
  //  alert('teste  '+idt_assinatura_controle+ ' '+es_estado+ ' '+idt_ggc) ;
    
    
    
    var str='&idt_assinatura_controle='+idt_assinatura_controle+'&es_estado='+es_estado+'&ggc_idt='+idt_ggc;
    var url_seg="conteudo_assinatura.php?prefixo=inc&menu=gerencia_assinatura&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S"+str;
    self.location = url_seg;

//    var  left   = 0;
//    var  top    = 0;
//    var  height = $(window).height();
//    var  width  = $(window).width();
//    var link_gantt='conteudo_assinatura.php?prefixo=inc&menu=gerencia_assinatura&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S';
//    assinaturatrabalho    =  window.open(link_gantt,"ControleAssinatura","left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=no,scrollbars=yes,toolbar=no");
//    assinaturatrabalho.focus();
    return false;
}
function  ch_imp()
{
    self.print();
    return false;
}
function  imprimir_ass(menu,idt_assinatura_controle,es_estado,ggc_idt)
{
    var str='&idt_assinatura_controle='+idt_assinatura_controle+'&es_estado='+es_estado+'&ggc_idt='+ggc_idt+'&pr=S';
   // var url_seg="conteudo_assinatura.php?prefixo=inc&menu=gerencia_assinatura&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S"+str;
    var  left   = 0;
    var  top    = 0;
    var  height = $(window).height();
    var  width  = $(window).width();
    var link_gantt='conteudo_assinatura_print.php?prefixo=inc&menu=gerencia_assinatura&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S'+str;
    assinaturatrabalhop    =  window.open(link_gantt,"ControleAssinatura_imprime","left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=no,scrollbars=yes,toolbar=no");
    assinaturatrabalhop.focus();
}

function  excel_ass(menu,idt_assinatura_controle,es_estado,ggc_idt)
{
    var str='&idt_assinatura_controle='+idt_assinatura_controle+'&es_estado='+es_estado+'&ggc_idt='+ggc_idt+'&pr=S'+'&excel_file=S';
    var link_gantt='conteudo_excel_3.php?prefixo=inc&menu=gerencia_assinatura_excel&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S'+str;
    self.location = link_gantt;
    
}


function  acessa_idt_tipo_acidente(thisw)
{
//    alert(' tem ');
    var indice            = thisw.selectedIndex;
    var idt_tipo_acidente = thisw.options[indice].value;
    var descricao_tipo_acidente  = thisw.options[indice].text;
  //  alert('teste  '+indice+ ' '+idt_tipo_acidente+ ' '+descricao_tipo_acidente) ;
    var url_seg="conteudo_rsqsms.php?prefixo=inc&menu=seguranca_trabalho&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S&idt_tipo_acidente="+idt_tipo_acidente;

    self.location = url_seg;


    return false;
}


var vez_condicionantes=0;
function condicionantes()
{
    alert('ssssss');
    var id = 'condicionantes';
    if (vez_condicionantes==1)
    {
        vez_condicionantes=0;
        $("#img_" + id).attr("src","imagens/fechar_div.gif");

        $("#img_" + id).attr("title","Clique aqui para Esconder item Condicionantes");
        $("#img_" + id).attr("alt","Clique aqui para Esconder item Condicionantes");
        $("#a_" + id).attr("title","Clique aqui para Esconder item Condicionantes");

    }
    else
    {
       vez_condicionantes=1;
       $("#img_" + id).attr("src","imagens/abrir_div.gif");
       $("#img_" + id).attr("title","Clique aqui para Mostrar item Condicionantes");
       $("#img_" + id).attr("alt","Clique aqui para Mostrar item Condicionantes");
       $("#a_" + id).attr("title","Clique aqui para Mostrar item Condicionantes");
    }




    $('#' + id).toggle();
    return false;
}



</script>




<style type="text/css">

   div#conteudo {
        padding:0px;
        margin:0px;
        margin-left:10px;
        width:670px;
        swidth:2000px;
        overflow:auto;
    }

    body {
        swidth:2000px;
        background:#FFFFFF;
    }

    div#conteudo img {
        text-align:center;
    }
    div#area_mostra {
        text-align:center;
        swidth:2000px;
        background:#FFFFFF;
    }

    div#barra {
        margin-bottom:5px;
        height:15px;
    }

    div#img {
        background-color:white;
        margin-top:3px;
    }
    div#tit_home {

        float:right;
        padding-bottom: 2px;
        padding-top: 3px;
        padding-left: 5px;
        padding-right: 37px;
        margin-bottom: 14px;
        font-size: 14px;
        font-weight: bold;
        color: #90141a;
        color: #B70909;
        background: #c9c9c9;
        sbackground: #B70909;

        background: #FFFFFF;

        sbackground: url(imagens/seta_titulo.jpg) right top no-repeat #c9c9c9;
        sborder:2px solid red;
    }
    div#tit_home_img {
        float:right;
        sborder:2px solid green;

    }
    div#tit_home_img a {
        text-decoration:none;
    }

    div#tit_home_img a:visited {
        text-decoration:none;
    }

table.tabela_titulo {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight:bold;
	color: #F7F7F7;
	padding-left:10px;
	text-align: center;
	border-collapse: collapse;
	background: #EBEBEB url(imagens/rodape_lista.jpg) repeat ;
}
td.titulo_lista {

	border-collapse: collapse;
	padding-right: 20px;

}
td.titulo_campo {
    padding-top:0px;
	padding-bottom:5px;
	padding-right: 20px;
}
tr.cabecalho_lista {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #6E6E6E;
	font-weight:bold;
    text-align: right;
	border-collapse: collapse;
	background-color: #EFEFEF;
}

td.cabecalho_campo {
    padding-top:5px;
	padding-bottom:5px;
 	padding-right: 4px;
	padding-left : 4px;
    border-bottom:1px solid #808080;

}


tr.rodape_lista {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 4px;
	color: #FFFFFF;
	font-weight:bold;
    text-align: right;
	border-collapse: collapse;
	background: #EBEBEB url(imagens/rodape_lista.jpg) repeat ;
	sbackground: #F1F1F1 ;
	background: #FFFFFF ;

	height:3px;
}

td.rodape_campo {
    padding-top:2px;
	padding-bottom:2px;
	padding-right: 20px;

}

tr.linha_lista {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	font-weight:normal;
	text-align: right;
	border-collapse: collapse;
	background-color: #F0F0F0;
	background-color: #FBFBFB;



}

tr.linha_rodape {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFFFFF;
	font-weight:bold;
	text-align: right;
	border-collapse: collapse;
	background: #A3A3A3;
}
td.linha_campo_rodape {
	border-collapse: collapse;
	padding-top:5px;
	padding-bottom:5px;
	padding-right: 20px;
	border-bottom:1px solid #C0C0C0;
	sbackground:#E6E6E6;
}




td.linha_campo {
	border-collapse: collapse;
	padding-top:5px;
	padding-bottom:5px;
	padding-right: 20px;
	border-bottom:1px solid #C0C0C0;
}

td.linha_campo a {
    text-decoration:none;
    color: #FF0000;
    color: #1E1E1E;
    font-weight:bold;
}

td.linha_campo a:hover {
    color:#A80000;
    font-weight:bold;
}



td.linha_campo_r {
	border-collapse: collapse;
	padding-top:5px;
	padding-bottom:5px;
	padding-right: 20px;
	border-bottom:1px solid #C0C0C0;
	background:#FFCACA;
}

td.linha_campo_r a {
    text-decoration:none;
    color: #000000;
    font-weight:bold;
}

td.linha_campo_r a:hover {
    color:#A80000;
    font-weight:bold;
}


td.linha_campo_a {
	border-collapse: collapse;
	padding-top:5px;
	padding-bottom:5px;
	padding-right: 20px;
	border-bottom:1px solid #C0C0C0;
	background:#A2A2A2;
	color: #FFFFFF;
    font-weight:bold;
}

td.linha_campo_a a {
    text-decoration:none;
    color: #FFFFFF;
    font-weight:bold;
}

td.linha_campo_a a:hover {
    color:#A80000;
    font-weight:bold;
}


td.linha_campo_pt {
	border-collapse: collapse;
	padding-top:5px;
	padding-bottom:5px;
	padding-right: 4px;
	padding-left: 4px;
	background:#F8F8F8;
	text-align:left   ;
	border-bottom:1px solid #C0C0C0;
}



td.linha_campo_p {
	border-collapse: collapse;
	padding-top:5px;
	padding-bottom:5px;
	padding-right: 4px;
	padding-left: 4px;
	sborder-bottom:1px solid #C0C0C0;
	background:#FFFFFF;
	text-align:right   ;
	border-bottom:1px solid #C0C0C0;
}

td.linha_campo_p a {
    text-decoration:none;
    color: #000000;
    font-weight:bold;
}

td.linha_campo_p a:hover {
    color:#A80000;
    font-weight:bold;
}








tr.linha_lista_t {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #808080;
	font-weight:bold;
	text-align: right;
	border-collapse: collapse;
	background-color: #FFDDDD;
	background-color: #F0F0F0;

}

td.linha_campo_t {
	border-collapse: collapse;
	padding-top:5px;
	padding-bottom:5px;
 	padding-right: 20px;
	border-bottom:1px solid #FFD2D2;
}


td.linha_campo_t a {
    text-decoration:none;
    color: #FF0000;
    color: #1E1E1E;
    font-weight:bold;
}

td.linha_campo_t a:hover {
    color:#A80000;
    font-weight:bold;
}



table.tabela_navegacao {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight:bold;
	color: #F7F7F7;
	padding-left:10px;
	text-align: center;
	border-collapse: collapse;
	sbackground: #EBEBEB url(imagens/rodape_lista.jpg) repeat ;
	margin-bottom:3px;
}


tr.navegacao_lista_1 {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #373737;
	font-weight:bold;
    text-align: center;
	border-collapse: collapse;
	sbackground: #EBEBEB url(imagens/rodape_lista.jpg) repeat ;
	background: #E4E4E4;
	sheight:3px;
	margin-bottom:13px;

}

tr.navegacao_lista_2 {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #373737;
	font-weight:bold;
    text-align: center;
	border-collapse: collapse;
	sbackground: #EBEBEB url(imagens/rodape_lista.jpg) repeat ;
	background: #F4F4F4;
	sheight:3px;
	margin-bottom:13px;
}


td.navegacao_campo {
    padding-top:2px;
	padding-bottom:2px;
	padding-right: 20px;
	margin-bottom:13px;
    swidth:10px;
    cursor:pointer;
}

td.navegacao_campo:hover {
    color: #B70000;
}


.bt_topo_barra {
   background:#900000;
   smargin-top:4px;
   padding-top:5px;
   height:35px;
   width:130px;
   float:left;
   border-right:1px solid #FFFFFF;
   border-left:1px solid #FFFFFF;
   text-align:center;
}


div#topo_barra1 .bt_topo_barra a {


   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 14px;
   color    : #FFFFFF;
   font-weight:bold;
   text-decoration:none;


}
div#topo_barra1 .bt_topo_barra:hover {
    background:#C0C0C0;
    color:#900000;
}
div#topo_barra1 .bt_topo_barra a:hover {
    background:#C0C0C0;
    color:#900000;
}

div#condicionantes {
   margin-bottom:15px;
   background: #EFEFEF;
   width:100%;
   display:none;
}


div#barra_condicionantes {
   background:#5B0000;
   height:35px;
   width:100%;
   display:block;
   padding-top:5px;
   spadding-left:20px;
   margin-bottom:5px;
   display:block;

}

div#barra_condicionantes a {
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:bold;
   margin-left:20px;
}


div#residuos {
   margin-bottom:15px;
   background:#FFFFFF;
   width:100%;
   display:block;
}
div#residuos a{
   text-decoration:none;
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #900000;
   font-weight:bold;
   margin-left:20px;

}

div#barra_residuos {
   background:#5B0000;
   height:35px;
   width:100%;
   display:block;
   padding-top:5px;
   spadding-left:20px;
   margin-bottom:5px;

}

div#barra_residuos a {
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:bold;
   margin-left:20px;
}


div#area_vivencia {
   margin-bottom:15px;
   background: #EFEFEF;
   width:100%;
   display:none;
}


div#barra_area_vivencia {
   background:#5B0000;
   height:35px;
   width:100%;
   display:block;
   padding-top:5px;
   spadding-left:20px;
   margin-bottom:5px;
   display:block;

}

div#barra_area_vivencia a {
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:bold;
   margin-left:20px;
}

div#tabela_det_residuos {
   background:#C0C0C0;
   display:none;
}

div#classe_legenda  {
   background:#F5F5F5;
   smargin-left:20px;
   display:none;
   padding-left:20px;

}

div#classe_legenda span {
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 10px;
   color    : #000000;
   font-weight:bold;
   spadding-left:20px;
}


div#barra_indicadores {
   smargin-left:20px;
   background:#808080;
   border-top:#000000;
   border-bottom:#000000;
   margin-top:10px;
   width:100%;
   text-align:left;

   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:normal;
   font-weight:bold;


}
div#barra_indicadores a {
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:normal;
   font-weight:bold;


}



div#barra_indicadores_1 {
   smargin-left:20px;
   background:#808080;
   border-top:#000000;
   border-bottom:#000000;
   margin-top:10px;
   width:100%;
   text-align:left;

   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:normal;
   font-weight:bold;


}
div#barra_indicadores_1 a {
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:normal;
   font-weight:bold;
}


div#barra_indicadores_3 {
   smargin-left:20px;
   background:#808080;
   border-top:#000000;
   border-bottom:#000000;
   margin-top:10px;
   width:100%;
   text-align:left;

   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:normal;
   font-weight:bold;


}
div#barra_indicadores_3 a {
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:normal;
   font-weight:bold;
}

div#barra_indicadores_4 {
   smargin-left:20px;
   background:#808080;
   border-top:#000000;
   border-bottom:#000000;
   margin-top:10px;
   width:100%;
   text-align:left;

   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:normal;
   font-weight:bold;


}
div#barra_indicadores_4 a {
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:normal;
   font-weight:bold;
}

div#barra_indicadores_5 {
   smargin-left:20px;
   background:#808080;
   border-top:#000000;
   border-bottom:#000000;
   margin-top:10px;
   width:100%;
   text-align:left;

   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:normal;
   font-weight:bold;


}
div#barra_indicadores_5 a {
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight:normal;
   font-weight:bold;
}


div#barra_sp {
   background:#808080;
   margin-top:2px;
   width:100%;
   height:1px;
   display:block;
}
div.erro  {
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 16px;
   color    : #FFFFFF;
   font-weight: bold;
   margin-left:20px;
   background:#FF0000;
   text-align:center;

}

    select#tipo_acidente {
        width:145px;
        background:#900000;
        color:#FFFFFF;
        font-weight: bold;
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 14px;

    }


div#assinatura_controle {
        font-family: Calibri, Arial, Helvetica, sans-serif;
        margin-left:20px;

}
tr.linha_cab_tabela_pa {
 	background: #600000;
	font-weight: bold;
	text-align: center;
	border: 0px solid #840000;
	border-collapse: collapse;
	padding: 2px;
	color:#FFFFFF;
    font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;

}

td.linha_tabela_pa {
	background: #DDDDDD;
	border-bottom: 1px solid #666666;
	border-collapse: collapse;
	padding: 4px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #151515;
	text-align: right;
}

td.linha_tabela_pa_d {
	background: #F2F2F2;
	font-weight: normal;
 border-bottom: 1px solid #666666;
	border-collapse: collapse;
	padding: 4px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #A7A7A7;
	text-align: right;
}

td.linha_tabela_pa_l {
	background: #F2F2F2;
	font-weight: normal;
 border-bottom: 1px solid #666666;
	border-collapse: collapse;
	padding: 4px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 11px;
    color:#000000;
	text-align: center;
}

.bt_topo_barra_acon {
   background:#900000;
   padding-top:5px;
   height:35px;
   width:150px;
   float:left;
   border-right:1px solid #FFFFFF;
   border-left:1px solid #FFFFFF;
   text-align:center;
}
.bt_topo_barra_estado {
   background:#900000;
   padding-top:5px;
   height:35px;
   width:150px;
   float:left;
   border-right:1px solid #FFFFFF;
   border-left:1px solid #FFFFFF;
   text-align:center;
}
.bt_topo_barra_ggc {
   background:#900000;
   padding-top:5px;
   height:35px;
   width:150px;
   float:left;
   border-right:1px solid #FFFFFF;
   border-left:1px solid #FFFFFF;
   text-align:center;
}
.bt_topo_barra_exe {
   background:#900000;
   padding-top:5px;
   height:35px;
   width:150px;
   float:left;
   border-right:1px solid #FFFFFF;
   border-left:1px solid #FFFFFF;
   text-align:center;
}

.bt_topo_barra_msg {
   background:#000000;
   padding-top:5px;
   height:35px;
   width:200px;
   float:left;
   border-right:1px solid #FFFFFF;
   border-left:1px solid #FFFFFF;
   text-align:center;
   display:none;
   color:#FFFFFF;
   font-size:16px;
   font-weight: bold;
}

div#topo_barra1 {
   spadding-left:30px;
   margin-bottom:5px;
   background:#900000;
   height:40px;
   width:100%;
}
div#topo_barra2 {
   spadding-left:30px;
   margin-bottom:5px;
   background:red;
   height:40px;
   width:100%;
}

div#topo_barra3 {
   margin-bottom:5px;
   background:#FFFFFF;
   border-bottom: 3px solid #C0C0C0;
   text-align:center;
   height:40px;
   width:100%;
   
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 18px;
   font-weight:bold;
   color: #600000;
}
div#topo_barra_msg_sem {
   margin-bottom:5px;

   background:red;
   border-top: 3px solid #C0C0C0;
   border-bottom: 3px solid #C0C0C0;
   text-align:center;
   height:40px;
   width:99%;
   font-family: Calibri, Arial, Helvetica, sans-serif;
   font-size: 20px;
   font-weight:bold;
   color: #FFFFFF;
}

div#lista_assinantes {
   display:none;
}

</style>

<?php

$ggc_idt                 = $_REQUEST['ggc_idt'];
$es_estado               = $_REQUEST['es_estado'];
$idt_assinatura_controle = $_REQUEST['idt_assinatura_controle'];

echo "<div id='area_mostra' >";

echo '<div id="barra" style="font-weight: bold; font-size:18px; background:#600000; color:#FFFFFF; height:30px;  margin-bottom:5px;">
      <div id="tela"> ';
echo '      <div class="tit_home" style="padding_top:4px; text-align:center; "   title="Clique aqui para voltar" onclick="javascript:top.close();">' ;
echo 'RELATÓRIO DE MONITORAMENTO DE ATUALIZAÇÃO';
echo '&nbsp;&nbsp;  ';
echo '      </div>  ';
echo '      </div>  ';

echo '      </div>  ';


if ($_GET['pr']=='')
{

echo ' <div id="topo_barra1" > ';

$imagemf = '<img  border="0"  id="img_condicionantes" src="imagens/esquerda.gif" title="Clique aqui para Mostrar Planilha" alt="Clique aqui para Mostrar planilha"/>';
echo ' <div class="bt_topo_barra" > ';
echo '       <a href="javascript:top.close();" title="Clique aqui retornar">'.$imagemf.'&nbsp;&nbsp;Retornar</a>';
echo ' </div>  ';

echo ' <div class="bt_topo_barra_acon" > ';
//echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';
//$setorlabelw="<label for='assina_controle' >Controle Assinatura:&nbsp;</label>";
$sql  = 'select idt, dia, mes, ano from assina_controle order by ano desc, mes desc, dia desc';
$rs = execsql($sql);
//$js = " onchange='return acessa_assinatura_controle(this);'";
$js = "";
echo "<span style='color:#FFFFFF;' >Selecione Data de Controle</span>";
criar_combo_rs($rs, 'idt_assinatura_controle', $idt_assinatura_controle, '', $js);
//echo '</form>';
echo ' </div>  ';


echo ' <div class="bt_topo_barra_estado" > ';
//echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';
//$setorlabelw="<label for='estado' >Estado:&nbsp;</label>";
$sql   = 'select distinct es.codigo,  es.codigo, es.descricao from estado es ';
$sql  .= ' inner join empreendimento em on em.estado = es.codigo ';
$sql  .= ' order by es.descricao';
$rs = execsql($sql);
//$js = " onchange='return acessa_estado(this);'";
$js = "";
echo "<span style='color:#FFFFFF;' >Selecione Estado</span>";
criar_combo_rs($rs, 'es_estado', $es_estado, '-- Não Considerar --', $js);
//echo '</form>';
echo ' </div>  ';


echo ' <div class="bt_topo_barra_ggc" > ';
//echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';
//$setorlabelw="<label for='ggc' >GGC:&nbsp;</label>";
$sql   = 'select gc.idt,  gc.nome_resumo from ggc gc ';
$sql  .= ' order by nome_resumo';
$rs = execsql($sql);
//$js = " onchange='return acessa_ggc(this);'";
$js = "";
echo "<span style='color:#FFFFFF;' >Selecione GGC</span>";
criar_combo_rs($rs, 'ggc_idt', $ggc_idt, '-- Não Considerar --', $js);
//echo '</form>';
echo '      </div>  ';


echo ' <div class="bt_topo_barra_exe" > ';
$btconfirma   = "<input type='button' name='btnAcao' value='Gerar Relatório'  style='width:145px; height:30px; margin-left:2px; cursor: pointer;' onclick='return gerar_assinaturas();' title='Executar Geraçao do Relatório'  />";
echo $btconfirma;
echo '      </div>  ';

echo ' <div id="assinatura_msg" class="bt_topo_barra_msg" > ';
//echo "<img  src='imagens/carregando_1.gif' style='float:left;' />Aguarde...<br> Gerando Relatório.";
echo "Aguarde...<br> Gerando Relatório.";
echo '      </div>  ';


echo '       </div> ';

echo '      </div>';

}

/*
echo ' <div id="topo_barra2" > ';
$imagemf = '<img id="img_residuos" src="imagens/fechar_div.gif" title="Clique aqui para Acessar Assinaturas" alt="Clique aqui para Esconder Indicadores"/>';
echo ' <div class="bt_topo_barra" > ';
echo '       <a id="a_residuos" href="#" onclick="return assinatura();" title="Clique aqui para Esconder Indicadores" >'.$imagemf.'<span class="oas">&nbsp;&nbsp;Indicadores SSO</span></a>';
echo '      </div>  ';

$imagemf = '<img id="img_area_vivencia" src="imagens/abrir_div.gif" title="Clique aqui para Mostrar Planilha Área Vivência" alt="Clique aqui para Mostrar planilha  Área Vivência"/>';
echo ' <div class="bt_topo_barra" > ';
echo '       <a id="a_area_vivencia" href="#" onclick="return area_vivencia();" title="Clique aqui para Mostrar Área Vivência" >'.$imagemf.'<span class="oas">&nbsp;&nbsp;Áreas de Vivência</span></a>';
echo '      </div>  ';

echo '       </div> ';
*/

if ($idt_assinatura_controle=='')
{
    echo ' <div id="topo_barra3" > ';
    echo '      <span >&nbsp;&nbsp;Selecione as opções desejadas e clique em executar para gerar relatório</span>';
    echo '       </div> ';
    exit();
}

//
//    PLANILHA
//
echo ' <div id="assinatura_controle" > ';


if ($_GET['pr']=='')
{
//  if ($_GET['print'] == 's') {
    echo "<div class='barra_ferramentas'>";
    echo "<table cellspacing='1' cellpadding='1' width='100%' border='1'>";
    echo "<tr>";
    
    
 //   echo "<td width='20'>";
 //   echo "<a HREF='conteudo.php?prefixo=inc&menu=administrar_menu&class=0'><img class='bartar' align=middle src='relatorio/voltar_ie.jpg'></a>";
 //   echo "</td>";

$ggc_idt                 = $_REQUEST['ggc_idt'];
$es_estado               = $_REQUEST['es_estado'];
$idt_assinatura_controle = $_REQUEST['idt_assinatura_controle'];

    echo "<td width='20'>";
    echo "<a HREF='#' onclick=\"return imprimir_ass('{$menu}','{$idt_assinatura_controle}','{$es_estado}','{$ggc_idt}');\"><img class='bartar' border='0' align=middle src='relatorio/visualiza_imprime.jpg'></a>";
    echo "</td>";
    echo "<td width='20'>";
    echo "<a HREF='#' onclick=\"return excel_ass('$menu','{$idt_assinatura_controle}','{$es_estado}','{$ggc_idt}');\"><img class='bartar' border='0' align=middle src='relatorio/excel.gif'></a>";
    echo "</td>";
    echo "<td>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";

    
    echo "</div>";
}
else
{
    echo "<div class='barra_imp' style='media:print;'>";
    echo "<a HREF='#' onclick=\"return ch_imp();\"><img border='0' class='bartar' align=middle src='imagens/impressora.gif'></a>";
    echo "</div>";
}



                    $vmesnum = Array();
                    $vmesnum['01'] = 'Janeiro';
                    $vmesnum['02'] = 'Fevereiro';
                    $vmesnum['03'] = 'Março';
                    $vmesnum['04'] = 'Abril';
                    $vmesnum['05'] = 'Maio';
                    $vmesnum['06'] = 'Junho';
                    $vmesnum['07'] = 'Julho';
                    $vmesnum['08'] = 'Agôsto';
                    $vmesnum['09'] = 'Setembro';
                    $vmesnum['10'] = 'Outubro';
                    $vmesnum['11'] = 'Novembro';
                    $vmesnum['12'] = 'Dezembro';

$ac_data     = '';
$ac_data_ref = '';


$estado = $es_estado;

$sql   = 'select idt, dia, mes, ano from assina_controle';
$sql  .= ' where idt = '.null($idt_assinatura_controle);
$sql  .= ' order by ano desc, mes desc, dia desc';
//p($sql);
$rs = execsql($sql);
if  ($rs->rows==0)
{
}
else
{
     ForEach($rs->data as $row) {
        $ac_data = $row['dia'].'/'.$row['mes'].'/'.$row['ano'];
        $ac_data_ref =  $vmesnum[$row['mes']].'/'.$row['ano'];

     }
}



//p($estado);



$titulo_rel     ='MONITORAMENTO DE ATUALIZAÇÃO';
$subtitulo_rel  ='';
$subtitulo_rel .="<span style='font-size:12px; ' >";
$subtitulo_rel .='<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
$subtitulo_rel .='<br />Emitido por:&nbsp;'.$_SESSION[CS]['g_nome_completo'];
$subtitulo_rel .="</span>";




$vetObras=Array();
$vetGGCObras=Array();
$vetGeralGGC=Array();
$vetFassina=Array();
$vetNatrizObraAss=Array();
$idt_controle_assinatura=null($idt_assinatura_controle);
$ret=carregar_matriz_obra_funcao($idt_controle_assinatura,$vetObras,$vetGGCObras,$vetGeralObra,$vetGeralGGC,$vetGGC,$vetFassina,$vetNatrizObraAss);


//p($vetNatrizObraAss);


$Vopcao_obras=Array();
$obras_escolhidas='';

//p(' iiiiii '.$ggc_idt);
if ($ggc_idt!='')
{
    // escolheu ggc
    // p( ' escolhe estado ');
    $obras_escolhidas=$vetGGCObras[$ggc_idt];
    if ($estado!='')
    {
       // considerar estado
     //  p( ' considerar estado '.$obras_escolhidas);
       $Vopcao_obras_ggc=explode('#',$obras_escolhidas);
     //  p($Vopcao_obras_ggc);
       $obras_escolhidas='';
       $sep='';
       ForEach ($vetObras as $idxo => $Vet_o)
       {
            $em_estado = $Vet_o['em_estado'];
         //   p($Vet_o);
            if ($estado==$em_estado)
            {
                $em_idt = $Vet_o['em_idt'];
                ForEach ($Vopcao_obras_ggc as $idxo => $idt_obraggc)
                {
       //             p($idt_obraggc);
                    if  ($idt_obraggc==$em_idt)
                    {
                         $obras_escolhidas=$obras_escolhidas.$sep.$idt_obraggc;
                         $sep='#';
                    }
                }
            }
       }
    }
    else
    {
       /*
       $Vopcao_obras_ggc=explode('#',$obras_escolhidas);
       $obras_escolhidas='';
       $sep='';
       ForEach ($vetObras as $idxo => $Vet_o)
       {
            $em_idt = $Vet_o['em_idt'];
            $obras_escolhidas=$obras_escolhidas.$sep.$em_idt;
            $sep='#';
       }
      */

    }
  //  p($vetObras);
  //  p(' iiii '.$ggc_idt.' est '.$estado);

    
}

//p($obras_escolhidas);

if  ($obras_escolhidas=='')
{
     if ($ggc_idt!='')
     {
         $opcao_obras='E';
         $Vopcao_obras=Array();
         echo "<br />";
         

echo ' <div id="topo_barra_msg_sem" > ';
echo '     Opção selecionada não gera resultado para ser apresentado. ';
echo '       </div> ';

         
         
         echo "</div>";

         exit();
         
     }
     else
     {
         $opcao_obras='T';
         if ($estado=='')
         {
             $obras_escolhidas='';
             $sep='';
             ForEach ($vetObras as $idxo => $Vet_o)
             {
                $em_idt = $Vet_o['em_idt'];
                $obras_escolhidas=$obras_escolhidas.$sep.$em_idt;
                $sep='#';
            }
            $opcao_obras='E';
            $Vopcao_obras=explode('#',$obras_escolhidas);
        }
     }
}
else
{
     $opcao_obras='E';
     $Vopcao_obras=explode('#',$obras_escolhidas);
}
//p($Vopcao_obras);
$Vopcao_obras_idt=Array();
ForEach ($Vopcao_obras as $idxo => $idt)
{
   $Vopcao_obras_idt[$idt]=$idt;
}

//p($vetObras);
//p($vetFassina);
//p($vetNatrizObraAss);
//exit();
//       $vetNatrizObraAssw[$idx]['func']=$Vet;
//       $vetNatrizObraAssw[$idx]['obra']=$vetObras_trabw;

   $tam = count($vetObras)+1;
   if ($estado!='-1')
   {
       $tam = 1;
       ForEach ($vetObras as $idxo => $Vet_o)
       {
            $em_estado = $Vet_o['em_estado'];
            if ($estado==$em_estado)
            {
                $tam = $tam+1;
            }
       }
   }

   if ($opcao_obras=='E')
   {
       $tam = count($Vopcao_obras)+1;
   }

echo "<br />";


$obrbrancos = 10 - $tam;
$percent    = 100 -  ($obrbrancos* 8);

$ref_atu= 'Atualização referente a<br /> '.$ac_data_ref;
$path = $dir_file.'/empreendimento/';

echo "<table class='Geral_pa' width='{$percent}%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class='linha_cab_tabela_pa' style='background:#FFFFFF;' >  ";


echo "   <td style='border-bottom:1px solid #666666; width:15%; color:#0080C0; font-weight: bold; font-size: 14px;' >$ref_atu</td> ";
ForEach ($vetObras as $idx => $Vet)
{

     $nome_obra = $Vet['em_descricao'].'<br>'.$Vet['em_estado'];
     if ($opcao_obras=='E')
     {
         $em_idt = $Vet['em_idt'];
         //p( ' aaaa '.$em_idt. ' bbbb '.$Vopcao_obras_idt[$em_idt]);
         if ($em_idt==$Vopcao_obras_idt[$em_idt])
         {
              echo "   <td style='background:#FFFFFF; width:8%; border-bottom:1px solid #666666;' >";
                       echo '<div class="sempreendimento_l">';
                       ImagemMostrar(80, 0, $path, $Vet['em_imagem'], $Vet['em_descricao'], false, 'idt="'.$Vet['em_idt'].'"');
                       echo '</div>';
               echo "   </td> ";
         }
         else
         {
             continue;
         }
     }
     else
     {
         if ($estado=='-1')
         {
//             echo "   <td style='width:8%;' >$nome_obra</td> ";
              echo "   <td style='background:#FFFFFF; width:8%; border-bottom:1px solid #666666;' >";
                        echo '<div class="sempreendimento_l">';
                        ImagemMostrar(80, 0, $path, $Vet['em_imagem'], $Vet['em_descricao'], false, 'idt="'.$Vet['em_idt'].'"');
                        echo '</div>';
               echo "   </td> ";

         }
         else
         {
             if ($estado==$Vet['em_estado'])
             {
  //               echo "   <td style='width:8%;' >$nome_obra</td> ";
                echo "   <td style='background:#FFFFFF;  width:8%; border-bottom:1px solid #666666;' >";
                       echo '<div class="sempreendimento_l">';
                       ImagemMostrar(80, 0, $path, $Vet['em_imagem'], $Vet['em_descricao'], false, 'idt="'.$Vet['em_idt'].'"');
                       echo '</div>';
               echo "   </td> ";

             }
         }
     }
}
echo "</tr>";
echo "<tr class='linha_cab_tabela_pa' style='background:#C0C0C0; color:#666666;' >  ";

// GGC da obra
echo "   <td style='border-bottom:1px solid #666666; width:15%; color:#0080C0; text-align:right; font-weight: bold; font-size: 12px;' >GGC</td> ";

//p($vetObras);




$path = $dir_file.'/ggc/';


$colspantotal=0;

ForEach ($vetObras as $idx => $Vet)
{

     $ggc_nome_resumo = $Vet['ggc_nome_resumo'];
     if ($ggc_nome_resumo=='')
     {
         $ggc_nome_resumo='Sem GGC Inf.';
     }
     if ($opcao_obras=='E')
     {
         $em_idt = $Vet['em_idt'];
 //        p( ' aaaa '.$em_idt. ' bbbb '.$Vopcao_obras_idt[$em_idt].' nnnn '.$ggc_nome_resumo);
         if ($em_idt==$Vopcao_obras_idt[$em_idt])
         {
                       if ($Vet['ggc_imagem']!='')
                       {
                           echo "   <td style='border-bottom:1px solid #666666; width:8%;' >";
                           echo '<div class="empreendimento_l">';
                           ImagemMostrar(80, 0, $path, $Vet['ggc_imagem'], $Vet['ggc_nome_resumo'], false, 'idt="'.$Vet['ggc_idt'].'"');
                           echo '</div>';
                           echo "   </td> ";
                           $vetidtGGC[]=$Vet['ggc_idt'];
                       }
                       else
                       {
                            echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:8%;  text-align:center;' >{$ggc_nome_resumo}</td> ";
                            $vetidtGGC[]=$Vet['ggc_idt'];
                       }
               $colspantotal=$colspantotal+1;
         }
         else
         {
             continue;
         }
     }
     else
     {
         if ($estado=='-1')
         {
                       if ($Vet['ggc_imagem']!='')
                       {
                           echo "   <td style='border-bottom:1px solid #666666; width:8%;' >";
                           echo '<div class="empreendimento_l">';
                           ImagemMostrar(80, 0, $path, $Vet['ggc_imagem'], $Vet['ggc_nome_resumo'], false, 'idt="'.$Vet['ggc_idt'].'"');
                           echo '</div>';
                           echo "   </td> ";
                           $vetidtGGC[]=$Vet['ggc_idt'];
                       }
                       else
                       {
                            echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:8%;  text-align:center;' >{$ggc_nome_resumo}</td> ";
                            $vetidtGGC[]=$Vet['ggc_idt'];
                       }
                       $colspantotal=$colspantotal+1;

         }
         else
         {
             if ($estado==$Vet['em_estado'])
             {
                       if ($Vet['ggc_imagem']!='')
                       {
                           echo "   <td style='border-bottom:1px solid #666666; width:8%;' >";
                           echo '<div class="empreendimento_l">';
                           ImagemMostrar(80, 0, $path, $Vet['ggc_imagem'], $Vet['ggc_nome_resumo'], false, 'idt="'.$Vet['ggc_idt'].'"');
                           echo '</div>';
                           echo "   </td> ";
                           $vetidtGGC[]=$Vet['ggc_idt'];
                       }
                       else
                       {
                            echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:8%;  text-align:center;' >{$ggc_nome_resumo}</td> ";
                            $vetidtGGC[]=$Vet['ggc_idt'];
                       }
                       $colspantotal=$colspantotal+1;

             }
         }
     }
}
echo "</tr>";


echo "<tr class='linha_cab_tabela_pa' style='background:#C0C0C0;  color:#666666;' >  ";

//p(' bbbbbbb '.$opcao_obras);
// % de assinatura
echo "   <td style='border-bottom:1px solid #666666; width:15%; color:#0080C0; text-align:right; font-weight: bold; font-size: 12px;' >% ATUALIZAÇÃO OBRA</td> ";


ForEach ($vetObras as $idx => $Vet)
{
      ForEach ($vetGeralObra as $idt_obra => $Vetqtd)
      {
          if ($Vet['em_idt']==$idt_obra)
          {
              $geral       = $Vetqtd['geral'];
              $assinado    = $Vetqtd['assinado'];
              $naoassinado = $Vetqtd['naoassinado'];
              $naoaplica   = $Vetqtd['naoaplica'];
              $totalparaassinar = $assinado+$naoassinado;
              $percassinados=0;
              if ($totalparaassinar>0)
              {
                  $percassinados    = ($assinado/$totalparaassinar)*100;
              }
          }
     }
     $nome_obra = $Vet['em_descricao'].'<br>'.$Vet['em_estado'];
     if ($opcao_obras=='E')
     {
         $em_idt = $Vet['em_idt'];
         //p( ' aaaa '.$em_idt. ' bbbb '.$Vopcao_obras_idt[$em_idt]);
         if ($em_idt==$Vopcao_obras_idt[$em_idt])
         {
             $percent_total_ggc = format_decimal($percassinados);
              echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:8%;  text-align:center;' >{$percent_total_ggc}%</td> ";
         }
         else
         {
             continue;
         }
     }
     else
     {
         if ($estado=='-1')
         {
             $percent_total_ggc = format_decimal($percassinados);
              echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:8%;  text-align:center;' >{$percent_total_ggc}%</td> ";
         }
         else
         {
             if ($estado==$Vet['em_estado'])
             {
              $percent_total_ggc = format_decimal($percassinados);
              echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666; width:8%; text-align:center;' >{$percent_total_ggc}%</td> ";

             }
         }
     }
}
echo "</tr>";




//p($vetObras);

//p(' bbbbbbb '.$opcao_obras);


// % geral do ggc
$vetGGCperc=Array();
ForEach ($vetGGC as $idt_ggc => $VetpercGGC)
{
   $assinado     =  $VetpercGGC['assinado'];
   $naoassinado  =  $VetpercGGC['naoassinado'];
   $total        =  $assinado+$naoassinado;
   $perc         =  0;
   if ($total>0)
   {
       $perc =($assinado/$total)*100;
   }
   $vetGGCperc[$idt_ggc]=$perc;
}


echo "<tr class='linha_cab_tabela_pa' style='background:#C0C0C0; color:#666666;' >  ";

echo "   <td style='border-bottom:1px solid #666666; width:15%; color:#0080C0; text-align:right; font-weight: bold; font-size: 12px;' >% GGC</td> ";
$igccant=0;
ForEach ($vetidtGGC as $ix => $idt_ggc)
{
    if ($igccant!=$idt_ggc)
    {
        $perc=$vetGGCperc[$idt_ggc];
        $percent_total_ggc = format_decimal($perc);
        $igccant=$idt_ggc;
    }
    else
    {
        $percent_total_ggc = '&nbsp;';
    }
    echo "   <td style='background:#FFFFFF;border-bottom:1px solid #666666; width:8%; text-align:center;' >{$percent_total_ggc}</td> ";
}
//echo "   <td style='background:#FFFFFF; border-bottom:1px solid #666666;  width:72%; ' colspan='{$sp}' >&nbsp;</td> ";


echo "</tr>";


echo "<tr class='linha_cab_tabela_pa' style='background:#FFFFFF;' >  ";
    $sp=($colspantotal);
    echo "   <td style='width:8%;' colspan='{$sp}' >&nbsp;</td> ";
echo "</tr>";



echo "<tr class='linha_cab_tabela_pa'>  ";
echo "   <td style='width:15%;' >Ítem</td> ";

//p($Vopcao_obras_idt);

//p(' bbbbbbb '.$opcao_obras);


ForEach ($vetObras as $idx => $Vet)
{

     $nome_obra = $Vet['em_descricao'].'<br>'.$Vet['em_estado'];
     if ($opcao_obras=='E')
     {
         $em_idt = $Vet['em_idt'];
         //p( ' aaaa '.$em_idt. ' bbbb '.$Vopcao_obras_idt[$em_idt]);
         if ($em_idt==$Vopcao_obras_idt[$em_idt])
         {
              echo "   <td style='width:8%;' >$nome_obra</td> ";
         }
         else
         {
             continue;
         }
     }
     else
     {
         if ($estado=='-1')
         {
             echo "   <td style='width:8%;' >$nome_obra</td> ";
         }
         else
         {
             if ($estado==$Vet['em_estado'])
             {
                 echo "   <td style='width:8%;' >$nome_obra</td> ";
             }
         }
     }
}
echo "</tr>";

$itgrupo=0;
$itele = 0;
ForEach ($vetNatrizObraAss as $idx => $Vet)
{
   $vet_func=$Vet['func'];
   $vet_obra=$Vet['obra'];
   // monta função;
   $sf_idt        = $vet_func['sf_idt'];
   $sf_nm_funcao  = $vet_func['sf_nm_funcao'];
   $sf_assinatura = $vet_func['sf_assinatura'];
   $sf_cod_classificacao =  $vet_func['sf_cod_classificacao'];

   $tam   = strlen($sf_cod_classificacao);
   $des   = str_repeat('&nbsp;', (($tam-2)*1) );
   $nivel = ($tam/2);

   $bgi='';
   $cli='#000000';

   if ($nivel==1)
   {
       $itgrupo=$itgrupo+1;
       $des = $des.'&nbsp;&nbsp;'.$itgrupo.' - '.mb_strtoupper($sf_nm_funcao);
       $itele = 0;
       $bgi='#C0C0C0;';
   }
   else
   {
       $itele=$itele+1;
       $des = $des.$itele.' - '.$sf_nm_funcao;
       $bgi='#FFFFFF;';
   }

   echo "<tr class= 'linha_tabela_pa' >";
   echo "<td class='linha_tabela_pa_l' style='font-weight: bold; background:{$bgi}; width:30%; color:{$cli}; text-align:left;'>{$des}</td>";
   // monta colunas
   ForEach ($vet_obra as $idxo => $Vet_o)

   {
        $em_idt    = $Vet_o['em_idt'];
        $em_estado = $Vet_o['em_estado'];
        $ativo     = $Vet_o['ativo'];
        $assina    = $Vet_o['assina'];
        $data      = $Vet_o['data'];
        $versao    = $Vet_o['versao'];
        $assinante = $Vet_o['assinante'];


        if ($opcao_obras=='E')
        {
            if ($em_idt!=$Vopcao_obras_idt[$em_idt])
            {
                continue;
            }
        }

        $colw  = '';
       // $colw  .= $ativo.'<br>';
       // $colw .= $assina.'<br>';



        $bg='#FFFFFF';
        $cc='#000000';
        if  ($assina=='S')
        {   // assinado verde
            //$bg='#00FF40';
            //$cc='#00FF00';
            //$colw .= $assinante.' - '.$data.' - '.$versao.'<br>';
            $colw .= '&radic;';
            //$colw .= '<img id="img_assina_ok" style="margin-left:5px;" width="16" height="16" src="imagens/img_assina_ok.gif" title="Assinatura OK" alt="&radic;"/>';
        }
        else
        {
            if  ($ativo=='S')
            {   // ativo e não assinado vermelho
              //  $bg='#FF0000';
                $cc='#FF0000';
                $colw .= '&Chi;';
           //     $colw .= '<img id="img_assina_nao_ok" style="margin-left:5px;" width="16" height="16" src="imagens/img_assina_nao_ok.gif" title="Assinatura não esta OK" alt="&Chi;"/>';
            }
            else
            {   // não ativo amarelo
              //  $bg='#FFFF80';
                if  ($ativo=='A')
                {   // ativo e não assinado vermelho
                    //bg='#0000FF';
              //      $cc='#0000FF';
                    $colw .= 'SNA';
                  //  $colw .= '<img id="img_assina_nao_assina" style="margin-left:5px;" width="16" height="16" src="imagens/img_assina_nao_assina.gif" title="Não é necessário assinar" alt="S/A"/>';
                }
                else
                {
                    if  ($ativo=='P')
                    {   // ativo e não assinado vermelho
                        $colw .= 'P';
                        $cc='#008080';
                    }
                    else
                    {
                        $colw .= 'N/A';
                    }
                 //   $colw .= '<img id="img_assina_nao_aplica" style="margin-left:5px;" width="16" height="16" src="imagens/img_assina__nao_aplica.gif" title="Não se aplica para esse empreendimento" alt="N/A"/>';
                }
            }
        }
        if ($nivel==1)
        {
            $bg='#C0C0C0';

            if  ($ativo!='S')
            {   // ativo e não assinado vermelho
                if  ($ativo=='P')
                {   // ativo e não assinado vermelho
                    if  ($assina=='S')
                    {   // assinado verde
                    }
                    else
                    {
                        $colw = 'P';
                        $cc='#008080';
                    }
                }
                else
                {
                     $colw = '&nbsp;';
                     $cc='#000000';
                }
            }
            else
            {

            }
        }

        
        
        if ($opcao_obras=='E')
        {
            echo "<td class='linha_tabela_pa_l' style='background:{$bg}; ' >"."<span style='color:{$cc}; '>$colw</span>"."</td>";
        }
        else
        {
            if ($estado=='-1')
            {
                echo "<td class='linha_tabela_pa_l' style='background:{$bg}; ' >"."<span style='color:{$cc}; '>$colw</span>"."</td>";
            }
            else
            {
                if ($estado==$em_estado)
                {
                    echo "<td class='linha_tabela_pa_l' style='background:{$bg}; ' >"."<span style='color:{$cc}; '>$colw</span>"."</td>";
                }
            }
        }
   }
   echo "</tr>";
}
echo "</table>";



echo ' </div> ';

echo ' <br /><br /> ';

//
//    PLANILHA
//
echo ' <div id="lista_assinantes" > ';



$where='';

$sql  = 'select ';
$sql .= ' at.*, ';
$sql .= ' ac.dia as ac_dia, ';
$sql .= ' ac.mes as ac_mes, ';
$sql .= ' ac.ano as ac_ano, ';
$sql .= ' em.idt as em_idt, ';
$sql .= ' em.estado as em_estado, ';
$sql .= ' em.descricao as em_descricao, ';
$sql .= ' sf.nm_funcao as sf_nm_funcao, ';
$sql .= ' sf.cod_classificacao as sf_cod_classificacao, ';
$sql .= ' us.nome_completo as us_nome_completo ';
$sql .= ' from  assina_tela at ';
$sql .= ' inner join assina_controle ac on ac.idt = at.idt_assina_controle';
$sql .= ' inner join site_funcao sf on sf.cod_assinatura = at.assinatura';
$sql .= ' inner join usuario us on us.id_usuario = at.idt_usuario';
$sql .= ' inner join empreendimento em on em.idt = at.idt_empreendimento';
//$sql .= ' where at.idt_empreendimento = '.null($vetFiltro['empreendimento']['valor']);


$sql .= ' where ac.idt = '.null($idt_assinatura_controle);
if ($estado!='-1')
{

    $sql .= ' and em.estado = '.aspa($es_estado);

}

$titulo_rel=' Lista de Assinantes - Controle de '.$ac_data;

$sql .= ' order by ac.ano desc, ac.mes desc , ac.dia desc, em.estado, em.descricao, em.idt, sf.cod_classificacao, us.nome_completo, at.versao desc';
$rs = execsql($sql);

echo "<br /><br />";

echo "<table class='Geral_t_pa' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class='linha_cab_tabela_t_pa'>  ";
echo "   <td style='text-align:center;'  colspan='6' >&nbsp;$titulo_rel</td> ";
echo "</tr>";
echo "<tr class='linha_cab_tabela_t_pa'>  ";
echo "   <td style='text-align:center;'  colspan='6' >&nbsp;$subtitulo_rel</td> ";
echo "</tr>";
echo "</table>";

if  ($rs->rows==0)
{
     $msg= "<br><b>Não tem Resultados para Assinaturas.</b><br><br>";
     echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
     echo "<tr class='linha_cab_tabela'>  ";
     echo "   <td style='text-align:center;' >&nbsp;$msg</td> ";
     echo "</tr>";
     echo "</table>";
}
else
{

     echo "<table class='Geral_pa' width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
     echo "<tr class='linha_cab_tabela_pa'>  ";
//     echo "   <td style='width:10%;' >Controle</td> ";
     echo "   <td style='width:10%;' >Estado</td> ";
     echo "   <td style='width:10%;' >Obra</td> ";
     echo "   <td style='width:15%;' >Menu</td> ";
     echo "   <td style='width:15%;' >Data<br />Assinatura</td> ";
     echo "   <td style='width:10%;' >Versão<br />Assinatura</td> ";
     echo "   <td style='width:20%;' >Usuário<br />Assinante</td> ";
     echo "</tr>";
     $em_estado_ant='#';
     $em_idt_ant=0;
     ForEach($rs->data as $row) {
        $ac_data                  = $row['ac_dia'].'/'.$row['ac_mes'].'/'.$row['ac_ano'];
        $em_idt                   = $row['em_idt'];
        $em_estado                = $row['em_estado'];
        $em_descricao             = $row['em_descricao'];
        $at_data                  = trata_data($row['data']);
        $at_versao                = $row['versao'];
        $us_nome_completo         = $row['us_nome_completo'];
        $sf_cod_classificacao     = $row['sf_cod_classificacao'];
        $sf_nm_funcao             = $row['sf_nm_funcao'];
        $tam = strlen($sf_cod_classificacao);
        $des = str_repeat('&nbsp;', (($tam-2)*1) );
        $des = '';
        echo "<tr class= 'linha_tabela_pa' >";
  //      echo "<td class='linha_tabela_pa_l' >".$ac_data."</td>";
        if ($em_estado_ant!=$em_estado)
        {
            echo "<td class='linha_tabela_pa_l' >".$em_estado."</td>";
            $em_estado_ant = $em_estado;

        }
        else
        {
            echo "<td class='linha_tabela_pa_l' >".'&nbsp;'."</td>";

        }
        if ($em_idt_ant!=$em_idt)
        {
            echo "<td class='linha_tabela_pa_l' >".$em_descricao."</td>";
            $em_idt_ant = $em_idt;

        }
        else
        {
            echo "<td class='linha_tabela_pa_l' >".'&nbsp;'."</td>";

        }


        echo "<td class='linha_tabela_pa_l' >{$des}".$sf_nm_funcao."</td>";
        echo "<td class='linha_tabela_pa_l' >".$at_data."</td>";
        echo "<td class='linha_tabela_pa_l' >".$at_versao."</td>";
        echo "<td class='linha_tabela_pa_l' >".$us_nome_completo."</td>";
        echo "</tr>";
    }
    echo "</table>";
}





// rodapé
if ($_GET['print'] == 's')
{
   /*
   echo " <table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
   echo " <tr class='linha_cab_tabela'>";
   echo "   <td align='center'><img src='imagens/rodape_rel.jpg'/></td>";
   echo " </tr>";
   echo " </table>";
   */
}

echo "</div>";

?>
