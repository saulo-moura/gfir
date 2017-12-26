<style>
    div#painel_geral {
        xmargin: 0px 30px;
    }
    div#painel_cont {
        xborder: 1px solid;
    }
    div#painel_cab {
        xborder: 1px solid;
        background:#14ADCC;
        color:#FFFFFF;
        text-align:center;
        height:32px;
        padding: 5px 0px; 
        font-weight: bold;
        margin-bottom:10px; 
        xborder:1px solid red;
    }
    div#painel_rod {
        border: 1px solid;
        background:#0000ff;
        color:#FFFFFF;
        text-align:center;
    }
    div#barra_a td {
        font-size: 20px;
        font-weight: bold;
        color:#2A5696;
    }
    div#painel_tit {

        xborder:1px solid red;

    }
    div#painel_controle {
        xborder:1px solid red;
    }
    div#painel_controle a {
        font-size: 16px;
        font-weight: bold;
        color:#2A5696;
        text-decoration:none;
    }
</style>



<div id="painel_geral">
    <?php
    if ($_SESSION[CS]['g_mostra_barra_home'] == 'S') {
	    $hint = "Barra de tarefas para o Administrador do PIR";
        echo "<div id='painel_cab' title='$hint'>";
        //echo "<div id='painel_tit' style='width:90%; text-align:center; float:left; '>RELACIONAMENTO COM O CLIENTE</div>";
		echo "<div id='painel_tit' style='width:90%; text-align:center; float:left; '></div>";
        $link = "conteudo.php?prefixo=inc&painel_btvoltar_rod=N&mostra_menu=N&menu=plu_seguranca&origem_tela=painel&cod_volta=home";
        $link_a = '<a href="'.$link.'"><img src="imagens/controle_seguranca_32.png" title="Controle de Segurança"/></a>';
        echo "<div id='painel_controle' style='width:9%; float:right;'>{$link_a}</div>";
        echo "</div>";
    }
    //$largura_tela = 810;
    $codigo_painel = 'home';
    require_once 'painel.php';
    //echo "<div id='painel_rod'>Teste depois...</div>";
    ?>
</div>


