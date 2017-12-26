var reduz_cron = 'S';
var num_inicialw = 1;
var pg_inicialw = 1;


$(document).ready(function () {
    if ($.isFunction(self.onLoadPag))
        onLoadPag();

    var idxSub = $.inArray(menu, subMenuF);
    if (idxSub > -1)
        MenuSub(subMenuP[idxSub]);
    /*
     $('div#menu li[id]').click(function() {
     $('div#menu li[id]').removeClass('menos');
     $('div#menu li[id]').addClass('mais');
     $('div#menu li[lang]').hide();
     
     var o = $(this);
     
     
     if (o.attr('id') != '') {
     o.removeClass('mais');
     o.addClass('menos');
     $('div#menu li[lang=' + o.attr('id') + ']').show();
     }
     });
     
     $('div#menu li[sem_filho]').click(function() {
     $('div#menu li[id]').removeClass('menos');
     $('div#menu li[id]').addClass('mais');
     $('div#menu li[lang]').hide();
     
     });
     */
    // esmeraldo 24-02-2011

    $('div#menu li[id]').click(function () {
        //$('div#menu li[id]').removeClass('menos');
        //$('div#menu li[id]').addClass('mais');
        //$('div#menu li[lang]').hide();

        var o = $(this);

        if (o.attr('id') != '') {
            //o.removeClass('mais');
            //o.addClass('menos');
            //$('div#menu li[lang=' + o.attr('id') + ']').show();
            MenuSub(o.attr('id'));
        }

        return false;
    });

    $('#menu_float_bt').click(function () {
        var img = $(this).find('img');

        if ($('#menu').is(':hidden')) {
            var p = $(this).position();
            $('#menu').css('top', p.top + img.height());
            $('#menu').css('left', p.left);
            $('#menu').show();
            img.attr('src', 'imagens/seta_baixo_32.png');
        } else {
            $('#menu').hide();
            img.attr('src', 'imagens/seta_cima_32.png');
        }
    });

    if ($('div.menu_float > ul > li').length == 0) {
        $('#menu_float_bt').hide();
    }

    if (print_tela == 'S')
        setTimeout('self.print()', 1000);

    /*
     $('div#menu li[sem_filho]').click(function() {
     $('div#menu li[id]').removeClass('menos');
     $('div#menu li[id]').addClass('mais');
     $('div#menu li[lang]').hide();
     });
     */

    // até aqui
    if (prefixo == 'cadastro') {
        $tabs = $("div#tabHtml").tabs({
            activate: function (event, ui) {
                TelaHeight();
            }
        });

        $('input:visible:not(:radio), textarea:visible').focus(function () {
            $(this).addClass('campo_focus');
        });

        $('input:visible:not(:radio), textarea:visible').blur(function () {
            $(this).removeClass('campo_focus');
        });
    }

    //  $("a[rel^='prettyPhoto']").prettyPhoto();






    //  $('#login img').click(function() {
    $('#login_b_entrar').click(function () {
        var login = $('#login_dados [name="login"]');
        var senha = $('#login_dados [name="senha"]');

        if (login.val() == '') {
            alert('Favor informar o Usuário!');
            login.focus();
            return false;
        }

        if (senha.val() == '') {
            alert('Favor informar a Senha!');
            senha.focus();
            return false;
        }
        // alert(' dfdfd 00000000'+login.val()+ ' bbb '+ senha.val());
        var str2 = '';
        $.post('admin/ajax.php?tipo=login', {
            async: false,
            login: url_encode(login.val()),
            senha: url_encode(senha.val())
        }, function (str2) {
            if (str2 == '') {
                $('#login_dados input').val('');
                self.location.reload();
            } else {
                $('#login_dados input').val('');
                alert(url_decode(str2).replace(/<br>/gi, "\n"));
            }
        });
    });

    $('#login_dados input').keyup(function (event) {
        if (event.keyCode == 13) {
            $('#login_b_entrar').click();
        }
    });


    $('#login_b_alterar_senha').click(function () {
        var login = $('#login_dados [name="login"]');
        var senha = $('#login_dados [name="senha"]');

        if (login.val() == '') {
            alert('Favor informar o Usuário!');
            login.focus();
            return false;
        }

        if (senha.val() == '') {
            alert('Favor informar a Senha!');
            senha.focus();
            return false;
        }

        $.post('admin/ajax.php?tipo=alterar_senha', {
            login: url_encode(login.val()),
            senha: url_encode(senha.val())
        }, function (str) {
            if (str == '') {
                $('#login_dados input').val('');
                self.location = 'conteudo.php';
            } else {
                $('#login_dados input').val('');
                alert(url_decode(str).replace(/<br>/gi, "\n"));
                self.location = 'conteudo.php';

            }
        });
    });

    $('#login_b_esqueci_senha').click(function () {
        var login = $('#login_dados [name="login"]');

        if (login.val() == '') {
            alert('Favor informar o Usuário!');
            login.focus();
            return false;
        }

        $.ajax({
            type: 'POST',
            url: 'admin/ajax.php?tipo=esqueci_senha',
            data: {
                login: login.val()
            },
            beforeSend: function () {
                processando();
            },
            complete: function () {
                $("#dialog-processando").remove();
            },
            success: function (str) {
                $("#dialog-processando").remove();

                if (str != '') {
                    alert(url_decode(str));
                }

                $('#login_dados input').val('');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#dialog-processando").remove();

                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
    });



    $('#administrar img').click(function () {
        var login = $('#login_gc [name="login"]');
        var senha = $('#login_gc [name="senha"]');

        if (login.val() == '') {
            alert('Favor informar o Usuário!');
            login.focus();
            return false;
        }

        if (senha.val() == '') {
            alert('Favor informar a Senha!');
            senha.focus();
            return false;
        }

        $.post('admin/ajax2.php?tipo=login', {
            login: url_encode(login.val()),
            senha: url_encode(senha.val())
        }, function (str) {
            if (str == '') {
                $('#login_gc input').val('');
                //  alert(' dfdfd ');
                //self.location = 'conteudo.php';

                window.open('admin/', 'admin');

                obj = document.getElementById('administrar_gc');
                obj.style.display = 'block';
                obj = document.getElementById('administrar');
                obj.style.display = 'none';
                obj = document.getElementById('login_gc');
                obj.style.display = 'none';




                //window.open('oas_pco/index.php', 'admin');
            } else {
                $('#login_gc input').val('');

                alert(url_decode(str).replace(/<br>/gi, "\n"));
                self.location = 'conteudo.php';





            }
        });
    });

    $('#login_gc input').keyup(function (event) {
        if (event.keyCode == 13) {
            $('#administrar img').click();
        }
    });


    if (prefixo == 'inc' && menu == 'home') {
    }




    if (menu == 'para fotos' && prefixo == 'det')
    {
        //alert (' vivi ');
        $('div#gallery a').lightBox({
            imageLoading: 'js/jquery-lightbox-0.5/lightbox-ico-loading.gif',
            imageBtnClose: 'js/jquery-lightbox-0.5/lightbox-btn-close.gif',
            imageBtnPrev: 'js/jquery-lightbox-0.5/lightbox-btn-prev.gif',
            imageBtnNext: 'js/jquery-lightbox-0.5/lightbox-btn-next.gif',
            imageBlank: 'js/jquery-lightbox-0.5/lightbox-blank.gif',
            keyToClose: 'f',
            keyToPrev: 'a',
            keyToNext: 'p',
            txtImage: 'Imagem',
            txtOf: 'de'
        });
    }



    if (menu == 'galeria_fotos' && prefixo == 'det') {
        $("a[rel^='prettyPhoto']").prettyPhoto({
            social_tools: '',
            slideshow: 3000,
            theme: 'facebook',
            allow_resize: false,
            animationSpeed: 'slow', /* fast/slow/normal */
            opacity: 0.40, /* Value between 0 and 1 */
            showTitle: false /* true/false */

        });

        if (queryString('abre') == 's') {

            var idt = queryString('id');
            if (idt == '') {
                $("a[rel^='prettyPhoto']:first").click();
            } else {
                var $o = $("a[rel^='prettyPhoto'][idt='" + idt + "']").click();
                if ($o.length == 0) {
                    $("a[rel^='prettyPhoto']:first").click();
                }
            }
        }
    }

    if (popup_open == '') {
        setTimeout("noticia_sistema(\"'T', 'S'\")", 500);
    }
});

function TelaHeight() {
    if ($('div#div_geral').length > 0) {
        $('div#conteudo').height('');

        var menos = 0;

        if ($('div#div_topo').css('display') != 'none') {
            menos += $('div#div_topo').height();
        }

        menos += $('div#div_rodape').height();

        if ($('div#div_geral').height() < $(window).height() - menos) {
            var height = $(window).height() - $('div#div_geral').height();
            height += $('div#conteudo').height();
            height -= menos;
            $('div#conteudo').height(height);
        }
    }

    /*
     if ($.isFunction(self.ajusta_altura_PopWin)) {
     ajusta_altura_PopWin('');
     }
     
     if (postMessageAcao) {
     parent.postMessage($('#geral_cadastro').outerHeight(true), postMessageUrl);
     }
     */
}

function MenuSub(menu) {
    if (menu != '') {
        $("div#menu li[lang='" + menu + "']").toggle();
        $("div#menu li[lang='" + menu + "']:last").toggleClass("fim_grupo");
        $("div#menu li#" + menu).toggleClass("menos");
    }
    return false;
}




function ativa_gc()
{
    obj = document.getElementById('administrar_gc');
    obj.style.display = 'none';
    obj = document.getElementById('administrar');
    obj.style.display = 'block';
    obj = document.getElementById('login_gc');
    obj.style.display = 'block';

    $('#login_gc input:first').focus();
    return false;
}
function desativa_gc()
{
    obj = document.getElementById('administrar_gc');
    obj.style.display = 'block';

    obj = document.getElementById('administrar');
    obj.style.display = 'none';
    obj = document.getElementById('login_gc');
    obj.style.display = 'none';

    return false;
}

var pos_mouse_x = 0;
var pos_mouse_y = 0;
var estado_ativo = '##';

function sensibiliza(event, estado)
{
    // neutralizado em 23/02/2011 por guy e pode voltar a ser válido
    // então deve tornar o estado vermelho...
    // chamar ajx??? deve vir da primeira chamada
    var idtest = 'mapa_e_' + estado;
    obj = document.getElementById(idtest);
    if (obj != null)
    {
        if (estado != 'xx')
        {
            idtest = 'mapa_e_xx';
            objxx = document.getElementById(idtest);
            objxx.style.display = 'none';
            obj.style.display = 'block';
        }
    }




    if (estado_ativo != estado)
    {

        if (estado_ativo != '##')
        {
            //    desensibiliza('##');
        }
        estado_ativo = estado;
    }
    return false;


    if (estado == 'TT')
    {
        //return false;
    }

    var obra_estado = 'obras_' + estado;
    // var obras = 'obras';
    var obras = obra_estado;
    obj = document.getElementById(obras);
    if (obj != null)
    {

        //  opcao='2'
        opcaow = busca_atributo(obj, 'opcao', '');
        if (opcaow == 1)
        {
            obj.style.display = 'block';
            iddiv = '#' + obras;
            //  $('#homeobra').fadeIn(2000);
            //  $('#homeobra').fadeTo("slow",0.5);
            //  $(iddiv).fadeIn(2000);
            //  $(iddiv).fadeTo("slow",0.7);
        } else
        {
            obj.style.cursor = 'default';
        }

    } else
    {
        return false;
    }

    //   obj=document.getElementById('empreendimento_l');
    //   obj.style.display='block';


    var e = event;

    coordenadasdomouse(e);

    var posx = pos_mouse_x;
    var posy = pos_mouse_y;
    if (estado == 'ba')
    {
        posy = posy - 30;

    }

    obj.style.left = posx + "px";
    obj.style.top = posy + "px";

}

function busca_atributo(theobject, katributow, kerrow)
{
    var valorw;
    try
    {
        valorw = theobject.attributes.getNamedItem(katributow).value;
    } catch (E)
    {
        valorw = kerrow;
    }
    return valorw;
}

function desativaobra()
{
    if (estado_ativo == '##')
    {
        return false;
    }
    desensibiliza('##');
    return false;
}

function movebox(event, estado)
{
    if (estado_ativo == '##')
    {
        return false;
    }

    estado = estado_ativo;


    var obra_estado = 'obras_' + estado;
    var obras = obra_estado;
    obj = document.getElementById(obras);
    if (obj != null)
    {
        obj.style.display = 'block';
    } else
    {
        return false;
    }
    var e = event;
    coordenadasdomouse(e);

    var posx = pos_mouse_x;
    var posy = pos_mouse_y;
    if (estado == 'ba')
    {
        posy = posy - 30;

    }
    obj.style.left = posx + "px";
    obj.style.top = posy + "px";

}

function coordenadasdomouse(e) {
    //var e = e1;
    //var e = event;
    var posx = 0;
    var posy = 0;
    if (!e)
        var e = window.event;
    if (e.pageX || e.pageY) {
        posx = e.pageX;
        posy = e.pageY;

        //alert(' a x1 '+posx+' y1 '+posy);


    } else if (e.clientX || e.clientY) {
        posx = e.clientX + document.body.scrollLeft
                + document.documentElement.scrollLeft;
        posy = e.clientY + document.body.scrollTop
                + document.documentElement.scrollTop;

        //alert(' b x1 '+posx+' y1 '+posy);

    }
    //alert(' x1 '+posx+' y1 '+posy);
    // posx and posy contain the mouse position relative to the document
    // Do something with this information
    pos_mouse_x = posx;
    pos_mouse_y = posy;

}
function saiestado(event, estado)
{
    if (estado_ativo != '##')
    {
        desensibiliza('##');
    }
}
function desensibiliza(estado)
{
    if (estado_ativo == estado)
    {
        return false;
    }

    //if (estado_ativo=='ba')
    //{
    var idtest = 'mapa_e_' + estado_ativo;
    obj = document.getElementById(idtest);
    if (obj != null)
    {
        idtest = 'mapa_e_xx';
        objxx = document.getElementById(idtest);
        objxx.style.display = 'block';
        obj.style.display = 'none';
    }
    if (estado == '##')
    {
        estado = estado_ativo;
    }


//    return false;



    // alert(estado);
    var obra_estado = 'obras_' + estado;
    //var obras = 'obras';
    var obras = obra_estado;

    obj = document.getElementById(obras);
    if (obj != null)
    {
        obj.style.display = 'none';

        // iddiv='#'+obras;

        // $('#homeobra').fadeIn(2000);
        // $('#homeobra').fadeTo("slow",1);

        // $(iddiv).fadeIn(2000);
        // $(iddiv).fadeTo("slow",1);





    } else
    {
        return false;
    }

//obj=document.getElementById('empreendimento_l');
//obj.style.display='none';

}




function mostra_quadro(obj) {
    obj.style.display = 'block';
}

function am_decimal(texto)
{

    var str = new String(texto);

    str1 = str.replace(/,/g, "#");
    str2 = str1.replace(/\./g, ",");
    str3 = str2.replace(/#/g, ".");

    i = str3.indexOf("-");
    if (i != -1)
    {
        str3 = str3.replace(/-/g, "( ");
        str3 = str3 + ' )';
    }

    return str3;
}


function omite_label(texto)
{

    var str = new String(texto);

    str1 = str.replace(/,/g, "#");
    str2 = str1.replace(/\./g, ",");
    str3 = str2.replace(/#/g, ".");

    i = str3.indexOf("-");
    if (i != -1)
    {
        str3 = str3.replace(/-/g, "( ");
        str3 = str3 + ' )';
    }

    if (str3 == '0,00')
    {
        str3 = '';
    } else
    {
        str3 = str3 + ' %';
    }

    return str3;
}


function ampliar(str) {
    // alert(str);
    OpenWin('conteudo_popup.php?' + str, 'oas_ampliar', 1000, $(window).height(), 50, ($(window).width() - 1000) / 2, 'yes');
}







function funcGerObra_gc(thisw)
{
    var indice = thisw.selectedIndex;
    var idt_empreendimento = thisw.options[indice].value;
    var nm_empreendimento = thisw.options[indice].text;
    var str = '';
    //   alert(' dfdfd  '+idt_empreendimento);
    $.post('ajax.php?tipo=obra_ge', {
        async: false,
        idt_obra: idt_empreendimento,
        nm_obra: nm_empreendimento
    }
    , function (str) {
        if (str == '') {
            self.location = 'conteudo.php?prefixo=inc&menu=fluxo_obras&idt_obra=' + idt_empreendimento;
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });

}



function desiste_altera_faleconosco() {

    self.location = 'conteudo.php';

}

function desiste_duvida() {


    self.location = 'conteudo.php';

}
function desiste_noticia_sistema() {


    self.location = 'conteudo.php';

}




function format_decimal_n(field, ndec) {
    var multiplicador = Math.pow(10, ndec);
    var vl = field * multiplicador;
    var rrr = Math.round(vl);
    //var vl_rrr = rrr/100;
    if (multiplicador != 0)
    {
        var vl_rrr = rrr / multiplicador;
    } else
    {
        var vl_rrr = rrr;
    }
    var sss = vl_rrr.toString();
    var str = format_decimal(sss, ndec);
    return str;
}


function format_decimal(field, ndec) {
    var valid = "0123456789,-";
    var ok = "yes";
    var ponto = 0;
    var temp;
    var numponto = 0;
    var vFinal = "";
    var msg = "";
    //Retira os Pontos
    fieldw = field.replace(/\./gi, ',');
    /////   alert( 'field '+fieldw);
    var ret = new Array();
    ret = fieldw.split(',');
    var tam = ret.length;

    var sep = ',';

    if (tam <= 1)
    {
        var com = Math.pow(10, ndec);
        var str = com.toString();
        var com = str.substring(1, ndec + 1);
        //  alert( 'dec '+com);
        if (tam <= 0)
        {
            fieldw = '0';
        }
        if (ndec > 0)
        {
            fieldw = fieldw + sep + com;
        } else
        {
        }
    } else
    {
        var p1 = ret[0];
        var com = Math.pow(10, ndec);
        var str = com.toString();
        var com = str.substring(1, ndec + 1);
        var p2w = ret[1] + com;
        var p2 = p2w.substring(0, ndec);
//       if (ndec>0)
//       {
        fieldw = p1 + sep + p2;
//       }
//       else
//       {
//       }
    }

    for (var i = 0; i < fieldw.length; i++) {
        temp = "" + fieldw.substring(i, i + 1);

        if (temp == ",") {
            numponto++;
            if (ponto == 0)
                ponto = i;
        }

        if (valid.indexOf(temp) == "-1")
            ok = "no";

        msg += i + " - Temp: " + temp + " Ok: " + ok + " NumPonto: " + numponto + " Ponto: " + ponto + "\n";
    }

    if (ponto != 0)
        temp = fieldw.length - (ponto + 1) - 2;
    else
        temp = 0;

    msg += "\nPonto: " + ponto + " Temp: " + temp + "\n";

    //alert(msg);
    // alert ( ' temp '+ temp + ' numponto = '+ numponto);
    // if (ok == "no") return false;
    // if (numponto >= 2) return false;
    // if (temp == -2 && numponto == 1) return false;
    // if (temp >= 1) return false;
    // if (ponto == 0 && numponto == 1) return false;

    //Coloca os pontos
    msg = "";

    if (ponto > 0)
        vFinal = fieldw.substr(ponto);
    if (ponto == 0)
        ponto = fieldw.length;

    for (var i = ponto - 3; i > -3; i = i - 3) {
        temp = "" + fieldw.substring(i, i + 3);
        vFinal = "." + temp + vFinal;
        msg += i + " - Temp: " + temp + "  vFinal: " + vFinal + "\n";
    }
    //alert(msg);

    if (vFinal.substring(0, 1) == ".")
        vFinal = vFinal.substr(1);
    //field = vFinal;
    return vFinal;
}

function abre_aplicacao(vlID)
{

    var id = 'aplicacao_' + vlID;
    $('#' + id).toggle();
    return false;
}
