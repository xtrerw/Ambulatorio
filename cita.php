<?php
include("tablas/crea_tablas.php");
global $conexion;  
if (isset($_GET['paciente'])) {
    # obtener id paciente
    $pacienteSelect=$_GET["paciente"]; 
}
if (isset($_POST["pedir"])) {
    # conseguir la información introducida de pedir cita
    $fecha=$_POST["cita"];
    $idMedico=$_POST["medico"];
    $sintoma=$_POST["sintoma"];
    $fecha=mysqli_escape_string($conexion,$fecha);
    $sintoma=mysqli_escape_string($conexion,$sintoma);
    #inserta todos a la base de datos
    $inserta="INSERT INTO consulta(id_medico,id_paciente,fecha,sintomatologia) 
    VALUES ($idMedico,$pacienteSelect,'$fecha','$sintoma');";
    mysqli_query($conexion,$inserta);
    // tmb actualiza la tabla paciente
    $update="UPDATE  pacientes
    SET id_med=$idMedico
    WHERE id=$pacienteSelect";
    mysqli_query($conexion,$update);
}          
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedir Cita</title>
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/cita.css">
    <script type="text/javascript" src="js/calendar.js"></script>
    <style type="text/css">@import url("js/calendar-blue.css");</style>
    <script type="text/javascript" src="js/calendar-es.js"></script>
    <script type="text/javascript" src="js/calendar-setup.js"></script>

</head>
<body>
    <!-- header -->
    <header>
        <img src="img/logo.jpg" alt="" srcset="">
        <div>
            <a href="index.php">Inicia Sesión</a>
        </div>
    </header>
    <!-- contenido -->
    <div class="container">
        <!-- formulario de pedir cita -->
        <form action="" method="post">
            <fieldset>
                <!-- Título de la página -->
                <legend>
                    Pedir una cita
                </legend>

                <!-- Fecha seleccionada -->
                <label>Seleciona una fecha disponible</label>
                <!-- cuando un paciente elige una fecha de la cita, lo va a deja aparecer aquí   -->
                <input type="text" name="cita" id="cita" readonly="readonly" onchange="fecha();" require>
                <!-- una imagen se funciona como un selector de fecha  -->
                <img src="img/calendario.png" alt="" width="30" id="selector">

                <!-- Médico selecionado -->
                <label>Seleciona un médico</label>
                <select name="medico" id="medico">
                    <?php 
                        //conseguir todos los médicos para selecionar
                        $select = "SELECT DISTINCT * FROM medico";
                        $resulta = mysqli_query($conexion,$select); 
                        while ($medico = $resulta->fetch_assoc()) {
                            echo "<option value='{$medico['id']}'>{$medico['nombre']} {$medico['apellidos']}-{$medico['especialidad']}</option>";
                        }
                    ?>
                </select>
                <!-- Síntoma de paciente que pueda modificar según su propia situación -->
                <label>Síntoma</label>
                <textarea name='sintoma' id='' cols='30' rows='10'></textarea>
                <!-- advertencia -->
                <label id="advertencia"></label>
                <!-- bóton para subir cita -->
                <input type="submit" value="Pedir una cita" name="pedir" id="pedir" onclick="click();">
            </fieldset>
        </form>
    </div>
    <label>
    <!-- muestra la información de la cita enviado -->
    <?php 
        if (isset($_POST["pedir"])) {
            echo"La cita ya ha pedido";
            // con Select según id seleccionado
            $select="SELECT DISTINCT * FROM pacientes WHERE id='$pacienteSelect'";
            $resulta=mysqli_query($conexion,$select);
            while ($informacion= $resulta->fetch_assoc()) {
                echo "<br/>Paciente: {$informacion['nombre']} 
                <br />
                La cita: $fecha<br />
                Su síntoma: $sintoma<br />";
            };
            // el médico seleccionado
            $select="SELECT DISTINCT * FROM medico WHERE id='$idMedico'";
            $resulta=mysqli_query($conexion,$select);
            while ($informacion= $resulta->fetch_assoc()) {
                echo "Su médico: {$informacion['nombre']}";
            };
        }
    ?>
    </label>
    <script type="text/javascript" src="js/cita.js"></script>
</body>
</html>