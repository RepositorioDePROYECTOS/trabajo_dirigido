<?php 
function numeroALetras($num, $currency = array()) {
    $defaultCurrency = array(
        'plural' => 'BOLIVIANOS',
        'singular' => 'BOLIVIANO',
        'centPlural' => 'CENTAVOS',
        'centSingular' => 'CENTAVO'
    );
    $currency = array_merge($defaultCurrency, $currency);

    $data = array(
        'numero' => $num,
        'enteros' => floor($num),
        'centavos' => round(($num - floor($num)) * 100),
        'letrasCentavos' => '',
        'letrasMonedaPlural' => $currency['plural'],
        'letrasMonedaSingular' => $currency['singular'],
        'letrasMonedaCentavoPlural' => $currency['centPlural'],
        'letrasMonedaCentavoSingular' => $currency['centSingular']
    );

    if ($data['enteros'] == 0) {
        return 'CERO ' . $data['centavos'] . '/100 ' . $data['letrasMonedaSingular'];
    } elseif ($data['enteros'] == 1) {
        return Millones($data['enteros']) . ' ' . $data['centavos'] . '/100 ' . $data['letrasMonedaSingular'];
    } else {
        return Millones($data['enteros']) . ' ' . $data['centavos'] . '/100 ' . $data['letrasMonedaPlural'];
    }
}

function Unidades($num) {
    switch ($num) {
        case 1:
            return 'UNO';
        case 2:
            return 'DOS';
        case 3:
            return 'TRES';
        case 4:
            return 'CUATRO';
        case 5:
            return 'CINCO';
        case 6:
            return 'SEIS';
        case 7:
            return 'SIETE';
        case 8:
            return 'OCHO';
        case 9:
            return 'NUEVE';
    }
    return '';
}

function Decenas($num) {
    $decena = floor($num / 10);
    $unidad = $num - ($decena * 10);

    switch ($decena) {
        case 1:
            switch ($unidad) {
                case 0:
                    return 'DIEZ';
                case 1:
                    return 'ONCE';
                case 2:
                    return 'DOCE';
                case 3:
                    return 'TRECE';
                case 4:
                    return 'CATORCE';
                case 5:
                    return 'QUINCE';
                default:
                    return 'DIECI' . Unidades($unidad);
            }
        case 2:
            switch ($unidad) {
                case 0:
                    return 'VEINTE';
                default:
                    return 'VEINTI' . Unidades($unidad);
            }
        case 3:
            return DecenasY('TREINTA', $unidad);
        case 4:
            return DecenasY('CUARENTA', $unidad);
        case 5:
            return DecenasY('CINCUENTA', $unidad);
        case 6:
            return DecenasY('SESENTA', $unidad);
        case 7:
            return DecenasY('SETENTA', $unidad);
        case 8:
            return DecenasY('OCHENTA', $unidad);
        case 9:
            return DecenasY('NOVENTA', $unidad);
        case 0:
            return Unidades($unidad);
    }
}

function DecenasY($strSin, $numUnidades) {
    if ($numUnidades > 0)
        return $strSin . ' Y ' . Unidades($numUnidades);
    return $strSin;
}

function Centenas($num) {
    $centenas = floor($num / 100);
    $decenas = $num - ($centenas * 100);

    switch ($centenas) {
        case 1:
            if ($decenas > 0)
                return 'CIENTO ' . Decenas($decenas);
            return 'CIEN';
        case 2:
            return 'DOSCIENTOS ' . Decenas($decenas);
        case 3:
            return 'TRESCIENTOS ' . Decenas($decenas);
        case 4:
            return 'CUATROCIENTOS ' . Decenas($decenas);
        case 5:
            return 'QUINIENTOS ' . Decenas($decenas);
        case 6:
            return 'SEISCIENTOS ' . Decenas($decenas);
        case 7:
            return 'SETECIENTOS ' . Decenas($decenas);
        case 8:
            return 'OCHOCIENTOS ' . Decenas($decenas);
        case 9:
            return 'NOVECIENTOS ' . Decenas($decenas);
    }
    return Decenas($decenas);
}

function Seccion($num, $divisor, $strSingular, $strPlural) {
    $cientos = floor($num / $divisor);
    $resto = $num - ($cientos * $divisor);

    $letras = '';

    if ($cientos > 0)
        if ($cientos > 1)
            $letras = Centenas($cientos) . ' ' . $strPlural;
        else
            $letras = $strSingular;

    if ($resto > 0)
        $letras .= '';

    return $letras;
}

function Miles($num) {
    $divisor = 1000;
    $cientos = floor($num / $divisor);
    $resto = $num - ($cientos * $divisor);

    $strMiles = Seccion($num, $divisor, 'MIL', 'MIL');
    $strCentenas = Centenas($resto);

    if ($strMiles == '')
        return $strCentenas;

    return $strMiles . ' ' . $strCentenas;
}

function Millones($num) {
    $divisor = 1000000;
    $cientos = floor($num / $divisor);
    $resto = $num - ($cientos * $divisor);

    $strMillones = Seccion($num, $divisor, 'UN MILLON DE', 'MILLONES DE');
    $strMiles = Miles($resto);

    if ($strMillones == '')
        return $strMiles;

    return $strMillones . ' ' . $strMiles;
}
