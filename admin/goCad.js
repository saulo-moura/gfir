var MenuPodeUsar = false;

function MenuAbre(linha, evt) {
    if (typeof evt == 'undefined') {
        evt = window.event;
    }

    if (MenuPodeUsar) {
        var div = document.getElementById('MenuGeral');

        if (linha < 0) {
            div.style.display = 'none';
        } else {
            Conf_Menu(goCad[linha], evt);
        }
    }
}

function Conf_Menu(vet, evt) {
    var div = document.getElementById('MenuGeral');
    var cont = MenuGeral.document.getElementById('MenuConteudo');

    var pos_x = 0;
    var pos_y = 0;

    if (document.all) { // IE
        pos_x = (document.documentElement && document.documentElement.scrollLeft) ? document.documentElement.scrollLeft : document.body.scrollLeft;
        pos_y = (document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop : document.body.scrollTop;
        pos_x += evt.clientX;
        pos_y += evt.clientY;
    } else { //Bons Navegadores
        pos_x = evt.pageX;
        pos_y = evt.pageY;
    }

    div.style.display = 'block';
    div.style.width = '210px';
    div.style.top = (pos_y - 5) + 'px';
    div.style.left = (pos_x - 5) + 'px';
    cont.innerHTML = Cria_Menu(vet);

    var alt_linha = 0;
    
    for (i = 0; i < vet.length; i++) {
        alt_linha += MenuGeral.document.getElementById('link' + i).offsetHeight;
    }
    
    div.style.height = alt_linha + 'px';
}

function Cria_Menu(vet) {
    var html = '';

    for (i = 0; i < vet.length; i++) {
        html += vet[i];
    }

    return html;
}
