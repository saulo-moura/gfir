<style>
.pesquisa_bia {
    font-size:14px;
    height:24px;
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
        padding-top:10px;
        padding-right:10px;
        cursor:pointer;
    }

    div#bia_menu_cab {
        xwidth :296px;
        
        width :100%;
        
        
        height:25px;
        
        border:2px solid #F1F1F1;
        color:white;
        background: #006ca8;
        text-align:left;
        color:#FFFFFF;

    }

    div#bia_menu_det {
        width:20%;
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
</style>
<?php
echo "<div id='bia_menu'>";
echo "    <div id='bia_menu_cab'>";
echo "         <img onclick='desativa_bia_menu();' title='Fechar ajuda de campo' src='imagens/fechar.gif' border='0'>";
echo '<a  >'."&nbsp;<img onclick='return abre_bia();' title='Abre Bia do Menu' src='imagens/alterar.gif' border='0'>".'&nbsp;</a>';
echo "        <span id='bia_menu_cab_texto'>Menu da BIA</span>";
echo "    </div>";
echo "    <div id='bia_menu_det'>";
echo "    </div>";
echo "</div>";



echo " <div  style='text-align:center; background:#004080; color:#FFFFFF; font-size:14px; width:100%; display:block; height:25px; float:left;'>";€€
       echo " BIA - Base de Informações para Atendimento";
echo " </div>";

//echo " <div  style='color:#004080; margin-top:4px; margin-right:4px; font-size:12px; float:left;'>";
//       echo " Texto para pesquisar: ";
//echo " </div>";


echo " <div  style='color:#004080; margin-top:4px; margin-right:10px; float:left;'>";
    //   echo " <img onclick='return ConfirmaPrioridade_sim({$idt_atendimento});'  style='cursor:pointer; padding-top=5px;' title='Clique para Pesquisar text existente na BIA' src='imagens/botao_pesquisar_n.png' border='0'>";
       echo " <img onclick='return ConfirmaMenuBia(event,{$idt_atendimento});'  style='cursor:pointer; padding-top=5px;' title='Mostra Menu BIA' src='imagens/seta_cima.png' border='0'>";
echo " </div>";


echo " <div  style='color:#004080; margin-top:4px;  float:left;'>";
       echo " <input id='texto_pesq_bia' type='text' size='47' name='pesq_bia' class='pesquisa_bia' value='' /> ";
echo " </div>";

echo " <div  style='color:#004080; margin-top:4px;  float:left;'>";
    //   echo " <img onclick='return ConfirmaPrioridade_sim({$idt_atendimento});'  style='cursor:pointer; padding-top=5px;' title='Clique para Pesquisar text existente na BIA' src='imagens/botao_pesquisar_n.png' border='0'>";
       echo " <img onclick='return ConfirmaPesquisarBIA({$idt_atendimento});'  style='cursor:pointer; padding-top=5px;' title='Clique para Pesquisar text existente na BIA' src='imagens/zoom.gif' border='0'>";
echo " </div>";
?>
<script>
$(document).ready(function () {
/*
           objd=document.getElementById('tipo_pessoa_desc');
           if (objd != null)
           {
               $(objd).css('visibility','hidden');
           }
           objd=document.getElementById('tipo_pessoa');
           if (objd != null)
           {
               objd.value = "";
               $(objd).css('visibility','hidden');
           }
*/
           
});


//var pos_mouse_x = 0;
//var pos_mouse_y = 0;

function ConfirmaPesquisarBIA(idt_atendimento)
{
    alert('Pesquisar BIA to vivo');
    /*
   var id='tipo_pessoa';
   objtp = document.getElementById(id);
   if (objtp != null) {
       objtp.value = 'S';
    }
*/
}
function ConfirmaMenuBia(e,idt_atendimento)
{
    //alert('Menu Bia to vivo');
    var bia_x = 0;
    var bia_y = 0;
    var width_bia  = 0;
    var height_bia = 0;
    
    var id='grd0';
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
       //$(objbia).css('width','100px');
       //$(objbia).css('height',height_bia);
       // buscar menu
       var str="";
       $.post('ajax_atendimento.php?tipo=MenuBia', {
          async: false
       }
       , function (str) {
           if (str == '') {
           } else {
               var id='bia_menu_det';
               objbiadet = document.getElementById(id);
               if (objbiadet != null) {
                   objbiadet.innerHTML = str;
               }
               var id='bia_menu';
               objbia = document.getElementById(id);
               if (objbia != null) {
                   $(objbia).show();
               }
           }
       });



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

var pTabela = '';
var pCampo = '';
var pDescricao = '';
function  xhelp_campo(e, campo, tabela, descricao)
{
    coordenadasdomouse(e);
    //  alert(' X '+pos_mouse_x+' Y '+pos_mouse_y);
    pTabela = tabela;
    pCampo = campo;
    pDescricao = descricao;

    $.post('ajax.php?tipo=help_campo', {
        async: false,
        tabelaw: tabela,
        campow: campo,
        descricaow: descricao
    }
    , function (str) {
        if (str == '') {
            //                self.location = 'conteudo.php?prefixo=listar&menu=pessoal_efetivo&class=0&idt0='+idt0+'&idt1='+idt1;
        } else {
            //  alert(url_decode(str).replace(/<br>/gi, "\n"));
            var ret = str.split('######');
            //   $(this).ColorPickerSetColor({r:cor[0], g:cor[1], b:cor[2]});
            re = ret[0];
            tx = ret[1];
            ds = ret[2];
            tx1 = '<p2 style="color:#900000;">' + re + '</p2>';
            tx = tx1 + '<a>' + tx + '</a>';

            objd = document.getElementById('help_campo_cab_texto');
            objd.innerHTML = '<span style="margin-top:5px;">Campo: ' + '<span style="color:#900000;">' + ds + '</span></span>';

            objd = document.getElementById('help_campo_det');
            objd.innerHTML = tx;
            obj = document.getElementById('help_campo');
            obj.style.height = '150px';
            objd.style.textAlign = 'left';
            objd.style.paddingLeft = '10px';
            obj.style.display = 'block';
            var posx = pos_mouse_x;
            var posy = pos_mouse_y;
            pos_mouse_x_cpo = posx;
            pos_mouse_y_cpo = posy;
            obj.style.left = posx + "px";
            obj.style.top = posy + "px";
            setTimeout("desativa_help_campo()", 20000);

        }
    });

    return false;
}
function xdesativa_help_campo() {
    document.getElementById('help_campo').style.display = 'none';
}

function xcoordenadasdomouse(e) {
    var posx = 0;
    var posy = 0;
    if (!e)
        var e = window.event;
    if (e.pageX || e.pageY) {
        posx = e.pageX;
        posy = e.pageY;
    }
    else if (e.clientX || e.clientY) {
        posx = e.clientX + document.body.scrollLeft
                + document.documentElement.scrollLeft;
        posy = e.clientY + document.body.scrollTop
                + document.documentElement.scrollTop;
    }
//	alert(' x1 '+posx+' y1 '+posy);
    // posx and posy contain the mouse position relative to the document
    // Do something with this information
    pos_mouse_x = posx;
    pos_mouse_y = posy;
    //  alert(' X '+pos_mouse_x+' Y '+pos_mouse_y);

}

function xabre_ajuda_campo() {
//    alert (' tt '+pTabela+' tt '+pCampo);

    if (pTabela == undefined)
        return false;
    if (pCampo == undefined)
        return false;

    var url = 'conteudo_ajuda_campo.php?tabela=' + pTabela + '&campo=' + pCampo + '&descricao=' + pDescricao;
    var L = (screen.width - 782) / 2;
    var T = (screen.height - 550) / 2;

    OpenWin(url, 'ajuda_campo', 782, 550, T, L);
    return false;
}

function AbreMenu(codigo)
{
alert('abre '+codigo);
}

</script>