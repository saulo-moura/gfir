<?php
// <INICIO DO ARQUIVO>                            //
////////////////////////////////////////////////////
//  GSD - V.1.0 - Janeiro 2010                    //
//  Classe de Métodos Gerais                                     //
//  Classe deve ser Instanciada apenas uma vez para o Sistema    //
////////////////////////////////////////////////////
// <INICIO CLASSE TStringsFuncoes - Trata Funções String>






class TStringsFuncoes
{
    public function __construct()
    {
    }
    public function __destruct()
    {
    }
    //
    // Funções Básicas
    //
    // Retorna Parte de uma String.
    // $conteudo -> String
    // $inicio   -> Posição Inicial na String 0 até n
    // $comprimento -> Comprimento da Cadeia de caracteres a ser lida
    // Se comprimento for negativo, conta n caracteres antes do final
    // Corresponde a Tamanho da String + (comprimento)   (+1)
    // Se inicio for negativo, conta inicio como sendo:
    // Tamanho da String + (inicio) (+1)
    public function subs($conteudo, $inicio, $comprimento)
    {
        if  ($comprimento=='Undefined')
        {
            $comprimentow=strlen($conteudo);
        }
        else
        {
            $comprimentow=$comprimento;
        }
        return substr($conteudo,$inicio,$comprimentow);
    }
    // Retorna String em maiúsculas.
    public function mai($str)
    {
        return mb_strtoupper($str);
    }
    // Retorna String em minúsculas.
    public function min($str)
    {
        return mb_strtolower($str);
    }
    // Retorna String preenchido com conteudo definido
    // str -> String Inicial a ser completada
    // tamanho -> Comprimento da String a ser retornada
    // String de Preenchimento
    // Tipo -> D -> Direita
    //         E -> Esquerda
    //         A -> Direita e Esquerda
    public function pre($str,$tamanho,$complemento = '',$tipo='E')
    {
        $a=$str;
        if  ($tipo=='D')
        {
            $a=str_pad($str,$tamanho,$complemento, STR_PAD_RIGHT);
        }
        else
        {
            if  ($tipo=='A')
            {
                $a=str_pad($str,$tamanho,$complemento, STR_PAD_BOTH);
            }
            else
            {   // ASSUMIR À ESQUERDA
                $a=str_pad($str,$tamanho,$complemento, STR_PAD_LEFT);
            }
        }
        return $a;
    }
    // Retorna String inicial repetida com o número de vezes do segundo parametro.
    // str -> String Inicial a ser repetida
    // quantidade de vezes a repetir
    public function rep($str,$quantidade)
    {
        return str_repeat($str,$quantidade);
    }
    // Retorna o  Tamanho da String.
    // str -> String Inicial a ser avaliado o Tamanho
    public function tam($str)
    {
        return strlen($str);
    }
    
    // Retorna o  String com parte substituida.
    // str -> String Inicial a ser avaliado para Troca
    // procurar -> String a Encontrar para ser substituida
    // substituirpor -> String que deve substituir a String com o conteudo de procurar.
    public function sub($str,$procurar,$substituirpor)
    {
        return str_replace($procurar,$substituirpor,$str);
    }
    // Retorna a posicao na String da String informada em procurar
    // str -> String Inicial a ser avaliado para Troca
    // procurar -> String a Encontrar para ser substituida
    // ignorar -> Quantidade de caracteres a ser ignorada.
    public function pos($str,$procurar,$ignorar=0)
    {
        return strpos($str,$procurar,$ignorar);
    }
    //
    // Caracteres de EScape
    //
    // Nova linha, proporciona uma quebra de linha
    public function nli()
    {
        return '\n';
    }
    // Retorno de Carro
    public function rca()
    {
        return '\r';
    }
    // Tabulação
    public function tab()
    {
        return '\t';
    }
    // Barra Invertida
    public function bin()
    {
        return '\\';
    }
    // aspas duplas
    public function adu()
    {
        return '\"';
    }
    // S´mbolo de $ - cifrão
    public function sci()
    {
        return '\$';
    }
    
    public function aspa( $campo, $tipo="'")
    {
        $ret=$tipo.$campo.$tipo;
        return $ret;
    }
    
    public function branco($tam=1)
    {
        $ret=str_repeat(' ',$tam);
        return $ret;
    }


    
    
    //
    // Funções derivadas das Básicas
    //
    // Retorna Primeira Posicao String em maiúsculas.
    public function pri_mai($str)
    {
        $p= $this->subs($str,0,1);
        $p= $this->mai($p);
        $p= $p.$this->subs($str,1,strlen($str)-1);
        return $p;
    }
    // Retorna Primeira Posicao String em minúsculas.
    public function pri_min($str)
    {
        $p= $this->subs($str,0,1);
        $p= $this->min($p);
        $p= $p.$this->subs($str,1,strlen($str)-1);
        return $p;
    }
    
    public function p($valor)
    {
        echo '<pre>';
        print_r($valor);
        echo '</pre>';
    }
}
// <FIM CLASSE TStringsFuncoes>
// <INICIO CLASSE TDataFuncoes - Trata Datas>
class TDataFuncoes
{
    public function __construct()
    {
    }
    public function __destruct()
    {
  }

  /**
   * Esta função retorna uma data escrita da seguinte maneira:
   * Exemplo: Terça-feira, 17 de Abril de 2007
   * @author Leandro Vieira Pinho [http://leandro.w3invent.com.br]
   * @param string $strDate data a ser analizada; por exemplo: 2007-04-17 15:10:59
   * @return string
   */
   function formata_data_extenso($strDate)
   {
    	// Array com os dia da semana em português;
	    $arrDaysOfWeek = array('Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado');
	    // Array com os meses do ano em português;
	    $arrMonthsOfYear = array(1 => 'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
	    // Descobre o dia da semana
	    $intDayOfWeek = date('w',strtotime($strDate));
	    // Descobre o dia do mês
	    $intDayOfMonth = date('d',strtotime($strDate));
	    // Descobre o mês
	    $intMonthOfYear = date('n',strtotime($strDate));
	    // Descobre o ano
	    $intYear = date('Y',strtotime($strDate));
	    // Formato a ser retornado
	    return $arrDaysOfWeek[$intDayOfWeek] . ', ' . $intDayOfMonth . ' de ' . $arrMonthsOfYear[$intMonthOfYear] . ' de ' . $intYear;
    }
    
    function SomarData($data, $dias, $meses, $ano)
    {
       /*www.brunogross.com*/
       //passe a data no formato dd/mm/yyyy
       $data = explode("/", $data);
       $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses,
       $data[0] + $dias, $data[2] + $ano) );
       return $newData;
    }
    
    // Passando data do banco "AAAA-MM-DD" para "DD/MM/AAAA"
    function mostraData ($data)
    {
        if ($data!='')
        {
            return (substr($data,8,2).'/'.substr($data,5,2).'/'.substr($data,0,4));
        }
        else
        {
            return '';
        }
    }

    // Passando data do text box "DD/MM/AAAA" para "AAAA-MM-DD"
    function gravaData ($datasql)
    {
        if ($datasql != '')
        {
            return (substr($datasql,6,4).'-'.substr($datasql,3,2).'-'.substr($datasql,0,2));
        }
        else
        {
             return '';
        }
    }
    function gravaDatahora ($datasql)
    {
        if ($datasql != '')
        {
            return (substr($datasql,6,4).'-'.substr($datasql,3,2).'-'.substr($datasql,0,2).' '.substr($datasql,11,8));
        }
        else
        {
             return '';
        }
    }
    
    // Formata data aaaa-mm-dd para dd/mm/aaaa
    function databr($databr)
    {
	    if (!empty($databr))
        {
	        $p_dt = explode('-',$datasql);
	        $data_br = $p_dt[2].'/'.$p_dt[1].'/'.$p_dt[0];
	        return $data_br;
	    }
    }
    // Formata data dd/mm/aaaa para mm/dd/aaaa
    function dataus($dataus)
    {
	    if (!empty($dataus))
        {
	        $p_dt = explode('/',$databr);
	        $data_us = $p_dt[1].'/'.$p_dt[0].'/'.$p_dt[2];
	        return $data_us;
	    }
    }

    // Formata data dd/mm/aaaa para aaaa-mm-dd
    function datasql($datasql)
    {
	    if (!empty($databr))
        {
	        $p_dt = explode('/',$datasql);
	        $data_sql = $p_dt[2].'-'.$p_dt[1].'-'.$p_dt[0];
	        return $data_sql;
	    }
    }
    function datahoje($formato='')
    {
        $dt_ho=date('d/m/Y');
        $ret=$dt_ho;
  	    if (empty($formato))
        {
           // retorna dd/mm/aaaa;
           return $ret;
	    }
	    if ($formato=='PSGRS')
        {
           // retorna aaaa-mm-dd;
           $ret= TDataFuncoes::gravaData ($ret);
           return $ret;
	    }

	    return $ret;
    }
    
    function datahorahoje($formato='')
    {
        $dt_ho=date('d/m/Y h:i:s');
        $ret=$dt_ho;
        
  	    if (empty($formato))
        {
           // retorna dd/mm/aaaa;
           return $ret;
	    }
	    if ($formato=='PSGRS')
        {
           // retorna aaaa-mm-dd hh:mm:ss;
           $ret= TDataFuncoes::gravaDatahora ($ret);
           return $ret;
	    }

	    return $ret;
    }
    
    
    
    
    
}
// <FIM CLASSE TDataFuncoes>
// <INICIO CLASSE TGlobal - Trata Variáveis Globais para o Sistema>
class TGlobal
{
    // Váriáveis de Classes Primárias - Funções
    public $sis;  // Classe de Funções de Identificação do Sistema
    public $str;  // Classe de Funções Básicas de tratamento de Strings
    public $dta;  // Classe de Funções Básicas de tratamento de Datas
    //
    public function __construct()
    {   // Instanciar Classes Básicas do Sistema
        $this -> str = new TStringsFuncoes();
        $this -> dta = new TDataFuncoes();
      // $this -> sis = new TIdentificaSistemaFuncoes();
    }
    public function __destruct()
    {
        $this -> str = NULL;
        $this -> dta = NULL;
      //  $this -> sis = NULL;
    }
    public function substring($conteudo, $inicio, $comprimento)
    {
        return $this -> str -> subs($conteudo,$inicio,$comprimento);
    }
    public function preenche($str,$tamanho,$complemento = '',$tipo='E')
    {
        return $this -> str -> pre($str,$tamanho,$complemento,$tipo);
    }
    public function repete($str,$quantidade)
    {
        return $this -> str -> rep($str,$quantidade);
    }
    public function tamanho($str)
    {
        return $this -> str -> tam($str);
    }
    public function substituir($str,$procurar,$substituirpor)
    {
        return $this -> str -> sub($str,$procurar,$substituirpor);
    }
    public function posicao($str,$procurar,$ignorar=0)
    {
        return $this -> str -> pos($str,$procurar,$ignorar);
    }
    public function maiusculas($conteudo)
    {
        return $this -> str -> mai($conteudo);
    }
    public function minusculas($conteudo)
    {
        return $this -> str -> min($conteudo);
    }
    public function primeira_maiuscula($conteudo)
    {
        return $this -> str -> pri_mai($conteudo);
    }
    public function primeira_minuscula($conteudo)
    {
        return $this -> str -> pri_min($conteudo);
    }
    public function quebra_linha()
    {
        return $this -> str -> nli();
    }
    public function retorno_carro()
    {
        return $this -> str -> rca();
    }
    public function tabulacao()
    {
        return $this -> str -> tab();
    }
    public function barra_invertida()
    {
        return $this -> str -> bin();
    }
    public function aspas_duplas()
    {
        return $this -> str -> adu();
    }
    public function cifrao()
    {
        return $this -> str -> sci();
    }
    public function mostra_campo($valor)
    {
        $this -> str -> p($valor);
        return true;
    }
}
// <FIM CLASSE TGlobal>


// <FIM CLASSE EXCEL>

class TGSD_excel
{
    private $arquivo_excel='';
    private $vetor_abas      = Array();
    private $nome_aba        = '';
    
    private $data            = '';

    private $vetor_row       = Array();
    public function __construct($arquivo_excel)
    {
        $this -> data          = '';
        $this -> arquivo_excel = $arquivo_excel;
    }
    public function __destruct()
    {
        $this -> arquivo_excel = '';
        $this -> vetor_abas    = Array();
        $this -> nome_aba      = '';
        $this -> data          = '';
        //$this -> vetor_row     = Array(vetor_colw = Array());
    }
    public function iniciar_aba_excel($nome_aba)
    {
        $this -> nome_aba        =  $nome_aba;
        $this -> vetor_row   = Array();
    }
    public function finalizar_aba_excel($nome_aba)
    {
        $this -> vetor_abas[$nome_aba] = $this -> vetor_row;
    }
    public function carregar_aba($l,$c,$ac,$ad,$valor)
    {
           $attr=Array();
           $attr['tipo']    = $ad['tipo'];
           $attr['StyleID'] = $ac['StyleID'];
           $attr['BgID']    = $ac['BgID'];
           $attr['MergeAcross']    = $ac['MergeAcross'];
           $attr['valor']=$valor;
           $this -> vetor_row[$l][$c] = $attr;

    }
    public function gerar_xml()
    {



           $this -> cabecalho_xml();
          // $p = new TStringsFuncoes;
          // $p -> p($this -> vetor_abas);
           
           foreach ($this -> vetor_abas as $aba => $vet_aba)
           {
                // inicializa Aba
                $this -> cabecalho_Worksheet($aba);
                foreach ($vet_aba as $l => $vet_linha)
                {

                    $this -> cabecalho_Row();
                    foreach ($vet_linha as $c => $vet_propriedades)
                    {
                        $tipo  = $vet_propriedades['tipo'];
                        if  ($tipo=='')
                        {
                             $tipo='String';
                        }
                        
                        $valor   = $vet_propriedades['valor'];
                        

                        
                        $StyleID = $vet_propriedades['StyleID'];
                        $BgID    = $vet_propriedades['BgID'];
                        $MergeAcross = $vet_propriedades['MergeAcross'];
                        if  ($StyleID!='')
                        {
                             $StyleID='ss:StyleID="'.$StyleID.'"';
                        }
                        else
                        {

                             $StyleID='ss:StyleID="'.'Default_GSD'.'"';
                        }
                        if  ($BgID!='')
                        {
                             $StyleID='ss:StyleID="'.$BgID.'"';
                        }
                        if  ($MergeAcross!='')
                        {
                             $MergeAcross='ss:MergeAcross="'.$MergeAcross.'"';
                        }

                        $this -> data .= "<Cell {$MergeAcross} {$StyleID} >";
                        $this -> data .= "<Data ss:Type='{$tipo}'>";
                        $this -> data .= $valor;
                        $this -> data .= "</Data>";
                        $this -> data .= "</Cell>";
                    }
                    $this -> finaliza_Row();

                }
                $this -> finaliza_Worksheet($aba);
           }
           $this -> finaliza_xml();
    }
    


    private function cabecalho_Worksheet($aba)
    {
        $this -> data .= "<Worksheet ss:Name='".$aba."'><Table>";
        $this -> data .= "";
        
        
        $this -> data .= '<Column ss:Index="2" ss:Width="48.75"/>';
        $this -> data .= '<Column ss:Width="66.75"/>';
        $this -> data .= '<Column ss:Width="53.25"/>';
        $this -> data .= '<Column ss:Width="72.75"/>';
        $this -> data .= '<Column ss:AutoFitWidth="0" ss:Width="70.5"/>';
        $this -> data .= '<Column ss:AutoFitWidth="0" ss:Width="67.5"/>';
        $this -> data .= '<Column ss:AutoFitWidth="0" ss:Width="105.75"/>';

    }
    private function finaliza_Worksheet($aba)
    {
        $this -> data .= "";
        $this -> data .= "</Table></Worksheet>";
    }

    private function cabecalho_Row()
    {
        $this -> data .= "<Row>";
    }
    private function finaliza_Row()
    {
        $this -> data .= "</Row>";
    }
    private function cabecalho_xml()
    {
        $this -> data .= "<?xml version='1.0'?>
                 <?mso-application progid='Excel.Sheet'?>
                 <Workbook xmlns='urn:schemas-microsoft-com:office:spreadsheet' xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns:ss='urn:schemas-microsoft-com:office:spreadsheet' xmlns:html='http://www.w3.org/TR/REC-html40'>";
                 
                 
$this -> data .= "<Styles>";

$this -> data .= ' <Style ss:ID="Default_GSD" ss:Name="Normal">';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/>';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0C0C0" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '   <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat/>';
$this -> data .= '   <Protection/>';
$this -> data .= '  </Style>';


$this -> data .= '  <Style ss:ID="s21"> ';
$this -> data .= '     <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '     <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>  ';
$this -> data .= '     <NumberFormat ss:Format="Standard"/>  ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0C0C0" />';
$this -> data .= '   </Borders>  ';

$this -> data .= '    </Style>  ';


$this -> data .= '  <Style ss:ID="s21_1"> ';
$this -> data .= '   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/> ';

$this -> data .= '     <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '     <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>  ';
$this -> data .= '     <NumberFormat ss:Format="Standard"/>  ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#666666" />';
$this -> data .= '   </Borders>  ';

$this -> data .= '    </Style>  ';




$this -> data .= '   <Style  ss:ID="s22"> ';
$this -> data .= '     <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0C0C0" />';
$this -> data .= '   </Borders>  ';

$this -> data .= '     <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>  ';
$this -> data .= '     <NumberFormat ss:Format="Short Date"/> ';
$this -> data .= '   </Style> ';



//$this -> data .= '   <Style  ss:ID="s22"> ';
//$this -> data .= '     <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
//$this -> data .= '   <Borders>  ';
//$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0C0C0" />';
//$this -> data .= '   </Borders>  ';

//$this -> data .= '     <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>  ';
//$this -> data .= '     <NumberFormat ss:Format="Short Date"/> ';
//$this -> data .= '   </Style> ';



$this -> data .= '<Style ss:ID="s23"> ';
//$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C00000" />';
$this -> data .= '    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C00000" /> ';
$this -> data .= '    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C00000" />';
$this -> data .= '    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C00000" />';

$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FFFFFF" ss:Bold="1" /> ';
$this -> data .= '   <Interior ss:Color="#C00000" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat/> ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';



$this -> data .= '<Style ss:ID="s23_1"> ';
//$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';
$this -> data .= '    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" /> ';
$this -> data .= '    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';
$this -> data .= '    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';

$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FFFFFF" ss:Bold="1" /> ';
$this -> data .= '   <Interior ss:Color="#C0C0C0" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat/> ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';



$this -> data .= '<Style ss:ID="s23_2"> ';
//$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Alignment ss:Horizontal="Right" ss:Vertical="Bottom" ss:WrapText="1"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';
$this -> data .= '    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" /> ';
$this -> data .= '    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';
$this -> data .= '    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';

$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" ss:Bold="1" /> ';
$this -> data .= '   <Interior ss:Color="#C0C0C0" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat/> ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';

$this -> data .= '<Style ss:ID="s23_3"> ';
//$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';
$this -> data .= '    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" /> ';
$this -> data .= '    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';
$this -> data .= '    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';

$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" ss:Bold="1" /> ';
$this -> data .= '   <Interior ss:Color="#C0C0C0" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat/> ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';

$this -> data .= '<Style ss:ID="s23_4"> ';
//$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom" ss:WrapText="1"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';
$this -> data .= '    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" /> ';
$this -> data .= '    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';
$this -> data .= '    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';

$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FFFFFF" ss:Bold="1" /> ';
$this -> data .= '   <Interior ss:Color="#C00000" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat/> ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';



$this -> data .= '<Style ss:ID="s23_5"> ';
//$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';
$this -> data .= '    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" /> ';
$this -> data .= '    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';
$this -> data .= '    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';

$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" ss:Bold="1" /> ';
$this -> data .= '   <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat/> ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';

$this -> data .= '<Style ss:ID="s23_6"> ';
//$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#666666" />';
$this -> data .= '    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" /> ';
$this -> data .= '    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';
$this -> data .= '    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#FFFFFF" />';

$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" ss:Bold="1" /> ';
$this -> data .= '   <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat/> ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';



$this -> data .= '<Style ss:ID="s24"> ';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0C0C0" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FFFFFF" ss:Bold="1" /> ';
$this -> data .= '   <Interior ss:Color="#C00000" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat ss:Format="Standard"/>  ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';


// para linha atual
$this -> data .= '<Style ss:ID="s25"> ';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0C0C0" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FFFFFF" ss:Bold="1" /> ';
$this -> data .= '   <Interior ss:Color="#000000" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat/> ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';
$this -> data .= '<Style ss:ID="s26"> ';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Borders/>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FFFFFF" ss:Bold="1" /> ';

$this -> data .= '   <Interior ss:Color="#000000" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat ss:Format="Standard"/>  ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';

// para linhas futuras
$this -> data .= '<Style ss:ID="s27"> ';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#808080" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '   <Interior ss:Color="#C0C0C0" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat/> ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';

$this -> data .= '<Style ss:ID="s28"> ';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#808080" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '   <Interior ss:Color="#C0C0C0" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat ss:Format="Standard"/>  ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';


$this -> data .= ' <Style ss:ID="s29" >';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/>';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0C0C0" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '   <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat/>';
$this -> data .= '   <Protection/>';
$this -> data .= '  </Style>';

$this -> data .= '<Style ss:ID="s30"> ';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0C0C0" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FFFFFF"  ss:Bold="1" /> ';
$this -> data .= '   <Interior ss:Color="#000000" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat ss:Format="Percent"/>  ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';

$this -> data .= '<Style ss:ID="s31"> ';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#808080" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '   <Interior ss:Color="#C0C0C0" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat ss:Format="Percent"/>  ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';

$this -> data .= '<Style ss:ID="s32"> ';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0C0C0" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '   <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat ss:Format="Percent"/>  ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';



$this -> data .= '<Style ss:ID="s40"> ';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#808080" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '   <Interior ss:Color="#C0C0C0" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat ss:Format="0.000"/>  ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';

$this -> data .= '<Style ss:ID="s41"> ';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Borders/>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FFFFFF" ss:Bold="1" /> ';

$this -> data .= '   <Interior ss:Color="#000000" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat ss:Format="0.000"/>  ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';

$this -> data .= '  <Style ss:ID="s42"> ';
$this -> data .= '     <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '     <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>  ';
$this -> data .= '     <NumberFormat ss:Format="0.000"/>  ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0C0C0" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '    </Style>  ';

$this -> data .= '  <Style ss:ID="s42_1"> ';
$this -> data .= '   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom" ss:WrapText="1"/> ';
$this -> data .= '     <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" /> ';
$this -> data .= '     <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>  ';
$this -> data .= '     <NumberFormat ss:Format="0.000"/>  ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#666666" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '    </Style>  ';


$this -> data .= '<Style ss:ID="s50"> ';
$this -> data .= '   <Alignment ss:Vertical="Bottom"/> ';
$this -> data .= '   <Borders>  ';
$this -> data .= '    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#C0C0C0" />';
$this -> data .= '   </Borders>  ';
$this -> data .= '   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FFFFFF"  ss:Bold="1" /> ';
$this -> data .= '   <Interior ss:Color="#C00000" ss:Pattern="Solid"/>  ';
$this -> data .= '   <NumberFormat ss:Format="Percent"/>  ';
$this -> data .= '   <Protection/>  ';
$this -> data .= '  </Style>  ';

                 
$this -> data .= '   </Styles>   ';

    }
    private function finaliza_xml()
    {
        $this -> data .= "</Workbook>";
    }
    
    public function retorna_xml()
    {
        return  $this -> data;
    }
    public function mostra_xls()
    {


       //header('Content-Type: application/x-msexcel; charset=iso-8859-1');


       header("Content-type: application/octet-stream; charset=iso-8859-1");


      //  header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename={$this -> arquivo_excel}.xls;");

        header("Content-Type: application/ms-excel");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $this -> data;
        
        
        
    }


    
}
// <FIM CLASSE TGlobal>



////////////////////////////////////////////////////
// <FIM DO ARQUIVO>                               //
////////////////////////////////////////////////////
?>