<?php
	function security($value)
    {
        if(is_array($value) )
        {
          $value = array_map('security', $value);
        }
        else
        {
            if( !get_magic_quotes_gpc() )
            {
              //$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
              $value = htmlspecialchars($value, ENT_QUOTES);
            }
            else
            {
              $value = htmlspecialchars(stripslashes($value), ENT_QUOTES);
            }
            $value = str_replace("\\", "\\\\", $value);
        }
    	return $value;
    }
    
    function msg_error($cod)
    {
        switch($cod)
        {
            case '1': echo "<strong>Debe iniciar Sesi&oacute;n.</strong>";
            case '403': echo "<div class='alert dismissible alert_red'><img height=\"24\" width=\"24\" src=\"images/icons/small/white/alarm_bell.png\"> Usted no tienen permiso para acceder a esta secci&oacute;n.</div>";
        }
    }
    
    function no_user_permit($nivel_denegado = "")
    {
        //admin admins cajero
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        
        if(empty($_SESSION['rol']))
        {
            echo "<meta http-equiv=\"Refresh\" content=\"3;url=index.php\" />";
            msg_error(1); 
            exit;     
        }
        
        if($nivel_denegado == 'admin' && $_SESSION['rol'] == 'admin')
        {
            echo "<meta http-equiv=\"Refresh\" content=\"3;url=index.php\" />";  
            msg_error(403);
            exit;     
        }
        
        if($nivel_denegado == 'admins' && $_SESSION['rol'] == 'admins')
        {
            echo "<meta http-equiv=\"Refresh\" content=\"3;url=index.php\" />";  
            msg_error(403);
            exit;     
        }
        
        if($nivel_denegado == 'cajero' && $_SESSION['rol'] == 'cajero')
        {
            echo "<meta http-equiv=\"Refresh\" content=\"3;url=index.php\" />";  
            msg_error(403);
            exit;     
        }
             
    }
    
    function require_login()
    {
        if(!isset($_SESSION['id_cliente']))
        {
            exit();
        }
    }
    
    function referer_permit()
    {
        $host_permit = "planillas";
        //$host_permit = "bigstorages.com"; 
        
        $http_referer = strtolower($_SERVER["HTTP_REFERER"]); 
        $pos = strpos($http_referer, $host_permit); 
     
        if($pos === false)
        {
            echo "Acceso no Permitido.";
            exit();
        }
    }
    
    function intdiv($a, $b)
    {
      return ($a - ($a % $b)) / $b;
    }
    function descargar_archivo($archivo, $downloadfilename = null)
    {
        if (file_exists($archivo)) {
            $downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $downloadfilename);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));
    
            ob_clean();
            flush();
            readfile($archivo);
            exit;
        }
    
    }
    
    function format_date($date)
    {
        $fecha = explode(" ", $date);
        
        $t = $fecha[1];        
        $f = explode("-", $fecha[0]); 
        
        $nueva_fecha = "$f[2]-$f[1]-$f[0] $t";
        
        return $nueva_fecha;
    }
    
    function format_date_dmy($date)
    {
        $fecha = explode(" ", $date);
        
        $t = $fecha[1];        
        $f = explode("-", $fecha[0]); 
        
        $nueva_fecha = "$f[2]-$f[1]-$f[0] $t";
        
        return $nueva_fecha;
    }
    
    function getDia($posicion)
    {
        $dias = array(1 => "Lunes", 2 => "Martes", 3 => "Miercoles", 4 => "Jueves", 5 => "Viernes", 6 => "S�bado", 7 => "Domingo");
        return $dias[$posicion];
    }
    
    function getMes($posicion)
    {
        $meses = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");
        return $meses[$posicion];
    }
    
    function getFechaText($fecha)
    {
        $ndia = date("N", strtotime($fecha));
        $dia = date("d", strtotime($fecha));
        $nmes = date("n", strtotime($fecha));
        $anio = date("Y", strtotime($fecha));
        //sabado, 20 de abril de 2019
        
        return getDia($ndia).", $dia de ".getMes($nmes)." de $anio";
    }

    function getCantidadMeses($fecha_ini, $fecha_fin){        
        $f1 = strtotime($fecha_ini);
        $f2 = strtotime($fecha_fin);
        
        $year1 = date('Y', $f1);
        $year2 = date('Y', $f2);
        
        $month1 = date('m', $f1);
        $month2 = date('m', $f2);
        
        return (($year2 - $year1) * 12) + ($month2 - $month1);
    }

    function diferenciafechas($fecha_ini, $fecha_fin)
    {
        $f1 = strtotime($fecha_ini);
        $f2 = strtotime($fecha_fin);
        
        $year1 = date('Y', $f1);
        $year2 = date('Y', $f2);
        
        $month1 = date('m', $f1);
        $month2 = date('m', $f2);

        $day1 = date('d', $f1);
        $day2 = date('d', $f2);
        
        $anios = $year2-$year1;
        $meses = $month2-$month1;
        $dias = $day2-$day1;

        if($dias < 0)
        {
          $dias = 30 + $dias;
          $rest_mes = 1;
          if($meses < 0)
          {
            $meses = 12 + $meses - $rest_mes;
            $rest_anio = 1;
            if($anios == 0)
            {
              $anios = 0;
            }
            else
            {
              $anios = $anios - $rest_anio;
            }
          }
          else
          {
            if($meses == 0)
            {

            }
          }
        }
        if($dias == 0)
        {
          $dias = 0;
          $inc_mes = 1;

        }
        

        $cantidad = array($anios,$meses,$dias);
        return $cantidad;
    }

    function years($fecha_actual, $fecha_nacimiento)
    {
      $years = date('Y',strtotime($fecha_actual)) - date('Y',strtotime($fecha_nacimiento));
      return $years;

    }

    function calculaedad($fecha_actual, $fechanacimiento)
    {
      list($ano,$mes,$dia) = explode("-",$fechanacimiento);
      $ano_diferencia  = date('Y',strtotime($fecha_actual)) - $ano;
      $mes_diferencia = date('m',strtotime($fecha_actual)) - $mes;
      $dia_diferencia   = date('d',strtotime($fecha_actual)) - $dia;
      if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
      return $ano_diferencia;
    }

    function antiguedad($startDate, $endDate)
        {
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);
            if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate)
              return false;
               
            $years = date('Y', $endDate) - date('Y', $startDate);
           
            $endMonth = date('m', $endDate);
            $startMonth = date('m', $startDate);
           
            // Calculate months
            $months = $endMonth - $startMonth;
            if ($months <= 0)  {
                $months += 12;
                $years--;
            }
            if ($years < 0)
                return false;
           
            // Calculate the days
                        $offsets = array();
                        if ($years > 0)
                            $offsets[] = $years . (($years == 1) ? ' year' : ' years');
                        if ($months > 0)
                            $offsets[] = $months . (($months == 1) ? ' month' : ' months');
                        $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now';

                        $days = $endDate - strtotime($offsets, $startDate);
                        $days = date('z', $days);   
                       
            return array($years, $months, $days);
        }

    function sumar_antiguedad($anterior, $nuevo)
    {
        $sum_dias = $anterior[2] + $nuevo[2];

        $sum_anios = $anterior[0] + $nuevo[0];
        
        if($sum_dias < 30)
        {
          $actual[2] = $sum_dias;
          $mes = 0;
        }
        else
        {
          $actual[2] = $sum_dias % 30;
          $mes = 1;
        }
        $sum_meses = $anterior[1] + $nuevo[1] + $mes;
        if($sum_meses < 12)
        {
          $actual[1] = $sum_meses;
          $anio = 0;
        }
        else
        {
          $actual[1] = $sum_meses % 12;
          $anio = 1;
        }
        $sum_anios = $anterior[0] + $nuevo[0] + $anio;
        $actual[0] = $sum_anios;
        return $actual;
    }

    function num2letras($num, $fem = false, $dec = true) 
    { 
       $matuni[2]  = "dos"; 
       $matuni[3]  = "tres"; 
       $matuni[4]  = "cuatro"; 
       $matuni[5]  = "cinco"; 
       $matuni[6]  = "seis"; 
       $matuni[7]  = "siete"; 
       $matuni[8]  = "ocho"; 
       $matuni[9]  = "nueve"; 
       $matuni[10] = "diez"; 
       $matuni[11] = "once"; 
       $matuni[12] = "doce"; 
       $matuni[13] = "trece"; 
       $matuni[14] = "catorce"; 
       $matuni[15] = "quince"; 
       $matuni[16] = "dieciseis"; 
       $matuni[17] = "diecisiete"; 
       $matuni[18] = "dieciocho"; 
       $matuni[19] = "diecinueve"; 
       $matuni[20] = "veinte"; 
       $matunisub[2] = "dos"; 
       $matunisub[3] = "tres"; 
       $matunisub[4] = "cuatro"; 
       $matunisub[5] = "quin"; 
       $matunisub[6] = "seis"; 
       $matunisub[7] = "sete"; 
       $matunisub[8] = "ocho"; 
       $matunisub[9] = "nove"; 
    
       $matdec[2] = "veinte"; 
       $matdec[3] = "treinta"; 
       $matdec[4] = "cuarenta"; 
       $matdec[5] = "cincuenta"; 
       $matdec[6] = "sesenta"; 
       $matdec[7] = "setenta"; 
       $matdec[8] = "ochenta"; 
       $matdec[9] = "noventa"; 
       $matsub[3]  = 'mill'; 
       $matsub[5]  = 'bill'; 
       $matsub[7]  = 'mill'; 
       $matsub[9]  = 'trill'; 
       $matsub[11] = 'mill'; 
       $matsub[13] = 'bill'; 
       $matsub[15] = 'mill'; 
       $matmil[4]  = 'millones'; 
       $matmil[6]  = 'billones'; 
       $matmil[7]  = 'de billones'; 
       $matmil[8]  = 'millones de billones'; 
       $matmil[10] = 'trillones'; 
       $matmil[11] = 'de trillones'; 
       $matmil[12] = 'millones de trillones'; 
       $matmil[13] = 'de trillones'; 
       $matmil[14] = 'billones de trillones'; 
       $matmil[15] = 'de billones de trillones'; 
       $matmil[16] = 'millones de billones de trillones'; 
       
       //Zi hack
       $float=explode('.',$num);
       $num=$float[0];
    
       $num = trim((string)@$num); 
       if ($num[0] == '-') { 
          $neg = 'menos '; 
          $num = substr($num, 1); 
       }else 
          $neg = ''; 
       while ($num[0] == '0') $num = substr($num, 1); 
       if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
       $zeros = true; 
       $punt = false; 
       $ent = ''; 
       $fra = ''; 
       for ($c = 0; $c < strlen($num); $c++) { 
          $n = $num[$c]; 
          if (! (strpos(".,'''", $n) === false)) { 
             if ($punt) break; 
             else{ 
                $punt = true; 
                continue; 
             } 
    
          }elseif (! (strpos('0123456789', $n) === false)) { 
             if ($punt) { 
                if ($n != '0') $zeros = false; 
                $fra .= $n; 
             }else 
    
                $ent .= $n; 
          }else 
    
             break; 
    
       } 
       $ent = '     ' . $ent; 
       if ($dec and $fra and ! $zeros) { 
          $fin = ' mil'; 
          for ($n = 0; $n < strlen($fra); $n++) { 
             if (($s = $fra[$n]) == '0') 
                $fin .= ' cero'; 
             elseif ($s == '1') 
                $fin .= $fem ? ' una' : ' un'; 
             else 
                $fin .= ' ' . $matuni[$s]; 
          } 
       }else 
          $fin = ''; 
       if ((int)$ent === 0) return 'Cero ' . $fin; 
       $tex = ''; 
       $sub = 0; 
       $mils = 0; 
       $neutro = false; 
       while ( ($num = substr($ent, -3)) != '   ') { 
          $ent = substr($ent, 0, -3); 
          if (++$sub < 3 and $fem) { 
             $matuni[1] = 'una'; 
             $subcent = 'as'; 
          }else{ 
             $matuni[1] = $neutro ? 'un' : 'uno'; 
             $subcent = 'os'; 
          } 
          $t = ''; 
          $n2 = substr($num, 1); 
          if ($n2 == '00') { 
          }elseif ($n2 < 21) 
             $t = ' ' . $matuni[(int)$n2]; 
          elseif ($n2 < 30) { 
             $n3 = $num[2]; 
             if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
             $n2 = $num[1]; 
             $t = ' ' . $matdec[$n2] . $t; 
          }else{ 
             $n3 = $num[2]; 
             if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
             $n2 = $num[1]; 
             $t = ' ' . $matdec[$n2] . $t; 
          } 
          $n = $num[0]; 
          if ($n == 1) { 
             $t = ' cien' . $t; 
          }elseif ($n == 5){ 
             $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
          }elseif ($n != 0){ 
             $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
          } 
          if ($sub == 1) { 
          }elseif (! isset($matsub[$sub])) { 
             if ($num == 1) { 
                $t = ' mil'; 
             }elseif ($num > 1){ 
                $t .= ' mil'; 
             } 
          }elseif ($num == 1) { 
             $t .= ' ' . $matsub[$sub] . '?n'; 
          }elseif ($num > 1){ 
             $t .= ' ' . $matsub[$sub] . 'ones'; 
          }   
          if ($num == '000') $mils ++; 
          elseif ($mils != 0) { 
             if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
             $mils = 0; 
          } 
          $neutro = true; 
          $tex = $t . $tex; 
       } 
       $tex = $neg . substr($tex, 1) . $fin; 
       
       if(strlen($float[1]) == 1)
       {
            $ceros = "0";
       }
       else
       {
            $ceros = "00";
       }
       
       //$end_num = ucfirst($tex).' coma  ' . $float[1];
       $end_num = ucfirst($tex);
       
       return $end_num; 
    }

    function sumar_horas($datos_hora)
    {
        $h=0;
        $m=0;
        for ($i = 0; $i <=sizeof($datos_hora); $i++) {
            $hora=split(":",$datos_hora[$i]);
            $h=$h+(int)$hora[0];
            $m=$m+(int)$hora[1];
        };
            $h+=(int)($m/60);
            $m = $m % 60;
        return $hora_salida = ($h*60)+$m;
        
    }
    
?>
