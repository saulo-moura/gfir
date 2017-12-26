<style>
    #nm_funcao_desc label{
    }
    #nm_funcao_obj {
    }
    .Tit_Campo {
    }
    .Tit_Campo_Obr {
    }
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        height:30px;
    }
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height:30px;
        padding-top:10px;
    }
    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }
    
    fieldset.class_frame_p {
        background:#ABBBBF;
        border:1px solid #FFFFFF;
    }
    div.class_titulo_p {
        background: #ABBBBF;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }


    
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #2C3E50;
    }
    div.class_titulo {
        background: #C4C9CD;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }
</style>
<?php
$tabela = 'gec_entidade';
$id = 'idt';
$onSubmitCon = ' gec_entidade_con() ';
if ($veio == "O") {   // Organização
    $vetCampo['codigo'] = objCNPJ('codigo', 'CNPJ', True);
    $vetCampo['descricao'] = objTexto('descricao', 'Razão Social', True, 60, 120);
    $vetCampo['resumo'] = objTexto('resumo', 'Nome Fantasia', True, 60, 120);

    $vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');
    $vetTipoEntidadew = Array();
    $vetTipoEntidadew['O'] = "Organização";
    $vetCampo['tipo_entidade'] = objCmbVetor('tipo_entidade', 'Tipo', True, $vetTipoEntidadew, '');
    //
    $sql = "select idt, codigo, descricao from gec_entidade_classe ";
    $sql .= " where tipo_entidade = 'O' ";
    $sql .= " order by codigo";


    $vetCampo['idt_entidade_classe'] = objCmbBanco('idt_entidade_classe', 'Classe', true, $sql, '', 'width:180px;');

    $maxlength = 700;
    $style = "width:700px;";
    $js = "";
    $vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe da Organização', false, $maxlength, $style, $js);
} else {
    if ($veio == "P") {   // Pessoa
        $consiste = ' consiste_codigo(this,'.'"'.$acao.'"'.') ';
        $vetCampo['codigo'] = objCPF('codigo', 'CPF', True, True, $consiste);
        $vetCampo['descricao'] = objTexto('descricao', 'Nome', True, 60, 120);
        $vetCampo['resumo'] = objTexto('resumo', 'Nome Resumo (Apelido)', True, 60, 120);

        $vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');
        $vetTipoEntidadew = Array();
        $vetTipoEntidadew['P'] = "Pessoa";
        $vetCampo['tipo_entidade'] = objCmbVetor('tipo_entidade', 'Tipo', True, $vetTipoEntidadew, '');
        //
        $sql = "select idt, codigo, descricao from gec_entidade_classe ";
        $sql .= " where tipo_entidade = 'P' ";
        $sql .= " order by codigo";
        $vetCampo['idt_entidade_classe'] = objCmbBanco('idt_entidade_classe', 'Classe', true, $sql, '', 'width:180px;');
        $maxlength = 700;
        $style = "width:700px;";
        $js = "";
        $vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe da Pessoa', false, $maxlength, $style, $js);
    } else {
        if ($acao == 'inc') {
            $vetCampo['codigo'] = objCPF('codigo', 'CNPJ/CPF', True);
            $vetCampo['descricao'] = objTexto('descricao', 'Razão Social/Nome', True, 60, 120);
            $vetCampo['resumo'] = objTexto('resumo', 'Nome Fantasia/Nome Resumo (Apelido)', True, 60, 120);

            $vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');
            $js = " onchange=' TipoEntidade(this);' ' ";
            // $vetCampo['tipo_entidade']     = objCmbVetor('tipo_entidade', 'Tipo de Entidade', True, $vetTipoEntidade,' ',$js);

            $sql = "select codigo, descricao from gec_entidade_tipo order by codigo";
            $vetCampo['tipo_entidade'] = objCmbBanco('tipo_entidade', 'Tipo de Entidade', true, $sql, '', 'width:180px;', $js);

            $sql = "select idt, codigo, descricao from gec_entidade_classe order by codigo";
            $vetCampo['idt_entidade_classe'] = objCmbBanco('idt_entidade_classe', 'Classe', true, $sql, '', 'width:180px;');


            $maxlength = 700;
            $style = "width:700px;";
            $js = "";
            $vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe da Entidade', false, $maxlength, $style, $js);
        } else {
////////////////////
            $sql = 'select ';
            $sql .= '     gec_en.* ';
            $sql .= ' from gec_entidade gec_en ';
            $sql .= ' where ';
            $sql .= '      gec_en.idt = '.null($_GET['id']);
            $rs = execsql($sql);
            $tipo_entidade = "";
            ForEach ($rs->data as $row) {
                $tipo_entidade = $row['tipo_entidade'];
            }
            $veio = $tipo_entidade;
            if ($veio == "O") {   // Organização
                $vetCampo['codigo'] = objCNPJ('codigo', 'CNPJ', True);
                $vetCampo['descricao'] = objTexto('descricao', 'Razão Social', True, 60, 120);
                $vetCampo['resumo'] = objTexto('resumo', 'Nome Fantasia', True, 60, 120);
                $vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');
                $js = " onchange=' TipoEntidade(this);' ' ";
                $vetCampo['tipo_entidade'] = objCmbVetor('tipo_entidade', 'Tipo', True, $vetTipoEntidade, '', $js);
                //
                $sql = "select idt, codigo, descricao from gec_entidade_classe ";
                $sql .= " where tipo_entidade = 'O' ";
                $sql .= " order by codigo";


                $vetCampo['idt_entidade_classe'] = objCmbBanco('idt_entidade_classe', 'Classe', true, $sql, '', 'width:180px;');

                $maxlength = 700;
                $style = "width:700px;";
                $js = "";
                $vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe da Organização', false, $maxlength, $style, $js);
            } else {
                if ($veio == "P") {   // Pessoa
                    $consiste = ' consiste_codigo(this,'.'"'.$acao.'"'.') ';
                    $vetCampo['codigo'] = objCPF('codigo', 'CPF', True, True, $consiste);
                    $vetCampo['descricao'] = objTexto('descricao', 'Nome', True, 60, 120);
                    $vetCampo['resumo'] = objTexto('resumo', 'Nome Resumo(Apelido)', True, 60, 120);

                    $vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');
                    $js = " onchange=' TipoEntidade(this);' ' ";
                    $vetCampo['tipo_entidade'] = objCmbVetor('tipo_entidade', 'Tipo', True, $vetTipoEntidade, '', $js);
                    //
                    $sql = "select idt, codigo, descricao from gec_entidade_classe ";
                    $sql .= " where tipo_entidade = 'P' ";
                    $sql .= " order by codigo";
                    $vetCampo['idt_entidade_classe'] = objCmbBanco('idt_entidade_classe', 'Classe', true, $sql, '', 'width:180px;');
                    $maxlength = 700;
                    $style = "width:700px;";
                    $js = "";
                    $vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe da Pessoa', false, $maxlength, $style, $js);
                } else {
                    echo " ERRO ....... <br />";
                }
            }


///////////////////////
        }
    }
}
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');


$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";


$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;


if ($veioinscricao != "I")
{   // Não veio da Inscrição
    if ($veio == "O")
    {   // Organização
       $titulo_cadastro="CADASTRO DA ORGANIZAÇÃO";
    }
    else
    {
       $titulo_cadastro="CADASTRO DA PESSOA";
    }
}
else
{
    if ($veio == "O")
    {   // Organização
       $titulo_cadastro="CADASTRO DO CANDIDATO - PESSOA JURÍDICA";
    }
    else
    {
       $titulo_cadastro="CADASTRO DO CANDIDATO - PESSOA FÍSICA";
    }
}
    
    
$vetFrm = Array();

$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha);

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);


$vetFrm[] = Frame('<span>1 - IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


//MesclarCol($vetCampo['idt_entidade_classe'], 3);

$vetParametros = Array(
    'codigo_pai' => 'parte01',
);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['ativo']),
    Array($vetCampo['tipo_entidade'], '', $vetCampo['resumo'], '', $vetCampo['idt_entidade_classe']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);



$vetParametros = Array(
    'codigo_frm' => 'parte02',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>2 - COMUNICAÇÃO (ENDEREÇOS, TELEFONES, EMAIL...) </span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

//  full dentro do conf --------------
$vetCampo = Array();
$vetCampo['gec_et_descricao'] = CriaVetTabela('Tipo');
$vetCampo['cep'] = CriaVetTabela('CEP');
$vetCampo['logradouro'] = CriaVetTabela('Logradouro');
$vetCampo['logradouro_numero'] = CriaVetTabela('Número');
$vetCampo['logradouro_complemento'] = CriaVetTabela('Complemento');
$vetCampo['logradouro_bairro'] = CriaVetTabela('Bairro');
$vetCampo['logradouro_municipio'] = CriaVetTabela('Município');
$vetCampo['logradouro_estado'] = CriaVetTabela('Estado');
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

$sql = '';
$sql .= ' select gec_ee.*,';
$sql .= '        gec_et.descricao as gec_et_descricao';
$sql .= ' from gec_entidade_endereco gec_ee';
$sql .= " inner join gec_endereco_tipo gec_et on gec_et.idt = gec_ee.idt_entidade_endereco_tipo";
$sql .= ' where gec_ee.idt_entidade = $vlID';
$sql .= ' order by gec_et.codigo';

$titulo = 'Endereços';

$vetCampo['gec_entidade_endereco'] = objListarConf('gec_entidade_endereco', 'idt', $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'codigo_pai' => 'parte02',
    'width' => '100%',
);
$vetFrm[] = Frame('<span>Endereços</span>', Array(
    Array($vetCampo['gec_entidade_endereco']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);



$vetParametros = Array(
    'codigo_frm' => 'parte03',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>3 - RELACIONAMENTOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

//--------------------------------------- relacionamentos
$vetCampo = Array();
$vetCampo['gec_er_descricao'] = CriaVetTabela('Tipo de Relação');
$vetCampo['gec_ef_descricao'] = CriaVetTabela('Entidade Relacionada');
$vetCampo['observacao'] = CriaVetTabela('Observação');
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);


$titulo = 'Relacionamentos das Entidades';

$TabelaPrinc = "gec_entidade_entidade";
$AliasPric = "gec_ene";
$Entidade = "Relacionamento da Entidade";
$Entidade_p = "Relacionamentos da Entidade";
$CampoPricPai = "idt_entidade";
$orderby = " gec_er.codigo, gec_ef.descricao ";

$sql = "select {$AliasPric}.*, ";
$sql .= "        gec_ef.descricao as gec_ef_descricao, ";
$sql .= "        gec_er.descricao as gec_er_descricao ";
//
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join gec_entidade gec_ep on  gec_ep.idt = {$AliasPric}.idt_entidade";
$sql .= " inner join gec_entidade gec_ef on  gec_ef.idt = {$AliasPric}.idt_entidade_relacionada";
//
$sql .= " inner join gec_entidade_relacao gec_er on  gec_er.idt = {$AliasPric}.idt_entidade_relacao";
//
$sql .= " where {$AliasPric}".'.idt_entidade = $vlID';
$sql .= " order by {$orderby}";


$vetCampo['gec_entidade_entidade'] = objListarConf('gec_entidade_entidade', 'idt', $vetCampo, $sql, $titulo, true);


$vetParametros = Array(
    'codigo_pai' => 'parte03',
    'width' => '100%',
);
$vetFrm[] = Frame('<span>Relacionamentos</span>', Array(
    Array($vetCampo['gec_entidade_entidade']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


//////////////////// isso é para Mercado
if ($veio == "O")
{   // Organização



    $vetParametros = Array(
        'codigo_frm' => 'parte04',
        'controle_fecha' => 'A',
    );

    $vetFrm[] = Frame('<span>4 - MERCADO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    //--------------------------------------- relacionamentos
    $vetCampo = Array();
    $vetCampo['gec_m_descricao']        = CriaVetTabela('Merdcado');
    $vetCampo['gec_mt_descricao']       = CriaVetTabela('Tipo');
    $vetCampo['data_inicio']            = CriaVetTabela('Data Inicio','data');
    $vetCampo['data_termino']           = CriaVetTabela('Data Término','data');
    $vetCampo['ativo']                  = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
    $titulo = 'Mercado da Organização ';

    $TabelaPrinc      = "gec_entidade_mercado";
    $AliasPric        = "gec_em";
    $Entidade         = "Mercado da Entidade";
    $Entidade_p       = "Mercados da Entidade";
    $CampoPricPai     = "idt_entidade";
    $orderby = "gec_m.codigo, gec_mt.codigo";

    $sql  = "select {$AliasPric}.*, ";
    $sql .= "        gec_m.descricao as gec_m_descricao, ";
    $sql .= "        gec_mt.descricao as gec_mt_descricao ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    //
    $sql .= " inner join gec_mercado gec_m on  gec_m.idt = {$AliasPric}.idt_mercado ";

    $sql .= " inner join gec_mercado_tipo gec_mt on  gec_mt.idt = {$AliasPric}.idt_tipo ";
    //
    $sql .= " where {$AliasPric}".'.idt_entidade = $vlID';
    $sql .= " order by {$orderby}";


    $vetCampo['gec_entidade_mercado'] = objListarConf('gec_entidade_mercado', 'idt', $vetCampo, $sql, $titulo, true);


    $vetParametros = Array(
        'codigo_pai' => 'parte03',
        'width' => '100%',
    );
    $vetFrm[] = Frame('<span>Mercado</span>', Array(
        Array($vetCampo['gec_entidade_mercado']),
    ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);









}
else
{
    // para pessoa


}








if ($veio == "O")
{   // Organização

    $vetParametros = Array(
        'codigo_frm' => 'parte05',
        'controle_fecha' => 'A',
    );
    $vetFrm[] = Frame('<span>5 - DADOS COMPLEMENTARIOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetCad[] = $vetFrm;

    $vetParametros = Array(
        'codigo_pai' => 'parte04',
    );
}
else
{
    $vetParametros = Array(
        'codigo_frm' => 'parte04',
        'controle_fecha' => 'A',
    );
    $vetFrm[] = Frame('<span>4 - DADOS COMPLEMENTARIOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetCad[] = $vetFrm;

    $vetParametros = Array(
        'codigo_pai' => 'parte04',
    );
}
if ($veio == "O") {   // Organização
    MesclarCadastro('gec_entidade_organizacao', 'idt_entidade', $vetCad, $vetParametros);
} else {
    MesclarCadastro('gec_entidade_pessoa', 'idt_entidade', $vetCad, $vetParametros);
}
?>
<script type="text/javascript">
    function TipoEntidade(thisw)
    {
        //alert ('tratar tipo de entidade = '+thisw.value);
        var cpf = '<input id="codigo" name="codigo" type="text" class="Texto" value="" size="12" maxlength="12" onblur="return Valida_CPF(this)" onkeyup="return Formata_Cpf(this,event)">';
        var cnpj = '<input id="codigo" name="codigo" type="text" class="Texto" value="" size="18" maxlength="18" onblur="return Valida_CNPJ(this)" onkeyup="return Formata_Cnpj(this,event)">';

        var tipoentidade = thisw.value;
        var str = "";
        var strd = "";
        var descd = "";
        var descr = "";
        if (tipoentidade == 'O')
        {
            str = cnpj;
            strd = 'CNPJ';
            descd = 'Razão Social:';
            descr = 'Nome Fantasia:';
        }
        else
        {
            str = cpf;
            strd = 'CPF';
            descd = 'Nome:';
            descr = 'Nome Resumo (Apelido):';
        }
        var id = 'codigo_obj';
        objd = document.getElementById(id);
        if (objd != null)
        {
            objd.innerHTML = str;
        }
        var id = 'codigo_desc';
        objd = document.getElementById(id);
        if (objd != null)
        {
            objd.innerHTML = strd;
        }
        var id = 'descricao_desc';
        objd = document.getElementById(id);
        if (objd != null)
        {
            objd.innerHTML = descd;
        }

        var id = 'resumo_desc';
        objd = document.getElementById(id);
        if (objd != null)
        {
            objd.innerHTML = descr;
        }

        return false;
    }

    function consiste_codigo(thisw, acao)
    {
        var ret = true;
        if (acao != 'inc')
        {
            return ret;
        }
        var codigo = thisw.value;
        //alert('consiste codigo'+thisw.value);
        var str = '';
        $.post('ajax2.php?tipo=consiste', {
            async: false,
            codigo: codigo
        }
        , function (str) {
            if (str == '') {
            } else {
                alert(url_decode(str).replace(/<br>/gi, "\n"));
                thisw.value = "";
                ret = false;
            }
        });




        return ret;
    }


    function gec_entidade_con()
    {
        var ret = true;
        alert(' Ajax ');
        return ret;
    }

</script>