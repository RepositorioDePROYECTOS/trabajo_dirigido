<?php
  include("../../modelo/conexion.php");
 
  $id_nombre_planilla = $_GET[id_nombre_planilla];
  
  $bd = new conexion();
  
 
    $delimitador = ";";
    $nombre_archivo = "planilla_elapas_ministerio.csv";
    $f = fopen('php://memory', 'w');
    $columnas = array('CODIGO_ENTIDAD', 'TIPO_PLANILLA','FUENTE','ORGANISMO','GESTION','MES','CARNET_IDENTIDAD','NUMERO_COMPLEMENTARIO','EXPEDIDO','NOMBRE_1','NOMBRE_2','APELLIDO_1','APELLIDO_2','APELLIDO_3','FECHA_NACIMIENTO','FECHA_INGRESO','SEXO','ITEM','CARGO','TIPO_EMPLEADO','GRADO_FORMACION','DIAS_TRABAJOS','BASICO','BONO_ANTIGUEDAD','OTROS_INGRESOS','TOTAL_GANADO','APORTE_SEGURO_SOCIAL_LARGO_PLAZO','OTROS_DESCUENTOS','APORTE_SOLIDARIO_ASEGURADO_0.5%','APORTE_PATRONAL_SOLIDARIO_3%','LIQUIDO_PAGABLE');
    $c = 0;
    fputcsv($f,$columnas,$delimitador);
        $registros_d = $bd->Consulta("select * from planilla p inner join trabajador t on p.ci=t.ci left join formacion f on t.id_trabajador=f.id_trabajador where p.id_nombre_planilla=$id_nombre_planilla  order by cast(p.item as unsigned) asc");
        while($registro_d = $bd->getFila($registros_d))
        {
            $c++;
            $otros_ingresos = $registro_d[horas_extra] + $registro_d[suplencia];
            $aporte_seguro_social_largo_plazo = $registro_d[categoria_individual] + $registro_d[prima_riesgo_comun] + $registro_d[comision_ente];
            $o_desccuentos = $registro_d[sindicato] + $registro_d[desc_rciva] + $registro_d[otros_descuentos] + $registro_d[fondo_social] + $registro_d[fondo_empleados] + $registro_d[entidades_financieras];
            $aporte_patronal_solidario = number_format($registro_d[total_ganado] * 0.03,2);
            $filas = array(802,'PAGO DE HABERES','20 RECESP','230 OTROS',$registro_d[gestion],$registro_d[mes],$registro_d[ci],'',$registro_d[exp],$registro_d[nombres],'',$registro_d[apellido_paterno],$registro_d[apellido_materno],'',$registro_d[fecha_nacimiento],$registro_d[fecha_ingreso],$registro_d[sexo],$registro_d[item],$registro_d[cargo],'PERMANENTE',$registro_d[grado_formacion],$registro_d[dias_pagado],$registro_d[haber_basico],$registro_d[bono_antiguedad],$otros_ingresos,$registro_d[total_ganado],$aporte_seguro_social_largo_plazo,$o_desccuentos,$registro_d[total_aporte_solidario],$aporte_patronal_solidario, $registro_d[liquido_pagable]);
            fputcsv($f, $filas, $delimitador);
        }


    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $nombre_archivo . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);


?>
          
                    