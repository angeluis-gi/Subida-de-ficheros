<html>

<head>
    <title>Procesa una subida de archivos </title>
    <meta charset="UTF-8">
</head>
<?php
// se incluyen esta tabla de  códigos de error que produce la subida de archivos en PHPP
// Posibles errores de subida segun el manual de PHP
$codigosErrorSubida = [
    UPLOAD_ERR_OK         => 'Subida correcta',
    UPLOAD_ERR_INI_SIZE   => 'El tamaño del archivo excede el admitido por el servidor',
    UPLOAD_ERR_FORM_SIZE  => 'El tamaño del archivo excede el admitido por el cliente',
    UPLOAD_ERR_PARTIAL    => 'El archivo no se pudo subir completamente',
    UPLOAD_ERR_NO_FILE    => 'No se seleccionó ningún archivo para ser subido',
    UPLOAD_ERR_NO_TMP_DIR => 'No existe un directorio temporal donde subir el archivo',
    UPLOAD_ERR_CANT_WRITE => 'No se pudo guardar el archivo en disco',
    UPLOAD_ERR_EXTENSION  => 'Una extensión PHP evito la subida del archivo',

];
$mensaje = '';
$directorioSubida = "imgusers/";

if (count($_FILES) == 0) {
    $mensaje = "Error: No se seleccionó ningún archivo.";
} else {
    $totalSize = 0;
    foreach ($_FILES['archivos']['name'] as $i => $nombreFichero) {
        $tipoFichero     = $_FILES['archivos']['type'][$i];
        $tamanioFichero  = $_FILES['archivos']['size'][$i];
        $temporalFichero = $_FILES['archivos']['tmp_name'][$i];
        $errorFichero    = $_FILES['archivos']['error'][$i];
        $totalSize += $tamanioFichero;

        $mensaje .= 'Intentando subir el archivo: ' . ' <br />';
        $mensaje .= "- Nombre: $nombreFichero" . ' <br />';
        $mensaje .= '- Tamaño: ' . number_format(($tamanioFichero / 1000), 1, ',', '.') . ' KB <br />';
        $mensaje .= "- Tipo: $tipoFichero" . ' <br />';
        $mensaje .= "- Nombre archivo temporal: $temporalFichero" . ' <br />';
        $mensaje .= "- Código de estado: $errorFichero" . ' <br />';

        $mensaje .= '<br />RESULTADO<br />';

        if ($errorFichero > 0) {
            $mensaje .= "Se ha producido el error nº $errorFichero: <em>"
                . $codigosErrorSubida[$errorFichero] . '</em> <br />';
            continue;
        }

        if ($tamanioFichero > 200 * 1024 || $totalSize > 300 * 1024) {
            $mensaje .= "El archivo $nombreFichero o el total de archivos supera el límite permitido. <br />";
            continue;
        }

        if (file_exists($directorioSubida . $nombreFichero)) {
            $mensaje .= "El archivo $nombreFichero ya existe. <br />";
            continue;
        }

        if (move_uploaded_file($temporalFichero,  $directorioSubida . $nombreFichero)) {
            $mensaje .= 'Archivo guardado en: ' . $directorioSubida . $nombreFichero . ' <br />';
        } else {
            $mensaje .= 'ERROR: Archivo no guardado correctamente <br />';
        }
    }
}
?>

<body>
    <?= $mensaje; ?>
    <br />
    <a href="2023.10.24_subida_de_archivos.html">Regresar</a>
</body>

</html>