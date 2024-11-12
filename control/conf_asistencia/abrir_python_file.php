<?php
    // URLs de los relojes
    // $urls = [
    //     'POCONAS' => 'http://192.168.16.30:3010/ejecutar_marcaciones_poconas',
    //     'PTAR' => 'http://192.168.16.30:3011/ejecutar_marcaciones_ptar',
    //     'URRIELAGOITIA' => 'http://192.168.16.30:3012/ejecutar_marcaciones_urrielagoitia'
    // ];
    $urls = array(
        'POCONAS' => 'http://192.168.18.46:3010/ejecutar_marcaciones_poconas',
        'PTAR' => 'http://192.168.18.46:3011/ejecutar_marcaciones_ptar',
        'URRIELAGOITIA' => 'http://192.168.18.46:3012/ejecutar_marcaciones_urrielagoitia'
    );

    // Array para almacenar los relojes que no devolvieron la respuesta esperada
    $failed_devices = array();

    // Función para realizar la solicitud cURL y procesar la respuesta
    function check_device($name, $url) {
        global $failed_devices;

        // Inicializar cURL
        $ch = curl_init();

        // Establecer la URL y configurar cURL para devolver la transferencia como una cadena
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Ejecutar la solicitud
        $response = curl_exec($ch);

        // Verificar si hubo errores en la solicitud
        if ($response === FALSE) {
            echo 'Error en cURL para ' . $name . ': ' . curl_error($ch) . '<br>';
            $failed_devices[] = $name;
        } else {
            // Decodificar la respuesta JSON
            $response_data = json_decode($response, true);

            // Verificar si la decodificación fue exitosa
            if (json_last_error() === JSON_ERROR_NONE) {
                // Verificar el valor de los campos "status" y "message"
                if (isset($response_data['status']) && $response_data['status'] === true && isset($response_data['message'])) {
                    echo 'Respuesta de ' . $name . ': ' . $response_data['message'] . '<br>';
                } else {
                    echo 'Respuesta incorrecta de ' . $name . ': ' . json_encode($response_data) . '<br>';
                    $failed_devices[] = $name;
                }
            } else {
                echo 'Error al decodificar la respuesta JSON de ' . $name . ': ' . json_last_error_msg() . '<br>';
                $failed_devices[] = $name;
            }
        }

        // Cerrar cURL
        curl_close($ch);
    }

    // Iterar sobre las URLs y realizar las solicitudes
    foreach ($urls as $name => $url) {
        check_device($name, $url);
    }

    // Mostrar el mensaje final
    if (count($failed_devices) > 0) {
        echo 'Marcaciones Importadas, pero faltaron: ' . implode(', ', $failed_devices);
    } else {
        echo 'Marcaciones Importadas.';
    }
?>