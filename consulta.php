<?php
include("tablas/crea_tablas.php");
session_start();
$idMedico=$_SESSION["idMedico"];
if (isset($_POST["add"]) && isset($_POST["sintomatologia"])) {
    # actualiza la fecha que este paciente ya elige en la tabla consulta
    $sintoma=$_POST["sintomatologia"];
    $sintoma=mysqli_escape_string($conexion,$sintoma);
    $update="UPDATE consulta 
    SET sintomatologia='$sintoma'
    WHERE id_medico=$idMedico";
    mysqli_query($conexion,$update);
}
//conseguir id de médico selecionado de la cita
if (isset($_POST["add"]) && isset($_POST["diagnostico"])) {
    # actualiza el id de médico que este paciente ya elige en la tabla consulta
    $diagnostico=$_POST["diagnostico"];
    $update="UPDATE consulta 
    SET diagnostico='$diagnostico'
    WHERE id_medico=$idMedico";
    mysqli_query($conexion,$update);
}

if (isset($_POST["add"]) && isset($_POST["medicamento"])) {
    # actualiza la medicamento 
    $medicamento=$_POST["medicamento"];
    $medicamento=mysqli_escape_string($conexion,$medicamento);
    $update="UPDATE receta r
    INNER JOIN consulta c ON c.id=r.id_consulta
    INNER JOIN medicamento m ON m.id=r.id_medicamento
    SET r.id_medicamento=$medicamento
    WHERE c.id_medico=$idMedico";
    mysqli_query($conexion,$update);
}
if (isset($_POST["add"]) && isset($_POST["cantidad"])) {
    # actualiza la cantidad 
    $cantidad=$_POST["cantidad"];
    $cantidad=mysqli_escape_string($conexion,$cantidad);
    $hora=$_POST["hora"];
    $hora=mysqli_escape_string($conexion,$hora);
    $update="UPDATE receta r
    INNER JOIN consulta c ON c.id=r.id_consulta
    SET r.posologia='$cantidad/$hora'
    WHERE c.id_medico=$idMedico";
    mysqli_query($conexion,$update);
}
if (isset($_POST["add"]) && isset($_POST["dia"])) {
    # actualiza la posología
    $dia=$_POST["dia"];
    $dia=mysqli_escape_string($conexion,$dia);
    $update="UPDATE receta r
    INNER JOIN consulta c ON c.id=r.id_consulta
    SET r.fecha_fin=DATE_ADD(NOW(), INTERVAL $dia DAY)
    WHERE c.id_medico=$idMedico";
    mysqli_query($conexion,$update);
}
if (isset($_POST["add"])) {
    # subir el pdf
    $nombre = $_FILES["archivo"]["name"];
    $nombre=mysqli_escape_string($conexion,$nombre);
    $nombre=mysqli_escape_string($conexion,$nombre);
    $update="UPDATE consulta SET archivo='$nombre' WHERE id_medico=$idMedico";
    mysqli_query($conexion,$update);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médico</title>
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/consulta.css">
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
    <!-- formulario de consulta -->
    <form action="" method="post" enctype="multipart/form-data">
        <legend>Consulta</legend>
        <fieldset>
            <!-- información de cita de hoy -->
            <legend>
                Información de Médico y Paciente
            </legend>
            <table>
                <thead>
                    <tr>
                        <td>Médico</td>
                        <td>Paciente</td>
                        <td>Fecha</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (isset($_POST['consulta'])) {
                            $select="SELECT m.nombre AS medico,p.nombre AS paciente, c.fecha AS fecha
                            FROM consulta c
                            INNER JOIN medico m ON c.id_medico=m.id
                            INNER JOIN pacientes p ON c.id_paciente=p.id 
                            WHERE c.id_medico=$idMedico";
                            $resulta=mysqli_query($conexion,$select);
                            while ($informacion= $resulta->fetch_assoc()) {
                                echo "
                                    <tr>
                                        <td>{$informacion['medico']}</td>
                                        <td>{$informacion['paciente']}</td>
                                        <td>{$informacion['fecha']}</td>
                                    </tr>
                                ";
                            }
                        };
                    ?>
                </tbody>
            </table>
            <!-- síntoma que puede modifcar el medico -->
            <legend>
            Sintomatología
            </legend>
            <div name="sintomatologia">
                <?php
                    if (isset($_POST['consulta'])) {
                        $select="SELECT c.sintomatologia AS sinto
                        FROM consulta c
                        INNER JOIN medico m ON c.id_medico=m.id
                        WHERE c.id_medico=$idMedico";
                        $resulta=mysqli_query($conexion,$select);
                        while ($informacion= $resulta->fetch_assoc()) {
                            echo "<textarea cols='100' rows='10'>{$informacion['sinto']}</textarea>";
                        }
                    };
                ?>
            </div>
            <!-- diagnóstico que también puede modifcar -->
            <legend>Diagnóstico</legend>
            <div name="diagnostico">
                <?php
                    if (isset($_POST['consulta'])) {
                        $select="SELECT c.diagnostico AS diagnostico
                        FROM consulta c
                        INNER JOIN medico m ON c.id_medico=m.id
                        WHERE c.id_medico=$idMedico";
                        $resulta=mysqli_query($conexion,$select);
                        while ($informacion= $resulta->fetch_assoc()) {
                            echo "<textarea name='diagnostico' id='' cols='100' rows='10'>{$informacion['diagnostico']}</textarea>";
                        }
                    };
                ?>
            </div>
        <!-- medicamento que recomenda el médico -->
            <legend>Medicación</legend>
            <label for="">Medicamentos</label>
            <select name="medicamento" id="">
                <?php
                    if (isset($_POST['consulta'])) {
                        $select="SELECT DISTINCT * FROM medicamento";
                        $resulta=mysqli_query($conexion,$select);
                        while ($medicamento= $resulta->fetch_assoc()) {
                            echo "<option value='{$medicamento['id']}'>{$medicamento['medicamento']}</option>";
                        }
                    };
                ?>
            </select>
            <label for="">Cantidad</label>
            <input type="text" maxlength="100 " name="cantidad" placeholder="eje: media pastilla" require>
            <label for="">Frecuencia</label>
            <input type="text" maxlength="100" name="hora" placeholder="eje: cada 8 hora" require>
            <input type="number" maxlength="100" id="dia" name="dia" placeholder="eje: 3 días">
            <label for="">
                ¿La medicación si es crónica?
                <input type="checkbox" id="cronica" onchange="check();">Sí
            </label>
            <?php

                // $columna="ALTER TABLE consulta ADD COLUMN archivo varchar(225) NOT NULL;";
                // mysqli_query($conexion,$columna);
            ?>
            <label for="archivo">Selecciona un archivo PDF:</label>
            <input type="file" name="archivo" id="archivo" accept=".pdf">
        </fieldset>
        <input type="submit" name="add" id="add" value="Añadir Medicación">
    </form>

    <form action="" method="post">
        <legend>Cita en Futuro</legend>
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
                <!-- advertencia -->
                <label id="advertencia"></label>
                <!-- bóton para subir cita -->
                <input type="submit" value="Pedir una cita" name="registro" id="registro">
            </fieldset>
        </form>
    </div>
    
    <script type="text/javascript" src="js/consulta.js"></script>
</body>
</html>