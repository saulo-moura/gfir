<style>
    fieldset.class_frame_t {
        background:#FFBF40;
        border:1px solid #FFFFFF;
    }
    div.class_titulo_t {
        background: #FFBF40;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }
    div.class_titulo_t span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }

    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame_p {
        background:#FFFFFF;
        border:0px solid #FFFFFF;
    }
    div.class_titulo_p {
        background: #2F66B8;
        text-align: left;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        color     : #FFFFFF;
        text-align: left;
        height    : 20px;
        font-size : 12px;
        padding-top:5px;
    }
    div.class_titulo_p span {
        padding:10px;
        text-align: left;
    }
    div.class_titulo_p_barra {
        text-align: left;
        background: #c4c9cd;
        border    : none;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 20px;
    }

    fieldset.class_frame {
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }
    div.class_titulo {
        text-align: left;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }
    div.class_titulo span {
        padding-left:10px;
    }
    div.class_titulo_c {
        text-align: center;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo_c span {
        padding-left:10px;
    }
    Select {
        border:0px;
        height:28px;
    }
    .TextoFixo {
        font-size:12px;
        text-align:left;
        border:0px;
        background:#ECF0F1;
        font-weight:normal;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;
    }
    td#idt_competencia_obj div {
        color:#FF0000;
    }
    .Tit_Campo {
        font-size:12px;
    }
    td.Titulo {
        color:#666666;
    }
    .formulario .detalhe {
        margin-bottom: 10px;
        padding: 5px;
        background-color: #ffffd7;
        border: 0px solid #508098;
        color: #000000;
		width:100%;
		display:block;
    }
    .formulario .detalhe_secao {
        margin-bottom: 10px;
        padding: 5px;
        background-color: #14ADCC;
        border: 1px solid #FFFFFF;
        color: #000000;
		width:100%;
		display:block;
    }

    .formulario .pergunta_cont {
        border: 0px solid #000000;
        margin-bottom: 10px;
        padding: 3px;
    }
	.formulario .pergunta_cont ul {
	    
        padding-bottom: 5px;
    }

    .formulario .pergunta {
        margin-bottom: 10px;
        padding: 5px;
        background-color: #ecf0f1;
        border: 0px solid #508098;
		color:#000000;
    }
    	
    .formulario ul {
        overflow: hidden;
        list-style-type: none;
        padding: 0px;
        margin: 0px;
    }

    .formulario ul > li {
        padding: 0px;
        margin: 0px;
        color: #00297b;
		color: #000000;
    }

    .formulario ul > li .detalhe {
        margin-bottom: 10px;
    }

    .formulario ul > li > label {
        cursor: pointer;
        display: block;
        margin: 3px 0px;
    }

    .formulario ul > li > label > input {
        cursor: pointer;
        vertical-align: top;
        padding: 0px;
        margin: 0px;
        margin-right: 5px;
		
    }

    .formulario ul > li > div > textarea {
        background: #F6F6F6;
        color: #000000;
        margin: 0px;
        margin-top: 3px;
        padding: 0px;
        border: 0px solid #508098;

        xwidth: 846px;
        height: 45px;
		
        width: 100%;
        xdisplay: none;
    }
	#evidencia {
	    display:block;
	    width: 70%;
		xborder:1px solid red;
		padding-top:10px;
		display: none;
	}
	.frame {
        border: 0px solid #508098;
    }
	.cab_rel_sist {
      background:#0000FF;
	  color:#FFFFFF;
	  font-size:14;
    }
	.cab_rel {
      background:#F1F1F1;
	  color:#000000;
	  font-size:14;
    }
    .tabela_rel {
	  padding-left:5%;
    }
</style>

<?php
$tabela = '';
$idt_reg_aoe = $_GET['id'];

$class_frame_t   = "class_frame_t";
$class_titulo_t  = "class_titulo_t";

$class_frame_f   = "class_frame_f";
$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;
//
// Acessar registro do aoe
//
$sql = '';
$sql .= " select grc_ne.* ";
$sql .= ' from grc_nan_estrutura grc_ne';
$sql .= ' where grc_ne.idt = '.null($idt_reg_aoe);
$rs = execsql($sql);
$row = $rs->data[0];

$idt_aoe = $row['idt_usuario'];

$sql = '';
$sql .= " select grc_at.* ";
$sql .= ' from grc_atendimento grc_at';
$sql .= ' where grc_at.idt_consultor = '.null($idt_aoe);
$rs = execsql($sql);
$row = $rs->data[0];

//echo " vvvvvvvvvvvvvvvvvvvvvvvvvv ";
   $vetsistemas= Array();
   $vetsistemas['grc']='CRM|Sebrae'; 
   $vetParametros['sistemas']=$vetsistemas;
   $vetEstatisticaUtilizacao=Array();
   PLU_EstatisticaUtilizacao($vetParametros,$vetEstatisticaUtilizacao);
   //p($vetEstatisticaUtilizacao);
   
   echo "<table class='tabela_rel' width='90%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
   ForEach ($vetEstatisticaUtilizacao as $sistema => $vetSistema)
   {
      if ($sistema == 'geral')
	  {
	      $QTDTGeral = $vetEstatisticaUtilizacao[$sistema]['QTDT'];
		  continue;
	  }
	  else
	  {
	      //
	      // Por sistema
		  //
		  echo "<tr class='cab_rel_sist'>  ";
		  echo "<td colspan='2' >  ";
		  echo "Sistema : {$sistema}";
		  echo "</td>  ";
		  echo "</tr>  ";
		  echo "<tr class='cab_rel'>  ";
		  echo "<td>  ";
		  echo "Login";
		  echo "</td>  ";
		  echo "<td>  ";
		  echo "Nome Completo";
		  echo "</td>  ";
		  echo "</tr>  ";
		  ForEach ($vetSistema as $login => $row)
		  {
		      $login         =  $row['login'];
			  $nom_usuario   =  $row['nom_usuario'];
			  echo "<tr class=''>  ";
			  echo "<td>  ";
			  echo $login;
			  echo "</td>  ";
			  echo "<td>  ";
			  echo $nom_usuario;
			  echo "</td>  ";
			  echo "</tr>  ";
		  } 
		  
		  
      } 
	} 
   ForEach ($vetEstatisticaUtilizacao as $sistema => $vetSistema)
   {
		if ($sistema != 'geral')
		{
		    continue;
		}
		
		echo "<tr class='cab_rel_sist'>  ";
		echo "<td colspan='2' >  ";
		echo "Quantidade de Usuários por Sistema";
		echo "</td>  ";
		
		echo "</tr>  ";
		echo "<tr class='cab_rel'>  ";
		echo "<td>  ";
		echo "Sistema";
		echo "</td>  ";
		echo "<td>  ";
		echo "Quantidade usuários";
		echo "</td>  ";
		echo "</tr>  ";
		ForEach ($vetSistema as $sistemaw => $VetQtd)
		{
		  $style   = ''; 
		  if ($sistemaw=='geral')
		  {
		      $sistemaw='Total Geral';
			  $style   =' style = background:#FF0000; color:#FFFFFF; ';
		  }
		  $qtd_usuarios   =  $VetQtd['qtd_usuarios'];
		  echo "<tr class=''>  ";
		  echo "<td {$style} >  ";
		  
		  echo $sistemaw;
		  echo "</td>  ";
		  echo "<td {$style}>  ";
		  $qtd_usuariosw = format_decimal($qtd_usuarios,0);
		  echo $qtd_usuariosw;
		  echo "</td>  ";
		  echo "</tr>  ";
		} 
	} 	
	
   echo "</table>";	
?>