<style type="text/css" >
    div#conteudo {
        padding:0px;
        margin:0px;
        margin-left:0px;
        width:1000px;
    }
    img#estado {
        float: left;
        margin-right: 10px;
    }

    div#empreendimento {
        float: left;
        margin-top:10px;
        margin-left:10px;
    }
    div#empreendimento img {
        margin-right: 10px;
        margin-bottom: 10px;
        vertical-align: middle;
        cursor: pointer;
    }
    div#empreendimento_l {
        float :left;
        height:110px;
        width :122px;
        width :120px;
        border:0px;
        padding:0px;
        border:1px solid #E2E2E2;
        margin-left:3px;
        margin-bottom:3px;
        vertical-align: middle;
        display:table;
    }
    div.empreendimento_l {
        float :left;
        height:110px;
        swidth :122px;
        width :120px;
        border:0px;
        padding:0px;
        border:3px solid #C0C0C0;
        sbackground:#E2E2E2;
        margin-left:15px;
        smargin-bottom:3px;
        margin-bottom:15px;
        vertical-align: middle;
        display:table-cell;
        sdisplay:table;
        text-align:center;



    }

    div.sempreendimento_l .empreendimento_l_d {

        height:110px;
        width :120px;
        top: 50%;
        left: 50%;
        margin-top: -55px;
        margin-left: -60px;
        position: absolute;
        border: 1px solid black;
    }
    div.empreendimento_l * {
        vertical-align: middle;
    }
    div#sem_empreendimento {
        float :left;
        height:300px;
        width :870px;
        border:3px solid #E5E5E5;
        padding:0px;
        margin:0px;
    }
</style>

<!--[if lt IE 8]>
<style type="text/css">
.box span {
    display: inline-block;
    height: 100%;
}
</style>
<![endif]-->


<?php
//echo '<img id="estado" src="imagens/estado/'.$_GET['estado'].'.jpg" alt="'.$vetEstado[$_GET['estado']].'"/>';
$_SESSION[CS]['g_imagem_logo_obra'] = '';


$sql = '';
$sql .= ' select ';
$sql .= '   em.*, ';
$sql .= '   uf.idt as uf_idt,  ';
$sql .= '   uf.descricao as uf_descricao,  ';
$sql .= '   uf.imagem as uf_imagem  ';
$sql .= ' from  estado uf';
$sql .= ' left join empreendimento em on em.estado = uf.codigo';
$sql .= ' where uf.codigo = '.aspa($_GET['estado']);
$sql .= '   and em.ativo = '.aspa('S');
$sql .= ' order by ordem, descricao';
$rs = execsql($sql);

$path = $dir_file.'/empreendimento/';
$path_uf = $dir_file.'/estado/';
//echo '<div id="empreendimento">';
$Vet_obra = Array();
$Vet_obra = $_SESSION[CS]['g_vet_obras'];
$pri = 0;



foreach ($rs->data as $row) {
    if ($Vet_obra[$row['idt']] == '') {
        continue;
    }
    if ($pri == 0) {
        $pri = 1;
        // echo "<div id='titulo_sel_emp' >";
        // ImagemMostrar(45, 45, $path_uf, $row['uf_imagem'], $row['uf_descricao'], false, 'idt="'.$row['uf_idt'].'"');
        // echo "<span>Selecione o Empreendimento</span>";
        // echo "</div>";

        echo '<div id="empreendimento">';
    }
    if ($row['estado'] != '') {

        echo '<div class="empreendimento_l">';
        //echo '<div class="empreendimento_l_d">';
        //echo '<span></span>';
        ImagemMostrar(100, 100, $path, $row['imagem'], $row['descricao'], false, 'idt="'.$row['idt'].'"');
        //echo '</div>';
        echo '</div>';
    } else {
        echo "Estado sem Empreendimentos cadastrados";
    }
}

if ($pri == 0) {
    echo '<div id="sem_empreendimento">';
    echo "carregar menu do gestor da tabela de itens de Menu";
}
echo '</div>';




?>
<script type="text/javascript" >

    $(document).ready(function () {
        $('.empreendimento_l').each(function() {
            var img = $(this).find('img');

            h = ($(this).height() - img.height()) / 2
            img.css('padding-top', h - (h % 2));
            img.css('padding-bottom', h + (h % 2));
        });

        var timer_obra=null;
        $('div#empreendimento img').click(function() {
            //alert('conteudo.php?prefixo=inc&menu=homeobra&idt=' + $(this).attr('idt'))


            // FuncObra_painel2($(this).attr('idt'));



            //   var idt =  $(this).attr('idt');

            //   alert('teste posiciona obra '+idt) ;

            // esperar loop para delay....
            var delay=1; // 500 milissegundos;
            sleep(delay);

            self.location = 'conteudo.php?prefixo=inc&menu=homeobra&obra_escolhida=S&idt=' + $(this).attr('idt');



            //   var delay=500; // 500 milissegundos;

            //   alert('teste posiciona obra 1...2 '+idt) ;

            //   clearTimeout(timer_obra);

            //   alert('teste posiciona obra 2 '+idt) ;

            //   setTimeout("menu_sistema_nada(1,'"+elemento+"')",ktimeoutw);
            //   setTimeout("chama_conteudo('"+idt+"')" ,delay);

            //   alert('teste posiciona obra 3 '+idt) ;

            return false;
        });
    });

    function chama_conteudo(idt)
    {
        alert('teste posiciona obra  4 '+idt) ;
        self.location = 'conteudo.php?prefixo=inc&menu=homeobra&obra_escolhida=S&idt=' + idt ;
    }

    function FuncObra_painel2(idt)
    {

        var nome=' guy sem efeito ';
        var idt_empreendimento=idt;
        var nm_empreendimento=nome;
        //  alert('teste xxx '+idt+ '    '+idt_empreendimento) ;

        var str='';

        $.post('ajax.php?tipo=obra',{
            async    : false,
            idt_obra : idt_empreendimento,
            nm_obra  : nm_empreendimento
        }
        , function(str) {
            if (str == '') {

                //alert('Obra Posicionada em '+nm_empreendimento);

                self.location = 'conteudo.php';

            } else {
                alert(url_decode(str).replace(/<br>/gi, "\n"));
            }
        });
    }




</script>