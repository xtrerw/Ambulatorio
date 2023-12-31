<?php
include("tablas/crea_tablas.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia Sesión</title>
    <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <!-- logo -->
    <img src="img/logoLogin.png" alt="" srcset="">
    <div>
        <!-- formulario de paciente, va a saltar a la página de paciente -->
        <form action="paciente.php" method="post" id="form1" >
            <h1>Paciente</h1>
            <label for="nombrePaciente">Nombre de Paciente</label>
            <!-- elige un paciente -->
            <select name="paciente" id="">
                <?php 
                    $select = "SELECT DISTINCT * FROM pacientes";
                    $resulta = mysqli_query($conexion,$select); 
                    while ($paciente = $resulta->fetch_assoc()) {
                        echo "<option value='{$paciente['id']}'>{$paciente['nombre']}</option>";
                    }
                ?>
            </select>
            <input type="submit" value="Log in" name="login">
        </form>
        <!-- formulario de médico, va a saltar a la página de médico -->
        <form action="medico.php" method="post" id="form2">
            <h1>Médicos</h1>
            <label for="nombreMedico">Nombre de Médico</label>
            <!-- elige un médico -->
            <select name="medico" id="">
                <?php 
                    $select = "SELECT DISTINCT * FROM medico";
                    $resulta = mysqli_query($conexion,$select); 
                    while ($medico = $resulta->fetch_assoc()) {
                        echo "<option value='{$medico['id']}'>{$medico['nombre']}</option>";
                    }
                ?>
            </select>
            <input type="submit" value="Log in" name="login">
        </form>
    </div>
    <script type="text/javascript" src="js/login.js"></script>   
</body>
</html>