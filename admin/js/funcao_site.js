var tabAtual = 0;
var tabTotal = 0;
var marcador_full = false;
var postMessageAcao = false;
var pos_mouse_x = 0;
var pos_mouse_y = 0;
var quebra_alert = "\n";

$(document).ready(function () {
    if (popup != '_abrir_sistema') {
        if ($.isFunction(top.muda_frame))
            top.muda_frame(true);
    }

    if ($.isFunction(self.onLoadPag)) {
        self.onLoadPag();
    }

    var frm = document.getElementById('frm');

    /*
    $('div#qm0 > a').css('text-align', 'center');
    $('div#qm0 > a').width(116);

    $('div#qm0 > a').filter('a:last').width(100);
    //$('div#qm0 > a').filter('a:first').width(80);

    $('div#qm0 > a + div').each(function () {
        if ($(this).width() <= 116) {
            $(this).width(117);
        }
    });
    */

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

    if ($('div#dtBanco').html() != null) {
        hoje = newDataStr($('div#dtBanco').html());
    }

    if (prefixo == 'listar' && menu == 'usuario')
    {
//        html = '<a class="Titulo" onclick="return Sincronizar_usuarios_oas_pco();" href="#"><div><img border="0" title="Sincronizar Sistemas da Solução sebrae.GRC" src="imagens/calendar.gif">Sincronizar Sistemas da Solução</div></a>';
//        $('#barra_full td').append(html);
    }
    if (prefixo == 'listar' && menu == 'gec_area_conhecimento')
    {
        html = '<a class="Titulo" onclick="return Sincronizar_Area_sgc();" href="#"><div><img border="0" title="Sincronizar com SGC" src="imagens/calendar.gif">Sincronizar SGC</div></a>';
        $('#barra_full td').append(html);
    }
    if (prefixo == 'listar' && menu == 'gec_metodologia')
    {
        html = '<a class="Titulo" onclick="return Sincronizar_Metodologia_sgc();" href="#"><div><img border="0" title="Sincronizar com SGC" src="imagens/calendar.gif">Sincronizar SGC</div></a>';
        $('#barra_full td').append(html);
    }

    TelaHeight();
    if (print_tela == 'S') {
        setTimeout('self.print()', 1000);
    }

    if (menu == 'dado_estatistico_cor' && prefixo == 'cadastro') {

        mostra_cor('cor');

        $('#cor').ColorPicker({
            color: '#0000ff',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onBeforeShow: function () {
                mostra_cor('cor');
                //   var cor = this.value.split('#');
                //   $(this).ColorPickerSetColor({r:cor[0], g:cor[1], b:cor[2]});
            },
            onChange: function (hsb, hex, rgb) {
                // $('#cor').val(rgb.r + '#' + rgb.g + '#' + rgb.b);
                $('#cor').val('#' + hex);
                mostra_cor('cor');
            }
        });
    }

    if (popup_open == '') {
        setTimeout("noticia_sistema(\"'T', 'G'\")", 500);
    }

    if (prefixo == 'cadastro' && menu == 'usuario_assinatura')
    {
        desativar_cpos_do_form();
    }

    $().mousemove(function (e) {
        window.mouseXPos = e.pageX;
        window.mouseYPos = e.pageY;
    });
});

function TelaHeight() {
    if ($('div#div_geral').length > 0) {
        $('div#conteudo' + popup).height('');

        var menos = 0;

        if ($('div#div_topo').css('display') != 'none') {
            menos += $('div#div_topo').height();
        }

        menos += $('div#div_rodape').height();

        if ($('div#div_geral').height() < $(window).height() - menos) {
            var height = $(window).height() - $('div#div_geral').height();
            height += $('div#conteudo' + popup).height();
            height -= menos;
            $('div#conteudo' + popup).height(height);
        }
    }

    if ($.isFunction(self.ajusta_altura_PopWin)) {
        ajusta_altura_PopWin('');
    }

    if (postMessageAcao) {
        parent.postMessage($('#geral_cadastro').outerHeight(true), postMessageUrl);
    }
}

function abre_ajuda(pMenu, pAcao) {
    if (pMenu == undefined)
        pMenu = menu;
    if (pAcao == undefined)
        pAcao = acao;

    var url = 'conteudo_ajuda.php?menu=' + pMenu + '&acao=' + pAcao;
    var L = (screen.width - 782) / 2;
    var T = (screen.height - 550) / 2;

    OpenWin(url, 'ajuda_sistema', 782, 550, T, L);
    return false;
}

function perfil() {
    var OK = false;
    var id_difu = document.frm.id_difu;

    if (valida == 'S') {
        for (l = 1; (l <= lin.length - 1) && !OK; l++) {
            for (c = 1; c <= col.length - 1; c++) {
                if (val[l][c][1] == 'S') {
                    OK = true;
                    break;
                }
            }
        }
    } else {
        OK = true;
    }

    if (OK) {
        id_difu.value = '';

        for (l = 1; l <= lin.length - 1; l++) {
            for (c = 1; c <= col.length - 1; c++) {
                if (val[l][c][1] == 'S') {
                    id_difu.value += val[l][c][0] + ',';
                }
            }
        }

        id_difu.value = id_difu.value.substr(0, id_difu.value.length - 1);

        return true;
    } else {
        alert("Favor informar os Direitos do Perfil!");
        return false;
    }
}

function site_perfil() {
    var OK = false;
    var id_difu = document.frm.id_difu;

    if (valida == 'S') {
        for (l = 1; (l <= lin.length - 1) && !OK; l++) {
            for (c = 1; c <= col.length - 1; c++) {
                if (val[l][c][1] == 'S') {
                    OK = true;
                    break;
                }
            }
        }
    } else {
        OK = true;
    }

    if (OK) {
        id_difu.value = '';

        for (l = 1; l <= lin.length - 1; l++) {
            for (c = 1; c <= col.length - 1; c++) {
                if (val[l][c][1] == 'S') {
                    id_difu.value += val[l][c][0] + ',';
                }
            }
        }

        id_difu.value = id_difu.value.substr(0, id_difu.value.length - 1);

        return true;
    } else {
        alert("Favor informar os Direitos do Perfil do Site!");
        return false;
    }
}

function site_perfil_assinatura() {
    var OK = false;
    var id_difu = document.frm.id_difu;

    if (valida == 'S') {
        for (l = 1; (l <= lin.length - 1) && !OK; l++) {
            for (c = 1; c <= col.length - 1; c++) {
                if (val[l][c][1] == 'S') {
                    OK = true;
                    break;
                }
            }
        }
    } else {
        OK = true;
    }

    if (OK) {
        id_difu.value = '';

        for (l = 1; l <= lin.length - 1; l++) {
            for (c = 1; c <= col.length - 1; c++) {
                if (val[l][c][1] == 'S') {
                    id_difu.value += val[l][c][0] + ',';
                }
            }
        }

        id_difu.value = id_difu.value.substr(0, id_difu.value.length - 1);

        return true;
    } else {
        alert("Favor informar os Direitos do Perfil do Site Assinatura!");
        return false;
    }
}

function funcDesativaCampo(des, naomuda) {
    var campo = $('#' + des);
    var obr = $('#' + des + '_desc');

    campo.attr("disabled", "true");
    campo.addClass("campo_disabled");
    obr.addClass("Tit_Campo");
    obr.removeClass("Tit_Campo_Obr");

    if (naomuda == undefined) {
        campo.val("");
        campo.change();
    }
}

function funcAtivaCampo(des) {
    var campo = $('#' + des);
    var obr = $('#' + des + '_desc');

    campo.removeAttr("disabled");
    campo.removeClass("campo_disabled");
    obr.addClass("Tit_Campo_Obr");
    obr.removeClass("Tit_Campo");
}

function config_con() {
    switch ($('#variavel').val()) {
        case 'idt_perfil_interno':
        case 'idt_perfil_estagiario':
            $('#extra').val($("#valor option:nth-child(" + ($('#valor')[0].selectedIndex + 1) + ")").text());
            break;
    }

    return true;
}

function Imprimir(str) {
    // alert(str);
    OpenWin('conteudo_print.php?' + str, 'oas_imprimir', 800, $(window).height(), 50, ($(window).width() - 800) / 2);
}

function ampliar(str) {
    // alert(str);
    OpenWin('conteudo_print.php?' + str, 'oas_ampliar', 800, $(window).height(), 50, ($(window).width() - 800) / 2);
}

function desativa_msg_login() {
    document.getElementById('msg_login').style.display = 'none';
}

function ativa_msg_login(msg, op) {
    objd = document.getElementById('msg_login_det');
    objd.innerHTML = msg;
    obj = document.getElementById('msg_login');
    if (op == 1)
    {
        obj.style.height = '150px';
        objd.style.textAlign = 'left';
        objd.style.paddingLeft = '10px';
        obj.style.display = 'block';
        setTimeout("desativa_msg_login()", 20000);
    } else
    {
        obj.style.height = '150px';
        obj.style.display = 'block';
        setTimeout("desativa_msg_login()", 10000);
    }
}

function desativa_msg_autenticando() {
    document.getElementById('msg_autenticando').style.display = 'none';
}

function ativa_msg_autenticando(msg, op) {
    objd = document.getElementById('msg_autenticando_det');
    objd.innerHTML = objd.innerHTML + msg;
    obj = document.getElementById('msg_autenticando');

    if (op == 2)
    {
        objc = document.getElementById('msg_autenticando_cab');
        objc.style.width = '396px';
        obj.style.width = '400px';
        obj.style.height = '250px';
        objd.style.color = '#333333';
        objd.style.textAlign = 'left';
        objd.style.paddingLeft = '10px';
        obj.style.display = 'block';

    } else
    {
        obj.style.display = 'block';
    }
}

function entra_sistema(p1, p2) {
    //alert(' guy  ');
    //self.location = 'conteudo.php?'+p2;
    setTimeout("entra_sistema_espera('" + p2 + "')", 10000);

}

function entra_sistema_espera(p2) {
    //alert(' guy  ');
    //    obj=document.getElementById('menu');
    //    obj.style.display='none';

    self.location = 'conteudo.php?' + p2;

}

function desiste_altera_faleconosco() {

    self.location = 'conteudo.php';

}

function desiste_duvida() {

    self.location = 'conteudo.php';

}

function desiste_confirma_cadastro() {
    self.location = 'conteudo.php';
}

function desativa_concan_acompanha_alteracao_curriculo() {
    document.getElementById('acompanha_concan_alteracao_curriculo').style.display = 'none';
}

var obj_ant = null;
var obj_anttd = null;
var obj_anttdimga = null;
var obj_anttdimgc = null;
var obj_anttdimge = null;
var cor_ant = null;
var numlinha_ant = '';
function marca_linha(thisw, numlinha, corimp, corpar, corcur)
{
    var tr = 'tr_l_' + numlinha;
    obj = document.getElementById(tr);
    if (thisw.checked)
    {
        obj.style.background = corcur;
        if (obj_ant != null)
        {
            obj_ant.style.background = cor_ant;
        }
        obj_ant = obj;
        resto = (numlinha + 1) % 2;
        // alert(numlinha+'resto '+resto);
        if (resto == 1)
        {
            cor_ant = corimp;
        } else
        {
            cor_ant = corpar;
        }

    }
}

function marca_linha_radio(thisw, numlinha, corimp, corpar, corcur, cormarca)
{
    var tr = 'tr_l_' + numlinha;
    var id_r = 'id_r_' + numlinha;
    var id_td = 'Titulo_ctl_' + numlinha;
    var id_td_imga = 'Titulo_ctl_img_a' + numlinha;
    var id_td_imgc = 'Titulo_ctl_img_c' + numlinha;
    var id_td_imge = 'Titulo_ctl_img_e' + numlinha;
    obj = document.getElementById(tr);
    objr = document.getElementById(id_r);
    objtd = document.getElementById(id_td);
    objtdimga = document.getElementById(id_td_imga);
    objtdimgc = document.getElementById(id_td_imgc);
    objtdimge = document.getElementById(id_td_imge);

    //visibility:visible;

    if (objr.checked == true)
    {
        objr.checked = false;
    } else
    {
        objr.checked = true;
    }
    if (objr.checked)
    {
        obj.style.background = corcur;
        objtd.style.background = corcur;
        objtdimga.style.visibility = 'visible';
        objtdimgc.style.visibility = 'visible';
        objtdimge.style.visibility = 'visible';
    }
    if (obj_ant != null)
    {
        if (numlinha_ant != numlinha)
        {
            obj_ant.style.background = cor_ant;
            obj_anttd.style.background = cormarca;
            obj_anttdimga.style.visibility = 'hidden';
            obj_anttdimgc.style.visibility = 'hidden';
            obj_anttdimge.style.visibility = 'hidden';
        } else
        {
            if (!objr.checked)
            {
                obj_ant.style.background = cor_ant;
                obj_anttd.style.background = cormarca;
                obj_anttdimga.style.visibility = 'hidden';
                obj_anttdimgc.style.visibility = 'hidden';
                obj_anttdimge.style.visibility = 'hidden';

            }


        }
    }

    obj_ant = obj;
    obj_antr = objr;
    obj_anttd = objtd;
    obj_anttdimga = objtdimga;
    obj_anttdimgc = objtdimgc;
    obj_anttdimge = objtdimge;
    numlinha_ant = numlinha;

    var resto = (numlinha + 1) % 2;
    // alert(numlinha+'resto '+resto);
    if (resto == 1)
    {
        cor_ant = corimp;
    } else
    {
        cor_ant = corpar;
    }
}

function marca_linha_over(thisw, numlinha, corimp, corpar, corcur, corover)
{

    thisw.style.background = corover;
    $(thisw).addClass('marca_linha_over');
    return 1;



}
function marca_linha_out(thisw, numlinha, corimp, corpar, corcur)
{
    var cor;
    var num = numlinha + 1;
    var resto = num % 2;
    if (resto == 1)
    {
        cor = corimp;
    } else
    {
        cor = corpar;
    }
    //  var tr   = 'tr_l_'+numlinha;
    var id_r = 'id_r_' + numlinha;

    //alert('22222');
    //       obj =document.getElementById(tr);
    objr = document.getElementById(id_r);
    if (objr.checked)
    {
        cor = corcur;
    }
    thisw.style.background = cor;
    $(thisw).removeClass('marca_linha_over');
    return 1;
}

function funcObra_gc(thisw)
{
    var indice = thisw.selectedIndex;
    var idt_empreendimento = thisw.options[indice].value;
    var nm_empreendimento = thisw.options[indice].text;
    // alert('teste gc '+indice+ '    '+idt_empreendimento) ;

    //    login: login.val(),
    //    senha: senha.val()
    if (indice == 0)
    {
        return false;
    }


    var str = '';

    // var par ="admin/ajax2.php?tipo=obra&idt_obra="+idt_empreendimento+"";


    $.post('ajax2.php?tipo=obra', {
        cas: conteudo_abrir_sistema,
        async: false,
        idt_obra: idt_empreendimento,
        nm_obra: nm_empreendimento
    }
    , function (str) {
        if (str == '') {
            //$('#login input').val('');
            //  alert(' dfdfd ');
            self.location = 'conteudo.php';
            ////            alert('Obra Posicionada em '+nm_empreendimento);
            //  window.open('admin/', 'admin');

            //window.open('oas_pco/index.php', 'admin');
        } else {
            //$('#login input').val('');
            //self.location = 'conteudo.php';
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });

}

function money_valido(field)
{
    obj = document.getElementById('valor_previsto');
    if (obj != null)
    {
        var valor_previsto = '';
        var valor_projetado = '';

        var valor_previsto_n = 0;
        var valor_projetado_n = 0;


        var diferenca = 0;
        var desvio = 0;

        var diferenca_s = '';
        var desvio_s = '';
        valor_previsto = new String(obj.value);
        valor_previsto = valor_previsto.replace(/\./gi, '');
        valor_previsto = valor_previsto.replace(/\,/gi, '.');
        valor_previsto_n = valor_previsto;

        obj = document.getElementById('valor_projetado');
        if (obj != null)
        {

            valor_projetado = new String(obj.value);
            valor_projetado = valor_projetado.replace(/\./gi, '');
            valor_projetado = valor_projetado.replace(/\,/gi, '.');
            valor_projetado_n = valor_projetado;
        }
        obj = document.getElementById('diferenca');
        if (obj != null)
        {

            diferenca = valor_projetado_n - valor_previsto_n;
            if (isNaN(valor_previsto_n))
            {
                alert(',,,,,,,' + diferenca);
            }
            diferenca_s = diferenca + '';
            diferenca_s = diferenca_s.replace(/\./gi, ',');
            obj.value = diferenca_s;
        }
        obj = document.getElementById('desvio');
        if (obj != null)
        {
            desvio = (diferenca / valor_previsto_n) * 100;
            desvio_s = desvio + '';
            desvio_s = truncate(desvio, '.');
            desvio_s = desvio_s.replace(/\./gi, ',');
            obj.value = desvio_s;
            obj = document.getElementById('desvio_fix');
            if (obj != null)
            {
                obj.value = desvio_s;
            }
        }

    }
}

function truncate(num, sinal) {
    string = "" + num;

    if (string.indexOf(sinal) == -1)
        return string + sinal + '00';

    seperation = string.length - string.indexOf(sinal);
    if (seperation > 3)
        return string.substring(0, string.length - seperation + 3);
    else if (seperation == 2)
        return string + '0';



    return string;
}

var linkw = '';
function desativa_msg_geral() {
    document.getElementById('msg_geral').style.display = 'none';
    if (linkw != '')
    {
        ativa_msg_link(linkw);
    }
}

var linkwf = '';
function desativa_msg_geral_f() {
    document.getElementById('msg_geral_f').style.display = 'none';
    if (linkwf != '')
    {
        ativa_msg_link(linkwf);
    }
}

function ativa_msg_geral(msg, op, link) {
    linkw = link;
    objd = document.getElementById('msg_geral_det');
    objd.innerHTML = msg;
    obj = document.getElementById('msg_geral');
    if (op == 1)
    {
        obj.style.height = '150px';
        objd.style.textAlign = 'left';
        objd.style.paddingLeft = '10px';
        obj.style.display = 'block';
        // setTimeout("desativa_msg_geral()",10000);
    } else
    {
        obj.style.height = '150px';
        obj.style.display = 'block';
        // setTimeout("desativa_msg_geral()",10000);
    }
}

function ativa_msg_link(link) {
    self.location = linkw;
}

function IsNumeric_c(sText)
{
    var ValidChars = "0123456789.";
    var IsNumber = true;
    var Char;

    for (i = 0; i < sText.length && IsNumber == true; i++)
    {
        Char = sText.charAt(i);
        if ((i == 0) && (Char == "-")) // check first character for minus sign
            continue;
        if (ValidChars.indexOf(Char) == -1)
        {
            IsNumber = false;
        }


    }

    return IsNumber;
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

function mostra_cor(id)
{
    obj = document.getElementById(id);
    if (obj != null) {
        obj.style.background = obj.value;
        obj.style.color = obj.value;
    }

    return false;
}

var pTabela = '';
var pCampo = '';
var pDescricao = '';
function  help_campo(e, campo, tabela, descricao)
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
            // self.location = 'conteudo.php?prefixo=listar&menu=pessoal_efetivo&class=0&idt0='+idt0+'&idt1='+idt1;
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

function desativa_help_campo() {
    document.getElementById('help_campo').style.display = 'none';
}

function coordenadasdomouse(e) {
    var posx = 0;
    var posy = 0;
    if (!e)
        var e = window.event;
    if (e.pageX || e.pageY) {
        posx = e.pageX;
        posy = e.pageY;
    } else if (e.clientX || e.clientY) {
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

function abre_ajuda_campo() {
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

function Sincronizar_Area_sgc()
{
    //alert('chama outro');

    var str = '';
    $.post('ajax2.php?tipo=Sincronizar_Area_sgc', {
        cas: conteudo_abrir_sistema,
        async: false
    }
    , function (str) {
        if (str == '') {
            self.location = 'conteudo.php?prefixo=listar&texto0=&menu=gec_area_conhecimento';
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
    return false;

}

function Sincronizar_Metodologia_sgc()
{
    //alert('chama outro');

    var str = '';
    $.post('ajax2.php?tipo=Sincronizar_Metodologia_sgc', {
        cas: conteudo_abrir_sistema,
        async: false
    }
    , function (str) {
        if (str == '') {
            self.location = 'conteudo.php?prefixo=listar&texto0=&menu=gec_metodologia';
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
    return false;

}

//////////////////
function processando_grc(titulo, cor) {
    var titulow = "Favor aguardar. Ação sendo processada!";
    if (titulo != '')
    {
        titulow = titulo;
    }
    var corw = "#C00000";
    if (cor != "")
    {
        corw = cor;
    }


    objd = document.getElementById('dialog_processando_grc');
    if (objd != null)
    {
        $(objd).remove();
    }



    var html = '';
    html += '<div id="dialog_processando_grc" style="z-index:2000;" >';
    html += '<h1>' + titulow + '</h1>';
    html += '<img src="imagens/pbar-ani.gif" width="280" height="22"/>';
    html += '</div>';

    var obj = $(html);

    var width = 500;
    var height = 110;

    obj.css('position', 'absolute');
    obj.css('text-align', 'center');
    obj.css('width', width + 'px');
    obj.css('height', height + 'px');
    obj.css('background-color', corw);
    obj.css('color', '#FFFFFF');

    var theBody = document.getElementsByTagName("BODY")[0];
    var scTop = parseInt(getScrollTop(), 10);
    var scLeft = parseInt(theBody.scrollLeft, 10);
    var fullHeight = getViewportHeight() - 200;
    var fullWidth = getViewportWidth();

    obj.css('top', (scTop + ((fullHeight - height) / 2)) + "px");
    obj.css('left', (scLeft + ((fullWidth - width) / 2)) + "px");




    $('body').append(obj);

}

function processando_acabou_grc() {
    //alert('teste .....'); 
    $("#dialog_processando_grc").remove();
    $("#dialog_processando_grc").css('display', 'none');
}

function wizardValidaCadastro(idDivGeral) {
    var ok = true;

    var lastExpressaoID = $('div#' + idDivGeral + ' > ul > li > .wizard_expressao:last > select').attr('id');

    $('div#' + idDivGeral + ' > ul > li').each(function () {
        var parentese_ant = $(this).find('.wizard_parentese_ant > select');
        var tabela = $(this).find('.wizard_tabela > select');
        var campo = $(this).find('.wizard_campo > select');
        var operador = $(this).find('.wizard_operador > select');
        var valor = $(this).find('.wizard_valor');
        var parentese_dep = $(this).find('.wizard_parentese_dep > select');
        var expressao = $(this).find('.wizard_expressao > select');

        if (parentese_ant.val() != '' || tabela.val() != '' || campo.val() != '' || operador.val() != '' || valor.val() != '' || parentese_dep.val() != '' || expressao.val() != '') {
            if (ok && tabela.val() == '') {
                ok = false;
                alert('Favor informar a Tabela!');
                tabela.focus();
            }

            if (ok && campo.val() == '') {
                ok = false;
                alert('Favor informar o Campo!');
                campo.focus();
            }

            if (ok && operador.val() == '') {
                ok = false;
                alert('Favor informar o Operador!');
                operador.focus();
            }

            if (ok && valor.val() == '') {
                ok = false;
                alert('Favor informar o Valor!');
                valor.focus();
            }

            if (lastExpressaoID == expressao.attr('id')) {
                if (ok && expressao.val() != '') {
                    ok = false;
                    alert('A última Expressão não pode ser informada!');
                    expressao.focus();
                }
            } else {
                if (ok && expressao.val() == '') {
                    ok = false;
                    alert('Favor informar a Expressão!');
                    expressao.focus();
                }
            }
        }
    });

    return ok;
}

function wizardTravaExpressaoLast(idDivGeral) {
    $('div#' + idDivGeral + ' > ul > li > .wizard_expressao > select').removeProp("disabled").removeClass("campo_disabled");
    $('div#' + idDivGeral + ' > ul > li > .wizard_expressao:last > select').val('').prop("disabled", true).addClass("campo_disabled");
}

function wizardMontaSQL(idDivGeral) {
    var sql = '';
    var vetChar = ['char', 'varchar', 'text', 'longtext'];
    var vetData = ['data', 'datatime'];

    $('div#' + idDivGeral + ' > ul > li').each(function () {
        var parentese_ant = $(this).find('.wizard_parentese_ant > select');
        var campo = $(this).find('.wizard_campo > select > option:selected');
        var operador = $(this).find('.wizard_operador > select');
        var valor = $(this).find('.wizard_valor');
        var parentese_dep = $(this).find('.wizard_parentese_dep > select');
        var expressao = $(this).find('.wizard_expressao > select');

        var vl = valor.val();

        if (parentese_ant.val() != '') {
            sql += parentese_ant.val() + ' ';
        }

        if (campo.val() != '') {
            sql += campo.val() + ' ';
        }

        if (operador.val() != '') {
            sql += operador.val() + ' ';
        }

        if (vl != '') {
            if (operador.val() == 'like') {
                sql += "'%" + vl + "%' ";
            } else if ($.inArray(campo.data('tipo'), vetChar) != -1) {
                sql += "'" + vl + "' ";
            } else if ($.inArray(campo.data('tipo'), vetData) != -1) {
                sql += "'" + vl + "' ";
            } else {
                sql += vl + ' ';
            }
        }

        if (parentese_dep.val() != '') {
            sql += parentese_dep.val() + ' ';
        }

        if (expressao.val() != '') {
            sql += expressao.val() + ' ';
        }
    });

    return sql;
}

function ChamaAtendimentoResumo(idt_atendimento, idt_atendimento_resumo) 
{
	//alert('idt resumo'+idt_atendimento_resumo); 
	//
	// Chamar popup do cadastro
	var  href = 'conteudo_cadastro.php?acao=con&prefixo=cadastro&menu=grc_atendimento_resumo&id='+idt_atendimento_resumo+'&idt0='+idt_atendimento;
	var  left   = 100; 
	var  top    = 20; 
	var  height = $(window).height() - 20 ; 
	var  width  = $(window).width()  - 100;  
	var  titulo = "Detalhamento do Resumo do Atendimento";
	                   
	
	if(typeof timerIdresumo!='undefined') 
	{
	    clearInterval(timerIdresumo);
	}	
	showPopWin(href, titulo , width, height, close_ChamaAtendimentoResumo);
	return false;
}

function close_ChamaAtendimentoResumo(returnVal) { 
	
	if(typeof timerIdresumo!='undefined') 
	{
	    timerIdresumo = setInterval('RefreshResumo()', delayresumo);
	}
}
	