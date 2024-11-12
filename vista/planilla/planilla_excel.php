<?php
    session_start();
    require_once('../../modelo/conexion.php'); 
    require_once('../../modelo/funciones.php');
    require_once('../../lib/phpexcel/PHPExcel.php');    
    $id_nombre_planilla = $_GET[id];

    $bd = new conexion();    
    $fecha = date("d-m-Y");
    
    $objPHPExcel = new PHPExcel();
    
    $objPHPExcel->getProperties()
        ->setCreator("ELAPAS")
        ->setLastModifiedBy("ELAPAS")
        ->setTitle("Planilla de pago")
        ->setSubject("")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("Planilla, ELAPAS")
        ->setCategory("ELAPAS");      
    //$objPHPExcel->setActiveSheetIndex(0)->mergeCellsByColumnAndRow(0,1,8,1);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:R1');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',"PLANILLA DE PAGO");
    $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', "NO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', "ITEM");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "CI");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', "NOMBRES");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', "APELLIDOS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', "CARGO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', "FECHA INGRESO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', "HABER BASICO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', "DIAS TRABAJADO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', "BONO ANTIGUEDAD");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', "EXTRAS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', "TOTAL GANADO");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', "DESCUENTOS AFP");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "DESCUENTOS RC-IVA");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', "DESCUENTOS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', "MULTAS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q2', "TOTAL DESCUENTOS");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R2', "LIQUIDO PAGABLE");
        $registros = $bd->Consulta("select * from planilla where id_nombre_planilla=$id_nombre_planilla order by item asc");
        
        if($bd->numFila($registros) > 0)
        {            
            $n =0;
            $total = 0;
            $i = 2;
            while($registro = $bd->getFila($registros))
            {
                $i++;
                $n++;                
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$i", "$n");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$i", "$registro[item]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$i", "$registro[ci]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$i", "$registro[nombres]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$i", "$registro[apellidos]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F$i", "$registro[cargo]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G$i", "$registro[fecha_ingreso]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H$i", "$registro[haber_basico]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I$i", "$registro[dias_pagado]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J$i", "$registro[bono_antiguedad]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K$i", "$registro[extras]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L$i", "$registro[total_ganado]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M$i", "$registro[descuentos_afp]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("N$i", "$registro[descuentos_rciva]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("O$i", "$registro[descuento]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("P$i", "$registro[multas]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("Q$i", "$registro[total_descuentos]");
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("R$i", "$registro[liquido_pagable]");
            }
                $estilo = array(
              'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                )
              )
            );

            $estilo2 = array(
              'borders' => array(
                'outline' => array(
                  'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
              )
            );
            
            $objPHPExcel->getActiveSheet()->getStyle("A1:R$i")->applyFromArray($estilo);
            $objPHPExcel->getActiveSheet()->getStyle("A1:R$i")->applyFromArray($estilo2);

            foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) { $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true); }    
            /*    
            $i++;                    
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$i", "Total");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$i", "");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$i", "");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$i", "");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$i", "");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F$i", "");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G$i", "");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H$i", "$total_pre");
            */
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="planilla.xlsx"');
            header('Cache-Control: max-age=0');
            
            $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
            $objWriter->save('php://output');
            exit;
        }
        else
            echo "Error. No existen trabajadores";
    
    	
?>