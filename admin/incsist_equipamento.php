<style type="text/css">

   div#conteudo {
        padding:0px;
        margin:0px;
        margin-top:5px;
        margin-left:10px;
        width:685px;
    }

    div#conteudo img {
        text-align:center;

    }
    div#link_e_doc  {

       width:685px;
       height: 30px;
       background:#C0C0C0;
       cursor:pointer;

       margin-bottom:20px;
       text-align:center;
       padding-top:10px;
    }
    div#link_e_doc  a {
       text-decoration:none;
       font-family : Arial, Helvetica, sans-serif;
       font-style: normal;
       font-size: 14px;
       font-weight: normal;
       color:#363636;


    }


</style>

<?php




$obra_escolhida=$_GET['obra_escolhida'];
$path    = $dir_file.'/empreendimento/';
$sql = '';
$sql .= ' select ';
$sql .= '   em.*, ';
$sql .= '   uf.idt as uf_idt,  ';
$sql .= '   uf.descricao as uf_descricao,  ';
$sql .= '   uf.imagem as uf_imagem  ';
$sql .= ' from  empreendimento em';
$sql .= ' left join  estado uf on uf.codigo = em.estado';
$sql .= ' where em.idt = '.null($_SESSION[CS]['g_idt_obra']);
$rs = execsql($sql);
//p($sql);

$estado='';
$nm_empreendimento='';
$img_empreendimento='';
$img_home_empreendimento='';
$idt=0;
$link_consultoria='';

foreach ($rs->data as $row)
{
    $estado                  = $row['uf_descricao'];
    $nm_empreendimento       = $row['descricao'];
    $img_empreendimento      = $row['imagem'];
    $img_home_empreendimento = $row['imagem_home'];
    $idt=$row['idt'];
    $link_consultoria        = $row['link_consultoria'];
}

$pathhome= 'imagens/home_obra.jpg';
$pathhomew='';
$pathhomey=$pathhome;
if ($img_home_empreendimento!='')
{
    $pathhome  = $path.$img_home_empreendimento;
    $pathhomew = $path;
    $pathhomey = $img_home_empreendimento;
}



$path=$pathhomew;
$img=$pathhomey;
//$vetConf['url_oas_empreendimentos']
echo "<div id='link_e_doc' > ";
if ($link_e_doc=='')
{
    echo '<a >Essa Exite LINK parametrizado para Acessar o e_doc</a>';
}
else
{
    echo '<a href="'.$link_e_doc.'" target="_blank" title="Clique aqui para acessar Site Consultoria Externa">Clique aqui para ter acesso ao Site da Consultoria Externa</a>';
}
echo "</div>";

//ImagemMostrar(676, 376, $path, $img, $nm_empreendimento, false, 'idt="'.$idt.'"');

//p($vetConf['url_oas_empreendimentos']);
//echo "<script type='text/javascript'>self.location = '".$vetConf['url_oas_empreendimentos']."';</script>";

//p($link_consultoria);

//$link_consultoria='www.oasempreendimentos.com.br';

$link_e_doc = $vetConf['url_e_doc'];
// montar parâmetros
$parcripto='';
$parsemcripto='';
$obra_edoc    = mb_strtoupper($nm_empreendimento);
$parsemcripto = 'p0='.date("Y-n-j H:i:s").'{&}p1=S{&}p2=000911001{&}p3=empreendimento{@}'.$obra_edoc;

//p0=20011-12-23 09:46:41 -> Data/Hora atual no formato aaaa-mm-dd hh:mm:ss
//{&}p1=S -> Mostra Comentario S ou N
//{&}p2=000904001 -> Codigo do Documento
//{&}p3=empreedimento{@}OAS IMOVEIS{$}cpfcnpj{@}33.000.118/0005-00 -> Parametros de consulta

$str = base64_encode($parsemcripto);
$str = base64_encode(GerarStr().$str.GerarStr());
//echo $str;
$parcripto=$str;

$link_e_doc = str_replace('obra123','',$link_e_doc);
$link_e_doc = $link_e_doc.$parcripto;

$link_e_doc = $vetConf['url_oas_equipamento'];
$link_e_doc = "http://localhost/oas_equipamento/";
if ($link_e_doc!='')
{

echo "<script type='text/javascript'> window.open('".$link_e_doc."', '_blank', 'Sistema e_doc'); </script> ";

if ($_GET['pri']!='S')
{
    //echo "<script type='text/javascript'>self.location = 'conteudo.php';</script>";
}

}
?>
<script type="text/javascript" >
    $(document).ready(function () {
        var linkw = '<?php echo $link_e_doc ?>';
       // alert(linkw);
        if (linkw!='')
        {
       //     OpenWinw(linkw, 'Sistema e_doc', 800, $(window).height(), 50, ($(window).width() - 800) / 2,'no');
        }
    });
</script>
