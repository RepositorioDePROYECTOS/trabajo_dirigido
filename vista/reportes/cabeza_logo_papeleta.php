<style type="text/css">
<!--
    *
    {
        font-size: 11px;
    }

    tr.rojo
    {
        background: #FED4D4;
    }

    .left
    {
        margin-left: 60px;
    }   

    table.page_header
    {
        width: 100%; 
        border: none;
        padding: 10px 10px 0px 10px;
        color: #223B50; 
        font-size: 10px;
    }

    table.page_footer 
    {
        width: 100%;
        height: 93px;
        border: none;
        padding: 25px 10px;
        color: #223B50;    
        font-size: 10px;
    }
    
table.cont tr.titulo
{    
    background: #223B50;
    color: #FFF;
    text-align: center;
    vertical-align: middle;
    font-size: 8px;    
    text-transform: uppercase;
}

tr.titulo4
{   
    color: #223B50;
    text-shadow: 0px 1px 0px #fff;
    background: #f5f5f5;
}

table.cont
{    
    width: 100%;
    border-left: solid 1px #223B50;
    border-top: solid 1px #223B50;
    background: #fff;
    font-size: 8px;
}

table.cont td
{    
    border-bottom: solid 1px #223B50;
    border-right: solid 1px #223B50;
    padding: 5px;
    font-size: 10px;
}

table.cont thead td
{    
    border-bottom: solid 1px #828587;
    border-right: solid 1px #828587;
    padding: 5px;
    font-size: 10px;
}

tr.fila1
{
    background: #f0f0f0;
}

tr.fila2
{
    background: #fff;
}

tr.fila3

{

    background: #eee;

}

h3

{

    display: block;

    text-align: center;

    color:#444;

    font-size: 14px;

    font-weight: normal;

}

h1

{

    display: block;

    text-align: center;

    color:#223B50;

    font-size: 14px;

} 

p{
    padding: 0px 40px;
    text-align: justify;
    line-height: 20px;
    margin: 5px 0;
}     

p.parrafo{
    margin-left: 15px;
}

.bg-red{
    background: #FFAAAA;
}

table.tabla_reporte
{  
    width: 100%;
    border: solid 1px #888;
    background: #fff;
    font-size: 9px;
    border-collapse: collapse;
}

table.tabla_reporte td
{    
    border: solid 1px #888;
    padding: 2px 3px;    
}

table.tabla_reporte thead td
{    
    border: solid 1px #888;
    padding: 3px;    
}

table.tabla_reporte tr.titulo{
    background: #ddd;
    text-transform: uppercase;
}
.moneda{
    text-align: right;
}

</style>
<?php
    include("../../modelo/conexion.php");
    include("../../modelo/entidad.php");
    include("../../modelo/funciones.php");

    $bd = new conexion();
    
    $entidad = new entidad();
    $entidad->get_entidad_defecto();
?>