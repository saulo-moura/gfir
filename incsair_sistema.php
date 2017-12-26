<style type="text/css">

    div#conteudo {
        width:1000px;
    }
   div#agradecimento {
        padding:0px;
        margin:0px;
        margin-left:60px;
        width:1000px;
        height:350px;
        sborder:1px solid red;
        margin-top:40px;
        background: url(imagens/home_obra.jpg) center top no-repeat #FFFFFF;

    }

   div#agradecimento_texto {
        padding:0px;
        margin:0px;
        margin-left:60px;
        width:1000px;
        height:30px;
        font-family : Calibri,Arial, Helvetica, sans-serif;
        font-size   : 18px;
        font-style  : normal;
        font-weight : bold;
        color       : #C40000;

        color       : #A2A2A2;


        sborder:1px solid red;
        text-align:center;
        background: #FFFFFF;
        padding-top:10px;
    }

    div#agradecimento_texto a {
        text-decoration:none;

    }

</style>



<?php
Require_Once('configuracao.php');
echo "<div id='agradecimento'>";
echo '</div>';
echo "<div id='agradecimento_texto'>";
echo ' Obrigado por utilizar o site <b>sebrae - Gestão de Credenciados</b>   <br /><br />';

echo ' <a href="index.php"  title="Clique aqui para Retornar ao Site" >Clique aqui para Retornar ao Site</a> ';
echo '</div>';

$tabela="usuario";
$id_lo =$_SESSION[CS]['g_id_usuario'];
$desc_log="Efetuado Logout para ".$_SESSION[CS]['g_login']. ' de '.$_SESSION[CS]['g_nome_completo'];
$nom_tabela="Logout Site GRC";
grava_log_sis($tabela, 'S', $id_lo, $desc_log, $nom_tabela);


unset($_SESSION[CS]);

// <script type="text/javascript">top.close();</script>

?>

