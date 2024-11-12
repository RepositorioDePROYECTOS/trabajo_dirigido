<page backtop="25mm" backbottom="14mm" backleft="0mm" backright="0mm" backimg="" style="font-size: 10pt">

    <page_header>        

        <table class="page_header">            

            <tr>

                <td style="width: 30%; text-align: left;">
                    <img src="../reportes/images/logo.png"/>
                </td>

                <td style="width: 30%; text-align: center">
                    &nbsp;
                </td>

                <td style="width: 40%; text-align: center;">
                    <?php
                        echo $entidad->nombre_entidad . "<br>";
                        echo $entidad->direccion . "<br>";
                        echo $entidad->telefonos . "<br>";
                        echo $entidad->correo;
                    ?>
                </td>

            </tr>

        </table>

    </page_header>    

    <page_footer>     
        <table class="page_footer">
            <tr>
                <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
            </tr>
            <tr>
                <td style="width: 33%; text-align: left;">
                </td>
                <td style="width: 34%; text-align: center">
                    p&aacute;gina [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 33%; text-align: right">
                    Fecha Impresi&oacute;n <?php echo date('d/m/Y'); ?>
                </td>
            </tr>
        </table>
    </page_footer>