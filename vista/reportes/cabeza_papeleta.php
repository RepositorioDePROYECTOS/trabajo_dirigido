<style type="text/css">
<!--
    *
    {
        font-size: 12px;
        color: black;
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

        /*background-image: url(../../images/pie.png);*/

        padding: 25px 10px;

        color: #223B50;     

        font-size: 10px;

    }



tr.titulo
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

    font-size: 7px;

}

table.cont thead td

{    

    border-bottom: solid 1px #828587;

    border-right: solid 1px #828587;

    padding: 5px;

    font-size: 7px;

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
}     
.ocultar{
    display: none;
}
-->

</style>
<?php
    include("../../modelo/conexion.php");
    include("../../modelo/entidad.php");
    include("../../modelo/funciones.php");
    $bd = new conexion();
    
    $entidad = new entidad();
    $entidad->get_entidad_defecto();
?>