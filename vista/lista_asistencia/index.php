<?php
$date = date('Y-m-d');
$data = $bd->Consulta("SELECT * FROM marcaciones_zkteco WHERE DATE(timestamp) = '$date'");

?>
<h2>Lista de Asistencia Hasta <?php echo date('d-m-Y'); ?></h2></br></br>
<a class="btn btn-info btn-icon" id="consulta-marcaciones" style="float: right; margin-right: 5px;">
    Extraer Asistencias de hoy
    <i class="entypo-plus"></i>
</a>
<a class="btn btn-info btn-icon" id="consulta-marcaciones-all" style="float: right; margin-right: 5px;">
    Extraer Todas las Asistencia
    <i class="entypo-plus"></i>
</a>
<!-- <a href="?mod=asistencia&pag=todos_asistencia&mes=<?php // echo $mes; 
                                                        ?>&gestion=<?php // echo $gestion; 
                                                                    ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
      Generar planilla<i class="entypo-plus"></i>
    </a>
    <a target="_blank" href="vista/reportes/visor_reporte.php?f=vista/asistencia/planilla_asistencia_pdf.php&mes=<?php echo $mes; ?>&gestion=<?php echo $gestion; ?>" class="btn btn-info btn-icon" style="float: right; margin-right: 5px;">
        Planilla Asistencia<i class="entypo-print"></i>
    </a> -->

</h2>
<br /><br /><br />
<div class="table-responsive">
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th>UUID</th>
                <th>Fecha Marcacion</th>
                <th>Estado</th>
                <th>Dispositivo</th>
                <th>Reloj</th>
                <th width="160">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php

            while ($info = $bd->getFila($data)) { ?>

                <tr>
                    <td> <?php echo utf8_encode($info[user_id]) ?> </td>
                    <td> <?php echo utf8_encode($info[timestamp]) ?> </td>
                    <td> <?php echo utf8_encode($info[status]) ?> </td>
                    <td> <?php echo utf8_encode($info[device_name]) ?> </td>
                    <td> <?php echo utf8_encode($info[origin]) ?> </td>
                    <td>-</td>
                </tr>

            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th>UUID</th>
                <th>Fecha Marcacion</th>
                <th>Estado</th>
                <th>Dispositivo</th>
                <th>Reloj</th>
                <th width="160">Acciones</th>
            </tr>
        </tfoot>
    </table>
</div>
<script>
    const urls = {
        'POCONAS': 'http://192.168.18.6:3010/ejecutar_marcaciones_poconas',
        'PTAR': 'http://192.168.18.6:3011/ejecutar_marcaciones_ptar',
        'URRIELAGOITIA': 'http://192.168.18.6:3012/ejecutar_marcaciones_urrielagoitia'
    };

    const urlsAll = {
        'POCONAS': 'http://192.168.18.6:3010/ejecutar_marcaciones_poconas_all',
        'PTAR': 'http://192.168.18.6:3011/ejecutar_marcaciones_ptar_all',
        'URRIELAGOITIA': 'http://192.168.18.6:3012/ejecutar_marcaciones_urrielagoitia_all'
    };

    const failedDevices = [];
    const failedDevicesAll = [];

    const fetchData = async (name, url) => {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = await response.json();
            if (data.status) {
                console.log(`Respuesta de ${name}:`, data.message);
            } else {
                failedDevices.push(name);
                console.warn(`Respuesta incorrecta de ${name}:`, data.message);
            }
        } catch (error) {
            failedDevices.push(name);
            console.error(`Error en ${name}:`, error.message);
        }
    };

    const fetchData_all = async (name, url) => {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = await response.json();
            if (data.status) {
                console.log(`Respuesta de ${name}:`, data.message);
            } else {
                failedDevicesAll.push(name);
                console.warn(`Respuesta incorrecta de ${name}:`, data.message);
            }
        } catch (error) {
            failedDevicesAll.push(name);
            console.error(`Error en ${name}:`, error.message);
        }
    };

    const fetchAllData = async () => {
        await Promise.all(Object.entries(urls).map(([name, url]) => fetchData(name, url)));

        // if (failedDevices.length > 0) {
        //     alert(`Marcaciones Importadas, pero faltaron: ${failedDevices.join(', ')}`);
        //     window.location.reload();
        // } else {
            alert('Marcaciones Importadas.');
            window.location.reload();
        // }
    };

    const fetchAllDataAll = async () => {
        await Promise.all(Object.entries(urlsAll).map(([name, url]) => fetchData_all(name, url)));

        // if (failedDevicesAll.length > 0) {
        //     alert(`Marcaciones Importadas, pero faltaron: ${failedDevicesAll.join(', ')}`);
        //     window.location.reload();
        // } else {
            alert('Marcaciones Importadas.');
            window.location.reload();
        // }
    };

    document.getElementById('consulta-marcaciones').addEventListener('click', function(event) {
        event.preventDefault();
        fetchAllData();
    });
    document.getElementById('consulta-marcaciones-all').addEventListener('click', function(event) {
        event.preventDefault();
        fetchAllDataAll();
    });
</script>