
<style type="text/css">


    table.Geral_ax {
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-weight:bold;
        color: #F7F7F7;
        padding-left:10px;
        text-align: center;
        border-collapse: collapse;
        background: #EBEBEB;
    }
    tr.linha_cab_tabela_ax {
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #900000;
        font-weight: bold;
        text-align: left;
        border-collapse: collapse;
        background-color: #C2C2C2;

    }
    td.titulo_cab_ax {
        padding-top:0px;
        padding-bottom:5px;
        padding-right: 20px;
        color: #900000;
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #900000;
        font-weight: bold;
        sborder-bottom:2px solid #900000;
    }

    tr.linha_tabela_ax {
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #000000;
        font-weight: bold;
        text-align: left;
        border-collapse: collapse;
        background-color: #FFFFFF;
    }
    td.linha_campo_ax {
        padding-top:0px;
        padding-bottom:5px;
        padding-right: 20px;
        border-bottom:1px solid #000000;
    }
    div.barra_ferramentas {
        sbackground: #FF0000;
        smargin-bottom:10px;
        swidth: 70%;
    }

    Table.Menu_print {
        background:#FFFFFF;
        width: 100%;
        }

   div#gerar_acidente {
       display:none;
       background:#FF0000;
       cursor: pointer;
       font-family: Calibri, Arial, Helvetica, sans-serif;
       font-size: 16px;
       color: #FFFFFF;
       font-weight: bold;
   }

   div.barra_cat_atual {
        background: #D7D7D7;
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 16px;
        color: #4E4E4E;
        font-weight: bold;
        text-align:center;
        width:100%;
        margin-top:10px;
        height:25px;
    }

</style>


<script type="text/javascript" src="gsd_upload/js/ajaxupload.3.5.js" ></script>
<link rel="stylesheet" type="text/css" href="gsd_upload/styles.css" />
</script>



<?php

$vazio    = $_GET['vazio'];
$acao     = $_GET['acao'];
$idt_cat  = null($_GET['id']);
$arqrcat  = $_GET['arqrcat'];
$idt_empreendimento  = $_GET['idt_empreendimento'];
$menu='st_acidente';
$_SESSION[CS]['g_nom_tela']='Importação CAT - INSS';

echo "<div align='center' style='background:#FFFFFF; padding-top:10px;'>";


// mostrar anexos existentes
echo "<div class='barra_ferramentas'>";
echo "<table cellspacing='0' cellpadding='0' width='100%' border='0'>";
echo "<tr>";
echo "<td width='20'>";
echo "<a HREF='#' onclick=\"top.close();\"><img class='bartar' title='Voltar para Tela anterior' align=middle src='relatorio/voltar_ie.jpg'></a>";
echo "</td>";
if ($vazio!='S')
{
    echo "<td width='20'>";
    echo "<a HREF='#' onclick=\"self.print();\"><img class='bartar' align=middle src='relatorio/visualiza_imprime.jpg'></a>";
    echo "</td>";
    //echo "<td>&nbsp;</td>";
    echo "   <td class='titulo_cab_ax' style='text-align:center; font-size:18px;' >CAT - INSS : Cópia da oas empreendimentos</td> ";
    echo "</tr>";
    echo "</table>";
    echo "</div>";

}
else
{
    echo "   <td class='titulo_cab_ax' style='text-align:center; font-size:18px;' >CAT - INSS : Cópia da oas empreendimentos</td> ";
    echo "</tr>";
    echo "</table>";
    echo "</div>";


    echo "<div class='barra_ferramentas'>";
	echo "	<h3>&raquo; Favor executar o Upload da CAT para o Sistema Catalogar.</h3>";
	//echo "	<!-- Upload Button, use any id you wish--> ";
	echo '	<div id="upload" ><span>Escolha a CAT no seu Micro<span></div><span id="status" ></span>';
//	echo '	<ul id="files" ></ul>';


    echo "<div id='gerar_acidente' class='barra_ferramentas'>";
//    echo '<input type="file" onkeydown="return !(event.keyCode == 13)" size="60" class="Texto" name="arquivo_cat" id="arquivo_cat">';
    echo "<a onclick=\"return importar_dados_cat();\"><img class='bartar' align=middle src='relatorio/inss_cat.jpg' swidth='25' sheight='25' title='Executa importação de dados do CAT INSS para sistema oas empreenedimentos' > Clique aqui para importar dados da CAT</a>";
    echo "</div>";
	echo '	<div id="files" ></div>';

    echo "</div>";

}



    echo "<div class='barra_ferramentas'>";

    echo "<div class='barra_cat_atual'>";
    echo "CAT Cadastrada (ATUAL)";
    echo "</div>";

//p($arqrcat);

//   arqrcat = 'cat.htm';
     if (file_exists($arqrcat)) {
         Require_Once($arqrcat);
     }
     else
     {
         if ($acao=='inc')
         {
             echo "<br><br><div align='center' class='Msg'>Favor Proceder a Importação da CAT.{$arqrcat}</div>";
           //  onLoadPag();
           //  FimTela();
           //  exit();
         }
         else
         {
             echo "<br><br><div align='center' class='Msg'>Favor Proceder a Importação da CAT.{$arqrcat}</div>";

         }
     }

     echo "</div>";



echo "</div>";
//<div id="area">
//<p> <input type="file"    id="file" /> </p>
//<p> <input type="button"        id="load"       value="Carregar..." /> </p>
//</div>

if ($vazio=='S')
{

?>
<script type="text/javascript">
    var file_upload_novo='';
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: 'gsd_upload/upload-file.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
			//	 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                if (! (ext && /^(html|htm)$/.test(ext))){
                    // extension is not allowed
					//status.text('Only JPG, PNG or GIF files are allowed');
					status.text('Apenas arquivos do tipo HTML, HTM, MHT são permitidos');
                    obj=document.getElementById('gerar_acidente');
                    if (obj != null) {
                        obj.style.display='none';
                    }
                    obj=document.getElementById('files');
                    if (obj != null) {
                        obj.innerHTML='';
                    }

                    file = 'erro.html';
                 //   $('<div></div>').appendTo('#files').html('<iframe src="./gsd_upload/uploads/'+file+'" style="align:center;" width="100%" height="600px" scrolling="auto"></iframe>').addClass('success');
                 
                    $('<div></div>').appendTo('#files').html('<iframe src="./gsd_upload/uploads/'+file+'" style="align:center;" width="100%" height="600px" scrolling="auto"></iframe>').addClass('success');
					return false;
				}
				//status.text('Uploading...');
				status.text('Aguarde... Tranferindo Arquivo...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				if(response==="error"){
					$('<li></li>').appendTo('#files').text(file).addClass('error');
                    obj=document.getElementById('gerar_acidente');
                    if (obj != null) {
                        obj.style.display='none';
                    }
				} else{
				//	$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');

				 //   $('<li></li>').appendTo('#files').html('<div >'+file+'"</div>');
				 //   src='menu/quickmenu.php'

//				    $('<li></li>').appendTo('#files').html('<iframe src="./gsd_upload/uploads/'+file+'"></iframe>'+file).addClass('success');
                    obj=document.getElementById('files');
                    if (obj != null) {
                        obj.innerHTML='';
                    }

				    //$('<div></div>').appendTo('#files').html('<iframe src="./gsd_upload/uploads/'+file+'" style="align:center;" width="100%" height="600px" scrolling="auto"></iframe>').addClass('success');
				    
				    $('<div></div>').appendTo('#files').html('<iframe src="./obj_file/st_acidente/'+file+'" style="align:center;" width="100%" height="600px" scrolling="auto"></iframe>').addClass('success');

                    obj=document.getElementById('gerar_acidente');
                    if (obj != null) {
                        obj.style.display='block';
                    }

                    file_upload_novo=response;

				}
			}
		});

	});




   function importar_dados_cat()
   {
      //alert(' importar ');
      var idt_cat = <?php echo  $idt_cat ?>;
      var arq_cat = '<?php echo  $arq_cat ?>';
      var arq_cat = file_upload_novo;

      var acao    = '<?php echo $acao ?>';
      var idt_empreendimento = <?php echo $idt_empreendimento ?>;

      objs=document.getElementById('arquivo_cat');
      if (objs != null)
      {
          arq_cat = objs.value;
      }

//       alert(' importar vai '+arq_cat+ ' acao = '+acao);
//      $("p").each(function () {
//           var cont = $(this).html();
//           alert(' importar '+cont);
//      });

//     return false;


      if (acao=='inc')
      {
         $.post('ajax.php?tipo=inclui_acidente',{
            async: false,
            idt_catw   : idt_cat,
            arq_catw   : arq_cat,
            acaow      : acao,
            idt_empreendimentow : idt_empreendimento
         }
         , function(str) {
            if (str == '') {
                alert(' Fim normal da Inclusão arquivo '+arq_cat);
      //          var wxs = "http://localhost/oas_PCO/admin/";
    //            parent.location = wxs.'conteudo.php?prefixo=listar&menu=st_acidente&class=0&acao=alt&idt0='+idt_empreendimento+'&id='+idt_cat;
                window.close();
            } else {
                alert(url_decode(str).replace(/<br>/gi, "\n"));
            }
         });
      }

      if (acao=='alt')
      {
         $.post('ajax.php?tipo=altera_acidente',{
            async: false,
            idt_catw   : idt_cat,
            arq_catw   : arq_cat,
            acaow      : acao,
            idt_empreendimentow : idt_empreendimento
         }
         , function(str) {
            if (str == '') {
                alert(' Fim normal da Alteração arquivo '+arq_cat);
                window.close();
                // self.location = 'conteudo.php?prefixo=cadastro&menu=st_acidente&class=0&acao=alt&idt0='+idt_empreendimento+'&id='+idt_cat;
            } else {
                alert(url_decode(str).replace(/<br>/gi, "\n"));
            }
         });
      }

    //  alert(' importar 2222'+arq_cat);

     /*
      $(document).ready(function () {

          html = '<a class="Titulo" onclick="return exportar_obra_residuo_quantidade();" href="#"><div><img border="0" title="Exportar Quantidades de Resíduos" src="imagens/exportar.gif">Exportar</div></a>';
          $('#barra_full td').append(html);
          html = '<a class="Titulo" onclick="return importar_obra_residuo_quantidade();" href="#"><div><img border="0" title="Importar Quantidades de Resíduos" src="imagens/importar.gif">Importar</div></a>';
          $('#barra_full td').append(html);

    */



   /*

      });
   */

      return false;
   }
</script>


<script type="text/javascript">

        function getFile(e){
                var iframe = document.createElement("IFRAME");
                //iframe.src = "file://" + document.getElementById("file").value;
                iframe.src = "file://" + document.getElementById("file").value;
                iframe.id                  = "iframe"
                iframe.style.width  = "100%";
                iframe.style.height = "300px";
                document.getElementById("area").appendChild(iframe);
        }

//        window.onload = function(){
//                document.getElementById('load').onclick  = getFile;
//        }

</script>


<script language="JavaScript1.2" src="rov_array.txt"></script>

<script language="JavaScript1.2">

//
// texto no servidor = ao que esta abaixo
// var ROV_ARRAY = ['Variavel 01','Variavel 02','Variavel 03','Variavel 04'];
//

// alert(ROV_ARRAY[1]);


</script>

<?php

}

?>





