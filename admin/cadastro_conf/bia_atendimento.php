<style>
.pesquisa_bia {
    font-size:14px;
    height:30px;
}
div#bia_menu {
        position:absolute;
        left:300px;
        top:230px;
        width :300px;
        background: #FFFFFF;
        display:none;
        z-index:2000000;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-style: normal;
        font-weight: normal;
        color: #000000;
        text-align:left;
        border-bottom:1px solid #000000;
        height:500px;

        xmin-height: 100%; /* Minimum height for modern browsers */
        xheight:100%; /* Minimum height for IE */
        overflow:scroll;
    }
    div#bia_menu img{
        float:right;
        padding-top:3px;
        padding-right:2px;
        cursor:pointer;
    }

    div#bia_menu_cab {
        xwidth :296px;

        width :100%;


        height:40px;

        border:2px solid #F1F1F1;
        color:white;
        background: #2A5696;
        text-align:left;
        color:#FFFFFF;
        padding-right:2px;

    }

    div#bia_menu_det {
        width:100%;
        padding-top:10px;
        padding-left:10px;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-style: normal;
        font-weight: normal;
        color: #313131;
        text-align:left;
        background:#FFFFFF;

    }
    div#bia_menu_cab_texto {
        padding-left:10px;

    }
</style>
<?php


echo "<div id='bia_menu'>";
echo "    <div id='bia_menu_cab'>";
echo "         <img onclick='desativa_bia_menu();' title='Fechar ajuda de campo' src='imagens/fechar.png' border='0'>";
echo "         <img onclick='email_bia_menu();' title='Enviar Bia por Email' src='imagens/email.png' border='0'>";


//echo '<a  >'."&nbsp;<img onclick='return imprime_bia_menu();' title='Imprimir Bia' src='imagens/print.png' border='0'>".'&nbsp;</a>';

echo "        <img onclick='return imprime_bia_menu();' title='Imprimir Bia' src='imagens/print.png' border='0'>";

echo "         <img onclick='DesmarcarTodos();' title='Desmarcar Todos' src='imagens/checkd_not.png' border='0'>";
echo "         <img onclick='MarcarTodos();' title='Marcar Todos' src='imagens/checkd.png' border='0'>";



echo "        <div id='bia_menu_cab_texto'>BIA</div>";





echo "    </div>";

echo "    <div id='bia_menu_det'>";
echo "    </div>";
echo "</div>";



echo " <div  style='text-align:center; background:#2A5696; color:#FFFFFF; font-size:14px; width:100%; display:block; height:25px; float:left;'>";
       echo " BASE DE INFORMAÇÕES";
echo " </div>";

/*
echo " <div  style='color:#004080; margin-top:4px; margin-right:10px; float:left;'>";
    //   echo " <img onclick='return ConfirmaPrioridade_sim({$idt_atendimento});'  style='cursor:pointer; padding-top=5px;' title='Clique para Pesquisar text existente na BIA' src='imagens/botao_pesquisar_n.png' border='0'>";
       echo " <img onclick='return ConfirmaMenuBia(event,{$idt_atendimento});'  style='cursor:pointer; padding-top=5px;' title='Mostra Menu BIA' src='imagens/seta_cima.png' border='0'>";
echo " </div>";
*/
echo " <div  style='width:80%; height:30px; color:#ffffff; background:#2f66b8;  float:left;'>";
       echo " <input id='texto_pesq_bia'   style='width:100%; height:25px; color:#5C6D7F; xbackground:#2f66b8;' type='text' xsize='47' name='pesq_bia' xclass='pesquisa_bia' value='' /> ";
echo " </div>";
echo " <div  style='width:20%;  background:#2f66b8;   float:left;'>";
       echo " <img class='pesquisa_bia' width='30' height='30' onclick='return ConfirmaPesquisarBIA({$idt_atendimento});'  style='cursor:pointer; padding-left:5px; ' title='Clique para Pesquisar texto existente na BIA' src='imagens/lupa.png' border='0'>";
echo " </div>";


 $_SESSION[CS]['g_menu_bia']='';
 $qtditens = 0;
 $html = GeraMenuBia($qtditens);
 echo $html;
 

?>
<script>


var grupo_bia    = "";
var menu_bia     = "";
var submenu_bia  = "";
var texto_pesq_bia='';

var qtditens =  <?php echo $qtditens;   ?>;


var idt_atendimento =  '<?php echo $idt_atendimento;   ?>';


$(document).ready(function () {
    if (qtditens>35)
    {
       objd=document.getElementById('grd1');
       if (objd != null)
       {
           $(objd).css('overflowy','scroll');
       }
    }
});

function ConfirmaPesquisarBIA(idt_atendimento)
{


   var id='texto_pesq_bia';
   objtp = document.getElementById(id);
   if (objtp != null) {
       texto_pesq_bia = objtp.value;
   }
   //alert('Pesquisar BIA to vivo '+texto_pesq_bia);
       var str="";
       var titulo = "Processando a solicitação da BIA. Aguarde...";
       processando_grc(titulo,'#2F66B8');
       $.post('ajax_atendimento.php?tipo=PesquisarBIA', {
          async: false,
          idt_atendimento : idt_atendimento,
          texto_pesq_bia   : texto_pesq_bia
       }
       , function (str) {
           if (str == '') {
           } else {
               processando_acabou_grc();
               var id='bia_menu_det';
               objbiadet = document.getElementById(id);
               if (objbiadet != null) {
                   objbiadet.innerHTML = str;
               }
               
               grupo_bia    = "Todas as Bias";
               menu_bia     = "";
               submenu_bia  = "";

               MolduraDaBia(0);
           }
       });
}
function MolduraDaBia(opc)
{

    texto_pesq_biaw='';
    if (texto_pesq_bia=='')
    {
        texto_pesq_biaw='';
    }
    else
    {
        texto_pesq_biaw="'"+texto_pesq_bia+"'";
    }

    if (opc==0)
    {
        var bia_menu_cab_texto = grupo_bia+"<br />"+"Texto: "+texto_pesq_biaw;
    }
    else
    {
        var bia_menu_cab_texto = grupo_bia + " - " + menu_bia + "<br />" + submenu_bia;
    }
    
    
    var id='bia_menu_cab_texto';
    objbia = document.getElementById(id);
    if (objbia != null) {
       objbia.innerHTML = bia_menu_cab_texto;
    }
    var bia_x = 0;
    var bia_y = 0;
    var width_bia  = 0;
    var height_bia = 0;
    var id='grd2';
    objpbia = document.getElementById(id);
    if (objpbia != null) {
        var coordenada = $(objpbia).position();
        bia_x  = coordenada.left;
        bia_y  = coordenada.top;
        width_bia  = $(objpbia).css('width');
        height_bia = $(objpbia).css('height');
    }
    var id='bia_menu';
    objbia = document.getElementById(id);
    if (objbia != null) {
       objbia.style.left = bia_x + "px";
       objbia.style.top  = bia_y + "px";
       $(objbia).css('width',width_bia);
       $(objbia).css('height',height_bia);
       $(objbia).show();
    }
}
function desativa_bia_menu()
{
    var id='bia_menu';
    objtp = document.getElementById(id);
    if (objtp != null) {
       $(objtp).hide();
    }
}

function AbreMenu(codigo)
{
   //alert('abre cccc '+codigo);
    var id = '#img_i'+codigo;
    var img = $(id);
    if (img.attr('src') == 'imagens/mais_t.png') {
         img.attr('src', 'imagens/menos_t.png');
         flag = 1;
    } else {
         img.attr('src', 'imagens/mais_t.png');
         flag = 0;
    }

   var id='.t'+codigo;
   $(id).each(function () {
       $(this).toggle();
   });
}

function AbreMenuGrupo(agrupamento)
{
   // alert('gggg');
    var flag = 0;
    var id = '#img_g'+agrupamento;
    var img = $(id);
    if (img.attr('src') == 'imagens/mais_t.png') {
         img.attr('src', 'imagens/menos_t.png');
         flag = 1;
    } else {
         img.attr('src', 'imagens/mais_t.png');
         flag = 0;
    }

   

   var id='.grupo'+agrupamento;
   $(id).each(function () {
       $(this).toggle();
   });
   
   var id='.grupotp'+agrupamento;
   $(id).each(function () {
       var cod = $(this).attr('cod');


       var id = '#img_i'+cod;
       var img = $(id);
       if (flag== 1)
       {
            //img.attr('src', 'imagens/menos1.png');
            img.attr('src', 'imagens/menos_t.png');
            var id='.t'+cod;
            $(id).each(function () {
               $(this).show();
            });
       }
       else
       {
            img.attr('src', 'imagens/mais_t.png');
            var id='.t'+cod;
            $(id).each(function () {
                $(this).hide();
            });

       }
   });

   
   
}

function ExecutaSubMenu(codigo, idt_pai, idt_filho, grupo, menu, submenu)
{
       // alert(' mostrar ' + codigo + ' pai '+ idt_pai + ' filho '+ idt_filho);
       grupo_bia    = grupo;
       menu_bia     = menu;
       submenu_bia  = submenu;
       //
       var str="";
       var titulo = "Processando a solicitação da BIA. Aguarde...";
       processando_grc(titulo,'#2F66B8');

       $.post('ajax_atendimento.php?tipo=ConteudoBia', {
          async: false,
          codigo    : codigo,
          idt_pai   : idt_pai,
          idt_filho : idt_filho
       }
       , function (str) {
           if (str == '') {
           } else {
               processando_acabou_grc();
               var id='bia_menu_det';
               objbiadet = document.getElementById(id);
               if (objbiadet != null) {
                   objbiadet.innerHTML = str;
               }
               MolduraDaBia(1);
           }
       });

}

function AbreItemMenu(idt_conteudo)
{

    var flag = 0;
    var id = '#img_cont_'+idt_conteudo;
    var img = $(id);
    if (img.attr('src') == 'imagens/mais_t.png') {
         img.attr('src', 'imagens/menos_t.png');
         flag = 1;
    } else {
         img.attr('src', 'imagens/mais_t.png');
         flag = 0;
    }



   var id='.contbia';
   $(id).each(function () {
       var idt = $(this).attr('idt');
       if (idt!=idt_conteudo)
       {
           $(this).hide();
       }
    });
    var id='contbia'+idt_conteudo;
    objtp = document.getElementById(id);
    if (objtp != null) {
       $(objtp).toggle();
    }
    return false;
}
function email_bia_menu()
{

   //alert(' idt_atendimento === '+idt_atendimento);

   var idt      = 0;
   var stridt   = "";
   var qtdcont  = 0;
   var marcado  = "";
   var marcados = "";
   var id='.esc_bia_pesq';
   $(id).each(function () {
        idt     = $(this).attr('idt');
        marcado = $(this).is(":checked");
        if (marcado)
        {
            marcados  = marcados + idt + '___' ;
            qtdcont   = qtdcont + 1;
        }

    });
    
    
    var idt_pessoa  = "";
    var id='idt_pessoa';
    objtp           = document.getElementById(id);
    if (objtp != null) {
       idt_pessoa = objtp.value;
    }

    //alert(marcados);




    
   // alert(' pessoa '+idt_pessoa+ ' idt = '+idt+' qtd '+qtdcont+ ' str '+ marcados + ' valor = '+ marcado );

   if (qtdcont>0)
   {
      var str="";

      MontaEnvioEmail(idt_pessoa,marcados,str);


/*
       $.post('ajax_atendimento.php?tipo=EnviarEmailBia', {
          async: false,
          marcados     : marcados,
          idt_pessoa   : idt_pessoa
       }
       , function (str) {
           if (str == '') {
                alert(' Envio de Email Não obteve Sucesso');
           } else {
               MontaEnvioEmail(idt_pessoa,marcados,str);
           }
       });
*/
       
       
   }
   else
   {
       alert('Por favor, selecione pelo menos um Conteúdo Bia para enviar email.');
   }

   return false;

}

function  MontaEnvioEmail(idt_pessoa,marcados,str)
{
    var  left   = 100;
    var  top    = 100;
    var  height = $(window).height()-100;
    var  width  = $(window).width() * 0.8 ;
    //var idt_atendimento=0;
    
    
    // alert( '  p '+idt_pessoa+'  m '+marcados);
    
    var  link ='conteudo_atendimento_email_bia.php?prefixo=inc&menu=atendimento_email_bia&idt_atendimento='+idt_atendimento+'&idt_pessoa='+idt_pessoa+'&marcados='+marcados+'&str='+str;
    emailbia =  window.open(link,"EmailBia","left="+left+",top="+top+",width="+width+",height="+height+",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
    emailbia.focus();
}
function imprime_bia_menu()
{
   var idt      = 0;
   var stridt   = "";
   var qtdcont  = 0;
   var marcado  = "";
   var marcados = "";
   var id='.esc_bia_pesq';
   $(id).each(function () {
        idt     = $(this).attr('idt');
        marcado = $(this).is(":checked");
        if (marcado)
        {
            marcados  = marcados + idt + '___' ;
            qtdcont   = qtdcont + 1;
        }

   });
   var idt_pessoa  = "";
   var id='idt_pessoa';
   objtp           = document.getElementById(id);
   if (objtp != null) {
       idt_pessoa = objtp.value;
   }
   if (qtdcont>0)
   {
      var str="";
      MontaImprimeBia(idt_pessoa,marcados,str);
   }
   else
   {
       alert('Por favor, selecione pelo menos um Conteúdo Bia para Impressão.');
   }
   return false;
}


function  MontaImprimeBia(idt_pessoa,marcados,str)
{
    var  left   = 100;
    var  top    = 100;
    var  height = $(window).height()-100;
    var  width  = $(window).width() * 0.8 ;
    var  link   = 'conteudo_atendimento_imprime_bia.php?prefixo=inc&menu=atendimento_imprime_bia&idt_atendimento='+idt_atendimento+'&idt_pessoa='+idt_pessoa+'&marcados='+marcados+'&str='+str;
    imprimebia  = window.open(link,"ImprimeBia","left="+left+",top="+top+",width="+width+",height="+height+",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
    imprimebia.focus();
}


function imprime_bia_menu_XXXX()
{
   var idt_pessoa = "";
   var id='idt_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
       idt_pessoa = objtp.value;
   }

   var marcados = SelecaoMarcados();
   alert('idt_pessoa '+idt_pessoa+' conteudo '+ marcados);

   var str="";
   $.post('ajax_atendimento.php?tipo=ImprimeBia', {
      async: false,
      marcados  : marcados,
      idt_pessoa       : idt_pessoa
   }
   , function (str) {
       if (str == '') {
           alert(' ok ');
       } else {
           /*
           var id='bia_menu_det';
           objbiadet = document.getElementById(id);
           if (objbiadet != null) {
               objbiadet.innerHTML = str;
           }
           MolduraDaBia();
           */
       }
   });


   return false;
}


function MarcarTodos()
{
   var id='.esc_bia_pesq';
   $(id).each(function () {
       $(this).prop("checked",true);
    });
    //return false;
}
function DesmarcarTodos()
{
   var id='.esc_bia_pesq';
   $(id).each(function () {
       $(this).prop("checked",false);

    });
    //return false;
}

function SelecaoMarcados()
{
   var marcados = "";
   var id='.esc_bia_pesq';
   $(id).each(function () {
       if ($(this).prop("checked")==true)
       {
           var idt  = $(this).attr("idt");
           marcados = marcados + idt + "###";
       }

    });
    return marcados;
}



</script>