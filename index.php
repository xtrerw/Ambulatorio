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
    <form action="paciente.php" method="POST">
        <h1>Paciente</h1>
        <label for="nombrePaciente">Nombre de Paciente</label>
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
</body>
</html>