<?php
$idCampo = 'idt';
$Tela = "a Ocupação do CBO";
$TabelaPrinc      = "cbo_ocupacao";
$AliasPric        = "cbo_o";
$Entidade         = "Ocupação de CBO";
$Entidade_p       = "Ocupações Grupo de CBO";
$barra_inc_h      = "Incluir um Novo Registro de {$Entidade} ";
$contlinfim       = "Existem #qt {$Entidade_p}.";
$sql     = 'select  codigo, descricao from cbo_grande_grupo ';
$sql    .= '    order by descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id']    = 'codigo';
$Filtro['nome']  = 'Grande Grupo';
$Filtro['LinhaUm']    = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['grande_grupo'] = $Filtro;
$sql     = 'select  codigo, descricao from cbo_familia ';
$sql    .= '    order by descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id']    = 'codigo';
$Filtro['nome']  = 'Familia';
$Filtro['LinhaUm']    = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['familia'] = $Filtro;
$sql     = 'select  codigo, descricao from cbo_sub_grupo_principal ';
$sql    .= '    order by descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id']    = 'codigo';
$Filtro['nome']  = 'Sub Grupo Principal';
$Filtro['LinhaUm']    = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['sub_grupo_principal'] = $Filtro;
$sql     = 'select  codigo, descricao from cbo_sub_grupo ';
$sql    .= '    order by descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id']    = 'codigo';
$Filtro['nome']  = 'Sub Grupo';
$Filtro['LinhaUm']    = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['sub_grupo'] = $Filtro;
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";



//Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
if ($vetFiltro['grande_grupo']['valor']!=-1)
{
    $sql  .= " where substring({$AliasPric}.codigo,1,1) = ".aspa($vetFiltro['grande_grupo']['valor']);
}
else
{
    if ($vetFiltro['familia']['valor']!=-1)
    {
        $sql  .= " where substring({$AliasPric}.codigo,1,4) = ".aspa($vetFiltro['familia']['valor']);
    }
    else
    {


        if ($vetFiltro['sub_grupo_principal']['valor']!=-1)
        {
            $sql  .= " where substring({$AliasPric}.codigo,1,2) = ".aspa($vetFiltro['sub_grupo_principal']['valor']);
        }
        else
        {
            if ($vetFiltro['sub_grupo']['valor']!=-1)
            {
                $sql  .= " where substring({$AliasPric}.codigo,1,3) = ".aspa($vetFiltro['sub_grupo']['valor']);
            }
            else
            {
                if ($vetFiltro['texto']['valor']!="")
                {
                    $sql .= ' where ';
                    $sql .= ' lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
                    $sql .= ' or  lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
                }
                else
                {

                }
            }
        }
    }
}
$sql  .= " order by $orderby ";

// p($sql);
//echo " codigo ".$vetFiltro['grande_grupo']['valor'];


?>
