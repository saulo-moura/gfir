var valida = '';
var valida_cust = '';
var valida_nao_visivel = 'S';

function imprimir(rel) {
    var taction = document.frm.action;
    document.frm.action = 'conteudo_print.php?print=s&prefixo=relatorio/&menu=' + rel;
    document.frm.target = "_blank";
    document.frm.submit();
    document.frm.target = "_self";
    document.frm.action = taction;
    return false;
}

function imprimir_sebraetec_pdf(rel, nome_relatorio) {
    var taction = document.frm.action;
    document.frm.action = 'conteudo_sebraetec_pdf.php?print=s&prefixo=relatorio/&menu=' + rel + '&titulo_rel=' + nome_relatorio;
    document.frm.target = "_blank";
    document.frm.submit();
    document.frm.target = "_self";
    document.frm.action = taction;
    return false;
}

function relatorio_exportar_xls(prefixo, arquivo, bt_print_tit_rel) {
    var taction = document.frm.action;
    document.frm.action = 'conteudo_relatorio_xls.php?print=s&prefixo=' + prefixo + '/&menu=' + arquivo + '&titulo_rel=' + bt_print_tit_rel;
    document.frm.target = "_blank";
    document.frm.submit();
    document.frm.target = "_self";
    document.frm.action = taction;
    return false;
}

function listar_rel_exportar($bt_print_tit_rel) {
    var taction = document.frm.action;
    var action = document.frm.action.replace(new RegExp('listar', "g"), 'listar_rel');
    action = action.replace(new RegExp('conteudo.php', "g"), 'conteudo_exportar.php');
    action = action.replace(new RegExp('conteudo_cadastro.php', "g"), 'conteudo_exportar.php');
    action = action.replace(new RegExp('conteudo_abrir_sistema.php', "g"), 'conteudo_abrir_sistema_exportar.php');
    document.frm.action = action + '&titulo_rel=' + $bt_print_tit_rel;
    document.frm.target = "_blank";
    document.frm.submit();
    document.frm.target = "_self";
    document.frm.action = taction;
    return false;
}

function listar_rel_print() {
    var taction = document.frm.action;
    var action = taction.replace(new RegExp('&print_tela=S', "g"), '');
    action = action.replace(new RegExp('conteudo.php', "g"), 'conteudo_print.php');
    action = action.replace(new RegExp('conteudo_cadastro.php', "g"), 'conteudo_pdf.php');
    action = action.replace(new RegExp('conteudo_abrir_sistema.php', "g"), 'conteudo_abrir_sistema_print.php');
    document.frm.action = action + '&print_tela=S';
    document.frm.target = "_blank";
    document.frm.submit();
    document.frm.target = "_self";
    document.frm.action = taction;
    return false;
}

function listar_rel_pdf(bt_exportar_tit) {
    var taction = document.frm.action;
    var action = taction.replace(new RegExp('&print_tela=S', "g"), '');
    action = action.replace(new RegExp('conteudo.php', "g"), 'conteudo_pdf.php');
    action = action.replace(new RegExp('conteudo_cadastro.php', "g"), 'conteudo_pdf.php');
    action = action.replace(new RegExp('conteudo_abrir_sistema.php', "g"), 'conteudo_abrir_sistema_pdf.php');

    if (bt_exportar_tit != undefined) {
        action = action.replace(new RegExp('&titulo_rel=', "g"), '&titulo_rel_sis=');
        action += '&titulo_rel=' + bt_exportar_tit;
    }

    document.frm.action = action + '&print_tela=S';
    document.frm.target = "_blank";
    document.frm.submit();
    document.frm.target = "_self";
    document.frm.action = taction;
    return false;
}

function listar_rel_pdf_url(url, bt_exportar_tit) {
    $('#listar_rel_pdf_url').remove();

    var frm = $('<form />');

    var action = url.replace(new RegExp('&print_tela=S', "g"), '');
    action = action.replace(new RegExp('conteudo.php', "g"), 'conteudo_pdf.php');
    action = action.replace(new RegExp('conteudo_cadastro.php', "g"), 'conteudo_pdf.php');
    action = action.replace(new RegExp('conteudo_abrir_sistema.php', "g"), 'conteudo_abrir_sistema_pdf.php');

    if (bt_exportar_tit != undefined) {
        action = action.replace(new RegExp('&titulo_rel=', "g"), '&titulo_rel_sis=');
        action += '&titulo_rel=' + bt_exportar_tit;
    }

    frm.attr('id', 'listar_rel_pdf_url');
    frm.attr('target', '_blank');
    frm.attr('method', 'post');
    frm.attr('action', action + '&print_tela=S');

    $('body').append(frm);

    $('#listar_rel_pdf_url').submit();
    return false;
}

function listar_rel_xls() {
    var taction = document.frm.action;
    var action = taction.replace(new RegExp('conteudo.php', "g"), 'conteudo_xls.php');
    action = action.replace(new RegExp('conteudo_cadastro.php', "g"), 'conteudo_cadastro_xls.php');
    action = action.replace(new RegExp('conteudo_abrir_sistema.php', "g"), 'conteudo_abrir_sistema_xls.php');
    document.frm.action = action;
    document.frm.target = "_blank";
    document.frm.submit();
    document.frm.target = "_self";
    document.frm.action = taction;
    return false;
}

function listar_rel_voltar() {
    self.close();
    return false;
}

// When the page loads:
function ativaObj() {
    if (document.getElementsByTagName) {
        // Get all the tags of type object in the page.
        var objs = document.getElementsByTagName("object");
        for (i = 0; i < objs.length; i++) {
            // Get the HTML content of each object tag
            // and replace it with itself.
            x = objs[i].outerHTML;
            objs[i].outerHTML = x;
        }
    }
}

window.onload = ativaObj;

function desativaObj() {
// When the page unloads:
    if (document.getElementsByTagName) {
        //Get all the tags of type object in the page.
        var objs = document.getElementsByTagName("object");
        for (i = 0; i < objs.length; i++) {
            // Clear out the HTML content of each object tag
            // to prevent an IE memory leak issue.
            objs[i].outerHTML = "";
        }
    }
}

window.onunload = desativaObj;

function OpenWin(URL, Nome, W, H, T, L, resizable)
{
    if (T == undefined)
        T = '200';

    if (L == undefined)
        L = '130';

    if (resizable == undefined)
        resizable = 'no';

    window.open(URL, Nome, 'alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,location=no,menubar=no,personalbar=no,resizable=' + resizable + ',scrollbars=yes,status=no,titlebar=no,toolbar=no,width=' + W + ',height=' + H + ',z-lock=yes,left=' + L + ',top=' + T);
}

function getPosicaoElemento(elemID) {
    var offsetTrail = document.getElementById(elemID);
    var offsetLeft = 0;
    var offsetTop = 0;

    while (offsetTrail) {
        offsetLeft += offsetTrail.offsetLeft;
        offsetTop += offsetTrail.offsetTop;
        offsetTrail = offsetTrail.offsetParent;
    }

    if (navigator.userAgent.indexOf("Mac") != -1 &&
            typeof document.body.leftMargin != "undefined") {
        offsetLeft += document.body.leftMargin;
        offsetTop += document.body.topMargin;
    }
    return {left: offsetLeft, top: offsetTop};
}

function getPosicaoElementoParent(elemID) {
    var offsetTrail = parent.document.getElementById(elemID);
    var offsetLeft = 0;
    var offsetTop = 0;

    while (offsetTrail) {
        offsetLeft += offsetTrail.offsetLeft;
        offsetTop += offsetTrail.offsetTop;
        offsetTrail = offsetTrail.offsetParent;
    }

    if (navigator.userAgent.indexOf("Mac") != -1 && typeof parent.document.body.leftMargin != "undefined") {
        offsetLeft += parent.document.body.leftMargin;
        offsetTop += parent.document.body.topMargin;
    }
    return {left: offsetLeft, top: offsetTop};
}

function newData(c) {
    return new Date(c.value.substr(6, 4), c.value.substr(3, 2) - 1, c.value.substr(0, 2));
}

function newDataStr(c) {
    var vet = c.split('/');
    return new Date(vet[2], vet[1] - 1, vet[0]);
}

function newDataHoraStr(usa_hora, c) {
    var vet = c.split(' ');

    if (usa_hora) {
        var d = vet[0].split('/');

        if (vet[1] == undefined || vet[1] == '') {
            var h = [0, 0, 0];
        } else {
            var h = vet[1].split(':');

            if (h[2] == undefined) {
                h[2] = 0;
            }
        }

        return new Date(d[2], d[1] - 1, d[0], h[0], h[1], h[2]);
    } else {
        return newDataStr(vet[0]);
    }
}

function checkdate(objName)
{
    var datefield = objName;
    if (datefield.value == "")
        return true;

    if (chkdate(objName) == false)
    {	//datefield.select();
        alert("Data inv·lida");
        datefield.value = "";
        datefield.focus();
        return false;
    } else
    {	//alert("Data V·lida");
        return true;
    }
}

function chkdate(objName)
{
    var strDate;
    var strDay;
    var strMonth;
    var strYear;
    var intday;
    var intMonth;
    var intYear;
    var datefield = objName;
    strDate = datefield.value;
    //concatenar os campos e verificar quantidades
    // considerando um campo sÛ com quantidade certa.
    strDay = strDate.substr(0, 2);
    strMonth = strDate.substr(3, 2);
    strYear = strDate.substr(6, 4);
    strBarra1 = strDate.substr(2, 1);
    strBarra2 = strDate.substr(5, 1);

    // Mostra os valores das variaveis
    //alert("strDay: " + strDay + "\nstrBarra1: " + strBarra1 + "\nstrMonth: " + strMonth + "\nstrBarra2: " + strBarra2 + "\nstrYear: " + strYear);

    intday = parseInt(strDay, 10);
    intday1 = parseInt(strDate.substr(0, 1), 10);
    intday2 = parseInt(strDate.substr(1, 1), 10);
    if ((isNaN(intday1)) || (isNaN(intday2)))
    {	//alert("Erro no dia");
        return false;
    }
    intMonth = parseInt(strMonth, 10);
    intMonth1 = parseInt(strDate.substr(3, 1), 10);
    intMonth2 = parseInt(strDate.substr(4, 1), 10);
    if ((isNaN(intMonth1)) || (isNaN(intMonth2)))
    {	//alert("Erro no mÍs");
        return false;
    }

    intYear = parseInt(strYear, 10);
    intYear1 = parseInt(strDate.substr(6, 1), 10);
    intYear2 = parseInt(strDate.substr(7, 1), 10);
    intYear3 = parseInt(strDate.substr(8, 1), 10);
    intYear4 = parseInt(strDate.substr(9, 1), 10);
    if ((isNaN(intYear1)) || (isNaN(intYear2)) || (isNaN(intYear3)) || (isNaN(intYear4)) || (intYear <= 1900))
    {	//alert("Erro no ano");
        return false;
    }

    if ((strBarra1 != "/") || (strBarra2 != "/"))
    {	//alert("Erro na Barra / ");
        return false;
    }

    if (intMonth > 12 || intMonth < 1)
    {
        return false;
    }
    if ((intMonth == 1 || intMonth == 3 || intMonth == 5 || intMonth == 7 || intMonth == 8 || intMonth == 10 || intMonth == 12) && (intday > 31 || intday < 1))
    {
        return false;
    }
    if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && (intday > 30 || intday < 1))
    {
        return false;
    }
    if (intMonth == 2)
    {
        if (intday < 1)
        {
            return false;
        }
        if (LeapYear(intYear) == true)
        {
            if (intday > 29)
            {
                return false;
            }
        } else
        {
            if (intday > 28)
            {
                return false;
            }
        }
    }
    return true;
}

function LeapYear(intYear)
{
    if (intYear % 100 == 0)
    {
        if (intYear % 400 == 0)
        {
            return true;
        }
    } else
    {
        if ((intYear % 4) == 0)
        {
            return true;
        }
    }
    return false;
}

function Valida_Data_Hoje(obj, $menor, menor_txt) {
    if (checkdate(obj)) {
        if (obj.value != '') {
            if (newData(obj) - hoje > 0) {
                alert('A data tem que menor ou igual a hoje!');
                obj.value = '';
                obj.focus();
                return false;
            }

            if ($menor != undefined) {
                if ($menor.val() == '') {
                    alert('Favor informar a data de ' + menor_txt + '!');
                    obj.value = '';
                    $menor.focus();
                    return false;
                }

                if (newData(obj) - newDataStr($menor.val()) < 0) {
                    alert('A data tem que maior ou igual a ' + menor_txt + '!');
                    obj.value = '';
                    obj.focus();
                    return false;
                }
            }
        }

        return true;
    }

    return false;
}

function Formata_Data(objeto, teclapres) {
    var tecla = teclapres.keyCode;
    vr = objeto.value;
    s = "";
    for (x = 0; x < vr.length; x++)
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57)
            s = s + vr.charAt(x);
    vr = s;
    tam = vr.length + 1;
    if (tecla != 9 && tecla != 8 && tecla != 46 && tecla != 37 && tecla != 39 && tecla != 35 && tecla != 36) {
        if (tam < 2)
            objeto.value = vr.substr(0, 2);
        if (tam > 2 && tam < 4)
            objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2);
        if (tam > 4)
            objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 4);
    }
    if (tam > 5 && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 4);
    if ((tam > 2 && tam < 6) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2);
    if (tam < 4 && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2);
}

function Valida_Email(objeto) {
    if ((objeto.value.indexOf("@") == -1 || objeto.value.indexOf(".") == -1) && objeto.value != "")
    {
        objeto.select();
        alert("e-Mail inv·lido");
        objeto.value = "";
        objeto.focus();
        return false;
    }
    return true;
}

function Valida_Telefone(objeto) {
    var str = objeto.value;
    var tel = "";
    var ddd = ['11', '12', '13', '14', '15', '16', '17', '18', '19', '21', '22', '24', '27', '28', '31', '32', '33', '34', '35', '37', '38', '41', '42', '43', '44', '45', '46', '47', '48', '49', '51', '53', '54', '55', '61', '62', '63', '64', '65', '66', '67', '68', '69', '71', '73', '74', '75', '77', '79', '81', '82', '83', '84', '85', '86', '87', '88', '89', '91', '92', '93', '94', '95', '96', '97', '98', '99'];

    if (str == "") {
        return true;
    }

    if ((str.length < 13 || str.length > 14 || str.substring(0, 1) != "(" || str.substring(3, 4) != ")") && (str.indexOf("-") != 7 || str.indexOf("-") != 8 || str.indexOf("-") != 9)) {
        objeto.select();
        alert("Telefone inv·lido. Formato: (12)34567-8901");
        objeto.value = "";
        objeto.focus();
        return false;
    }

    for (var i = 0; i < str.length; i++) {
        if (str.substring(i, i + 1) >= "0" && str.substring(i, i + 1) <= "9") {
            tel += str.substring(i, i + 1);
        }
    }

    if (isNaN(tel)) {
        objeto.select();
        alert("Telefone inv·lido. Formato: (12)34567-8901");
        objeto.value = "";
        objeto.focus();
        return false;
    }

    if ($.inArray(tel.substr(0, 2), ddd) < 0) {
        objeto.select();
        alert("O DDD do telefone È inv·lido.");
        objeto.value = "";
        objeto.focus();
        return false;
    }

    return true;
}

function Formata_Telefone(objeto, teclapres) {
    var tecla = teclapres.keyCode;
    var vr = objeto.value;
    var s = "";

    for (x = 0; x < vr.length; x++) {
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57) {
            s = s + vr.charAt(x);
        }
    }

    vr = s;

    switch (vr.length) {
        case 0:
            objeto.value = vr;
            break;

        case 1:
        case 2:
            objeto.value = '(' + vr.substr(0, 2);
            break;

        case 3:
        case 4:
        case 5:
        case 6:
            objeto.value = '(' + vr.substr(0, 2) + ')' + vr.substr(2, 4);
            break;

        case 7:
        case 8:
        case 9:
        case 10:
            objeto.value = '(' + vr.substr(0, 2) + ')' + vr.substr(2, 4) + '-' + vr.substr(6, 4);
            break;

        default:
            objeto.value = '(' + vr.substr(0, 2) + ')' + vr.substr(2, 5) + '-' + vr.substr(7, 4);
            break;
    }
}

function Valida_Url(objeto) {
    if (objeto.value.substr(0, 7).toLowerCase() == "http://")
        objeto.value = objeto.value.substr(7).toLowerCase();
    return true;
}

function enumero(field)
{
    var valid = "0123456789";
    var ok = "yes";
    var temp;

    var msg = "";

    for (var i = 0; i < field.value.length; i++)
    {
        temp = "" + field.value.substring(i, i + 1);
        if (valid.indexOf(temp) == "-1")
            ok = "no";

        msg += i + " - Temp: " + temp + " Ok: " + ok + "\n";
    }
    //alert(msg);
    if (ok == "no")
    {
        alert("Neste campo sÛ pode ter n˙mero inteiro!");
        field.value = "";
        field.focus();
        return false;
    } else
        return true;
}

function enumero_zero(field, tam)
{
    var valid = "0123456789";
    var ok = "yes";
    var temp;

    var msg = "";

    for (var i = 0; i < field.value.length; i++)
    {
        temp = "" + field.value.substring(i, i + 1);
        if (valid.indexOf(temp) == "-1")
            ok = "no";

        msg += i + " - Temp: " + temp + " Ok: " + ok + "\n";
    }
    //alert(msg);
    if (ok == "no")
    {
        alert("Neste campo sÛ pode ter n˙mero inteiro!");
        field.value = "";
        field.focus();
        return false;
    } else {
        if (field.value != '') {
            tam = tam - field.value.length;
            if (tam > 0)
                field.value = repeat(0, tam) + field.value;
        }

        return true;
    }
}

function tira_zero(field) {
    if (field.value.length > 0)
        field.value = parseInt(field.value, 10);
}

function repeat(repeatString, repeatNum) {
    var newString = "";

    for (var x = 1; x <= parseInt(repeatNum, 10); x++) {
        newString = newString + repeatString;
    }

    return (newString);
}

//*******************************************************************
// Valida Campo de CNPJ
//Passa o objeto Text
function Valida_CNPJ(objName)
{
    var datefield = objName;
    if (datefield.value == "")
        return true;

    if (CalculaCNPJ(objName.value) == false)
    {
        datefield.select();
        // alert("CNPJ inv·lido!!!");
        alert("CNPJ inv·lido. Por favor, confira o n˙mero informado e tente novamente.");
        datefield.value = "";
        datefield.focus();
        return false;
    } else
    {
        return true;
    }
}

function CalculaCNPJ(RecebeCNPJ)
{
    var soma;
    var resultado1;
    var resultado2;

    if (RecebeCNPJ.length == 0) {
        return false;
    }

    s = "";

    for (x = 0; x < RecebeCNPJ.length; x++)
        if (RecebeCNPJ.charCodeAt(x) >= 48 && RecebeCNPJ.charCodeAt(x) <= 57)
            s = s + RecebeCNPJ.charAt(x);

    RecebeCNPJ = s;

    if (RecebeCNPJ.length != 14 || RecebeCNPJ == "00000000000000")
    {
        return false;
    } else
    {
        soma = RecebeCNPJ.charAt(0) * 5 + RecebeCNPJ.charAt(1) * 4 + RecebeCNPJ.charAt(2) * 3 + RecebeCNPJ.charAt(3) * 2 + RecebeCNPJ.charAt(4) * 9 + RecebeCNPJ.charAt(5) * 8 + RecebeCNPJ.charAt(6) * 7 + RecebeCNPJ.charAt(7) * 6 + RecebeCNPJ.charAt(8) * 5 + RecebeCNPJ.charAt(9) * 4 + RecebeCNPJ.charAt(10) * 3 + RecebeCNPJ.charAt(11) * 2;

        soma = soma - (11 * (parseInt(soma / 11)));

        if (soma == 0 || soma == 1)
            resultado1 = 0;
        else
            resultado1 = 11 - soma;

        if (resultado1 == RecebeCNPJ.charAt(12))
        {
            soma = RecebeCNPJ.charAt(0) * 6 + RecebeCNPJ.charAt(1) * 5 + RecebeCNPJ.charAt(2) * 4 + RecebeCNPJ.charAt(3) * 3 + RecebeCNPJ.charAt(4) * 2 + RecebeCNPJ.charAt(5) * 9 + RecebeCNPJ.charAt(6) * 8 + RecebeCNPJ.charAt(7) * 7 + RecebeCNPJ.charAt(8) * 6 + RecebeCNPJ.charAt(9) * 5 + RecebeCNPJ.charAt(10) * 4 + RecebeCNPJ.charAt(11) * 3 + RecebeCNPJ.charAt(12) * 2;

            soma = soma - (11 * (parseInt(soma / 11)));

            if (soma == 0 || soma == 1)
                resultado2 = 0;
            else
                resultado2 = 11 - soma;

            if (resultado2 == RecebeCNPJ.charAt(13))
                return true;
            else
                return false;
        } else
            return false;
    }
}

function Formata_Cnpj(objeto, teclapres) {
    var tecla = teclapres.keyCode;
    vr = objeto.value;
    s = "";
    for (x = 0; x < vr.length; x++)
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57)
            s = s + vr.charAt(x);
    vr = s;
    tam = vr.length + 1;
    if (tecla != 9 && tecla != 8 && tecla != 46 && tecla != 37 && tecla != 39 && tecla != 35 && tecla != 36) {
        if (tam < 3)
            objeto.value = vr.substr(0, 2);
        if (tam > 2 && tam < 6)
            objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3);
        if (tam > 5 && tam < 9)
            objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '.' + vr.substr(5, 3);
        if (tam > 8 && tam < 13)
            objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '.' + vr.substr(5, 3) + '/' + vr.substr(8, 4);
        if (tam > 12)
            objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '.' + vr.substr(5, 3) + '/' + vr.substr(8, 4) + '-' + vr.substr(12, 2);
    }
    if (tam > 13 && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '.' + vr.substr(5, 3) + '/' + vr.substr(8, 4) + '-' + vr.substr(12, 2);
    if ((tam > 8 && tam < 14) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '.' + vr.substr(5, 3) + '/' + vr.substr(8, 4);
    if ((tam > 5 && tam < 9) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '.' + vr.substr(5, 3);
    if ((tam > 2 && tam < 6) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3);
    if ((tam > 1 && tam < 3) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2);
}

function Valida_CPF(objName)
{
    var datefield = objName;
    if (datefield.value == "")
        return true;

    if (checaCPF(objName.value) == false)
    {
        datefield.select();
        //  alert("CPF inv·lido!!!");
        alert("CPF inv·lido. Por favor, confira o n˙mero informado e tente novamente.");

        datefield.value = "";
        datefield.focus();
        return false;
    } else
    {	//alert("Data V·lida");
        return true;
    }
}

function checaCPF(CPF) {
    s = "";
    for (x = 0; x < CPF.length; x++)
        if (CPF.charCodeAt(x) >= 48 && CPF.charCodeAt(x) <= 57)
            s = s + CPF.charAt(x);
    CPF = s;

    if (CPF.length != 11 || CPF == "00000000000" || CPF == "11111111111" ||
            CPF == "22222222222" || CPF == "33333333333" || CPF == "44444444444" ||
            CPF == "55555555555" || CPF == "66666666666" || CPF == "77777777777" ||
            CPF == "88888888888" || CPF == "99999999999")
        return false;
    soma = 0;
    for (i = 0; i < 9; i ++)
        soma += parseInt(CPF.charAt(i)) * (10 - i);
    var resto = 11 - (soma % 11);
    if (resto == 10 || resto == 11)
        resto = 0;
    if (resto != parseInt(CPF.charAt(9)))
        return false;
    soma = 0;
    for (i = 0; i < 10; i ++)
        soma += parseInt(CPF.charAt(i)) * (11 - i);
    resto = 11 - (soma % 11);
    if (resto == 10 || resto == 11)
        resto = 0;
    if (resto != parseInt(CPF.charAt(10)))
        return false;
    return true;
}

function Formata_Cpf(objeto, teclapres) {
    var tecla = teclapres.keyCode;
    vr = objeto.value;
    s = "";
    for (x = 0; x < vr.length; x++)
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57)
            s = s + vr.charAt(x);
    vr = s;
    tam = vr.length + 1;
    if (tecla != 9 && tecla != 8 && tecla != 46 && tecla != 37 && tecla != 39 && tecla != 35 && tecla != 36) {
        if (tam < 10)
            objeto.value = vr.substr(0, 9);
        if (tam > 9)
            objeto.value = vr.substr(0, 9) + '-' + vr.substr(9, 2);
    }
    if (tam >= 11 && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 9) + '-' + vr.substr(9, 2);
    if (tam <= 10 && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, tam);
}

function Formata_Cep(objeto, teclapres) {
    var tecla = teclapres.keyCode;
    vr = objeto.value;
    s = "";
    for (x = 0; x < vr.length; x++)
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57)
            s = s + vr.charAt(x);
    vr = s;
    tam = vr.length + 1;
    if (tecla != 9 && tecla != 8 && tecla != 46 && tecla != 37 && tecla != 39 && tecla != 35 && tecla != 36) {
        if (tam < 2)
            objeto.value = vr.substr(0, 2);
        if (tam > 2 && tam < 5)
            objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3);
        if (tam > 5)
            objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '-' + vr.substr(5, 3);
    }
    if ((tam > 5 && tam < 9) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '-' + vr.substr(5, 3);
    if ((tam > 2 && tam < 6) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 3);
    if ((tam > 1 && tam < 3) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2);
}

function IsCEP(objeto) {
    var strCEP = objeto.value;
    var objER = /^[0-9]{2}.[0-9]{3}-[0-9]{3}$/;

    var vr = strCEP;
    var s = "";

    for (x = 0; x < vr.length; x++) {
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57) {
            s = s + vr.charAt(x);
        }
    }

    vr = s;

    if (vr.length > 0) {
        strCEP = vr.substr(0, 2) + '.' + vr.substr(2, 3) + '-' + vr.substr(5, 3);
        objeto.value = strCEP;

        if (!objER.test(strCEP)) {
            objeto.select();
            alert("CEP n„o esta no formato valido! (00.000-000)");
            objeto.value = "";
            objeto.focus();
            return false;

        }
    }

    return true;
}

function money(field)
{
    if (field.value == "")
        return true;

    if (validateNumber(field))
    {
        //alert("VALIDO!!!");
        money_valido(field);
        return true;
    } else
    {
        alert("Informe apenas valor no formato numÈrico!");
        field.value = "";
        field.focus();
        return false;
    }
}

function validateNumber(field) {
    var valid = "0123456789,";
    var ok = "yes";
    var ponto = 0;
    var temp;
    var numponto = 0;
    var vFinal = "";
    var msg = "";
    var sinal = "";
    if (field.value.substring(0, 1) == '-')
    {
        sinal = "S";
        field.value = field.value.substring(1);
        // alert(' gggg '+field.value);
    }

    //Retira os Pontos
    field.value = field.value.replace(/\./gi, '');

    for (var i = 0; i < field.value.length; i++) {
        temp = "" + field.value.substring(i, i + 1);

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
        temp = field.value.length - (ponto + 1) - 2;
    else
        temp = 0;

    msg += "\nPonto: " + ponto + " Temp: " + temp + "\n";

    //alert(msg);

    if (ok == "no")
        return false;
    if (numponto >= 2)
        return false;
    if (temp == -2 && numponto == 1)
        return false;
    if (temp >= 1)
        return false;
    if (ponto == 0 && numponto == 1)
        return false;

    //Coloca os pontos
    msg = "";

    if (ponto > 0)
        vFinal = field.value.substr(ponto);
    if (ponto == 0)
        ponto = field.value.length;

    for (var i = ponto - 3; i > -3; i = i - 3) {
        temp = "" + field.value.substring(i, i + 3);
        vFinal = "." + temp + vFinal;
        msg += i + " - Temp: " + temp + "  vFinal: " + vFinal + "\n";
    }
    //alert(msg);

    if (vFinal.substring(0, 1) == ".")
        vFinal = vFinal.substr(1);
    field.value = vFinal;
    if (sinal == 'S')
    {
        field.value = '-' + vFinal;
    }
    return true;
}



function money_ndec(field, ndec)
{
    if (field.value == "")
        return true;

    if (ndec == 2)
    {

        if (validateNumber(field))
        {
            alert("VALIDO!!! " + field);
            money_valido(field);
            return true;
        } else
        {
            alert("Informe apenas valor no formato numÈrico!");
            field.value = "";
            field.focus();
            return false;
        }

    } else
    {



    }


}


function Limita_Tamanho(campo, tam) {
    var tamcarater = campo.value.length;
    if (tamcarater >= tam) {
        alert('Limite de caracteres excedido. M·ximo permitido ' + tam);
        return false;
    } else {
        //
        // colocar aqui o contador
        // faltam x  posiÁıes
        //  
        return true;
    }
}

function Trunca_Campo(campo, tam) {
    if (campo.value.length > tam) {
        alert("O campo tem um limite de " + tam + " caracteres!" + '\n O texto ser· truncado em ' + tam + ' posiÁıes');
        campo.value = campo.value.substring(0, tam);
    }
}

function troca_caracter(campo) {
    var estranha = "·ÈÌÛ˙‡ËÏÚ˘‚ÍÓÙ˚‰ÎÔˆ¸„ı@#$%^&*()_+=-~` Á";
    var correta = "aeiouaeiouaeiouaeiouao________________c";
    var re;

    campo = campo.toLowerCase();

    for (var i = 0; i < estranha.length; i++) {
        re = new RegExp('\\' + estranha.charAt(i), "g");
        campo = campo.replace(re, correta.charAt(i));
    }

    campo = campo.replace(/_/gi, "");

    return campo;
}

function base64_encode(data) {
    //  discuss at: http://phpjs.org/functions/base64_encode/
    // original by: Tyler Akins (http://rumkin.com)
    // improved by: Bayron Guevara
    // improved by: Thunder.m
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Rafa? Kukawski (http://kukawski.pl)
    // bugfixed by: Pellentesque Malesuada
    //   example 1: base64_encode('Kevin van Zonneveld');
    //   returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
    //   example 2: base64_encode('a');
    //   returns 2: 'YQ=='
    //   example 3: base64_encode('? ‡ la mode');
    //   returns 3: '4pyTIMOgIGxhIG1vZGU='

    var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
            ac = 0,
            enc = '',
            tmp_arr = [];

    if (!data) {
        return data;
    }

    data = unescape(encodeURIComponent(data));

    do {
        // pack three octets into four hexets
        o1 = data.charCodeAt(i++);
        o2 = data.charCodeAt(i++);
        o3 = data.charCodeAt(i++);

        bits = o1 << 16 | o2 << 8 | o3;

        h1 = bits >> 18 & 0x3f;
        h2 = bits >> 12 & 0x3f;
        h3 = bits >> 6 & 0x3f;
        h4 = bits & 0x3f;

        // use hexets to index into b64, and append result to encoded string
        tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
    } while (i < data.length);

    enc = tmp_arr.join('');

    var r = data.length % 3;

    return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
}

function base64_decode(data) {
    //  discuss at: http://phpjs.org/functions/base64_decode/
    // original by: Tyler Akins (http://rumkin.com)
    // improved by: Thunder.m
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    //    input by: Aman Gupta
    //    input by: Brett Zamir (http://brett-zamir.me)
    // bugfixed by: Onno Marsman
    // bugfixed by: Pellentesque Malesuada
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    //   example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==');
    //   returns 1: 'Kevin van Zonneveld'
    //   example 2: base64_decode('YQ===');
    //   returns 2: 'a'
    //   example 3: base64_decode('4pyTIMOgIGxhIG1vZGU=');
    //   returns 3: '? ‡ la mode'

    var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
            ac = 0,
            dec = '',
            tmp_arr = [];

    if (!data) {
        return data;
    }

    data += '';

    do {
        // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));

        bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

        o1 = bits >> 16 & 0xff;
        o2 = bits >> 8 & 0xff;
        o3 = bits & 0xff;

        if (h3 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1);
        } else if (h4 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1, o2);
        } else {
            tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
        }
    } while (i < data.length);

    dec = tmp_arr.join('');

    return decodeURIComponent(escape(dec.replace(/\0+$/, '')));
}

function url_encode(str) {
    if (str == null) {
        str = '';
    }

    var hex_chars = "0123456789ABCDEF";
    var noEncode = /^([a-zA-Z0-9\_\-\.])$/;
    var n, strCode, hex1, hex2, strEncode = "";

    for (n = 0; n < str.length; n++) {
        if (noEncode.test(str.charAt(n))) {
            strEncode += str.charAt(n);
        } else {
            strCode = str.charCodeAt(n);
            hex1 = hex_chars.charAt(Math.floor(strCode / 16));
            hex2 = hex_chars.charAt(strCode % 16);
            strEncode += "%" + (hex1 + hex2);
        }
    }
    return strEncode;
}

function url_decode(str) {
    var n, strCode, strDecode = "";

    if (str == null) {
        return '';
    }

    for (n = 0; n < str.length; n++) {
        if (str.charAt(n) == "%") {
            strCode = str.charAt(n + 1) + str.charAt(n + 2);
            strDecode += String.fromCharCode(parseInt(strCode, 16));
            n += 2;
        } else {
            strDecode += str.charAt(n);
        }
    }
    return strDecode;
}

function cursorfim(obj) {
    var range = obj.createTextRange();
    var end = obj.value.length;
    range.collapse(true);
    range.moveEnd('character', end + 1);
    range.moveStart('character', end);
    range.select();
}

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
}

function calcular_idade(data) {
    //calcular a idade de uma pessoa
    //recebe a data como um string em formato portugues
    //devolve um inteiro com a idade. Devolve false em caso de que a data seja incorreta ou maior que o dia atual

    var ano;
    var mes;
    var dia;
    var rAno;
    var rMes;
    var rDia;

    var array_data = data.split("/");
    if (array_data.length != 3)
        return false;

    ano = parseInt(array_data[2], 10);
    if (isNaN(ano))
        return false;

    mes = parseInt(array_data[1], 10);
    if (isNaN(mes))
        return false;

    dia = parseInt(array_data[0], 10);
    if (isNaN(dia))
        return false;

    if (ano <= 99)
        ano += 1900;

    rAno = hoje.getYear() - ano - 1; //-1 porque ainda nao fez anos durante este ano
    if ($.browser.mozilla)
        rAno += 1900;

    //se subtraio os meses e for menor que 0 entao nao cumpriu anos. Se for maior sim ja cumpriu
    //+ 1 porque os meses comecam em 0
    rMes = hoje.getMonth() + 1 - mes;
    rDia = hoje.getUTCDate() - dia;

    if (hoje.getMonth() + 1 - mes == 0) {
        //entao eh porque sao iguais. Vejo os dias
        //se subtraio os dias e der menor que 0 entao nao cumpriu anos. Se der maior ou igual sim que j· cumpriu
        if (rDia >= 0)
            rAno++;
    } else if (hoje.getMonth() + 1 - mes > 0) {
        rAno++;
    }

    if (rDia < 0) {
        rMes--;
        var tMes = hoje.getMonth() + 1;
        if (tMes == 1 || tMes == 3 || tMes == 5 || tMes == 7 || tMes == 8 || tMes == 10 || tMes == 12)
            rDia = 31 + rDia - 1;
        if (tMes == 4 || tMes == 6 || tMes == 9 || tMes == 11)
            rDia = 30 + rDia - 1;
    }

    if (rMes < 0)
        rMes = 11;

    return {ano: rAno, mes: rMes, dia: rDia};
}

function Valida_Url(objeto) {
    if (objeto.value.substr(0, 7).toLowerCase() == "http://")
        objeto.value = objeto.value.substr(7).toLowerCase();
    return true;
}

function minCaracteres(obj, tam) {
    if (tam == undefined)
        tam = 7;

    if (obj.value.length > 0 && obj.value.length <= tam) {
        alert('Favor informar o texto com mais de ' + tam + ' caracteres!');
        obj.value = '';
        obj.focus();
        return false;
    } else {
        return true;
    }

}

function mudaTab(g) {
    if ($('div#grd' + g).css('display') == 'none') {
        $('div#tabHtml').tabs('option', 'active', g - 1);
    }
}

function abreFRM(campo) {
    var $campo = $('#' + campo);

    if ($('fieldset').length == 0) {
        return;
    }

    if ($campo.length == 1) {
        var frm = achaFRM($campo);

        if (frm.is(":hidden")) {
            $('#' + frm.data('codigo_pai')).click();
        }
    }
}

function achaFRM(obj) {
    if (obj.is("fieldset")) {
        return obj;
    } else {
        return achaFRM(obj.parent());
    }
}

function queryString(parameter) {
    var loc = location.search.substring(1, location.search.length);
    var param_value = false;
    var params = loc.split("&");
    for (i = 0; i < params.length; i++) {
        param_name = params[i].substring(0, params[i].indexOf('='));
        if (param_name == parameter) {
            param_value = params[i].substring(params[i].indexOf('=') + 1);
        }
    }

    if (param_value) {
        return param_value;
    } else {
        return '';
    }
}

function Formata_DataHora(objeto, teclapres) {
    var tecla = teclapres.keyCode;
    vr = objeto.value;
    s = "";
    for (x = 0; x < vr.length; x++)
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57)
            s = s + vr.charAt(x);
    vr = s;
    tam = vr.length + 1;
    if (tecla != 9 && tecla != 8 && tecla != 46 && tecla != 37 && tecla != 39 && tecla != 35 && tecla != 36) {
        if (tam < 2)
            objeto.value = vr.substr(0, 2);
        if (tam > 2 && tam < 4)
            objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2);
        if (tam > 4 && tam < 8)
            objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 4);
        if (tam > 8 && tam < 10)
            objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 4) + ' ' + vr.substr(8, 2);
        if (tam > 10)
            objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 4) + ' ' + vr.substr(8, 2) + ':' + vr.substr(10, 2);
    }
    if (tam > 10 && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 4) + ' ' + vr.substr(8, 2) + ':' + vr.substr(10, 2);
    if ((tam > 8 && tam < 11) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 4) + ' ' + vr.substr(8, 2);
    if ((tam > 4 && tam < 9) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 4);
    if ((tam > 2 && tam < 5) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + '/' + vr.substr(2, 2);
    if (tam < 3 && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2);
}

function Valida_DataHora(objName) {
    var ValorOriginal = objName.value;
    objName.value = ValorOriginal.substring(0, 10);
    if (checkdate(objName)) {
        objName.value = ValorOriginal.substring(11, 16);
        if (Valida_Hora(objName)) {
            objName.value = ValorOriginal;
        }
    }
}

function Formata_Hora(objeto, teclapres) {
    var tecla = teclapres.keyCode;
    vr = objeto.value;
    s = "";
    for (x = 0; x < vr.length; x++)
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57)
            s = s + vr.charAt(x);
    vr = s;
    tam = vr.length + 1;
    if (tecla != 9 && tecla != 8 && tecla != 46 && tecla != 37 && tecla != 39 && tecla != 35 && tecla != 36) {
        if (tam < 2)
            objeto.value = vr.substr(0, 2);
        if (tam > 2)
            objeto.value = vr.substr(0, 2) + ':' + vr.substr(2, 2);
    }
    if ((tam > 2 && tam < 5) && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2) + ':' + vr.substr(2, 2);
    if (tam < 3 && (tecla == 8 || tecla == 46))
        objeto.value = vr.substr(0, 2);
}

function Valida_Hora(campo)
{
    if (campo.value.length == 0)
    {
        return true;
    } else if ((campo.value.length >= 1) && (campo.value.length < 5))
    {
        campo.select();
        alert("Hora Inv·lida!");
        campo.value = "";
        campo.focus();
        return false;
    } else if (campo.value.length == 5)
    {
        if (isNaN(campo.value.substring(0, 2)) || (campo.value.substring(0, 2) > 23) || (campo.value.substring(0, 2) < 0))
        {
            campo.select();
            alert("Hora Inv·lida!");
            campo.value = "";
            campo.focus();
            return false;
        } else if (isNaN(campo.value.substring(3, 5)) || (campo.value.substring(3, 5) > 59) || (campo.value.substring(3, 5) < 0))
        {
            campo.select();
            alert("Hora Inv·lida!");
            campo.value = "";
            campo.focus();
            return false;
        } else if (campo.value.substring(2, 3) != ":")
        {
            campo.select();
            alert("Hora Inv·lida!");
            campo.value = "";
            campo.focus();
            return false;
        } else
        {
            return true;
        }
    }
}

function validaCPFCNPJ(obj) {
    if (obj.value == "") {
        return true;
    }

    var s = "";
    var txt = obj.value;
    for (x = 0; x < txt.length; x++) {
        if (txt.charCodeAt(x) >= 48 && txt.charCodeAt(x) <= 57) {
            s += txt.charAt(x);
        }
    }

    if (s.length <= 11) {
        var erro = false;
        CPF = s;
        if (CPF.length != 11 || CPF == "00000000000" || CPF == "11111111111" || CPF == "22222222222" || CPF == "33333333333" || CPF == "44444444444" || CPF == "55555555555" || CPF == "66666666666" || CPF == "77777777777" || CPF == "88888888888" || CPF == "99999999999")
            erro = true;
        else {
            var soma = 0;
            for (i = 0; i < 9; i ++)
                soma += parseInt(CPF.charAt(i)) * (10 - i);
            resto = 11 - (soma % 11);
            if (resto == 10 || resto == 11)
                resto = 0;
            if (resto != parseInt(CPF.charAt(9)))
                erro = true;
            else {
                soma = 0;
                for (i = 0; i < 10; i ++)
                    soma += parseInt(CPF.charAt(i)) * (11 - i);
                resto = 11 - (soma % 11);
                if (resto == 10 || resto == 11)
                    resto = 0;
                if (resto != parseInt(CPF.charAt(10)))
                    erro = true;
            }
        }
        if (erro == true) {
            obj.select();
            //   alert("CPF inv·lido!");
            alert("CPF inv·lido. Por favor, confira o n˙mero informado e tente novamente.");


            obj.value = "";
            obj.focus();
            return false;
        }
        obj.value = CPF.substr(0, 3) + CPF.substr(3, 3) + CPF.substr(6, 3) + '-' + CPF.substr(9, 2);
    } else {
        var soma;
        var resultado1;
        var resultado2;
        var RecebeCNPJ = s;
        var erro = false;
        if (RecebeCNPJ.length != 14 || RecebeCNPJ == "00000000000000") {
            erro = true;
        } else {
            soma = RecebeCNPJ.charAt(0) * 5 + RecebeCNPJ.charAt(1) * 4 + RecebeCNPJ.charAt(2) * 3 + RecebeCNPJ.charAt(3) * 2 + RecebeCNPJ.charAt(4) * 9 + RecebeCNPJ.charAt(5) * 8 + RecebeCNPJ.charAt(6) * 7 + RecebeCNPJ.charAt(7) * 6 + RecebeCNPJ.charAt(8) * 5 + RecebeCNPJ.charAt(9) * 4 + RecebeCNPJ.charAt(10) * 3 + RecebeCNPJ.charAt(11) * 2;
            soma = soma - (11 * (parseInt(soma / 11)));
            if (soma == 0 || soma == 1)
                resultado1 = 0;
            else
                resultado1 = 11 - soma;
            if (resultado1 == RecebeCNPJ.charAt(12)) {
                soma = RecebeCNPJ.charAt(0) * 6 + RecebeCNPJ.charAt(1) * 5 + RecebeCNPJ.charAt(2) * 4 + RecebeCNPJ.charAt(3) * 3 + RecebeCNPJ.charAt(4) * 2 + RecebeCNPJ.charAt(5) * 9 + RecebeCNPJ.charAt(6) * 8 + RecebeCNPJ.charAt(7) * 7 + RecebeCNPJ.charAt(8) * 6 + RecebeCNPJ.charAt(9) * 5 + RecebeCNPJ.charAt(10) * 4 + RecebeCNPJ.charAt(11) * 3 + RecebeCNPJ.charAt(12) * 2;
                soma = soma - (11 * (parseInt(soma / 11)));
                if (soma == 0 || soma == 1)
                    resultado2 = 0;
                else
                    resultado2 = 11 - soma;
                if (resultado2 != RecebeCNPJ.charAt(13))
                    erro = true;
            } else
                erro = true;
        }
        if (erro == true) {
            obj.select();
            alert("CNPJ inv·lido!");
            obj.value = "";
            obj.focus();
            return false;
        }
        obj.value = RecebeCNPJ.substr(0, 2) + '.' + RecebeCNPJ.substr(2, 3) + '.' + RecebeCNPJ.substr(5, 3) + '/' + RecebeCNPJ.substr(8, 4) + '-' + RecebeCNPJ.substr(12, 2);
    }

    return true;
}

function validaCPFCNPJLogin(obj) {
    var vl = obj.value;
    var re = '';

    re = new RegExp('\\.', "g");
    vl = vl.replace(re, '');

    re = new RegExp('\\-', "g");
    vl = vl.replace(re, '');

    re = new RegExp('\\/', "g");
    vl = vl.replace(re, '');

    if (!isNaN(vl)) {
        validaCPFCNPJ(obj);
    }
}

function formataCPFCNPJ(obj, teclapres) {
    if (obj.value.length > 12) {
        Formata_Cnpj(obj, teclapres);
    } else {
        Formata_Cpf(obj, teclapres);
    }
}

function formataCPFCNPJLogin(obj, teclapres) {
    var vl = obj.value;
    var re = '';

    re = new RegExp('\\.', "g");
    vl = vl.replace(re, '');

    re = new RegExp('\\-', "g");
    vl = vl.replace(re, '');

    re = new RegExp('\\/', "g");
    vl = vl.replace(re, '');

    if (!isNaN(vl)) {
        if (obj.value.length > 12) {
            Formata_Cnpj(obj, teclapres);
        } else {
            Formata_Cpf(obj, teclapres);
        }
    }
}

function validaDataMaior(usa_hora, $dt, dt_desc, $dt_referencia, dt_referencia_desc, pode_igual) {
    if (pode_igual == undefined) {
        pode_igual = true;
    }

    if ($dt.length == 0) {
        return true;
    }

    if (checkdate($dt[0]) === false) {
        return false;
    }

    if ($dt.val() == '') {
        return true;
    }

    if (checkdate($dt_referencia[0]) === false) {
        return false;
    }

    if ($dt_referencia.val() == '') {
        alert('Favor informar a data de ' + dt_referencia_desc + '!');
        $dt_referencia.focus();
        return false;
    }

    if (pode_igual) {
        if (newDataHoraStr(usa_hora, $dt.val()) - newDataHoraStr(usa_hora, $dt_referencia.val()) < 0) {
            alert('A data ' + dt_desc + ' tem que ser maior ou igual a ' + dt_referencia_desc + ' (' + $dt_referencia.val() + ')!');
            $dt.val('');
            $dt.focus();
            return false;
        }
    } else {
        if (newDataHoraStr(usa_hora, $dt.val()) - newDataHoraStr(usa_hora, $dt_referencia.val()) <= 0) {
            alert('A data ' + dt_desc + ' tem que ser maior que ' + dt_referencia_desc + ' (' + $dt_referencia.val() + ')!');
            $dt.val('');
            $dt.focus();
            return false;
        }
    }

    return true;
}

function validaDataMenor(usa_hora, $dt, dt_desc, $dt_referencia, dt_referencia_desc, pode_igual) {
    if (pode_igual == undefined) {
        pode_igual = true;
    }

    if ($dt.length == 0) {
        return true;
    }

    if (checkdate($dt[0]) === false) {
        return false;
    }

    if ($dt.val() == '') {
        return true;
    }

    if (checkdate($dt_referencia[0]) === false) {
        return false;
    }

    if ($dt_referencia.val() == '') {
        alert('Favor informar a data de ' + dt_referencia_desc + '!');
        $dt_referencia.focus();
        return false;
    }

    if (pode_igual) {
        if (newDataHoraStr(usa_hora, $dt.val()) - newDataHoraStr(usa_hora, $dt_referencia.val()) > 0) {
            alert('A data ' + dt_desc + ' tem que ser menor ou igual a ' + dt_referencia_desc + ' (' + $dt_referencia.val() + ')!');
            $dt.val('');
            $dt.focus();
            return false;
        }
    } else {
        if (newDataHoraStr(usa_hora, $dt.val()) - newDataHoraStr(usa_hora, $dt_referencia.val()) >= 0) {
            alert('A data ' + dt_desc + ' tem que ser menor que ' + dt_referencia_desc + ' (' + $dt_referencia.val() + ')!');
            $dt.val('');
            $dt.focus();
            return false;
        }
    }

    return true;
}

function validaDataMaiorStr(usa_hora, $dt, dt_desc, dt_referencia, dt_referencia_desc, pode_igual, txt_msg) {
    if (pode_igual == undefined) {
        pode_igual = true;
    }

    if (txt_msg == undefined) {
        txt_msg = 'A data ';
    }
    
    if ($dt.length == 0) {
        return true;
    }

    if (checkdate($dt[0]) === false) {
        return false;
    }

    if ($dt.val() == '') {
        return true;
    }

    if (dt_referencia == '') {
        alert('Favor informar a data de ' + dt_referencia_desc + '!');
        return false;
    }
    
    if (!usa_hora) {
        dt_referencia = dt_referencia.substr(0, 10);
    }

    if (pode_igual) {
        if (newDataHoraStr(usa_hora, $dt.val()) - newDataHoraStr(usa_hora, dt_referencia) < 0) {
            alert(txt_msg + dt_desc + ' tem que ser maior ou igual a ' + dt_referencia_desc + ' (' + dt_referencia + ')!');
            $dt.val('');
            $dt.focus();
            return false;
        }
    } else {
        if (newDataHoraStr(usa_hora, $dt.val()) - newDataHoraStr(usa_hora, dt_referencia) <= 0) {
            alert(txt_msg + dt_desc + ' tem que ser maior que ' + dt_referencia_desc + ' (' + dt_referencia + ')!');
            $dt.val('');
            $dt.focus();
            return false;
        }
    }

    return true;
}

function validaDataMenorStr(usa_hora, $dt, dt_desc, dt_referencia, dt_referencia_desc, pode_igual) {
    if (pode_igual == undefined) {
        pode_igual = true;
    }

    if ($dt.length == 0) {
        return true;
    }

    if (checkdate($dt[0]) === false) {
        return false;
    }

    if ($dt.val() == '') {
        return true;
    }

    if (dt_referencia == '') {
        alert('Favor informar a data de ' + dt_referencia_desc + '!');
        return false;
    }

    if (!usa_hora) {
        dt_referencia = dt_referencia.substr(0, 10);
    }

    if (pode_igual) {
        if (newDataHoraStr(usa_hora, $dt.val()) - newDataHoraStr(usa_hora, dt_referencia) > 0) {
            alert('A data ' + dt_desc + ' tem que ser menor ou igual a ' + dt_referencia_desc + ' (' + dt_referencia + ')!');
            $dt.val('');
            $dt.focus();
            return false;
        }
    } else {
        if (newDataHoraStr(usa_hora, $dt.val()) - newDataHoraStr(usa_hora, dt_referencia) >= 0) {
            alert('A data ' + dt_desc + ' tem que ser menor que ' + dt_referencia_desc + ' (' + dt_referencia + ')!');
            $dt.val('');
            $dt.focus();
            return false;
        }
    }

    return true;
}

function ListarCmbClick(campo, arq, titulo) {
    var par = '';
    par += '?prefixo=listar_cmb';
    par += '&menu=' + arq;
    par += '&campo=' + campo;
    par += '&cas=' + conteudo_abrir_sistema;
    var url = 'conteudo_cadastro.php' + par;
    var parListarCmb = window['parListarCmb_' + campo];

    if ($.isFunction(parListarCmb)) {
        var par = parListarCmb();

        if (par === false) {
            return false;
        }

        url += par;
    }

    showPopWin(url, titulo, $('div.showPopWin_width').width() - 30, $(window).height() - 100, ListarCmbClose, false);
}

function ListarCmbMultiClick(campo, arq, session_cod, titulo) {
    var par = '';
    par += '?prefixo=listar_cmbmulti';
    par += '&menu=' + arq;
    par += '&campo=' + campo;
    par += '&session_cod=' + session_cod;
    par += '&cas=' + conteudo_abrir_sistema;
    var url = 'conteudo_cadastro.php' + par;
    var parListarCmb = window['parListarCmbMulti_' + campo];

    if ($.isFunction(parListarCmb)) {
        var par = parListarCmb();

        if (par === false) {
            return false;
        }

        url += par;
    }

    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: ajax_plu + '&tipo=ListarCmbMultiCopia',
        data: {
            cas: conteudo_abrir_sistema,
            session_cod: session_cod
        },
        success: function (response) {
            if (response.erro != '') {
                alert(url_decode(response.erro));
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
        },
        async: false
    });

    showPopWin(url, titulo, $('div.showPopWin_width').width() - 30, $(window).height() - 100, ListarCmbMultiClose, false);
}

function ListarCmbClose(returnVal) {
    var valorAnt = $('#' + returnVal.campo).val();
    var descAnt = $('#' + returnVal.campo + '_obj > div').text();

    $('#' + returnVal.campo).val(returnVal.valor);
    $('#' + returnVal.campo + '_obj > div').text(returnVal.desc);

    if ($('#contListar').length > 0) {
        $('#contListar').height($('#contListar').innerHeight()).html('<div align="center" class="Msg">Favor clicar no bot„o de Pesquisar!</div>');
        //TelaHeight();
    }

    var fncListarCmbMuda = window['fncListarCmbMuda_' + returnVal.campo];

    if ($.isFunction(fncListarCmbMuda)) {
        fncListarCmbMuda(returnVal.valor, returnVal.desc, valorAnt, descAnt);
    }
}

function ListarCmbMultiClose(returnVal) {
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: ajax_plu + '&tipo=ListarCmbMultiAtualiza',
        data: {
            cas: conteudo_abrir_sistema,
            session_cod: returnVal.session_cod
        },
        success: function (response) {
            if (response.erro == '') {
                $('#' + returnVal.campo + '_obj > .ListarCmbMulti > li').remove();
                $('#' + returnVal.campo + '_obj > .ListarCmbMulti').append(url_decode(response.html));
                $('#' + returnVal.campo + '_tot').val(response.tot);


                var fncListarCmbMultiMuda = window['fncListarCmbMultiMuda_' + returnVal.campo];

                if ($.isFunction(fncListarCmbMultiMuda)) {
                    fncListarCmbMultiMuda(returnVal.session_cod);
                }
            } else {
                alert(url_decode(response.erro));
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
        },
        async: false
    });

    TelaHeight();
}

function ListarCmbMultiLimpa(campo, session_cod) {
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: ajax_plu + '&tipo=ListarCmbMultiRemoveAll',
        data: {
            cas: conteudo_abrir_sistema,
            session_cod: session_cod
        },
        success: function (response) {
            if (response.erro == '') {
                if (campo == '') {
                    document.frm.submit();
                } else {
                    $('#' + campo + '_obj > .ListarCmbMulti > li').remove();
                    $('#' + campo + '_tot').val(0);
                }
            } else {
                alert(url_decode(response.erro));
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
        },
        async: false
    });

    TelaHeight();
}

function ListarCmbLimpa(campo) {
    var valorAnt = $('#' + campo).val();
    var descAnt = $('#' + campo + '_obj > div').text();

    var parListarCmb = window['parListarCmbLimpa_' + campo];

    if ($.isFunction(parListarCmb)) {
        var par = parListarCmb();

        if (par === false) {
            return false;
        }
    }

    $('#' + campo).val('');
    $('#' + campo + '_obj > div').text('†');

    if ($('#contListar').length > 0) {
        $('#contListar').height($('#contListar').innerHeight()).html('<div align="center" class="Msg">Favor clicar no bot„o de Pesquisar!</div>');
        //TelaHeight();
    }

    var fncListarCmbMuda = window['fncListarCmbMuda_' + campo];

    if ($.isFunction(fncListarCmbMuda)) {
        fncListarCmbMuda('', '', valorAnt, descAnt);
    }
}

function alert_sistema(msg) {
    var defer = $.Deferred();
    var div = $("div#alert_sistema");

    if (div.length > 0) {
        div.dialog("destroy").remove();
    }

    div = $('<div id="alert_sistema" title="Aviso do Sistema"></div>');
    $('body').add(div);

    div.html(msg).dialog({
        dialogClass: "no-close",
        modal: true,
        maxHeight: $(window).height() - 100,
        maxWidth: $(window).width() - 40,
        buttons: {
            Ok: function () {
                defer.resolve("true");
                $(this).dialog("close");
            }
        }
    });

    div.focus();
    return defer.promise();
}

function alertDialog(Msg) {
    return alert_sistema(Msg);
}

function noticia_sistema(local_apresentacao) {
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: ajax_plu + '&tipo=noticia_sistema',
        data: {
            local_apresentacao: local_apresentacao
        },
        success: function (response) {
            if (response.erro == '') {
                var div = $("div#noticia_sistema");

                if (div.length > 0) {
                    div.dialog("destroy").remove();
                }

                if (response.html != '') {
                    div = $('<div id="noticia_sistema" title="' + url_decode(response.titulo) + '"></div>');
                    div.html(url_decode(response.html));

                    $('body').add(div);

                    if (response.rows > 1) {
                        div.find('#accordion').accordion({
                            heightStyle: "content",
                            activate: function () {
                                var height = $("#accordion").outerHeight() + 60;
                                var maxHeight = $("#noticia_sistema").dialog("option", "maxHeight");

                                if (height > maxHeight) {
                                    height = maxHeight;
                                }

                                $("#noticia_sistema").dialog("option", "height", height);
                            }
                        });
                    }

                    div.dialog({
                        modal: true,
                        resizable: false,
                        width: 700,
                        height: 350,
                        minWidth: 350,
                        minHeight: 170,
                        maxWidth: $(window).width() - 40,
                        maxHeight: $(window).height() - 100
                    });

                    $("#accordion").accordion("refresh");

                    var height = $("#noticia_sistema > div:first").outerHeight() + 60;
                    var maxHeight = div.dialog("option", "maxHeight");

                    if (height > maxHeight) {
                        height = maxHeight;
                    }

                    div.dialog("option", "height", height);

                    div.focus();
                }
            } else {
                alert(url_decode(response.erro));
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
        },
        async: false
    });
}

function muda_size_font(size) {
    $('input, select, textarea, span, div, label', 'fieldset').css('font-size', size + 'px');
    $('input, select, textarea, span, div, label', 'fieldset').css('line-height', (size + 4) + 'px');
    $('input', 'fieldset').css('height', (size + 7) + 'px');
    $('select, textarea, span, div, label', 'fieldset').css('height', 'auto');
    $('fieldset', 'form').css('height', 'auto');

    $('span, div', 'fieldset').css('width', 'auto');
}

function processando(msg) {
    if ($('#dialog-processando').length == 0) {
        if (msg == undefined) {
            msg = 'Favor aguardar. AÁ„o sendo processada!';
        }

        var html = '';
        html += '<div id="dialog-processando">';
        html += '<h1>' + msg + '</h1>';
        html += '<img src="imagens/pbar-ani.gif" width="400" height="22"/>';
        html += '</div>';

        var obj = $(html);
        var width = 500;
        var height = 130;

        obj.css('position', 'absolute');
        obj.css('text-align', 'center');
        obj.css('width', width + 'px');
        obj.css('height', height + 'px');
        obj.css('background-color', '#C00000');
        obj.css('color', '#FFFFFF');

        var theBody = document.getElementsByTagName("BODY")[0];
        var scTop = parseInt(getScrollTop(), 10);
        var scLeft = parseInt(theBody.scrollLeft, 10);
        var fullHeight = getViewportHeight();
        var fullWidth = getViewportWidth();

        obj.css('top', (scTop + ((fullHeight - height) / 2)) + "px");
        obj.css('left', (scLeft + ((fullWidth - width) / 2)) + "px");

        $('body').append(obj);
    }
}

function float2str(num) {
    var x = 0;

    if (num < 0) {
        num = Math.abs(num);
        x = 1;
    }

    if (isNaN(num)) {
        num = "0";
    }

    var cents = Math.floor((num * 100 + 0.5) % 100);

    num = Math.floor((num * 100 + 0.5) / 100).toString();

    if (cents < 10) {
        cents = "0" + cents;
    }

    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++) {
        num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
    }

    var ret = num + ',' + cents;

    if (x == 1) {
        ret = '-' + ret;
    }

    return ret;
}

function str2float(num) {
    return parseFloat(num.replace(/\./gi, '').replace(',', '.'));
}

function Formata_Nirf(objeto) {
    var vr = objeto.value;
    var s = "";

    for (x = 0; x < vr.length; x++) {
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57) {
            s = s + vr.charAt(x);
        }
    }

    vr = s;

    switch (vr.length) {
        case 0:
            objeto.value = vr;
            break;

        case 1:
            objeto.value = vr.substr(0, 1) + '.';
            break;

        case 2:
        case 3:
            objeto.value = vr.substr(0, 1) + '.' + vr.substr(1, 2);
            break;

        case 4:
            objeto.value = vr.substr(0, 1) + '.' + vr.substr(1, 3) + '.';
            break;

        case 5:
        case 6:
            objeto.value = vr.substr(0, 1) + '.' + vr.substr(1, 3) + '.' + vr.substr(4, 2);
            break;

        case 7:
            objeto.value = vr.substr(0, 1) + '.' + vr.substr(1, 3) + '.' + vr.substr(4, 3) + '-';
            break;

        default:
            objeto.value = vr.substr(0, 1) + '.' + vr.substr(1, 3) + '.' + vr.substr(4, 3) + '-' + vr.substr(7, 1);
            break;
    }

    return true;
}

function Valida_Nirf(objeto) {
    var vr = objeto.value;
    var df = 0;

    if (vr == "") {
        return true;
    }

    var s = "";

    for (x = 0; x < vr.length; x++) {
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57) {
            s = s + vr.charAt(x);
        }
    }

    vr = s;

    if (parseInt(vr, 10) == 0) {
        alert("O Nirf informado È inv·lido!");
        objeto.value = "";
        objeto.focus();
        return false;
    }

    var tam = 8 - vr.length;

    if (tam > 0) {
        vr = repeat(0, tam) + vr;
    }

    var n0 = vr.charAt(0);
    var n1 = vr.charAt(1);
    var n2 = vr.charAt(2);
    var n3 = vr.charAt(3);
    var n4 = vr.charAt(4);
    var n5 = vr.charAt(5);
    var n6 = vr.charAt(6);
    var n7 = vr.charAt(7);

    var soma = (n0 * 8) + (n1 * 7) + (n2 * 6) + (n3 * 5) + (n4 * 4) + (n5 * 3) + (n6 * 2);
    soma = soma - (11 * parseInt(soma / 11, 10));

    if (soma == 0 || soma == 1) {
        df = 0;
    } else {
        df = 11 - soma;
    }

    if (df == n7) {
        objeto.value = vr.substr(0, 1) + '.' + vr.substr(1, 3) + '.' + vr.substr(4, 3) + '-' + vr.substr(7, 1);
    } else {
        alert("O Nirf informado È inv·lido!");
        objeto.value = "";
        objeto.focus();
        return false;
    }

    return true;
}

function FormataSICAB(objeto) {
    var vr = objeto.value;
    var s = "";

    var estado = vr.substr(0, 2).toUpperCase();

    for (x = 0; x < vr.length; x++) {
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57) {
            s = s + vr.charAt(x);
        }
    }

    vr = estado + s;

    switch (vr.length) {
        case 0:
        case 1:
        case 2:
            objeto.value = vr;
            break;

        case 3:
        case 4:
        case 5:
        case 6:
            objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 4);
            break;

        case 7:
        case 8:
        case 9:
        case 10:
        case 11:
        case 12:
        case 13:
            objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 4) + '.' + vr.substr(6, 7);
            break;

        default:
            objeto.value = vr.substr(0, 2) + '.' + vr.substr(2, 4) + '.' + vr.substr(6, 7) + '.' + vr.substr(13, 2);
            break;
    }

    return true;
}

function ValidaSICAB(objeto) {
    var vr = objeto.value;
    var vetEstado = ['AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO'];

    if (vr == "") {
        return true;
    }

    var estado = vr.substr(0, 2).toUpperCase();

    var s = "";

    for (x = 0; x < vr.length; x++) {
        if (vr.charCodeAt(x) >= 48 && vr.charCodeAt(x) <= 57) {
            s = s + vr.charAt(x);
        }
    }

    vr = estado + s;

    if (vr.length != 15 || vetEstado.indexOf(estado) < 0) {
        alert("O SICAB informado È inv·lido!");
        objeto.value = "";
        objeto.focus();
        return false;
    }

    return true;
}

function exportChart(type, filename, width, svg) {
    $.ajax({
        type: 'POST',
        url: exporting_url + 'save.php',
        data: {
            type: type,
            filename: filename,
            width: width,
            svg: svg
        },
        success: function (response) {
            if (response != '') {
                alert(response);
            }
        },
        async: false
    });
}

function DataHojeCalendario()
{
    data = new Date();
    dia = data.getDate();
    mes = data.getMonth();
    ano = data.getFullYear();
    //
    meses = new Array(12);
    meses[0] = "Janeiro";
    meses[1] = "Fevereiro";
    meses[2] = "MarÁo";
    meses[3] = "Abril";
    meses[4] = "Maio";
    meses[5] = "Junho";
    meses[6] = "Julho";
    meses[7] = "Agosto";
    meses[8] = "Setembro";
    meses[9] = "Outubro";
    meses[10] = "Novembro";
    meses[11] = "Dezembro";
    var datatexto = "Hoje È o dia " + dia + " de " + meses[mes] + " de " + ano;
    //document.write ("Hoje È o dia " + dia + " de " + meses[mes] + " de " + ano);
    return datatexto;
}