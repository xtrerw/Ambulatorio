<?php
include("tablas/crea_tablas.php");
//conseguir id de paciente que inicia sesión
session_start();
$pacienteSelect=$_SESSION["idPaciente"]; 
if (isset($_POST["registro"]) && isset($_POST["cita"])) {
    # actualiza la fecha que este paciente ya elige en la tabla consulta
    $fecha=$_POST["cita"];
    $fecha=mysqli_escape_string($conexion,$fecha);
    $update="UPDATE consulta 
    SET fecha='$fecha'
    WHERE id_paciente=$pacienteSelect";
    mysqli_query($conexion,$update);
}
//conseguir id de médico selecionado de la cita
if (isset($_POST["registro"]) && isset($_POST["medico"])) {
    # actualiza el id de médico que este paciente ya elige en la tabla consulta
    $idMedico=$_POST["medico"];
    $update="UPDATE consulta 
    SET id_medico=$idMedico
    WHERE id_paciente=$pacienteSelect";
    mysqli_query($conexion,$update);
    # actualiza el id de médico que este paciente ya elige en la tabla paciente
    $update="UPDATE  pacientes
    SET id_med=$idMedico
    WHERE id=$pacienteSelect";
    mysqli_query($conexion,$update);
}
//conseguir la síntoma que este paciente ha apuntado
if (isset($_POST["registro"]) && isset($_POST["sintoma"])) {
    # actualiza la síntoma que este paciente ya elige en la tabla consulta
    $sintoma=$_POST["sintoma"];
    $update="UPDATE consulta 
    SET sintomatologia='$sintoma'
    WHERE id_paciente=$pacienteSelect";
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
            <a href="index.php">Inicial Sesión</a>
        </div>
    </header>
    <!-- contenido -->
    <div class="container">
        <!-- formulario de cita -->
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
                <select name="medico" id="">
                    <?php 
                        //conseguir todos los médicos
                        $select = "SELECT DISTINCT * FROM medico";
                        $resulta = mysqli_query($conexion,$select); 
                        while ($medico = $resulta->fetch_assoc()) {
                            echo "<option value='{$medico['id']}'>{$medico['nombre']} {$medico['apellidos']}-{$medico['especialidad']}</option>";
                        }
                    ?>
                </select>
                <!-- Síntoma de paciente que pueda modificar según su propia situación -->
                <label>Síntoma</label>
                
                <?php
                    //combinarse la tabla de consulta con la de paciente y conseguir la síntoma apuntada de paciente
                    $select="SELECT c.sintomatologia AS sinto
                    FROM consulta c
                    INNER JOIN pacientes p ON c.id_paciente=p.id
                    WHERE c.id=$pacienteSelect";
                    $resulta=mysqli_query($conexion,$select);
                    if ($informacion= $resulta->num_rows>0) {
                        while ($informacion= $resulta->fetch_assoc()) {
                            //conseguir el array seleccionado desde SQL por fetch_assoc() y recorrer el array,presenta la información de síntoma 
                            echo "<textarea name='sintoma' id='' cols='30' rows='10'>{$informacion['sinto']}</textarea>";
                        }
                    }  
                ?>

                <!-- advertencia -->
                <label id="advertencia"></label>
                <!-- bóton para subir cita -->
                <input type="submit" value="Pedir una cita" name="registro" id="registro">
            </fieldset>
        </form>
    </div>
    <script type="text/javascript" src="js/cita.js"></script>
</body>
</html>