<?php
include("tablas/crea_tablas.php");         
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia Sesión</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <form action="index.php" method="POST">
            <h1>Paciente</h1>
            <label for="">Nombre de Paciente</label>
            <select name="paciente" id="">
                <?php 
                    $select = "SELECT DISTINCT * FROM pacientes";
                    $resulta = mysqli_query($conexion,$select); 
                    while ($paciente = $resulta->fetch_assoc()) {
                        echo "<option value='{$paciente['id']}'>{$paciente['nombre']}</option>";
                    }
                ?>
            </select>
            <input type="submit" value="Log in">
    </form>
</body>
</html>